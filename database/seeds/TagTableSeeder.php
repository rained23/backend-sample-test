<?php

use Illuminate\Database\Seeder;
use App\Tag;

class TagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $beta = new Tag;
        $beta->name = "beta";
        $beta->save();

        $normal = new Tag;
        $normal->name = "normal";
        $normal->save();
        
    }
}
