<?php

namespace Modules\Iplaces\Repositories\Eloquent;

use Modules\Iplaces\Repositories\ServiceRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Iplaces\Events\ServiceWasCreated;

class EloquentServiceRepository extends EloquentBaseRepository implements ServiceRepository
{

    public function create($data)
    {
        // dd($data);
        $service= $this->model->create($data);
        event(new ServiceWasCreated($service, $data));
        return $this->find($service->id);
    }


}
