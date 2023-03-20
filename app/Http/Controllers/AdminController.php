<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function AdminDashboard(){

        return view('admin.index');
    } // End Function


    public function AdminLogout(Request $request){

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

         $notification = [
                'message' => 'Admin Logout Successfully',
                'alert-type' => 'info'
            ];

        return redirect('/admin/logout/page')->with($notification);
    } // End Function


    public function AdminLogin(){

         

        return view('admin.admin_login');

    } // End Function


    public function AdminLogoutPage(){
       

        return view('admin.admin_logout');

    } // End Function

    public function AdminProfile(){

        $id = Auth::id();
        $adminData = User::find($id);

        return view('admin.admin_profile_view', compact('adminData'));

    } // End Function


    public function AdminProfileStore(Request $request){

        $id = Auth::id();
        $adminData = User::find($id);

        $adminData->name = $request->name;
        $adminData->username = $request->username;
        $adminData->email = $request->email;
        $adminData->phone = $request->phone;

        if ($request->file('photo')) {

           $file = $request->file('photo');
           @unlink(public_path('upload/admin_images/'.$adminData->photo));
           $filename = date('YmdHi').$file->getClientOriginalName();
           $file->move(public_path('upload/admin_images'), $filename);
           $adminData->photo = $filename;
        }
        
        $adminData->save();

        $notification = [
                'message' => 'Admin Profile Updated Successfully',
                'alert-type' => 'success'
            ];

        return redirect()->back()->with($notification);

    } // End Function
}
