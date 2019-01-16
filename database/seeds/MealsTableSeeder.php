<?php

use App\Models\Meal;
use Illuminate\Database\Seeder;

class MealsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Meal::truncate();
        factory(Meal::class,5)->create();
    }
}
