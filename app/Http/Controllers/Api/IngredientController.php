<?php

namespace App\Http\Controllers\Api;

use App\Models\Ingredient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\IngredientResource;

class IngredientController extends Controller
{
    /**
    * @SWG\Get(
    *     path="/ingredients",
    *     description="Return a list of Ingredients",
    *     summary="List all ingredients",
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
    * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection /Resources/IngredientResource.php
    */

    public function index()
    {
        return IngredientResource::collection(Ingredient::latest()->paginate());
    }

    /**
    * @SWG\Get(
    *     path="/ingredients/{ingredient}",
    *     description="Return a Ingredient resource",
    *     summary="Read one Ingredient",
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
    *
    * Display the specified resource.
    *
    * @param  Ingredient $ingredient
    * @return IngredientResource /Resources/IngredientResource.php
    */
    public function show(Ingredient $ingredient)
    {
        return IngredientResource::make($ingredient);
    }

    /**
     * @SWG\Post(
     *     path="/ingredients",
     *     description="Return a Ingredients name and description",
     *     summary="Create one Ingredient",
     *     @SWG\Parameter(
     *         name="name",
     *         in="query",
     *         type="string",
     *         description="Title of ingredient",
     *         required=true,
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
     *
     * Store a newly created resource in storage and Return JSON response from the application.
     *
     * @param  $request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function store(Request $request)
    {
        $ingredient = Ingredient::create($request->all());
        return response()->json($ingredient, 201);
    }


    /**
     * @SWG\Put(
     *     path="/ingredients/{ingredient}",
     *     description="Return a Ingredent name and description",
     *     summary="Update one Ingredent",
     *     @SWG\Parameter(
     *         name="ingredient",
     *         in="path",
     *         type="string",
     *         description="Id of ingredient",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="title",
     *         in="query",
     *         type="string",
     *         description="Title of ingredient",
     *         required=false,
     *     ),
     *     @SWG\Parameter(
     *         name="body",
     *         in="query",
     *         type="string",
     *         description="Body of ingredient",
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
     * @param  Ingredient $ingredient
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function update(Request $request, Ingredient $ingredient)
    {
        $ingredient->update($request->all());
        return response()->json($ingredient, 200);
    }

    /**
     * @SWG\Delete(
     *     path="/ingredients/{ingredient}",
     *     description="A ingredient resource will be deleted",
     *     summary="Delete one Ingredent.",
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
     *
     * Remove the specified resource from storage and Return JSON response from the application.
     *
     * @param  Ingredient $ingredient
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function delete(Ingredient $ingredient)
    {
        $ingredient->delete();
        return response()->json(null, 204);
    }
}
