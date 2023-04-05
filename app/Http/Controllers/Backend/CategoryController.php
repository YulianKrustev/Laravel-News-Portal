<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category; 
use App\Models\SubCategory; 

class CategoryController extends Controller
{
    public function AllCategory(){
        $categories = Category::latest()->get();
        return view('backend.category.category_all', compact('categories'));
    } // End function

    public function AddCategory(){
        return view('backend.category.category_add');
    } // End function

    public function StoreCategory(Request $request){

        Category::insert([
            'category_name' => $request->category_name,
            'category_slug' =>strtolower(str_replace(' ', '-', $request->category_name )),


        ]);

        $notification = [
                'message' => 'Category Inserted Successfully',
                'alert-type' => 'success'
            ];

        return redirect()->route('all.category')->with($notification);

    } // End function


    public function EditCategory($id){

        $category = Category::findOrFail($id);

        return view('backend.category.category_edit', compact('category'));
    } // End function

    public function UpdateCategory(Request $request){

        $id = $request->id;

        Category::findOrFail($id)->update([
            'category_name' => $request->category_name,
            'category_slug' =>strtolower(str_replace(' ', '-', $request->category_name )),


        ]);



        $notification = [
                'message' => 'Category Updated Successfully',
                'alert-type' => 'success'
            ];

        return redirect()->route('all.category')->with($notification);

    } // End function

     public function DeleteCategory($id){

        Category::findOrFail($id)->delete();

        $notification = [
                'message' => 'Category Deleted Successfully',
                'alert-type' => 'success'
            ];

        return redirect()->back()->with($notification);

    } // End function

    public function GetSubCategory($category_id){

        $subcat = SubCategory::where('category_id', $category_id)->orderBy('subcategory_name', 'ASC')->get();
        return json_encode($subcat);

    } // End function

}
