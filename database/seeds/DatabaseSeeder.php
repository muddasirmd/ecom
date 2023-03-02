<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(AdminTableSeeder::class);
        // $this->call(UsersTableSeeder::class);
        // $this->call(SectionsTableSeeder::class);
        // $this->call(CategoriesTableSeeder::class);
        // $this->call(ProductTableSeeder::class);
        $this->call(ProductAttributesTableSeeder::class);
    }
}
