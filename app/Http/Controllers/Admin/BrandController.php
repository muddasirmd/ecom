<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;

use Session;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::get();
        return view('admin.brands.brands')->with(compact('brands'));
    }

    public function updateBrandStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            
            if($data['status'] == 'Active'){
                $status = 0;
            }else{
                $status = 1;
            }
            Brand::where('id', $data['brand_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status, 'brand_id'=>$data['brand_id']]);
        }
    }

    public function deleteBrand($id){

        Brand::destroy($id);

        session::flash('success_message','Brand has been deleted.');
        return redirect()->back();
    }

    public function addEditBrand(Request $request, $id=null){

        if($id == ""){
            $title = "Add Brand";
            $brand = new Brand();
            $message = 'Brand Added Successfully';
        }
        else{
            $title = "Edit Brand";
            $brand = Brand::find($id);
            $message = 'Brand Updated Successfully';
        }

        if($request->isMethod('post')){

            // Data Validation
            $rules = [
                'brand_name'=>'required|regex:/^[\pL\s\-]+$/u',
            ];
            $customMessages = [
                'brand_name.required'=> 'Brand name is required',
                'brand_name.alpha'=> "Valid Brand name required",
            ];
            $this->validate($request, $rules, $customMessages);

            $data = $request->except('_token');

            $brand = Brand::updateOrCreate(['id'=>$brand->id], $data);

            Session::flash('success_message', $message);
        }

        return view("admin.brands.add_edit_brand")->with(compact('title', 'brand'));
    }

}
