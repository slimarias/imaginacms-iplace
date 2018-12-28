<?php

namespace Modules\Iplaces\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface ServiceRepository extends BaseRepository
{
    /**
     * @param $type
     * @return mixed
     */
    public function whereType($type);
}
