<?php

namespace App\Models;

use DB;

use Illuminate\Database\Eloquent\Model;

class RoomDayPrice extends Model
{
    protected $table = 'room_day_price';
	public $timestamps = false;

	protected $fillable = ['from_date', 'to_date', 'price','room_id'];
}
 