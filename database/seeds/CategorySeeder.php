<?php

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories=[
            ['name'=>'Electronics','icon'=>'fas fa-desktop'],
            ['name'=>'Buildings','icon'=>'far fa-building'],
            ['name'=>'Furniture','icon'=>'fas fa-couch'],
        ];
        foreach ($categories as $category)
        {
            \App\Category::create($category);
        }
    }
}
