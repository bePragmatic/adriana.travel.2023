<?php

/**
 * Imported iCal Model
 *
 * @package     Tempus media | Booking
 * @subpackage  Model
 * @category    Imported iCal
 * @author      Tempus media
 * @version     2.0
 * @link        https://tempusmedia.hr
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImportedIcal extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'imported_ical';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['room_id', 'url', 'name', 'last_sync'];
}
