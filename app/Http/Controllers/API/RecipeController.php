<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Ingredient;
use App\Models\MeasurementQty;
use App\Models\MeasurementUnit;
use App\Models\Recipe;
use App\Models\RecipeIngredient;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }
}
