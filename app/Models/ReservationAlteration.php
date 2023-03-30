<?php

/**
 * Reservation Alteration Model
 *
 * @package     Tempus media | Booking
 * @subpackage  Model
 * @category    Reservation Alteration
 * @author      Tempus media
 * @version     2.0
 * @link        https://tempusmedia.hr
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReservationAlteration extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'reservation_alteration';

    public $timestamps = false;
}
