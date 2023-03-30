<?php

/**
 * Language Model
 *
 * @package     Tempus media | Booking
 * @subpackage  Model
 * @category    Language
 * @author      Tempus media
 * @version     2.0
 * @link        https://tempusmedia.hr
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
     /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'language';

    public $timestamps = false;

    public function scopeActive($query) {
        return $query->where('status', 'Active');
    }

    public function scopeTranslatable($query) {
        return $query->active()->where('is_translatable', '1');
    }
}
