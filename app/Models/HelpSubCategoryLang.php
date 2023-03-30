<?php

/**
 * HelpSubCategoryLang Us Model
 *
 * @package     Tempus media | Booking
 * @subpackage  Model
 * @category    HelpSubCategoryLang Us
 * @author      Tempus media
 * @version     1.5.3
 * @link        https://tempusmedia.hr
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model; 

class HelpSubCategoryLang extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'help_sub_category_lang';

    protected $fillable = ['name', 'description'];

    public $timestamps = false;

    public function language() {
        return $this->belongsTo('App\Models\Language','locale','value');
    }
}
