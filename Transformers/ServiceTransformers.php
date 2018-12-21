<?php


namespace Modules\Iplaces\Transformers;

use Illuminate\Http\Resources\Json\Resource;
use Modules\User\Transformers\UserProfileTransformer;
use Modules\Iplaces\Events\ServiceWasCreated;
use Modules\Iplaces\Entities\Servtype;

class ServiceTransformers extends Resource
{

    public function toArray($request)
    {

        $servtype = new Servtype();
      //  $dateformat= config('asgard.iplace.config.dateformat');
        $options=$this->options;
        unset($options->mainimage,$options->metatitle,$options->metadescription);
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'status'=>$this->status,
            'description' => $this->description,
            'type' => $this->servtype,
            'typeName' => $servtype->get($this->servtype),
            'mainimage' => $this->mainimage,
            'metatitle'=>$this->metatitle??$this->title,
            'metadescription'=>$this->metadescription,
            'metakeywords'=>$this->metakeywords,
            'options' => $options,
            'created_at' => ($this->created_at),
            'updated_at' => ($this->updated_at)
        ];

       
    }


}