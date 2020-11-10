<?php
/**
 * Created by PhpStorm.
 * User: imagina
 * Date: 10/10/2018
 * Time: 5:26 PM
 */

namespace Modules\Iplaces\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\User\Transformers\UserProfileTransformer;

use Modules\Iplaces\Transformers\ZoneTransformer;
use Modules\Iplaces\Transformers\ServiceTransformer;
use Modules\Iplaces\Transformers\ScheduleTransformer;

use Modules\Iplaces\Entities\Gama;
use Modules\Iplaces\Entities\Weather;
use Modules\Iplaces\Entities\Status;
use Modules\Iplaces\Entities\StatusYN;

use Modules\Iplaces\Transformers\CityTransformer;
use Modules\Ilocations\Transformers\ProvinceTransformer;

class PlaceTransformer extends JsonResource
{

  /**
   * @param $request
   * @return array
   */
  public function toArray($request)
  {

    $includes = explode(",", $request->include);

    $gama = new Gama();
    $weather = new Weather();
    $status = new Status();
    $statusYN = new StatusYN();

    $data = [
      'id' => $this->id,
      'title' => $this->title,
      'slug' => $this->slug,
      'status' => $this->status,
      'statusName' => $status->get($this->status),
      'summary' => $this->summary,
      'description' => $this->description,
      'address' => $this->address,
      'phone1' => $this->phone_1,
      'phone2' => $this->phone_2,
      'phone3' => $this->phone_3,
      'mainImage' => $this->main_image,
      'gama' => $this->gama,
      'gamaNAME' => $gama->get($this->gama),
      'quantityPerson' => $this->quantity_person,
      'weather' => $this->weather,
      'weatherName' => $weather->get($this->weather),
      'housing' => $this->housing,
      'housingName' => $statusYN->get($this->housing),
      'transport' => $this->transport,
      'transportName' => $statusYN->get($this->transport),
      'metaTitle' => $this->meta_title ?? $this->title,
      'metaDescription' => $this->meta_description ?? $this->summary,
      'metaKeywords' => $this->meta_keywords,
      'createdAt' => ($this->created_at),
      'updatedAt' => ($this->updated_at),
      'city' => $this->city_id,
      'province' => $this->city_id,
      'zone' => $this->zone_id,
      'schedule' => $this->schedule_id,
      'categoryId' => $this->category_id,
      'options' => $this->options,
      'schedules' => $this->schedules,

    ];

    /*Transform Relation Ships*/

    if (in_array('services', $includes)) {
      $data['servicies'] = ServiceTransformer::collection($this->services);
    }

    if (in_array('spaces', $includes)) {
      $data['spaces'] = SpaceTransformer::collection($this->spaces);
    }

    if (in_array('schedule', $includes)) {
      $data['schedule'] = new ScheduleTransformer($this->schedule);
    }

    if (in_array('schedules', $includes)) {
      $data['schedules'] = ScheduleTransformer::collection($this->schedules);
    }

    if (in_array('category', $includes)) {
      $data['category'] = new CategoryTransformer($this->category);
      $data['categories'] = CategoryTransformer::collection($this->categories);
    }

    if (in_array('zone', $includes)) {
      $data['zone'] = new ZoneTransformer($this->zone);
    }

    if (in_array('province', $includes)) {
      $data['province'] = new ProvinceTransformer($this->province);
    }

    if (in_array('city', $includes)) {
      $data['city'] = new CityTransformer($this->city);
    }

    if (in_array('categories', $includes)) {
      $data['categories'] = CategoryTransformer::collection($this->categories);
    }


    $filter = json_decode($request->filter);

    // Return data with available translations
    if (isset($filter->allTranslations) && $filter->allTranslations) {
      // Get langs avaliables
      $languages = \LaravelLocalization::getSupportedLocales();

      foreach ($languages as $lang => $value) {
        $data[$lang]['title'] = $this->hasTranslation($lang) ?
          $this->translate("$lang")['title'] : '';
        $data[$lang]['description'] = $this->hasTranslation($lang) ?
          $this->translate("$lang")['description'] ?? '' : '';
        $data[$lang]['summary'] = $this->hasTranslation($lang) ?
          $this->translate("$lang")['summary'] ?? '' : '';
        $data[$lang]['slug'] = $this->hasTranslation($lang) ?
          $this->translate("$lang")['slug'] : '';
        $data[$lang]['metaTitle'] = $this->hasTranslation($lang) ?
          $this->translate("$lang")['meta_title'] : '';
        $data[$lang]['metaDescription'] = $this->hasTranslation($lang) ?
          $this->translate("$lang")['meta_description'] : '';
      }
    }


    return $data;
  }


}
