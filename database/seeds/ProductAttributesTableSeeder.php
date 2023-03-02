<?php

use Illuminate\Database\Seeder;
use App\Models\ProductAttribute;

class ProductAttributesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $records = [
            ['id'=> 1, 'product_id'=> 1, 'size'=> 'Small', 'sku'=>'BH01-S', 'stock'=> 10, 'price'=>1200],
            ['id'=> 2, 'product_id'=> 1, 'size'=> 'Large', 'sku'=>'BH01-L', 'stock'=> 5, 'price'=>1300],
        ];

        ProductAttribute::insert($records);
    }
}
