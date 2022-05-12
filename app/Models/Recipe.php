<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    public function recipe_ingredients()
    {
        return $this->hasMany(RecipeIngredient::class);
    }
}
