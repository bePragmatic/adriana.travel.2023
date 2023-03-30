<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BoatBooking extends Model
{
    
    protected $table = 'boat_booking';
    
    protected $fillable = [ 'boat_id','checkIn_date', 'checkOut_date','no_of_person' ,'half_day_price', 'full_day_price', 'total', 'boat_type','status'];


}
