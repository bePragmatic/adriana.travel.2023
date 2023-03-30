<?php

/**
 * HelpCategoryLang Us Model
 *
 * @package     Tempus media | Booking
 * @subpackage  Model
 * @category    HelpCategoryLang Us
 * @author      Tempus media
 * @version     1.5.3
 * @link        https://tempusmedia.hr
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HelpCategoryLang extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'help_category_lang';

    public $timestamps = false;

    protected $fillable = ['name', 'description'];

    public function language() {
        return $this->belongsTo('App\Models\Language','locale','value');
    }
}
