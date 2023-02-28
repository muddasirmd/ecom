<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Section;
use Intervention\Image\Facades\Image;

use Session;
use stdClass;


class ProductController extends Controller
{
    public function index(){
        $products = Product::with(['category.section'])->get();
        return view('admin.products.products')->with(compact('products'));
    }

    public function updateProductStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            
            if($data['status'] == 'Active'){
                $status = 0;
            }else{
                $status = 1;
            }
            Product::where('id', $data['product_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status, 'product_id'=>$data['product_id']]);
        }
    }

    public function deleteProduct($id){

        $product = Product::where('id',$id)->first();

        $imagePath = 'images/admin_images/product_images/';

        // Delete Product Image File
        if(!empty($product->main_image) && file_exists($imagePath.$product->main_image)){
            unlink($imagePath.$product->main_image);
        }

        $product->delete();

        session::flash('success_message','Product has been deleted.');
        return redirect()->back();
    }

    public function addEditProduct(Request $request, $id = null){
        if($id == ""){
            $title = "Add Product";
            $product = new Product();
            $message = 'Product Added Successfully';
        }else{
            $title = "Edit Product";
            $product = Product::where('id', $id)->first();
            $message = 'Product Updated Successfully';
        }


        if($request->isMethod('post')){
            // Data Validation
            $rules = [
                'product_name'=>'required|regex:/^[\pL\s\-]+$/u',
                'category_id'=>'required|numeric'
            ];
            $customMessages = [
                'product_name.required'=> 'Product name is required',
                'product_name.alpha'=> "Valid Product name required",
                'category_id.numeric'=> 'Select a category'
            ];
            $this->validate($request, $rules, $customMessages);
            
            $data = $request->all();
            unset($data['_token']);

             // Upload Product Image
            if($request->hasFile('product_image')){
                $imageTmp = $request->file('product_image');
                if($imageTmp->isValid()){
                    // Get img Extension
                    $extension = $imageTmp->getClientOriginalExtension();
                    // Generate new image name
                    $imageName = rand(111,99999).'.'.$extension;
                    $imagePath = 'images/admin_images/product_images/'.$imageName;
                    // Upload the image: Using Intervention package
                    Image::make($imageTmp)->save($imagePath);
                    $data['product_image'] = $imageName;
                }
            }
            // dd($product->id);
            // dd($data);

            $product = Product::updateOrCreate(['id'=>$product->id], $data);

            Session::flash('success_message', $message);
            return redirect('admin/products');
        }

        // Filter Arrays
        $fabrics = [['key'=>'cotton', 'val'=>'Cotton'], ['key'=>'polyester', 'val'=>'Polyester'],
        ['key'=>'wool', 'val'=>'Wool']];
        
        $sleeves = [['key'=>'full-sleeve','val'=>'Full Sleeve'], ['key'=>'half-sleeve', 'val'=>'Half Sleeve'], 
        ['key'=>'short-sleeve','val'=>'Short Sleeve'], ['key'=>'sleeveless','val'=>'Sleeveless']];

        $patterns = [['key'=>'checked','val'=>'Checked'], ['key'=>'plain','val'=>'Plain'], 
        ['key'=>'printed', 'val'=>'Printed'], ['key'=>'self','val'=>'Self'], ['key'=>'solid','val'=>'Solid']];
        
        $fits = [['key'=>'regular','val'=>'Regular'], ['key'=>'slim','val'=>'Slim']];
        
        $occasions = [['key'=>'casual','val'=>'Casual'], ['key'=>'formal','val'=>'Formal']];


        
        // Sections with Categories and Subcategories
        $sections = Section::with(['categories'])->get();

        return view('admin.products.add_edit_product')->with(compact('title', 'product', 'sections', 'fabrics', 
    'sleeves', 'patterns', 'fits', 'occasions'));
    }
}
