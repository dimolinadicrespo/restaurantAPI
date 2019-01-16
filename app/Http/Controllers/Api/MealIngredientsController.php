<?php

namespace App\Http\Controllers\Api;

use App\Models\Meal;
use App\Models\Ingredient;
use App\Http\Controllers\Controller;
use App\Http\Resources\IngredientOnMealResource;

class MealIngredientsController extends Controller
{
    /**
     * @SWG\Get(
     *     path="/meals/{meal}/ingredients",
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
     *     path="meals/{meal}/ingredients/{ingredient}",
     *     description="Show the specific ingredient associated to a meal.",
     *     summary="Read one ingredient",
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
            'assigned_meals_id' => $ingredient->id
        ])->get());
    }

    /**
     * @SWG\Post(
     *     path="/meals/{meal}/ingredients/{ingredient}",
     *     description="Create a new association between meal and ingredient resource",
     *     summary="Create one meal",
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
            'assigned_meals'   => $ingredient->id,
            'assigned_meals_type' => get_class($ingredient)
        ]);
        return response()->json($ingredient, 201);
    }


    /**
     * @SWG\Delete(
     *     path="/meals/{meal}/ingredients/{ingredient}",
     *     description="A meal resource will be deleted",
     *     summary="Delete one meal.",
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
