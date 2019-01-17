<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use App\Models\Allergen;
use App\Http\Resources\AllergenOnMealResource;

class MealAllergensController extends Controller
{
    /**
     * @SWG\Get(
     *     path="/meals/{meal}/allergens",
     *     description="Return a list of allergens",
     *     summary="List all allergens associated with the meal",
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
     * @return AllergenOnMealResource|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Meal $meal)
    {
        return AllergenOnMealResource::collection($meal->allergens);
    }

    /**
     * @SWG\Get(
     *     path="meals/{meal}/allergens/{allergen}",
     *     description="Show the specific allergen associated to a meal.",
     *     summary="Read one allergen",
     *     @SWG\Parameter(
     *         name="meal",
     *         in="path",
     *         type="string",
     *         description="Id of meal",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="allergen",
     *         in="path",
     *         type="string",
     *         description="Id of allergen",
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
     * @param  Allergen $allergen
     * @return AllergenOnMealResource|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function show(Meal $meal, Allergen $allergen)
    {
        return AllergenOnMealResource::collection($meal->allergens()->where([
            'assigned_meals_id' => $allergen->id
        ])->get());
    }

    /**
     * @SWG\Post(
     *     path="/meals/{meal}/allergens/{allergen}",
     *     description="Create a new association between meal and allergen resource",
     *     summary="Create one meal",
     *     @SWG\Parameter(
     *         name="meal",
     *         in="path",
     *         type="string",
     *         description="Id of meal",
     *         required=true,
     *     ),
     *      @SWG\Parameter(
     *         name="allergen",
     *         in="path",
     *         type="string",
     *         description="Id of allergen",
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
     * @param  \App\Models\Allergen $allergen
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function store(Meal $meal, Allergen $allergen)
    {
        $meal->allergens()->attach([
            'assigned_meals'   => $allergen->id,
            'assigned_meals_type' => get_class($allergen)
        ]);
        return response()->json($allergen, 201);
    }


    /**
     * @SWG\Delete(
     *     path="/meals/{meal}/allergens/{allergen}",
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
     *         name="allergen",
     *         in="path",
     *         type="string",
     *         description="Id of allergen",
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
     * Remove the specified Association between meal and allergen from storage and Return JSON response from the application.
     *
     * @param  \App\Models\Meal $meal
     * @param  \App\Models\Allergen $allergen
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function delete(Meal $meal, Allergen $allergen)
    {
        $meal->allergens()->detach($allergen->id);

        return response()->json(null, 204);
    }
}
