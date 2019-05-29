<?php
/**
 * Created by PhpStorm.
 * User: imagina
 * Date: 13/11/2018
 * Time: 10:16 AM
 */

namespace Modules\Iplaces\Transformers;

use Illuminate\Http\Resources\Json\Resource;
use Modules\User\Transformers\UserProfileTransformer;


class ScheduleTransformer extends Resource
{
  
  public function toArray($request)
  {
    
    $data = [
      'id' => $this->id,
      'title' => $this->title,
      'options' => $this->options,
      'createdAt' => $this->created_at,
      'updatedAt' => $this->updated_at
    ];
    $filter = json_decode($request->filter);
    
    // Return data with available translations
    if (isset($filter->allTranslations) && $filter->allTranslations) {
      // Get langs avaliables
      $languages = \LaravelLocalization::getSupportedLocales();
      
      foreach ($languages as $lang => $value) {
        $data[$lang]['title'] = $this->hasTranslation($lang) ?
          $this->translate("$lang")['title'] : '';

      }
    }
    
    return $data;
    
  }
  
  
}