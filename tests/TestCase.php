<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Function that check if a class make use of a specific trait.
     *
     * @covers \App\Models\Ingredient
     * @covers \App\Models\Allergen
     * @param $trait
     * @param $class
     */
    protected function assertClassHasTrait($trait,$class)
    {
        $this->assertArrayHasKey(
            $trait,
            class_uses($class),
            "{$class} must use {$trait} trait"
        );
    }
}
