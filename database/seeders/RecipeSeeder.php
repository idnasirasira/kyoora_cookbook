<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use App\Models\MeasurementQty;
use App\Models\MeasurementUnit;
use App\Models\Recipe;
use App\Models\RecipeIngredient;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RecipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $recipe = Recipe::create([
            'name' => 'Sweet Black Hot Tea',
            'description' => 'It`s a simple black hot tea with sugar',
        ]);

        $ingredients = [
            [
                'qty' => 5,
                'unit' => 'sdt',
                'ingredient' => 'Tea',
            ],
            [
                'qty' => 1,
                'unit' => 'sdt',
                'ingredient' => 'Sugar',
            ],
        ];

        foreach ($ingredients as $key => $value) {
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
}
