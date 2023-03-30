<?php

namespace App\Models;

use App\Models\Reservation;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{

    protected $guarded = ['id'];

    public function transactions()
    {
        return $this->belongsTo(Reservation::class);
    }
}
