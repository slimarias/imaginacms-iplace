<?php


namespace Modules\Iplaces\Transformers;

use Illuminate\Http\Resources\Json\Resource;
use Modules\User\Transformers\UserProfileTransformer;
use Modules\Iplaces\Events\CategoryWasCreated;


class CategoryTransformer extends Resource
{
  
  public function toArray($request)
  {
    
    $data = [
      'id' => $this->id,
      'title' => $this->title,
      'slug' => $this->slug,
      'description' => $this->description,
      'status' => $this->status ? true : false,
      'parentId' => $this->parent_id,
      'parentCategory' => new CategoryTransformer($this->parent),
      'mainImage' => $this->main_image,
      'metaTitle' => $this->meta_title ?? $this->title,
      'metaDescription' => $this->meta_description,
      'metaKeywords' => $this->meta_keywords,
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
        $data[$lang]['description'] = $this->hasTranslation($lang) ?
          $this->translate("$lang")['description'] ?? '' : '';
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