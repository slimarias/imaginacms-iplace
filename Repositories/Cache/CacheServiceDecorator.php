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

    public function getItemsBy($params)
    {
        return $this->remember(function () use ($params) {
            return $this->repository->getItemsBy($params);
        });
    }

    public function getItem($criteria, $params)
    {
        return $this->remember(function () use ($criteria, $params) {
            return $this->repository->getItem($criteria, $params);
        });
    }


    public function updateBy($criteria, $data, $params)
    {
        return $this->remember(function () use ($criteria, $data, $params) {
            return $this->repository->updateBy($criteria, $data, $params);
        });
    }

    public function deleteBy($criteria, $params)
    {
        return $this->remember(function () use ($criteria, $params) {
            return $this->repository->deleteBy($criteria, $params);
        });
    }
}
