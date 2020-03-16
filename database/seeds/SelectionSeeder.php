<?php

use App\Selection;
use Illuminate\Database\Seeder;

class SelectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $selections=[
            ['name'=>'happy','selector_id'=>0],
            ['name'=>'sad','selector_id'=>0],
            ['name'=>'yes','selector_id'=>1],
            ['name'=>'no','selector_id'=>1],
            ['name'=>'i dont know','selector_id'=>1],
        ];
        foreach ($selections as $selection)
        {
            Selection::create($selection);
        }
    }
}
