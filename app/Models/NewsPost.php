<?php

namespace App\Models;

use App\Models\User;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NewsPost extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function Category(){
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function SubCategory(){
        return $this->belongsTo(SubCategory::class, 'subcategory_id', 'id');
    }

    public function User(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
