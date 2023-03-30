<?php

/**
 * Reservation Model
 *
 * @package     Tempus media | Booking
 * @subpackage  Model
 * @category    Reservation
 * @author      Tempus media
 * @version     2.0
 * @link        https://tempusmedia.hr
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{

    /*
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'ratings';
    protected $guarded =['id'];
    protected $appends = ['compliance_of_the_boat',	'comfort_on_board',	'standard_of_maintenance','cleanliness','welcome_and_communication','value_for_money','feedback','name','email','boat'];

    
}
