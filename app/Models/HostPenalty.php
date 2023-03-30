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

class HostPenalty extends Model
{
    use CurrencyConversion;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'host_penalty';

    // Join with currency table
    public function currency()
    {
        return $this->belongsTo('App\Models\Currency', 'currency_code', 'code');
    }

    // Get Penalty Amount
    public function getConvertedAmountAttribute()
    {
        return $this->currency_calc('amount');
    }

    // Get Penalty Remaining Amount
    public function getConvertedRemainAmountAttribute()
    {
        return $this->currency_calc('remain_amount');
    }
}
