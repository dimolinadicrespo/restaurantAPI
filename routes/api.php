<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
// Meals
Route::get(   'meals',                                  'MealController@index') 					->name('api.meals.index');
Route::get(   'meals/{meal}',                           'MealController@show')  					->name('api.meals.show');
Route::post(  'meals',                                  'MealController@store') 					->name('api.meals.store');
Route::put(   'meals/{meal}',                           'MealController@update')					->name('api.meals.update');
Route::delete('meals/{meal}',                           'MealController@delete')					->name('api.meals.delete');
//Ingredients
Route::get(   'ingredients',                            'IngredientController@index') 			->name('api.ingredients.index');
Route::get(   'ingredients/{ingredient}',               'IngredientController@show')  			->name('api.ingredients.show');
Route::post(  'ingredients',                            'IngredientController@store') 			->name('api.ingredients.store');
Route::put(   'ingredients/{ingredient}',               'IngredientController@update')			->name('api.ingredients.update');
Route::delete('ingredients/{ingredient}',               'IngredientController@delete')			->name('api.ingredients.delete');
//Allergen
Route::get(		'allergens',                              'AllergenController@index') 			->name('api.allergens.index');
Route::get(		'allergens/{allergen}',                   'AllergenController@show')  			->name('api.allergens.show');
Route::post(	'allergens',                              'AllergenController@store') 			->name('api.allergens.store');
Route::put(		'allergens/{allergen}',                   'AllergenController@update')			->name('api.allergens.update');
Route::delete('allergens/{allergen}',                   'AllergenController@delete')	            ->name('api.allergens.delete');
// Add / Remove Ingredients to Meals
Route::get(   'meals/{meal}/ingredients',               'MealIngredientsController@index')       ->name('api.meals.ingredients.index');
Route::get(   'meals/{meal}/ingredients/{ingredient}',  'MealIngredientsController@show')        ->name('api.meals.ingredients.show');
Route::post(  'meals/{meal}/ingredients/{ingredient}',  'MealIngredientsController@store')       ->name('api.meals.ingredients.store');
Route::delete('meals/{meal}/ingredients/{ingredient}',  'MealIngredientsController@delete')      ->name('api.meals.ingredients.delete');
// Add / Remove Allergen to Meals
Route::get(   'meals/{meal}/allergens',                 'MealAllergensController@index')         ->name('api.meals.allergens.index');
Route::get(   'meals/{meal}/allergens/{allergen}',      'MealAllergensController@show')          ->name('api.meals.allergens.show');
Route::post(  'meals/{meal}/allergens/{allergen}',      'MealAllergensController@store')         ->name('api.meals.allergens.store');
Route::delete('meals/{meal}/allergens/{allergen}',      'MealAllergensController@delete')        ->name('api.meals.allergens.delete');
// Route for Not Found Resources
Route::fallback(function(){
    return response()->json(['message' => 'Data Not Found!'], 404);
})->name('fallback');