<?php

namespace Modules\Iplaces\Repositories\Cache;

use Modules\Iplaces\Repositories\ServiceRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheServiceDecorator extends BaseCacheDecorator implements ServiceRepository
{
    public function __construct(ServiceRepository $service)
    {
        parent::__construct();
        $this->entityName = 'iplaces.services';
        $this->repository = $service;
    }
}
