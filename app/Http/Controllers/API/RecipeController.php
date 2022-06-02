<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Ingredient;
use App\Models\MeasurementQty;
use App\Models\MeasurementUnit;
use App\Models\Recipe;
use App\Models\RecipeIngredient;
use Illuminate\Http\Request;
use \Illuminate\Database\Eloquent\ModelNotFoundException;

class RecipeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $recipes = Recipe::with([
            'recipe_ingredients' => function($q) {
                $q->join('measurement_units', 'recipe_ingredients.measurement_unit_id','=','measurement_units.id');
                $q->join('measurement_qties', 'recipe_ingredients.measurement_qty_id','=','measurement_qties.id');
                $q->join('ingredients', 'recipe_ingredients.ingredient_id','=','ingredients.id');
            }
        ])->get();

        return response()->json([
            'msg' => 'All recipes',
            'data' => $recipes,
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $recipe = Recipe::create([
                'name' => $request->name,
                'description' => $request->description,
            ]);

            foreach ($request->ingredients as $key => $value) {
                $measurement_qty = MeasurementQty::firstOrCreate([
                    'qty_amount' => $value['qty']
                ]);

                $measurement_unit = MeasurementUnit::firstOrCreate([
                    'measurement_description' => $value['unit']
                ]);

                $ingredient = Ingredient::firstOrCreate([
                    'ingredient_name' => $value['ingredient']
                ]);

                RecipeIngredient::create([
                    'recipe_id' => $recipe->id,
                    'measurement_unit_id' => $measurement_unit->id,
                    'measurement_qty_id' => $measurement_qty->id,
                    'ingredient_id' => $ingredient->id,
                ]);
            }

            return response()->json([
                'msg' => __('Recipe created.'),
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'msg' => __('Ops, we fail to create your recipe. Please try again.'),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $recipes = Recipe::with([
            'recipe_ingredients' => function($q) {
                $q->join('measurement_units', 'recipe_ingredients.measurement_unit_id','=','measurement_units.id');
                $q->join('measurement_qties', 'recipe_ingredients.measurement_qty_id','=','measurement_qties.id');
                $q->join('ingredients', 'recipe_ingredients.ingredient_id','=','ingredients.id');
            }
        ])->where('id', $id)->get()->first();

        return response()->json([
            'msg' => "Recipes by ID#{$id}",
            'data' => $recipes,
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $recipe = Recipe::findOrFail($id);
        } catch (\Throwable $th) {
            if($th instanceof ModelNotFoundException) {
                return response()->json([
                    'msg' => __("Recipe with ID :ID not found.", ['ID' => $id]),
                ], 404);
            }
        }

        if(!$recipe->isEmpty()) {
            RecipeIngredient::where('recipe_id', $id)->delete();

            $recipe->delete();

            return response()->json([
                'msg' => __("Recipes :ID has been deleted", ['ID' => $id]),
            ], 200);
        } else {
            return response()->json([
                'msg' => __("Deleting recipe :ID failed.", ['ID' => $id]),
            ], 200);
        }

    }
}
