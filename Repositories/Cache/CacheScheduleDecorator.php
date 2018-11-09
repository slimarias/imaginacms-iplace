<?php

namespace Modules\Iplaces\Repositories\Cache;

use Modules\Iplaces\Repositories\ScheduleRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheScheduleDecorator extends BaseCacheDecorator implements ScheduleRepository
{
    public function __construct(ScheduleRepository $schedule)
    {
        parent::__construct();
        $this->entityName = 'iplaces.schedules';
        $this->repository = $schedule;
    }
}
