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


class ScheduleTransformers extends Resource
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


    }


}