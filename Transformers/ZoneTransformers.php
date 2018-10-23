<?php

namespace Modules\Iplaces\Transformers;

use Illuminate\Http\Resources\Json\Resource;
use Modules\User\Transformers\UserProfileTransformer;

class ZoneTransformers extends Resource
{

    public function toArray($request)
    {

      //  $dateformat= config('asgard.iplace.config.dateformat');
        $options=$this->options;
        unset($options->mainimage,$options->metatitle,$options->metadescription);
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'options' => $options,
            'created_at' => ($this->created_at),
            'updated_at' => ($this->updated_at)
        ];

       /* if (in_array('service',$includes)) {

            $data['service']= ServiceTransformers::collection($this->services);
        }
        return $data;
*/

    }


}