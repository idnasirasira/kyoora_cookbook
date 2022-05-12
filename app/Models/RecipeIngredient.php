<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecipeIngredient extends Model
{
    use HasFactory;

    public function recipe()
    {
        return $this->hasOne(Recipe::class);
    }

    public function measurement_unit()
    {
        return $this->belongsTo(MeasurementUnit::class);
    }

    public function measurement_qty()
    {
        return $this->belongsTo(MeasurementQty::class);
    }

    public function ingredient()
    {
        return $this->belongsTo(Ingredient::class);
    }


}
