<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function UserDashboard(){

        $id = Auth::id();
        $userData = User::find($id);
        return view('frontend.user_dashboard', compact('userData'));

    } // End Function

    public function UserProfileUpdate(Request $request){

        
        $userData = $request->user();

        if ($request->file('photo')) {

           $file = $request->file('photo');
           @unlink(public_path('upload/user_images/'.$userData->photo));
           $filename = date('YmdHi').$file->getClientOriginalName();
           $file->move(public_path('upload/user_images'), $filename);
           $userData->photo = $filename;
        }

        $userData-> username = $request-> username;
        $userData-> name = $request-> name;
        $userData-> email = $request-> email;
        $userData-> phone = $request-> phone;
        $userData-> username = $request-> username;

        $userData->save();


        return back()->with("status", "Profile Updated Successfully");
    } // End Function

    public function UserLogout(Request $request){

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login')->with("status", "User logout Successfully");

    } // End Function

    public function ChangePassword(){
        $id = Auth::id();
        $userData = User::find($id);

        return view('frontend.change_password', compact('userData'));

    } // End Function

    public function UserChangePassword(Request $request){

         $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
            
        ]);

        // Match the old password
        if (!Hash::check($request->old_password, Auth::user()->password)) {
            return back()->with('error', "Old Password Doesn't match!");
        }

        // Update the password
        $request->user()->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with('status', "Password Changed Successfully!");

    } // End Function
}
