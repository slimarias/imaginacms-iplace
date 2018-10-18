<?php
/**
 * Created by PhpStorm.
 * User: imagina
 * Date: 10/10/2018
 * Time: 5:26 PM
 */

namespace Modules\Iplaces\Transformers;

use Illuminate\Http\Resources\Json\Resource;
use Modules\User\Transformers\UserProfileTransformer;


class PlaceTransformers extends Resource
{

    public function toArray($request)
    {
      //  $dateformat= config('asgard.iplace.config.dateformat');
        $options=$this->options;
        unset($options->mainimage,$options->metatitle,$options->metadescription);
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'category_id'=>$this->category_id,
            'mainimage' => $this->mainimage,
            'mediumimage'=>$this->mediumimage,
            'thumbails'=>$this->thumbails,
            'metatitle'=>$this->metatitle??$this->title,
            'metadescription'=>$this->metadescription??$this->summary,
            'metakeywords'=>$this->metakeywords,
            'options'=>$options,
            'created_at'=>($this->created_at),
            'updated_at'=>($this->updated_at)
        ];
    }


}