<?php

namespace Modules\Iplaces\Entities;


use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\Iplaces\Entities\Category;
use Modules\Iplaces\Entities\Schedule;
use Modules\Iplaces\Entities\Zone;
use Laracasts\Presenter\PresentableTrait;
use Modules\Iplaces\Presenters\PlacePresenter;
use Modules\Iplaces\Events\PlaceWasCreated;
use Modules\Core\Traits\NamespacedEntity;
use Modules\Iplaces\Entities\City as Site;
use Modules\Ilocations\Entities\City;
use Modules\Ilocations\Entities\Province;
use Modules\Iplaces\Entities\Range;
use Modules\Media\Support\Traits\MediaRelation;
use Modules\Media\Entities\File;

class Place extends Model
{
  use Translatable, PresentableTrait, NamespacedEntity, MediaRelation;

  protected $table = 'iplaces__places';
  public $translatedAttributes = [
    'title',
    'description',
    'slug',
    'summary',
    'meta_title',
    'meta_description',
    'meta:keywords'
  ];
  protected $fillable = [
    'title',
    'description',
    'slug',
    'user_id',
    'status',
    'summary',
    'address',
    'options',
    'category_id',
    'meta_title',
    'meta_description',
    'meta_keywords',
    'zone_id',
    'city_id',
    'site_id',
    'service_id',
    'province_id',
    'schedule_id',
    'gama',
    'quantity_person',
    'weather',
    'housing',
    'transport',
    'rating',
    'validated',
    'order',
    'options',
    'schedules'
  ];
  protected $fakeColumns = ['options','address'];
  protected $presenter = PlacePresenter::class;

  protected $casts = [
    'options' => 'array',
    'status' => 'int',
    'zone_id' => 'int',
    'schedule_id' => 'int',
    'province_id',
    'weather' => 'int',
    'address' => 'array'
  ];

  /*
   * ---------
   * RELATIONS
   * --------
   */
  protected function setSlugAttribute($value)
  {

    if (!empty($value)) {
      $this->attributes['slug'] = Str::slug($value, '-');
    } else {
      $this->attributes['slug'] = Str::slug($this->attributes['title'], '-');
    }

  }

  public function user()
  {
    $driver = config('asgard.user.config.driver');
    return $this->belongsTo("Modules\\User\\Entities\\{$driver}\\User");
  }

  public function category()
  {
    return $this->belongsTo(Category::class, 'category_id');
  }

  public function categories()
  {
    return $this->belongsToMany(Category::class, 'iplaces__place_category');
  }

  public function services()
  {
    return $this->belongsToMany(Service::class, 'iplaces__place_service');
  }

  public function spaces()
  {
    return $this->belongsToMany(Space::class, 'iplaces__place_space');
  }


  public function zone()
  {
    return $this->belongsTo(Zone::class);
  }

  public function city()
  {
    return $this->belongsTo(City::class);
  }

  public function site()
  {
    return $this->belongsTo(Site::class);
  }

  public function province()
  {
    return $this->belongsTo(Province::class);
  }

  public function schedule()
  {
    return $this->belongsTo(Schedule::class);
  }

  public function schedules()
  {
    return $this->belongstoMany(Schedule::class, 'iplaces__place_schedule');
  }

  /*
   * -------------
   * IMAGE
   * -------------
   */

  public function getMainImageAttribute()
  {

    $thumbnail = $this->files()->where('zone', 'mainimage')->first();
    if (!$thumbnail) return [
      'mimeType' => 'image/jpeg',
      'path' => url('modules/iblog/img/post/default.jpg')
    ];
    return [
      'mimeType' => $thumbnail->mimetype,
      'path' => $thumbnail->path_string
    ];
  }

  public function getMediumImageAttribute()
  {

    return url(str_replace('.jpg', '_mediumThumb.jpg', $this->options->mainimage ?? 'modules/iplaces/img/default.jpg'));
  }

  public function getSmallImageAttribute()
  {

    return url(str_replace('.jpg', '_smallThumb.jpg', $this->options->mainimage ?? 'modules/iplaces/img/default.jpg'));
  }

  /*public function getMetatitleAttribute(){

      $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();
      return $this->translate($locale)->metatitle ?? $this->translate($locale)->title;

  }
  public function getMetadescriptionAttribute(){

      return $this->metadescription ?? substr(strip_tags($this->description),0,150);
  }*/


  public function getUrlAttribute()
  {
    $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();
    return route($locale.'.iplaces.place.show', [$this->category->slug, $this->slug]);
  }

  public function getVideosAttribute()
  {

    if (isset($this->options->videos) && !empty($this->options->videos)) {

      $videos = explode(',', $this->options->videos);

      return $videos;
    }
    return null;
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
  public function scopeCloudy(Builder $query)
  {
    return $query->whereWeather(Weather::CLOUDY);
  }

  public function scopeWarm(Builder $query)
  {
    return $query->whereWeather(Weather::WARM);
  }

  public function getOptionsAttribute($value) {
    return json_decode($value);
  }

  public function setOptionsAttribute($value) {
    $this->attributes['options'] = json_encode($value);
  }

  public function getAddressAttribute($value) {
    return json_decode($value);
  }

  public function setAddressAttribute($value) {
    $this->attributes['address'] = json_encode($value);
  }

  public function getSchedulesAttribute($value) {
    return json_decode($value);
  }

  public function setSchedulesAttribute($value) {
    $this->attributes['schedules'] = json_encode($value);
  }

}
