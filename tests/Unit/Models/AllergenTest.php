<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Allergen;
use App\Traits\HasMeals;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AllergenTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Test that check if a App\Models\Ingredient makes use of HasMeals trait.
     */
    /** @test */
    public function aIngredientModelMustBeUseHasMealsTrait()
    {
        $this->assertClassHasTrait(HasMeals::class,Allergen::class);
    }
}
