<?php

namespace Modules\Iplaces\Repositories\Eloquent;

use Modules\Iplaces\Repositories\Collection;
use Modules\Iplaces\Repositories\PlaceRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Iplaces\Events\PlaceWasCreated;

class EloquentPlaceRepository extends EloquentBaseRepository implements PlaceRepository
{

    public function create($data)
    {
     // dd($data);
        $place= $this->model->create($data);
        event(new PlaceWasCreated($place, $data));
        $place->categories()->sync(array_get($data, 'categories', []));
        $place->services()->sync(array_get($data, 'services', []));
        $place->zones()->sync(array_get($data, 'zones', []));
        return $this->find($place->id);
    }

    public function update($model, $data)
    {//dd($data);
        $model->update($data);
        $model->categories()->sync(array_get($data, 'categories', []));
        $model->services()->sync(array_get($data, 'services', []));
        $model->zones()->sync(array_get($data, 'zones', []));
        return $model;
    }


}
