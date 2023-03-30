<?php

/**
 * Password Resets Model
 *
 * @package     Tempus media | Booking
 * @subpackage  Model
 * @category    Password Resets
 * @author      Tempus media
 * @version     2.0
 * @link        https://tempusmedia.hr
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordResets extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'password_resets';

    public $timestamps = false;
}
