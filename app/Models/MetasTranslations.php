<?php

/**
 * Our Community Banners Translations Model
 *
 * @package     Tempus media | Booking
 * @subpackage  Model
 * @category    Our Community Banners Translations
 * @author      Tempus media
 * @version     2.0
 * @link        https://tempusmedia.hr
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MetasTranslations extends Model
{
    public $timestamps = false;
    protected $fillable = ['title', 'description', 'keywords'];

    public function language() {
    	return $this->belongsTo('App\Models\Language','locale','value');
    }   
}
