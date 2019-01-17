<?php

namespace App\Http\Controllers;

use App\Models\Allergen;
use Illuminate\Http\Request;
use App\Http\Resources\AllergenResource;

class AllergenController extends Controller
{
    /**
     * @SWG\Get(
     *     path="/allergens",
     *     tags={"allergens"},
     *     description="Return a list of Allergens",
     *     summary="Lists all allergens with their associated meals",
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
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection /Resources/AllergenResource.php
     */

    public function index()
    {
        return AllergenResource::collection(Allergen::latest()->paginate());
    }

    /**
     * @SWG\Get(
     *     path="/allergens/{allergen}",
     *     tags={"allergens"},
     *     description="Return a Allergen resource",
     *     summary="Read one Allergen",
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
     *
     * Display the specified resource.
     *
     * @param  Allergen $allergen
     * @return AllergenResource /Resources/AllergenResource.php
     */
    public function show(Allergen $allergen)
    {
        return AllergenResource::make($allergen);
    }

    /**
     * @SWG\Post(
     *     path="/allergens",
     *     tags={"allergens"},
     *     description="Create a allergen resource",
     *     summary="Create one Allergen",
     *     @SWG\Parameter(
     *         name="name",
     *         in="query",
     *         type="string",
     *         description="Title of Allergen",
     *         required=true,
     *     ),
     *     @SWG\Response(
     *         response=201,
     *         description="OK",
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
        $allergen = Allergen::create($request->all());
        return response()->json($allergen, 201);
    }

    /**
     * @SWG\Put(
     *     path="/allergens/{allergen}",
     *     tags={"allergens"},
     *     description="Update an Allergen and return name.",
     *     summary="Update one Allergen",
     *     @SWG\Parameter(
     *         name="allergen",
     *         in="path",
     *         type="string",
     *         description="Id of allergen",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="name",
     *         in="query",
     *         type="string",
     *         description="Title of allergen",
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
     * Update a allergen resource and Return JSON response from the application.
     *
     * @param  $request $request
     * @param  Allergen $allergen
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function update(Request $request, Allergen $allergen)
    {
        $allergen->update($request->all());
        return response()->json($allergen, 200);
    }

    /**
     * @SWG\Delete(
     *     path="/allergens/{allergen}",
     *     tags={"allergens"},
     *     description="A allergen resource will be deleted",
     *     summary="Delete one Allergen.",
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
     * Remove the specified resource from storage and Return JSON response from the application.
     *
     * @param  Allergen $allergen
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function delete(Allergen $allergen)
    {
        $allergen->delete();
        return response()->json(null, 204);
    }
}
