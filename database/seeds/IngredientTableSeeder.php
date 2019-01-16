<?php

use App\Models\Ingredient;
use Illuminate\Database\Seeder;

class IngredientTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Ingredient::truncate();
        factory(Ingredient:: class,10)->create();
    }
}
