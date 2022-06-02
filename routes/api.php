<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\RecipeController;
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

Route::post('/login', [AuthController::class, 'login'])->name('api.login');
Route::post('/register', [AuthController::class, 'register'])->name('api.register');
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout'])->name('api.logout');

Route::middleware('auth:sanctum')->group(function(){
    Route::get('/recipes', [RecipeController::class, 'index'])->name('api.recipe.index');
    Route::get('/recipe/{id}', [RecipeController::class, 'show'])->name('api.recipe.show');
    Route::delete('/recipe/{id}', [RecipeController::class, 'destroy'])->name('api.recipe.destroy');
    Route::post('/recipe', [RecipeController::class, 'store'])->name('api.recipe.store');
});
