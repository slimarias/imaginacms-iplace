<?php
namespace Modules\Iplaces\Events\Handlers;

use Modules\Iplaces\Events\PlaceWasCreated;
use Modules\Iplaces\Repositories\PlaceRepository;


class SavePlaceImage
{
    private $place;
    public function __construct(PlaceRepository $place)
    {
        $this->place = $place;
    }
    public function handle(PlaceWasCreated $event)
    {
        $id = $event->entity->id;
        if (!empty($event->data['mainimage'])) {
            dd('hola');
            $mainimage = saveImage($event->data['mainimage'], "assets/iplaces/place/" . $id . ".jpg");
            if(isset($event->data['options'])){
                $options=(array)$event->data['options'];
            }else{$options = array();}
            $options["mainimage"] = $mainimage;
            $event->data['options'] = json_encode($options);
        }else{
            $event->data['options'] = json_encode($event->data['options']);
        }
        $this->place->update($event->entity, $event->data);
    }

}