<?php

namespace App\Http\Controllers;

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

        return redirect('/admin/logout/page');
    } // End Function


    public function AdminLogin(){

        return view('admin.admin_login');

    } // End Function


    public function AdminLogoutPage(){

        return view('admin.admin_logout');

    } // End Function
}
