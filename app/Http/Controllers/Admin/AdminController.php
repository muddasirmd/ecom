<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use Hash;
use Image;

class AdminController extends Controller
{
    public function login(Request $request){
        
        if($request->isMethod('post')){
            
            $data = $request->all();

            $rules = [
                'email' => 'required|email|max:255',
                'password' => 'required'
            ];

            $customMessages = [
                'email.required' => 'Email is Required.',
                'email.email' => 'Enter a valid Email.',
                'password.required' => 'Password is Required.'
            ];

            $this->validate($request, $rules, $customMessages);

            if(Auth::guard('admin')->attempt(['email' => $data['email'], 'password' => $data['password']])){
                return redirect('admin/dashboard');
            }
            else{
                Session::flash('error_message', 'Invalid Email or Password');
                return redirect()->back();
            }
        }
        return view('admin.admin_login');
    }

    public function dashboard(){
        return view('admin.admin_dashboard');
    }

    public function settings(){

        $adminDetails = Admin::where('email', Auth::guard('admin')->user()->email)->first();
        return view('admin.admin_settings')->with(compact('adminDetails'));
    }

    public function logout(){
        Auth::guard('admin')->logout();
        return redirect('/admin');
    }

    public function chkCurrentPassword(Request $request){
        $data = $request->all();

        if(Hash::check($data['current_password'], Auth::guard('admin')->user()->password)){
            return True;
        }
        else{
            return False;
        }
    }

    public function updateCurrentPassword(Request $request){
        
        // dd($request->all());
        if($request->isMethod('post')){

            $data = $request->all();

            if(Hash::check($data['current_password'], Auth::guard('admin')->user()->password)){
                
                if($data['new_password'] == $data['confirm_password']){
                    Admin::where('id', Auth::guard('admin')->user()->id)->update(['password'=>bcrypt($data['new_password'])]);

                    Session::flash("success_message", "Password has been updated successfully");
                }
                else{
                    Session::flash('error_message', "New password and confirm password does not match.");    
                }
            }
            else{
                Session::flash('error_message', "Current password is not correct.");
            }

            return redirect()->back();
        }

    }

    public function updateAdminDetails(Request $request){

        // dd($request->is('admin/update-admin-details'));
        if($request->isMethod('post')){
            $data = $request->all();

            $rules = [
                'name'=>'required|regex:/^[\pL\s\-]+$/u',
                'mobile'=>'required|numeric',
                'image'=>'image'
            ];
            $customMessages = [
                'name.required'=> 'Name is required',
                'name.alpha'=> "Valid name required",
                'mobile.required'=> 'Mobile number is required',
                'mobile.required'=> 'Valid mobile number is required',
                'image.image'=>'Valid image required'
            ];

            $this->validate($request, $rules, $customMessages);

            // Upload Image
            if($request->hasFile('image')){
                $imageTmp = $request->file('image');
                if($imageTmp->isValid()){
                    // Get img Extension
                    $extension = $imageTmp->getClientOriginalExtension();
                    // Generate new image name
                    $imageName = rand(111,99999).'.'.$extension;
                    $imagePath = 'images/admin_images/admin_photos/'.$imageName;
                    // Upload the image: Using Intervention package
                    Image::make($imageTmp)->save($imagePath);
                }
            }
            else if(!empty($data['current_image'])){
                $imageName = $data['current_image'];
            }
            else{
                $imageName = "";
            }

            Admin::where('email', Auth::guard('admin')->user()->email)->update(['name'=> $data['name'], 'mobile'=> $data['mobile'], 
            'image'=> $imageName]);
            Session::flash('success_message','Admin details has been updated.');
            return redirect()->back();
        }
        return view('admin.update_admin_details');
    }
}
