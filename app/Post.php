<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Post extends Model implements TranslatableContract
{
    use Translatable;

    public $translatedAttributes = ['title', 'slug', 'content', 'meta_title','meta_description', 'meta_keywords' ];
    protected $fillable = ['author','img'];
    public $appends = ['src'];



    public function getOriginalSrcAttribute(){
        return @$this->attributes['img'];
    }

    // Get picture source URL based on photo_source
    public function getSrcAttribute()
    {
        $src = $this->attributes['img'];

        if($src == '') {
        //    return url('images/user_pic-225x225.png');
        }


            $photo_src=explode('.',$this->attributes['img']);
            if(count($photo_src)>1) {
                $picture_details = pathinfo($this->attributes['img']);
                $src = url('images/blog/'.$this->attributes['id'].'/'.@$picture_details['filename'].'_600x400.'.@$picture_details['extension']);

        }

        return $src;
    }

}
