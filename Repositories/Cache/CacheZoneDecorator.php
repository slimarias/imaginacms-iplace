<?php

namespace Modules\Iplaces\Repositories\Cache;

use Modules\Iplaces\Repositories\ZoneRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheZoneDecorator extends BaseCacheDecorator implements ZoneRepository
{
    public function __construct(ZoneRepository $zone)
    {
        parent::__construct();
        $this->entityName = 'iplaces.zones';
        $this->repository = $zone;
    }
}
