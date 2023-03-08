<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // protected $fillable = ['product_name', 'category_id', 'product_color', 'product_code', 'product_price',
    //                     'product_discount', 'product_weight', 'product_video', 'product_image', 'description',
    //                     'wash_care', 'fabric', 'pattern', 'sleeve', 'fit', 'occasion', 'meta_title', 'meta_description',
    //                     'meta_keywords', 'is_featured', 'status'];
    protected $guarded = ['id'];


    public function category(){
        return $this->belongsTo(Category::class, 'category_id')->select('id', 'section_id','category_name');
    }

    public function section(){
        return $this->belongsTo(Section::class, 'section_id')->select('id', 'name');
    }

    public function productAttributes()
    {
        return $this->hasMany(ProductAttribute::class);
    }
}
