<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function subCategories(){
        return $this->hasMany(Category::class, 'parent_id')->where('status', 1);
    }

    public function section(){
        return $this->belongsTo(Section::class, 'section_id')->select('id','name');
    }

    public function parentCategory(){
        return $this->belongsTo(Category::class,'parent_id')->select('id','category_name', 'url');
    }

    public function scopeCategoryByUrl($query, $url){
        $category = $query->select('id', 'parent_id', 'category_name', 'url', 'description')->with(['subCategories' => function($q){
            $q->select('id', 'parent_id')->where('status', 1);
        }])->where('url', $url)->first();

        return $category;
    }
}
