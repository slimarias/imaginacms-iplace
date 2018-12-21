<?php

namespace Modules\Iplaces\Repositories\Cache;

use Modules\Iplaces\Repositories\SpaceRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheSpaceDecorator extends BaseCacheDecorator implements SpaceRepository
{
    public function __construct(SpaceRepository $space)
    {
        parent::__construct();
        $this->entityName = 'iplaces.spaces';
        $this->repository = $space;
    }
}
