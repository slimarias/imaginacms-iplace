<?php

namespace Modules\Iplaces\Repositories\Eloquent;

use Modules\Iplaces\Repositories\SpaceRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Iplaces\Events\SpaceWasCreated;

class EloquentSpaceRepository extends EloquentBaseRepository implements SpaceRepository
{

    public function create($data)
    {
        $space= $this->model->create($data);
        event(new SpaceWasCreated($space, $data));
        return $this->find($space->id);
    }


}
