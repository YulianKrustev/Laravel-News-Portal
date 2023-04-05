<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\NewsPost;
use App\Models\User;

class NewsPostController extends Controller
{
    public function AllNewsPost(){
        $allnews = NewsPost::latest()->get();

        return view('backend.news.all_news_post', compact('allnews'));

    } // End function

    public function AddNewsPost(){
        $categories = Category::latest()->get();
        $subcategories = SubCategory::latest()->get();
        $adminuser = User::where('role', 'admin')->latest()->get();
        return view('backend.news.add_news_post', compact('categories', 'subcategories', 'adminuser'));
        
    } // End function


    public function StoreNewsPost(){
        
        
    } // End function


}
