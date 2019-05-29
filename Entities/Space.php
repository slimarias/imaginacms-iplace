<?php

namespace Modules\Iplaces\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Iplaces\Presenters\SpacePresenter;
use Laracasts\Presenter\PresentableTrait;
use Modules\Media\Support\Traits\MediaRelation;
use Modules\Media\Entities\File;

class Space extends Model
{
    use Translatable,PresentableTrait, MediaRelation;

    protected $table = 'iplaces__spaces';
    public $translatedAttributes = ['title', 'description', 'slug','meta_title','meta_description','meta_keywords'];
    protected $fillable = ['title', 'description', 'slug', 'options','status','meta_title','meta_description','meta_keywords'];
    protected $fakeColumns = ['options'];

    protected $presenter = SpacePresenter::class;

    protected $casts = [
        'options' => 'array'
    ];

    public function places()
    {
        return $this->belongsToMany(Place::class, 'iplaces__place_space');
    }

    protected function setSlugAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['slug'] = str_slug($value, '-');
        } else {
            $this->attributes['slug'] = str_slug($this->attributes['title'], '-');
        }
    }

    public function getMainImageAttribute()
    {
        $image=$this->options->mainimage ?? 'modules/iplaces/img/default.jpg';
        $v=strftime('%u%w%g%k%M%S', strtotime($this->updated_at));
        // dd($v) ;
        return url($image.'?v='.$v);

    }

    public function getUrlAttribute()
    {
        return url($this->slug);
    }

    public function getOptionsAttribute($value)
    {
        return json_decode(json_decode($value));
    }

}
