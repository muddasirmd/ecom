<?php

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $records = [['id'=>1, 'parent_id'=>0, 'section_id'=>1, 'category_name'=>'T-Shirts', 'url'=>'t-shirts'],
        ['id'=>2, 'parent_id'=>1, 'section_id'=>1, 'category_name'=>'Casual T-Shirts', 'url'=>'casual-t-shirts'],
        ];

        Category::insert($records);
    }
}
