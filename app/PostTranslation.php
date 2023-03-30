<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class PostTranslation extends Model
{
    use Sluggable;

    public $timestamps = false;
    protected $fillable = ['title', 'content', 'slug' ,'meta_title', 'meta_description', 'meta_keywords'];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function get_excerpt( $content, $length = 40, $more = '...' ) {
        $excerpt = strip_tags( trim( $content ) );
        $words = str_word_count( $excerpt, 2 );
        if ( count( $words ) > $length ) {
            $words = array_slice( $words, 0, $length, true );
            end( $words );
            $position = key( $words ) + strlen( current( $words ) );
            $excerpt = substr( $excerpt, 0, $position ) . $more;
        }
        return $excerpt;
    }
}
