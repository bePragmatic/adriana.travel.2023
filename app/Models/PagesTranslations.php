<?php

/**
 * Pages Translations Model
 *
 * @package     Tempus media | Booking
 * @subpackage  Model
 * @category    Pages Translations
 * @author      Tempus media
 * @version     2.0
 * @link        https://tempusmedia.hr
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PagesTranslations extends Model
{
    public $timestamps = false;
    protected $fillable = ['name', 'content'];
    
    public function language() {
    	return $this->belongsTo('App\Models\Language','locale','value');
    }
}
