<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Section;
use App\Models\ProductAttribute;
use App\Models\ProductImage;
use Intervention\Image\Facades\Image;

use Session;

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

            // If is_featured is empty set it to No (Because when checkbox is unchecked then is_featured attribute will not come with post data)
            if(empty($data['is_featured'])){
                $data['is_featured'] = "No";
            }

             // Upload Product Image
            if($request->hasFile('product_image')){
                $imageTmp = $request->file('product_image');
                if($imageTmp->isValid()){
                    // Get img Extension
                    $extension = $imageTmp->getClientOriginalExtension();
                    // Generate new image name
                    $imageName = $imageTmp->getClientOriginalName();
                    $imageName = $imageName.'_'.rand(111,99999).'.'.$extension;
                    $largeImagePath = 'images/admin_images/product_images/large/'.$imageName;
                    $mediumImagePath = 'images/admin_images/product_images/medium/'.$imageName;
                    $smallImagePath = 'images/admin_images/product_images/small/'.$imageName;
                    // Upload the image: Using Intervention package
                    Image::make($imageTmp)->save($largeImagePath);
                    Image::make($imageTmp)->resize(420,500)->save($mediumImagePath);
                    Image::make($imageTmp)->resize(160,200)->save($smallImagePath);
                    $data['product_image'] = $imageName;
                }
            }

             // Upload Product Video
             if($request->hasFile('product_video')){
                $videoTmp = $request->file('product_video');
                if($videoTmp->isValid()){
                    // Get video Extension
                    $extension = $videoTmp->getClientOriginalExtension();
                    // Generate new image name
                    $videoName = $videoTmp->getClientOriginalName();
                    $videoName = $videoName.'_'.rand(111,99999).'.'.$extension;
                    $videoPath = 'videos/product_ivideo/';
                    // Upload the video: Using Intervention package
                    $videoTmp->move($videoPath, $videoName);
                    $data['product_video'] = $videoName;
                }
            }
           
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

    public function deleteProductImage($id){
        $product = Product::select('product_image')->where('id', $id)->first();

        $smallImagePath = 'images/admin_images/product_images/small/';
        $mediumImagePath = 'images/admin_images/product_images/medium/';
        $largeImagePath = 'images/admin_images/product_images/large/';

        // Delete File
        if(!empty($product->product_image) && file_exists($smallImagePath.$product->product_image)){
            unlink($smallImagePath.$product->product_image);
        }
        if(!empty($product->product_image) && file_exists($mediumImagePath.$product->product_image)){
            unlink($mediumImagePath.$product->product_image);
        }
        if(!empty($product->product_image) && file_exists($largeImagePath.$product->product_image)){
            unlink($largeImagePath.$product->product_image);
        }

        // Delete image from table
        Product::where('id', $id)->update(['product_image'=> '']);

        session::flash('success_message','Product Image has been deleted.');
        return redirect()->back();
    }

    public function deleteProductVideo($id){
        $product = Product::select('product_video')->where('id', $id)->first();

    
        $videoPath = 'videos/product_videos/';

        // Delete File
        if(!empty($product->product_video) && file_exists($videoPath.$product->product_video)){
            unlink($videoPath.$product->product_video);
        }

        // Delete video from table
        Product::where('id', $id)->update(['product_video'=> '']);

        session::flash('success_message','Product video has been deleted.');
        return redirect()->back();
    }

    /**
     * PRODUCT ATTRIBUTES SECTION
     * 
     */

    public function addProductAttributes(Request $request, $id = null){

        $title = "Edit Attributes";
        $product = Product::select('id', 'product_name', 'product_code', 'product_color', 'product_image')->find($id);

        if($request->isMethod('post')){
            $data = $request->all();
            
            foreach($data['sku'] as $key => $val){
                if(!empty($val)){

                    // If SKU already exists
                    $skuCount = ProductAttribute::where('sku', $val)->count();
                    if($skuCount > 0){
                        
                        session::flash('error_message','SKU already exist, Please enter another SKU.');
                        return redirect()->back();
                    }

                    // If Size already exists
                    $sizeCount = ProductAttribute::where(['product_id'=> $id, 'size'=> $data['size'][$key]])->count();
                    if($sizeCount > 0){
                        session::flash('error_message','Size already exist, Please enter another Size.');
                        return redirect()->back();
                    }

                    $productAttr = new ProductAttribute;
                    $productAttr->product_id = $id;
                    $productAttr->sku = $val;
                    $productAttr->size = $data['size'][$key];
                    $productAttr->stock = $data['stock'][$key];
                    $productAttr->price = $data['price'][$key];
                    $productAttr->save();
                }
                
            }

            session::flash('success_message','Product Attributes Added Successfully.');
            // return redirect()->back();
        }
        
        return view('admin.products.add_edit_product_attributes')->with(compact('product', 'title'));
    }

    public function editProductAttributes(Request $request, $id = null){

        if($request->isMethod("post")){
            $data = $request->all();
            
            foreach($data['attrId'] as $key => $val){
                ProductAttribute::where('id', $val)->update(['price'=>$data['price'][$key], 'stock'=>$data['stock'][$key]]);

            }
        }

        session::flash('success_message','Product Attributes Updated Successfully.');
        return redirect()->back();
    }

    public function updateProductAttributeStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            
            if($data['status'] == 'Active'){
                $status = 0;
            }else{
                $status = 1;
            }
            ProductAttribute::where('id', $data['attr_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status, 'attr_id'=>$data['attr_id']]);
        }
    }

    public function deleteProductAttribute($id){

        $product = ProductAttribute::where('id',$id)->delete();

        session::flash('success_message','Attribute has been deleted.');
        return redirect()->back();
    }

    /**
     * PRODUCT IMAGES SECTION
     * 
     */

    public function addProductImages(Request $request, $id = null){

        $title = "Add Images";
        $product = Product::select('id', 'product_name', 'product_code', 'product_color', 'product_image')->find($id);

        if($request->isMethod('post')){

            if($request->hasFile('images')){
                $images = $request->file('images');

                foreach($images as $key => $img){

                    // Upload Product Images
                    if($img->isValid()){
                        // Get img Extension
                        $extension = $img->getClientOriginalExtension();
                        // Generate new image name
                        $imageName = $img->getClientOriginalName();
                        $imageName = $imageName.'_'.rand(111,99999).'_'.time().'.'.$extension;
                        $largeImagePath = 'images/admin_images/product_images/large/'.$imageName;
                        $mediumImagePath = 'images/admin_images/product_images/medium/'.$imageName;
                        $smallImagePath = 'images/admin_images/product_images/small/'.$imageName;
                        // Upload the image: Using Intervention package
                        Image::make($img)->save($largeImagePath);
                        Image::make($img)->resize(420,500)->save($mediumImagePath);
                        Image::make($img)->resize(160,200)->save($smallImagePath);

                        // Save product Image
                        $productImage = new ProductImage();
                        $productImage->image = $imageName;
                        $productImage->product_id = $product->id;
                        $productImage->save();
                    }
                }
            }           
        }

        return view('admin.products.add_edit_product_images')->with(compact('product', 'title'));
    }

    public function updateProductImageStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            
            if($data['status'] == 'Active'){
                $status = 0;
            }else{
                $status = 1;
            }
            ProductImage::where('id', $data['image_id'])->update(['status'=> $status]);
            return response()->json(['status'=>$status, 'image_id'=>$data['image_id']]);
        }
    }

    public function deleteProductImages($id){
        $img = ProductImage::select('image')->where('id', $id)->first();

        $smallImagePath = 'images/admin_images/product_images/small/';
        $mediumImagePath = 'images/admin_images/product_images/medium/';
        $largeImagePath = 'images/admin_images/product_images/large/';

        // Delete File
        if(!empty($img->image) && file_exists($smallImagePath.$img->image)){
            unlink($smallImagePath.$img->image);
        }
        if(!empty($img->image) && file_exists($mediumImagePath.$img->image)){
            unlink($mediumImagePath.$img->image);
        }
        if(!empty($img->image) && file_exists($largeImagePath.$img->image)){
            unlink($largeImagePath.$img->image);
        }

        // Delete image from table
        // ProductImage::delete($id) is a querly builder method
        ProductImage::destroy($id); // destroy is ORM Method

        session::flash('success_message','Product Image has been deleted.');
        return redirect()->back();
    }
}
