<?php

/**
 * Home Page Sliders Model
 *
 * @package     Tempus media | Booking
 * @subpackage  Model
 * @category    Home Page Slider
 * @author      Tempus media
 * @version     2.0
 * @link        https://tempusmedia.hr
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomePageSlider extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'home_page_sliders';

    public $timestamps = false;

    public $appends = ['image_url'];

    public function scopeActiveOnly($query)
    {
        return $query->whereStatus('Active');
    }

    public function getImageUrlAttribute()
    {
        if($this->attributes['source'] == 'Local') {
            return asset('/images/slider/'.$this->attributes['image']);
        }
        $options['secure']  = TRUE;
        $options['crop']    = 'fill';
        return $src=\Cloudder::show($this->attributes['image'],$options);
    }
}
