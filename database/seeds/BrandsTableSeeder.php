<?php

use Illuminate\Database\Seeder;

class BrandsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $records = [['name' => 'Leo'], ['name'=> 'Polo'], ['name'=> 'Outfitters'], ['name'=> 'Gaps']];

        DB::table('Brands')->insert($records);
    }
}
