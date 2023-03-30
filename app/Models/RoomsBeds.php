<?php

/**
 * Applied Rooms Beds
 *
 * @package     Tempus media | Booking
 * @subpackage  Model
 * @category    Applied Rooms Beds
 * @author      Tempus media
 * @version     1.5.4
 * @link        https://tempusmedia.hr
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Session;

class RoomsBeds extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'rooms_beds';

    public $guarded = [];

    public $timestamps = false;

  /*  public function getIconAttribute()
    {
        $name = strtolower(str_replace(' ','-',$this->attributes['name']));
        $url = url('images/icons/bed_type/'.$name.'.png');
        return $url;

    }*/

  
}
