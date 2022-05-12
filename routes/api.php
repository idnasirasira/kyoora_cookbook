<?php

use App\Models\Recipe;
use App\Models\RecipeIngredient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/recipes', function(Request $request) {

    $recipes = Recipe::with([
        'recipe_ingredients' => function($q) {
            $q->join('measurement_units', 'recipe_ingredients.measurement_unit_id','=','measurement_units.id');
            $q->join('measurement_qties', 'recipe_ingredients.measurement_qty_id','=','measurement_qties.id');
            $q->join('ingredients', 'recipe_ingredients.ingredient_id','=','ingredients.id');
        }
    ])->get();

    return response()->json([
        'data' => $recipes,
    ], 200);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
