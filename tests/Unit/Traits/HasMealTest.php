<?php

namespace Tests\Unit\Traits;

use App\Models\Meal;
use Tests\TestCase;
use App\Traits\HasMeals;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Model as Model;

class HasMealTest extends TestCase
{
    use RefreshDatabase;
    /** @test */

    public function aModelCanBelongsToManyMeals()
    {
        $model = new MyModelWithMeals(['id' => 1]);

        $meal1 = factory(Meal::class)->create(['name' => 'Plato1']);
        $meal2 = factory(Meal::class)->create(['name' => 'Plato2']);
        $meal3 = factory(Meal::class)->create(['name' => 'Plato3']);

        $model->meals()->attach([
            'assigned_meal'   => $meal1->id,
            'assigned_meal_type' => get_class($meal1)
        ]);
        $model->meals()->attach([
            'assigned_meal'   => $meal2->id,
            'assigned_meal_type' => get_class($meal2)
        ]);
        $model->meals()->attach([
            'assigned_meal'   => $meal3->id,
            'assigned_meal_type' => get_class($meal3)
        ]);

        $this->assertInstanceOf(Meal::class, $model->meals->shift());
        $this->assertInstanceOf(Meal::class, $model->meals->shift());
        $this->assertInstanceOf(Meal::class, $model->meals->shift());
    }
}

class MyModelWithMeals extends Model
{
    use HasMeals;
    protected $fillable = ['id'];
}
