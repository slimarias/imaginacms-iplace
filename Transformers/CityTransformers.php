<?php
/**
 * Created by PhpStorm.
 * User: imagina
 * Date: 10/10/2018
 * Time: 5:26 PM
 */

namespace Modules\Iplaces\Transformers;

use Illuminate\Http\Resources\Json\Resource;
use Modules\Iplaces\Http\Controllers\Api\PlaceController;
use Modules\User\Transformers\UserProfileTransformer;

use Modules\Iplaces\Transformers\ZoneTransformers;
use Modules\Iplaces\Transformers\ServiceTransformers;
use Modules\Iplaces\Transformers\ScheduleTransformers;

use Modules\Iplaces\Entities\Gama;
use Modules\Iplaces\Entities\Weather;
use Modules\Iplaces\Entities\Status;
use Modules\Iplaces\Entities\StatusYN;

use Modules\Ilocations\Transformers\CityTransformer;
use Modules\Ilocations\Transformers\ProvinceTransformer;

class CityTransformers extends Resource
{

    /**
     * @param $request
     * @return array
     */
    public function toArray($request)
    {
        $options = $this->options;
        $includes = explode(",", $request->include);
        unset($options->mainimage, $options->metatitle, $options->metadescription);
        $data = [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'options' => $options,
            'created_at' => ($this->created_at),
            'updated_at' => ($this->updated_at)
        ];


        if (in_array('province', $includes)) {
            $data['province'] = new ProvinceTransformer($this->province);
        }

        if (in_array('places', $includes)) {
            $data['city'] = PlaceTransformer::collection($this->places);
        }

        return $data;
    }


}