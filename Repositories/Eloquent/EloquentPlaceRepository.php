<?php

namespace Modules\Iplaces\Repositories\Eloquent;

use Modules\Iplaces\Repositories\PlaceRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Iplaces\Events\PlaceWasCreated;

class EloquentPlaceRepository extends EloquentBaseRepository implements PlaceRepository
{

    public function create($data)
    {
       //  dd($data);
        $place= $this->model->create($data);
        event(new PlaceWasCreated($place, $data));
        return $this->find($place->id);
    }

}
