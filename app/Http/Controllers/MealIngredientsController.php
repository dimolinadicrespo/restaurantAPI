<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use App\Models\Ingredient;
use App\Http\Resources\IngredientOnMealResource;

class MealIngredientsController extends Controller
{
    /**
     * @SWG\Get(
     *     path="/meals/{meal}/ingredients",
     *     tags={"Associate ingredient to meal"},
     *     description="Return a list of ingredients",
     *     summary="List all ingredients associated with the meal",
     *     @SWG\Parameter(
     *         name="meal",
     *         in="path",
     *         type="string",
     *         description="Id of meal",
     *         required=true,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Please provide correct data"
     *     )
     * )
     *
     * Display a listing of the resource.
     *
     * @param \App\Models\Meal $meal
     * @return IngredientOnMealResource|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Meal $meal)
    {
        return IngredientOnMealResource::collection($meal->ingredients);
    }

    /**
     * @SWG\Get(
     *     path="/meals/{meal}/ingredients/{ingredient}",
     *     tags={"Associate ingredient to meal"},
     *     description="Show the specific ingredient associated to a meal.",
     *     summary="Read one ingredient associate to a meal",
     *     @SWG\Parameter(
     *         name="meal",
     *         in="path",
     *         type="string",
     *         description="Id of meal",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="ingredient",
     *         in="path",
     *         type="string",
     *         description="Id of ingredient",
     *         required=true,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Please provide correct data"
     *     )
     * )
     *
     * Display the specified resource.
     * @param \App\Models\Meal $meal
     * @param  Ingredient $ingredient
     * @return IngredientOnMealResource|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function show(Meal $meal, Ingredient $ingredient)
    {
        return IngredientOnMealResource::collection($meal->ingredients()->where([
            'assigned_meal_id' => $ingredient->id
        ])->get());
    }

    /**
     * @SWG\Post(
     *     path="/meals/{meal}/ingredients/{ingredient}",
     *     tags={"Associate ingredient to meal"},
     *     description="Create a new association between meal and ingredient resource",
     *     summary="Associate one ingredient associate to meal",
     *     @SWG\Parameter(
     *         name="meal",
     *         in="path",
     *         type="string",
     *         description="Id of meal",
     *         required=true,
     *     ),
     *      @SWG\Parameter(
     *         name="ingredient",
     *         in="path",
     *         type="string",
     *         description="Id of ingredient",
     *         required=true,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Not found"
     *     )
     * )
     *
     * Store a newly created association in storage and Return JSON response from the application.
     *
     * @param \App\Models\Meal $meal
     * @param  \App\Models\Ingredient $ingredient
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function store(Meal $meal, Ingredient $ingredient)
    {
        $meal->ingredients()->attach([
            'assigned_meal'   => $ingredient->id,
            'assigned_meal_type' => get_class($ingredient)
        ]);
        return response()->json($ingredient, 201);
    }


    /**
     * @SWG\Delete(
     *     path="/meals/{meal}/ingredients/{ingredient}",
     *     tags={"Associate ingredient to meal"},
     *     description="A meal resource will be deleted",
     *     summary="Disassociation one allergen of one  meal.",
     *     @SWG\Parameter(
     *         name="meal",
     *         in="path",
     *         type="string",
     *         description="Id of meal",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="ingredient",
     *         in="path",
     *         type="string",
     *         description="Id of ingredient",
     *         required=true,
     *     ),
     *     @SWG\Response(
     *         response=204,
     *         description="Resource deleted",
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Not found"
     *     )
     * )
     *
     * Remove the specified Association between meal and ingredient from storage and Return JSON response from the application.
     *
     * @param  \App\Models\Meal $meal
     * @param  \App\Models\Ingredient $ingredient
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function delete(Meal $meal, Ingredient $ingredient)
    {
        $meal->ingredients()->detach($ingredient->id);

        return response()->json(null, 204);
    }
}
