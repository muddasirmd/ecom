<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use Intervention\Image\Facades\Image;

use Session;

class BannerController extends Controller
{
    public $imageFilePath = 'images/admin/banner_images/';

    public function index(){
        $banners = Banner::where('status', 1)->get();
        return view('admin.banners.banners')->with(compact('banners'));
    }

    public function updateBannerStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            
            if($data['status'] == 'Active'){
                $status = 0;
            }else{
                $status = 1;
            }
            Banner::where('id', $data['banner_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status, 'banner_id'=>$data['banner_id']]);
        }
    }

    public function addEditBanner(Request $request, $id = null){
        if($id == ""){
            $title = "Add Banner";
            $banner = new Banner();
            $message = 'Banner Added Successfully';
        }else{
            $title = "Edit Banner";
            $banner = Banner::where('id', $id)->first();
            $message = 'Banner Updated Successfully';
        }


        if($request->isMethod('post')){
            // Data Validation
            $rules = [
                'title'=>'required|regex:/^[\pL\s\-]+$/u',
            ];
            $customMessages = [
                'title.required'=> 'Banner name is required',
                'title.alpha'=> "Valid Banner name required",
                'category_id.numeric'=> 'Select a category'
            ];
            $this->validate($request, $rules, $customMessages);
            
            // $data = $request->all();
            $data = $request->except('_token');

             // Upload Banner Image
            if($request->hasFile('image')){
                $imageTmp = $request->file('image');
                if($imageTmp->isValid()){
                    // Get img Extension
                    $extension = $imageTmp->getClientOriginalExtension();
                    // Generate new image name
                    $imageName = $imageTmp->getClientOriginalName();
                    $imageName = $imageName.'_'.rand(111,99999).'.'.$extension;
                    $largeImagePath = 'images/admin/banner_images/'.$imageName;
                    // Upload the image: Using Intervention package
                    Image::make($imageTmp)->save($largeImagePath);
                    $data['image'] = $imageName;
                }
            }

            $banner = Banner::updateOrCreate(['id'=>$banner->id], $data);

            Session::flash('success_message', $message);
            return redirect('admin/banners');
        }

        return view('admin.banners.add_edit_banner')->with(compact('title', 'banner'));
    }

    public function deleteBanner($id){

        $banner = Banner::where('id',$id)->first();

        // Helper Func: Delete Image File
        deleteImageFile($banner, $this->imageFilePath);

        $banner->delete();

        session::flash('success_message','Banner has been deleted.');
        return redirect()->back();
    }

    public function deleteBannerImage($id){
        $banner = Banner::select('image')->where('id', $id)->first();

        // Helper Func: Delete Image File
        deleteImageFile($banner, $this->imageFilePath);

        // Delete image from table
        Banner::where('id', $id)->update(['image'=> '']);

        session::flash('success_message','Banner Image has been deleted.');
        return redirect()->back();
    }
}
