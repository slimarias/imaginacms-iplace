<?php

namespace Modules\Iplaces\Repositories\Cache;

use Modules\Iplaces\Repositories\CityRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheCityDecorator extends BaseCacheDecorator implements CityRepository
{
    public function __construct(CityRepository $city)
    {
        parent::__construct();
        $this->entityName = 'iplaces.cities';
        $this->repository = $city;
    }
}
