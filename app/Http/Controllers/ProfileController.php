<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Admin;
use App\Rules\ValidateUserCurrentPassword;
use App\Rules\ValidateAdminCurrentPassword;

class ProfileController extends Controller
{
    public function showProfilePage(){
        return view('profile');
    }

    public function showAdminProfilePage(){
        return view('admin.profile');
    }

    public function updateName(Request $request){
        $rules = [
            'name'=>'required|regex:/^[\pL\s\-]+$/u|unique:users,name'
        ];
        $customMessages = [
            'required' => 'The :attribute field is required.',
            'unique'=>'The name already exist. Please update with a different name',
            'regex'=>'Name can contain letters and numbers only'
        ]; 

        $this->validate($request, $rules, $customMessages);

        $user = User::find(Auth()->user()->id);
        $user->name = $request->name;
        $user->save();

        $request->session()->flash('status', 'Name updated successfully');
        return redirect($request->header('referer'));        
    }

    public function updateEmail(Request $request){
        $rules = [
            'email'=>'required|email||unique:users,email'
        ];
        $customMessages = [
            'required' => 'The :attribute field is required.',
            'unique'=>'The email already exist. Please update with a different email'
        ];
        $this->validate($request, $rules, $customMessages); 
        $user = User::find(Auth()->user()->id);
        $user->email = $request->email;
        $user->save();

        $request->session()->flash('status', 'Email updated successfully');
        return redirect($request->header('referer'));
    }

    public function updatePassword(Request $request){
        $this->validate($request, [
            'current_password' => ['required',new ValidateUserCurrentPassword()],
            'new_password' => 'required|min:6|confirmed',
            'new_password_confirmation' => 'required|min:6',
        ]); 
             
        $user = User::find(Auth()->user()->id);
        $user->password =  bcrypt($request->new_password);
        $user->save();

        $request->session()->flash('status', 'Password updated successfully');
        return redirect($request->header('referer'));
    }

    public function adminUpdateName(Request $request){
        $rules = [
            'name'=>'required|regex:/^[\pL\s\-]+$/u|unique:admins,name'
        ];
        $customMessages = [
            'required' => 'The :attribute field is required.',
            'unique'=>'The name already exist. Please update with a different name',
            'regex'=>'Name can contain letters and numbers only'
        ]; 

        $this->validate($request, $rules, $customMessages);

        $admin = Admin::find(Auth('admin')->user()->id);
        $admin->name = $request->name;
        $admin->save();

        $request->session()->flash('status', 'Name updated successfully');
        return redirect($request->header('referer'));        
    }

    public function adminUpdateEmail(Request $request){
        $rules = [
            'email'=>'required|email||unique:admins,email'
        ];
        $customMessages = [
            'required' => 'The :attribute field is required.',
            'unique'=>'The email already exist. Please update with a different email'
        ];
        $this->validate($request, $rules, $customMessages); 
        $admin = Admin::find(Auth('admin')->user()->id);
        $admin->email = $request->email;
        $admin->save();

        $request->session()->flash('status', 'Email updated successfully');
        return redirect($request->header('referer'));
    }

    public function adminUpdatePassword(Request $request){
        $this->validate($request, [
            'current_password' => ['required',new ValidateAdminCurrentPassword()],
            'new_password' => 'required|min:6|confirmed',
            'new_password_confirmation' => 'required|min:6',
        ]); 
             
        $admin = Admin::find(Auth('admin')->user()->id);
        $admin->password =  bcrypt($request->new_password);
        $admin->save();

        $request->session()->flash('status', 'Password updated successfully');
        return redirect($request->header('referer'));
    }
}
