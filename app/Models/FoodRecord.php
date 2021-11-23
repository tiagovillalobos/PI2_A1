<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'food_id',
        'institution_id'
    ];

    protected $appends = [
        'amount_remaining'
    ];

    public function scopeGroupByFood($query)
    {
        return $query->selectRaw(
            'foods.id AS food_id, 
            foods.name AS food_name, 
            foods.unit AS food_unit, 
            SUM(food_records.amount) AS amount,
            (SELECT 
                SUM(consumptions.amount_consumed) FROM consumptions WHERE consumptions.food_id = foods.id
            ) AS amount_consumed,
            (SELECT amount - COALESCE(amount_consumed, 0)) AS amount_remaining
            '
        )
        ->join('foods', 'foods.id', '=', 'food_records.food_id')
        ->groupBy('foods.id');
    }

    public function getAmountRemainingAttribute()
    {
        $amountRemaining = $this->attributes['amount_remaining'];

        return $amountRemaining <= 9 ? '0'.$amountRemaining : $amountRemaining;
    }

    public function food()
    {
        return $this->belongsTo(Food::class);
    }
}
