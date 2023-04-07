<?php

namespace App\Http\Controllers\Backend;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Category;
use App\Models\NewsPost;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;

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


    public function StoreNewsPost(Request $request){
        
        $image = $request->file('image');
        $name_gen = hexdec(uniqid()). '.' .$image->getClientOriginalExtension();
        Image::make($image)->resize(784,436)->save('upload/news/'.$name_gen);
        $save_url = 'upload/news/'.$name_gen;

        NewsPost::insert([
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'user_id' => $request->user_id,
            'news_title' => $request->news_title,
            'news_title_slug' => strtolower(str_replace(' ','-', $request->news_title)),
            'news_details' => $request->news_details,
            'tags' => $request->tags,
            'image' => $save_url,

            'breaking_news' => $request->breaking_news,
            'top_slider' => $request->top_slider,
            'first_section_three' => $request->first_section_three,
            'first_section_nine' => $request->first_section_nine,
            'post_date' => date('d-m-Y'),
            'post_month' => date('F'),
            'created_at' => Carbon::now(),
        ]);

        $notification = [
                'message' => 'News Post Inserted Successfully',
                'alert-type' => 'success'
            ];

        return redirect()->route('all.news.post')->with($notification);
        
    } // End function

     public function EditNewsPost($id){
        $news_post = NewsPost::find($id);
        $categories = Category::latest()->get();
        $subcategories = SubCategory::latest()->get();
        $adminuser = User::where('role', 'admin')->latest()->get();
        return view('backend.news.edit_news_post', compact('news_post', 'categories', 'subcategories', 'adminuser'));
        
    } // End function

    public function UpdateNewsPost(Request $request){
        $newspost_id = $request->id;

        if ($request->file('image')) {
        $img = NewsPost::findOrFail($newspost_id)->image;
        unlink($img);

        $image = $request->file('image');
        $name_gen = hexdec(uniqid()). '.' .$image->getClientOriginalExtension();
        Image::make($image)->resize(784,436)->save('upload/news/'.$name_gen);
        $save_url = 'upload/news/'.$name_gen;

        NewsPost::findOrFail($newspost_id)->update([
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'user_id' => $request->user_id,
            'news_title' => $request->news_title,
            'news_title_slug' => strtolower(str_replace(' ','-', $request->news_title)),
            'news_details' => $request->news_details,
            'tags' => $request->tags,
            'image' => $save_url,

            'breaking_news' => $request->breaking_news,
            'top_slider' => $request->top_slider,
            'first_section_three' => $request->first_section_three,
            'first_section_nine' => $request->first_section_nine,
            'post_date' => date('d-m-Y'),
            'post_month' => date('F'),
            'updated_at' => Carbon::now(),
        ]);

        $notification = [
                'message' => 'News Post Updated with Image Successfully',
                'alert-type' => 'success'
            ];

        } else {

            NewsPost::findOrFail($newspost_id)->update([
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'user_id' => $request->user_id,
            'news_title' => $request->news_title,
            'news_title_slug' => strtolower(str_replace(' ','-', $request->news_title)),
            'news_details' => $request->news_details,
            'tags' => $request->tags,
            'breaking_news' => $request->breaking_news,
            'top_slider' => $request->top_slider,
            'first_section_three' => $request->first_section_three,
            'first_section_nine' => $request->first_section_nine,
            'post_date' => date('d-m-Y'),
            'post_month' => date('F'),
            'updated_at' => Carbon::now(),
        ]);

        $notification = [
                'message' => 'News Post Updated without Image Successfully',
                'alert-type' => 'success'
            ];
        }
        
        return redirect()->route('all.news.post')->with($notification);
    } // End function


}
