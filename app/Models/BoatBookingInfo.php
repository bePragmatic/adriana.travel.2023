<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BoatBookingInfo extends Model
{
    
    protected $table = 'booking_info';
    
    protected $fillable = [ 'boat_booking_id','first_name', 'last_name','email' ,'phone', 'zip_code', 'country', 'city', 'address', 'city', 'date_of_birth', 'message'];


}
