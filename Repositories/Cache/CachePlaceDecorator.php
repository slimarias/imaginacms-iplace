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

    public function whereCategory($id)
    {
        return $this->remember(function () use ($id) {
            return $this->repository->whereCategory($id);
        });
    }

    public function wherebyFilter($page, $take, $filter, $include)
    {
        return $this->remember(function () use ($page, $take, $filter, $include) {
            return $this->repository->wherebyFilter($page, $take, $filter, $include);
        });
    }
}
