<?php

namespace App\Http\Controllers\Secretary\Institution\Report;

use App\Http\Controllers\Controller;
use App\Models\{FoodRecord, Institution};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class InstitutionReportController extends Controller
{
    public function index(Institution $institution, Request $request)
    {
        
        
        $foodRecords = DB::select('select foods.name as name, foods.unit as unit,'
            .' food_records.amount as amount, DATE_FORMAT(food_records.created_at, "%d/%m/%Y") as created_at'
            .' from food_records, foods where foods.id = food_records.food_id AND'
            .' food_records.institution_id = '.$institution->id
            .' AND Date(food_records.created_at) >= '.Carbon::now()->format('Y/m/d')
            .' order by food_records.created_at, food_records.amount DESC');
        
        $consumptions = DB::select('select foods.name as name, foods.unit as unit,'
            .' consumptions.amount_consumed as amount,'
            .' DATE_FORMAT(consumptions.created_at, "%d/%m/%Y") as created_at'
            .' from consumptions, foods where foods.id = consumptions.food_id AND'
            .' consumptions.institution_id = '.$institution->id
            .' AND Date(consumptions.created_at) >= '.Carbon::now()->format('Y/m/d')
            .' order by consumptions.created_at, consumptions.amount_consumed DESC');
            
        $meals = DB::select('select meal.mealtime as time, meal.name as name,'
            .' meal.amount as amount, meal.`repeat` as `repeat`,'
            .' DATE_FORMAT(meal.created_at, "%d/%m/%Y") as created_at'
            .' from meal where meal.institution_id = '.$institution->id
            .' AND Date(meal.created_at) >= '.Carbon::now()->format('Y/m/d')
            .' order by meal.created_at, meal.mealtime, meal.amount DESC');
            
        
        return view('secretary.institutions.report.index', [
            'foodRecords' => $foodRecords,
            'consumptions' => $consumptions,
            'meals' => $meals,
            'institution' => $institution,
            'search' => isset($request->search) ? $request->search : '',
            'begin' => isset($request->begin) ? $request->begin : Carbon::now()->format('d/m/Y'),
            'end' => isset($request->end) ? $request->end : Carbon::now()->format('d/m/Y'),
        ]);

    }
}
