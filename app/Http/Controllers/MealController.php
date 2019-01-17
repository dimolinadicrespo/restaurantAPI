<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use Illuminate\Http\Request;
use App\Http\Resources\MealResource;

class MealController extends Controller
{
    /**
     * @SWG\Get(
     *     path="/meals",
     *     tags={"meals"},
     *     description="Return a list of meals",
     *     summary="List all meals",
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
     *
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection /Resources/MealResource.php
     */

    public function index()
    {
        return MealResource::collection(Meal::latest()->paginate());
    }

    /**
     * @SWG\Get(
     *     path="/meals/{meal}",
     *     tags={"meals"},
     *     description="Return a meal resource",
     *     summary="Read one meal",
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
     *
     * Display the specified resource.
     *
     * @param  Meal $meal
     * @return MealResource /Resources/MealResource.php
     */
    public function show(Meal $meal)
    {
        return MealResource::make($meal);
    }

    /**
     * @SWG\Post(
     *     path="/meals",
     *     tags={"meals"},
     *     description="Create a meal resource",
     *     summary="Create one meal",
     *     @SWG\Parameter(
     *         name="name",
     *         in="query",
     *         type="string",
     *         description="Title of meal",
     *         required=true,
     *     ),
     *      @SWG\Parameter(
     *         name="description",
     *         in="query",
     *         type="string",
     *         description="Description of meal",
     *         required=true,
     *     ),
     *     @SWG\Response(
     *         response=201,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Not found"
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Unprocessable Entity, validation fails."
     *     )
     * )
     *
     * Store a newly created resource in storage and Return JSON response from the application.
     *
     * @param  $request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function store(Request $request)
    {
        $meal = Meal::create($request->all());

        return response()->json($meal, 201);
    }


    /**
     * @SWG\Put(
     *     path="/meals/{meal}",
     *     tags={"meals"},
     *     description="Update a meal and return a meal name and description.",
     *     summary="Update one meal",
     *     @SWG\Parameter(
     *         name="meal",
     *         in="path",
     *         type="string",
     *         description="Id of meal",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="name",
     *         in="query",
     *         type="string",
     *         description="Mame of meal",
     *         required=false,
     *     ),
     *     @SWG\Parameter(
     *         name="description",
     *         in="query",
     *         type="string",
     *         description="Description of meal",
     *         required=false,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Not found"
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Unprocessable Entity, validation fails."
     *     )
     * )
     *
     * Update a meal resource and Return JSON response from the application.
     *
     * @param  $request $request
     * @param  Meal $meal
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function update(Request $request, Meal $meal)
    {
        $meal->update($request->all());

        return response()->json($meal, 200);
    }

    /**
     * @SWG\Delete(
     *     path="/meals/{meal}",
     *     tags={"meals"},
     *     description="A meal resource will be deleted",
     *     summary="Delete one meal.",
     *     @SWG\Parameter(
     *         name="meal",
     *         in="path",
     *         type="string",
     *         description="Id of meal",
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
     * Remove the specified resource from storage and Return JSON response from the application.
     *
     * @param  Meal $meal
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function delete(Meal $meal)
    {
        $meal->delete();

        return response()->json(null, 204);
    }
}
