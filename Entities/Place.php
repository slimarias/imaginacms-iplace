<?php

namespace Modules\Iplaces\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Iplaces\Entities\Category;
use Laracasts\Presenter\PresentableTrait;
use Modules\Iplaces\Presenters\PlacePresenter;
use Modules\Iplaces\Events\PlaceWasCreated;
use Modules\Core\Traits\NamespacedEntity;



class Place extends Model
{
    use Translatable, PresentableTrait, NamespacedEntity;

    protected $table = 'iplaces__places';
    public $translatedAttributes = ['title','description','slug','metatitle','metadescription','metakeywords'];
    protected $fillable = ['title','description','slug','user_id','status','summary','address','options','category_id','created_at','metatitle','metadescription','metakeywords'];
    protected $fakeColumns = ['options'];
    protected $presenter = PlacePresenter::class;

    protected $casts = [
        'options' => 'array',
        'status'=>'int'
    ];

    /*
     * ---------
     * RELATIONS
     * --------
     */
    protected function setSlugAttribute($value){

        if(!empty($value)){
            $this->attributes['slug'] = str_slug($value,'-');
        }else{
            $this->attributes['slug'] = str_slug($this->attributes['title'],'-');
        }

    }

    public function user()
    {
        $driver = config('asgard.user.config.driver');
        return $this->belongsTo("Modules\\User\\Entities\\{$driver}\\User");
    }
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'iplaces_place_category');
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /*
     * -------------
     * IMAGE
     * -------------
     */

    public function getMainimageAttribute(){

        $image=$this->options->mainimage ?? 'modules/iplaces/img/default.jpg';
        $v=strftime('%u%w%g%k%M%S', strtotime($this->updated_at));
        // dd($v) ;
        return url($image.'?v='.$v);
        //return ($this->options->mainimage ?? 'modules/iplace/img/place/default.jpg').'?v='.format_date($this->updated_at,'%u%w%g%k%M%S');
    }
    public function getMediumimageAttribute(){

        return str_replace('.jpg','_mediumThumb.jpg',$this->options->mainimage ?? 'modules/iplaces/img/default.jpg').'?v='.format_date($this->updated_at,'%u%w%g%k%M%S');
    }
    public function getThumbailsAttribute(){

        return str_replace('.jpg','_smallThumb.jpg',$this->options->mainimage?? 'modules/iplaces/img/default.jpg').'?v='.format_date($this->updated_at,'%u%w%g%k%M%S');
    }
    public function getMetatitleAttribute(){

        $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();
        return $this->translate($locale)->metatitle ?? $this->translate($locale)->title;

    }
    public function getMetadescriptionAttribute(){

        return $this->metadescription ?? substr(strip_tags($this->description),0,150);
    }


    public function getUrlAttribute() {

        return url($this->slug);

        //return \URL::route(\LaravelLocalization::getCurrentLocale() . '.iplaces.slug', [$this->category->slug,$this->slug]);
    }
    public function getOptionsAttribute($value)
    {

        return json_decode(json_decode($value));

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
