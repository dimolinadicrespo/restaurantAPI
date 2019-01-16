<?php

namespace Tests\Unit\Http\Models;

use Tests\TestCase;
use App\Traits\HasMeals;
use App\Models\Ingredient;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IngredientTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that check if a App\Models\Ingredient makes use of HasMeals trait.
     */
    /** @test */
    public function aIngredientModelMustBeUseHasMealsTrait()
    {
        $this->assertClassHasTrait(HasMeals::class,Ingredient::class);
    }
}
