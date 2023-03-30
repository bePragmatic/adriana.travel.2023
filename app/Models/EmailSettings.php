<?php

/**
 * Email Settings Model
 *
 * @package     Tempus media | Booking
 * @subpackage  Model
 * @category    Email Settings
 * @author      Tempus media
 * @version     2.0
 * @link        https://tempusmedia.hr
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailSettings extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'email_settings';

    public $timestamps = false;
}
