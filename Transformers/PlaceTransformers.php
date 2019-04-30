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

use Modules\Iplaces\Transformers\ZoneTransformers;
use Modules\Iplaces\Transformers\ServiceTransformers;
use Modules\Iplaces\Transformers\ScheduleTransformers;

use Modules\Iplaces\Entities\Gama;
use Modules\Iplaces\Entities\Weather;
use Modules\Iplaces\Entities\Status;
use Modules\Iplaces\Entities\StatusYN;

use Modules\Iplaces\Transformers\CityTransformers;
use Modules\Ilocations\Transformers\ProvinceTransformer;

class PlaceTransformers extends Resource
{

    /**
     * @param $request
     * @return array
     */
    public function toArray($request)
    {
        //  $dateformat= config('asgard.iplace.config.dateformat');
        $options = $this->options;
        unset($options->mainimage, $options->metatitle, $options->metadescription);

        $includes = explode(",", $request->include);

        $gama = new Gama();
        $weather = new Weather();
        $status = new Status();
        $statusYN = new StatusYN();
       
        $data = [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'status'=>$this->status,
            'statusName' => $status->get($this->status),
            'summary' => $this->summary,
            'description' => $this->description,
            'address'=> json_decode($this->address),
            'mainimage' => $this->mainimage,
            'mediumimage' => $this->mediumimage,
            'thumbails' => $this->thumbails,
            'gama' => $this->gama,
            'gamaNAME' => $gama->get($this->gama),
            'quantity_person' => $this->quantity_person,
            'weather' => $this->weather,
            'weatherName' => $weather->get($this->weather),
            'housing' => $this->housing,
            'housingName' => $statusYN->get($this->housing),
            'transport' => $this->transport,
            'transportName' => $statusYN->get($this->transport),
            'metatitle' => $this->metatitle ?? $this->title,
            'metadescription' => $this->metadescription ?? $this->summary,
            'metakeywords' => $this->metakeywords,
            'options' => $options,
            'created_at' => ($this->created_at),
            'updated_at' => ($this->updated_at),
            'city' => $this->city_id,
            'province' => $this->city_id,
            'zone' => $this->zone_id,
            'schedule' => $this->schedule_id,

        ];

        /*Transform Relation Ships*/

        if (in_array('services', $includes)) {
            $data['servicies']= ServiceTransformers::collection($this->services);
        }

        if (in_array('spaces', $includes)) {
            $data['spaces'] = SpaceTransformers::collection($this->spaces);
        }

        if (in_array('schedule', $includes)) {
            $data['schedule']= new ScheduleTransformers($this->schedule);
        }

        if (in_array('category', $includes)) {
            $data['category'] = new CategoryTransformers($this->category);
            $data['categories']= CategoryTransformers::collection($this->categories);
        }

        if (in_array('zone', $includes)) {
            $data['zone'] = new ZoneTransformers($this->zone);
        }

        if (in_array('province', $includes)) {
            $data['province'] = new ProvinceTransformer($this->province);
        }

        if (in_array('city', $includes)) {
            $data['city'] = new CityTransformers($this->city);
        }

        return $data;
    }


}