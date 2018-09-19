<?php

namespace Modules\Iplaces\Repositories\Cache;

use Modules\Iplaces\Repositories\CategoryRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheCategoryDecorator extends BaseCacheDecorator implements CategoryRepository
{
    public function __construct(CategoryRepository $category)
    {
        parent::__construct();
        $this->entityName = 'iplaces.categories';
        $this->repository = $category;
    }
}
