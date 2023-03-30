<?php

/**
 * Rooms Steps Status Model
 *
 * @package     Tempus media | Booking
 * @subpackage  Model
 * @category    Rooms Steps Status
 * @author      Tempus media
 * @version     2.0
 * @link        https://tempusmedia.hr
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomsStepsStatus extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'rooms_steps_status';

    public $timestamps = false;

    protected $primaryKey = 'room_id';

    public function setAttribute($attribute, $value)
    {
        if($attribute != 'id')
        {
            $this->attributes[$attribute] = $value.'';
        }
    }
}
