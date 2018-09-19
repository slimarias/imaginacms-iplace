<?php

namespace Modules\Iplaces\Repositories\Cache;

use Modules\Iplaces\Repositories\PlaceRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CachePlaceDecorator extends BaseCacheDecorator implements PlaceRepository
{
    public function __construct(PlaceRepository $place)
    {
        parent::__construct();
        $this->entityName = 'iplaces.places';
        $this->repository = $place;
    }
}
