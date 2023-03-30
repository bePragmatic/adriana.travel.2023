<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Boat extends Model
{
    
    protected $table = 'managing_boat_price';
    
    protected $fillable = ['from_date', 'to_date', 'half_day_price', 'full_day_price', 'season_name', 'boat_type'];


}
