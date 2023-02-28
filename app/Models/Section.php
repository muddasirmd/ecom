<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    public function categories(){
        return $this->hasMany(Category::class, 'section_id')->where(['parent_id'=>0, 'status'=>1]);
    }
}
