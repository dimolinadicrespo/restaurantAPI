<?php

use App\Models\Allergen;
use Illuminate\Database\Seeder;

class AllergenTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Allergen::truncate();
        factory(Allergen:: class,10)->create();
    }
}
