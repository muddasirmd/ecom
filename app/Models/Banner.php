<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $guarded = ['id'];

    public static function getBanners(){
        $banners = Banner::where("status", 1)->get();
        return $banners;
    }
}
