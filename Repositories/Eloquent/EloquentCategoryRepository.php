<?php

namespace Modules\Iplaces\Repositories\Eloquent;

use Modules\Iplaces\Repositories\CategoryRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Iplaces\Events\CategoryWasCreated;

class EloquentCategoryRepository extends EloquentBaseRepository implements CategoryRepository
{

    public function create($data)
    {
       // dd($data);
        $category= $this->model->create($data);
        event(new CategoryWasCreated($category, $data));
        return $this->find($category->id);
    }


}
