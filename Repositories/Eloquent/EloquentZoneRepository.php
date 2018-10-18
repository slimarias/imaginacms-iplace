<?php

namespace Modules\Iplaces\Repositories\Eloquent;

use Modules\Iplaces\Events\ZoneWasCreated;
use Modules\Iplaces\Repositories\ZoneRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentZoneRepository extends EloquentBaseRepository implements ZoneRepository
{
    public function create($data)
    {
        // dd($data);
        $zone= $this->model->create($data);
        event(new ZoneWasCreated($zone, $data));
        return $this->find($zone->id);
    }


}
