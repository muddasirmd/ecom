<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Section;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Session;
use stdClass;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::with('section', 'parentCategory')->get();
    
        return view('admin.categories.categories')->with(compact('categories'));
    }

    public function updateCategoryStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            
            if($data['status'] == 'Active'){
                $status = 0;
            }else{
                $status = 1;
            }
            Category::where('id', $data['category_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status, 'category_id'=>$data['category_id']]);
        }
    }

    public function addEditCategory(Request $request, $id = null){
        if($id == ""){
            $title = "Add Category";
            $category = new Category();
            $categories = array();
            $message = 'Category Added Successfully';
        }else{
            $title = "Edit Category";
            $category = Category::where('id', $id)->first();
            $categories = Category::with("subCategories")->where(['parent_id'=> 0, 'section_id'=> $category->section_id])->get();
            $categories = json_decode(json_encode($categories), true);
            $message = 'Category Updated Successfully';
        }
        

        // Upload Category Image
        if($request->hasFile('category_image')){
            $imageTmp = $request->file('category_image');
            if($imageTmp->isValid()){
                // Get img Extension
                $extension = $imageTmp->getClientOriginalExtension();
                // Generate new image name
                $imageName = rand(111,99999).'.'.$extension;
                $imagePath = 'images/admin/category_images/'.$imageName;
                // Upload the image: Using Intervention package
                Image::make($imageTmp)->save($imagePath);
                $category->category_image = $imageName;
            }
        }

        if($request->isMethod('post')){
            // Data Validation
            $rules = [
                'category_name'=>'required|regex:/^[\pL\s\-]+$/u',
                'section_id'=>'required|numeric',
                'category_image'=>'image'
            ];
            $customMessages = [
                'category_name.required'=> 'Category name is required',
                'category_name.alpha'=> "Valid Category name required",
                'section_id.numeric'=> 'Select a section',
                'category_image.image'=>'Upload a valid category image'
            ];
            $this->validate($request, $rules, $customMessages);
            
            $data = $request->all();

            $category->parent_id = $data['parent_id'];
            $category->section_id = $data['section_id'];
            $category->category_name = $data['category_name'];
            $category->category_discount = $data['category_discount'];
            $category->description = $data['description'];
            $category->url = $data['url'];
            $category->meta_title = $data['meta_title'];
            $category->meta_description = $data['meta_description'];
            $category->meta_keywords = $data['meta_keywords'];
            $category->save();

            Session::flash('success_message', $message);
            return redirect('admin/categories');
        }

        $sections = Section::get();

        return view('admin.categories.add_edit_category')->with(compact('title', 'sections', 'category', 'categories'));
    }

    public function appendCategoriesLevel(Request $request){
        if($request->ajax()){
            $data = $request->all();

            $categories = Category::with('subCategories')->where(['section_id'=> $data['section_id'], 'parent_id'=>0, 'status'=>1])->get();
            $categories = json_decode(json_encode($categories), true);
            
            return view('admin.categories.append_categories_level')->with(compact('categories'));
        }
    }

    public function deleteCategoryImage($id){
        $category = Category::select('category_image')->where('id', $id)->first();

        $imagePath = 'images/admin/category_images/';

        // Delete File
        if(file_exists($imagePath.$category->category_image)){
            unlink($imagePath.$category->category_image);
        }

        // Delete image from table
        Category::where('id', $id)->update(['category_image'=> '']);

        session::flash('success_message','Category Image has been deleted.');
        return redirect()->back();
    }

    public function deleteCategory($id){

        $category = Category::where('id',$id)->first();

        $imagePath = 'images/admin/category_images/';

        // Delete Category Image File
        if(!empty($category->category_image) && file_exists($imagePath.$category->category_image)){
            unlink($imagePath.$category->category_image);
        }

        // Category::where('id',$id)->delete();
        $category->delete();

        session::flash('success_message','Category has been deleted.');
        return redirect()->back();
    }
}
