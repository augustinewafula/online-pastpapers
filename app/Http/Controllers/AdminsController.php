<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Admin;

class AdminsController extends Controller
{
    protected $redirectPath = 'admin/admins';

    public function index(){
        $admins = Admin::select('id','name','email','type')->get();
        return view('admin.admins')->with('admins',$admins);
    }

    public function create(){
        return view('admin.add_admin');
    }

    public function store(Request $request){
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:admins',
        ]);

        $password = substr(md5(microtime()),rand(0,26),8);
        Admin::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => bcrypt($password)
        ]);
        $admin_first_name = explode(" ", $request['name'], 2)[0];
        $admin_email = $request['email'];
        $admin_password = $password;

        $data = array('name'=>$admin_first_name,'email'=>$admin_email,'password'=>$admin_password);
        $beautymail = app()->make(\Snowfire\Beautymail\Beautymail::class);
        $beautymail->send('admin.registration_mail_template', $data, function($message) use ($admin_email, $admin_first_name)
        {
            $message
                ->from('noreply@onlinepastpapers.com','Online Pastpapers')
                ->to($admin_email, $admin_first_name)
                ->subject('Registered as admin');
        });

        //Give message to admin after successfull registration
        $request->session()->flash('status', 'login credential has been sent to registered admin email');
        return redirect($this->redirectPath);
    }

    public function destroy(Request $request, $id){
        Admin::find($id)->delete();
        $request->session()->flash('status', 'Admin deleted successfully');
        return redirect($this->redirectPath);        
    }
}
