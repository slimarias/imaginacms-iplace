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
        return $this->find($place->id);
    }

    public function update($model, $data)
    {//dd($data);
        $model->update($data);
        $model->categories()->sync(array_get($data, 'categories', []));
        return $model;
    }

    /**
     * Return the latest x iblog posts
     * @param int $amount
     * @return Collection
     */
    public function latest($amount = 5)
    {
        // TODO: Implement latest() method.
    }

    /**
     * Get the previous post of the given post
     * @param object $place
     * @return object
     */
    public function getPreviousOf($place)
    {
        // TODO: Implement getPreviousOf() method.
    }

    /**
     * Get the next post of the given post
     * @param object $place
     * @return object
     */
    public function getNextOf($place)
    {
        // TODO: Implement getNextOf() method.
    }

    /**
     * Get the next post of the given post
     * @param object $id
     * @return object
     */
    public function find($id)
    {
        // TODO: Implement find() method.
    }
}
