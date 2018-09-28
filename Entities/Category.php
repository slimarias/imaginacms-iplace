<?php

namespace Modules\Iplaces\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;


class Category extends Model
{
    use Translatable;
    //use Sluggable;

    protected $table = 'iplaces__categories';
    public $translatedAttributes = ['title', 'description', 'slug'];
    protected $fillable = ['title', 'description', 'slug', 'parent_id', 'options','status'];
    protected $fakeColumns = ['options'];

    protected $casts = [
        'options' => 'array'
    ];

    /*
     * ---------
     * RELATIONS
     * ---------
     */
    public function parent()
    {
        return $this->belongsTo('Modules\Iplaces\Entities\Category', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany('Modules\Iplaces\Entities\Category', 'parent_id');
    }

    public function places()
    {
        return $this->belongsToMany(Place::class, 'iplaces_place_category');
    }

    protected function setSlugAttribute($value)
    {

        if (!empty($value)) {
            $this->attributes['slug'] = str_slug($value, '-');
        } else {
            $this->attributes['slug'] = str_slug($this->attributes['title'], '-');
        }
    }
    //generar url automatica
    /* public function sluggable()
     {
         return [
             'slug' => [
                 'source' => 'title'
             ]
         ];
     }*/
    /*
     * -------------
     * IMAGE
     * -------------
     */

    public function getMainimageAttribute()
    {

        return ($this->options->mainimage ?? 'modules/iplace/img/category/default.jpg') . '?v=' . format_date($this->updated_at, '%u%w%g%k%M%S');
    }

    public function getMediumimageAttribute()
    {

        return str_replace('.jpg', '_mediumThumb.jpg', $this->options->mainimage ?? 'modules/iplace/img/category/default.jpg') . '?v=' . format_date($this->updated_at, '%u%w%g%k%M%S');
    }

    public function getThumbailsAttribute()
    {

        return str_replace('.jpg', '_smallThumb.jpg', $this->options->mainimage ?? 'modules/iplace/img/category/default.jpg') . '?v=' . format_date($this->updated_at, '%u%w%g%k%M%S');
    }

    public function getMetadescriptionAttribute()
    {

        return $this->options->metadescription ?? substr(strip_tags($this->description), 0, 150);
    }

    /**
     * @return mixed
     */
    public function getMetatitleAttribute()
    {

        return $this->options->metatitle ?? $this->title;
    }

    public function getUrlAttribute()
    {

        return url($this->slug);

    }

    /*
   |--------------------------------------------------------------------------
   | SCOPES
   |--------------------------------------------------------------------------
   */
    public function scopeFirstLevelItems($query)
    {
        return $query->where('depth', '1')
            ->orWhere('depth', null)
            ->orderBy('lft', 'ASC');
    }

    /**
     * Check if the post is in draft
     * @param Builder $query
     * @return Builder
     */
    public function scopeActive(Builder $query)
    {
        return $query->whereStatus(Status::ACTIVE);
    }

    /**
     * Check if the post is pending review
     * @param Builder $query
     * @return Builder
     */
    public function scopeInactive(Builder $query)
    {
        return $query->whereStatus(Status::INACTIVE);
    }

}
