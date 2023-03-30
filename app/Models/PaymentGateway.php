<?php

/**
 * Payment Gateway Model
 *
 * @package     Tempus media | Booking
 * @subpackage  Model
 * @category    Payment Gateway
 * @author      Tempus media
 * @version     2.0
 * @link        https://tempusmedia.hr
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentGateway extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'payment_gateway';

    public $timestamps = false;
}
