<?php

use Illuminate\Database\Seeder;

class BannersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $records = [['title' => 'Black Jacket', 'image'=>'Banner1.png', 'alt'=>'black_jacket'],
        ['title' => 'Green Shirt', 'image'=>'Banner2.png', 'alt'=>'green_shirt'],
        ['title' => 'Blue Shirt', 'image'=>'Banner3.png', 'alt'=>'blue_shirt'],];

        DB::table('banners')->insert($records);
    }
}
