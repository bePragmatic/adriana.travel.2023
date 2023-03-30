<?php

/**
 * Help Translations Model
 *
 * @package     Tempus media | Booking
 * @subpackage  Model
 * @category    Help Translations
 * @author      Tempus media
 * @version     1.5.6
 * @link        https://tempusmedia.hr
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HelpTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['name', 'description'];

    public function language() {
    	return $this->belongsTo('App\Models\Language','locale','value');
    }
}
