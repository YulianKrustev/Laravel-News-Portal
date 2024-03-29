<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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


    public function AdminChangePassword(){

        return view('admin.admin_change_password');

    } // End Function

    public function AdminUpdatePassword(Request $request) {

        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
            
        ]);

        // Match the old password
        if (!Hash::check($request->old_password, Auth::user()->password)) {
            return back()->with('error', "Old Password Doesn't match!");
        }

        // Update the password
        User::whereId(Auth::id())->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with('status', "Password Changed Successfully!");

    } // End Function


    public function AllAdmin(){

        $alladminuser = User::where('role', 'admin')->latest()->get();

        return view('backend.admin.all_admin', compact('alladminuser'));

    } // End Function

    public function AddAdmin(){

        return view('backend.admin.add_admin');

    } // End Function

    public function StoreAdmin(Request $request){

        $user = new User();
        $user->username = $request->username;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = Hash::make($request->username);
        $user->role = 'admin';
        $user->status = 'inactive';
        $user->save();

        $notification = [
                'message' => 'New Admin User Created Successfully',
                'alert-type' => 'success'
            ];

        
            return redirect()->back()->with($notification);

    } // End Function

    public function EditAdmin($id){

        $user = User::findOrFail($id);

        return view('backend.admin.edit_admin', compact('user'));

    } // End Function

    public function UpdateAdmin(Request $request){

        $user = User::findOrFail($request->id);
        $user->username = $request->username;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->save();

        $notification = [
                'message' => 'Admin User Updated Successfully',
                'alert-type' => 'success'
            ];

        
            return redirect()->back()->with($notification);

    } // End Function


    public function DeleteAdmin($id){

        User::findOrFail($id)->delete();

         $notification = [
                'message' => 'Admin User Deleted Successfully',
                'alert-type' => 'success'
            ];

        return redirect()->back()->with($notification);

    } // End function


    public function InactiveAdminUser($id){

        User::findOrFail($id)->update(['status' => 'inactive']);

         $notification = [
                'message' => 'Admin User Inactive',
                'alert-type' => 'success'
            ];

        return redirect()->back()->with($notification);

    } // End function


    public function ActiveAdminUser($id){

        User::findOrFail($id)->update(['status' => 'active']);

         $notification = [
                'message' => 'Admin User Active',
                'alert-type' => 'success'
            ];

        return redirect()->back()->with($notification);

    } // End function
}
