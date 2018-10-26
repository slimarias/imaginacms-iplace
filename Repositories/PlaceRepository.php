<?php

namespace Modules\Iplaces\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface PlaceRepository extends BaseRepository
{

    public function whereCategory($id);

    public function wherebyFilter($page, $take, $filter, $include);

}
