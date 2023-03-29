<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubCategory; 
use App\Models\Category; 

class SubCategoryController extends Controller
{
    public function AllSubCategory(){
        $subcategories = SubCategory::latest()->get();
        return view('backend.subcategory.subcategory_all', compact('subcategories'));
    } // End function

    public function AddSubCategory(){
        $categories = Category::latest()->get();
        return view('backend.subcategory.subcategory_add', compact('categories'));
    } // End function

    public function StoreSubCategory(Request $request){

        SubCategory::insert([
            'category_id' => $request->category_id,
            'subcategory_name' => $request->subcategory_name,
            'subcategory_slug' =>strtolower(str_replace(' ', '-', $request->subcategory_name )),


        ]);

        $notification = [
                'message' => 'SubCategory Inserted Successfully',
                'alert-type' => 'success'
            ];

        return redirect()->route('all.subcategory')->with($notification);

    } // End function


    public function EditSubCategory($id){
        $categories = Category::latest()->get();
        $subcategory = SubCategory::findOrFail($id);

        return view('backend.subcategory.subcategory_edit', compact('subcategory', 'categories'));
    } // End function

    public function UpdateSubCategory(Request $request){

        $id = $request->id;

        SubCategory::findOrFail($id)->update([
            'category_id' => $request->category_id,
            'subcategory_name' => $request->subcategory_name,
            'subcategory_slug' =>strtolower(str_replace(' ', '-', $request->subcategory_name )),


        ]);

        $notification = [
                'message' => 'SubCategory Updated Successfully',
                'alert-type' => 'success'
            ];

        return redirect()->route('all.subcategory')->with($notification);

    } // End function

     public function DeleteSubCategory($id){

        SubCategory::findOrFail($id)->delete();

        $notification = [
                'message' => 'SubCategory Deleted Successfully',
                'alert-type' => 'success'
            ];

        return redirect()->back()->with($notification);

    } // End function
}
