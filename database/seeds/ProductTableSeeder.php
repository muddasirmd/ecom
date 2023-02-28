<?php

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $records = [
            ['id'=> 1, 'category_id'=> 1, 'section_id'=> 1, 'product_name'=> 'Blue T-Shirt', 'product_code'=>'BH01', 'product_color'=>'Blue'],
            ['id'=> 2, 'category_id'=> 1, 'section_id'=> 1, 'product_name'=> 'Red T-Shirt', 'product_code'=>'BH02', 'product_color'=>'Red'],
        ];

        Product::insert($records);
    }
}
