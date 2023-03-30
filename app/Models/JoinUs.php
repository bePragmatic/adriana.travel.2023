<?php

/**
 * Join Us Model
 *
 * @package     Tempus media | Booking
 * @subpackage  Model
 * @category    Join Us
 * @author      Tempus media
 * @version     2.0
 * @link        https://tempusmedia.hr
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JoinUs extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'join_us';

    public $timestamps = false;
}
