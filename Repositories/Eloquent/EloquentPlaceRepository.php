<?php

namespace Modules\Iplaces\Repositories\Eloquent;

use Modules\Iplaces\Repositories\Collection;
use Modules\Iplaces\Repositories\PlaceRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Iplaces\Events\PlaceWasCreated;

class EloquentPlaceRepository extends EloquentBaseRepository implements PlaceRepository
{
    public function index($page, $take, $filter, $include)
    {
        //Initialize Query
        $query = $this->model->query();

        /*== RELATIONSHIPS ==*/
        if (count($include)) {
            //Include relationships for default
            $includeDefault = [];
            $query->with(array_merge($includeDefault, $include));
        }

        /*== FILTER ==*/
        if ($filter) {
            //Filter by slug
            if (isset($filter->slug)) {
                $query->where('slug', $filter->slug);
            }

            //Filter by parent_id
            if (isset($filter->parentId) && is_array($filter->parentId)) {
                $query->whereIn('parent_id', $filter->parentId);
            }

            //Filter by parent_slug
            if (isset($filter->parentSlug) && is_array($filter->parentSlug)) {
                $query->whereIn('parent_id', function ($query) use ($filter) {
                    $query->select('iblog__places.id')
                        ->from('iblog__places')
                        ->whereIn('iblog__places.slug', $filter->parentSlug);
                });
            }

            //Filter excluding places by ID
            if (isset($filter->excludeById) && is_array($filter->excludeById)) {
                $query->whereNotIn('id', $filter->excludeById);
            }

            //Get specific places by ID
            if (isset($filter->includeById) && is_array($filter->includeById)) {
                $query->whereIn('id', $filter->includeById);
            }

            //Search filter
            if (isset($filter->search) && !empty($filter->search)) {
                //Get the words separately from the criterion
                $words = explode(' ', trim($filter->search));

                //Add condition of search to query
                $query->where(function ($query) use ($words) {
                    foreach ($words as $index => $word) {
                        $query->where('title', 'like', "%" . $word . "%")
                            ->orWhere('description', 'like', "%" . $word . "%");
                    }
                });
            }

            //Add order By
            $orderBy = isset($filter->orderBy) ? $filter->orderBy : 'created_at';
            $orderType = isset($filter->orderType) ? $filter->orderType : 'desc';
            $query->orderBy($orderBy, $orderType);
        }

        /*=== REQUEST ===*/
        if ($page) {//Return request with pagination
            $take ? true : $take = 12; //If no specific take, query default take is 12
            return $query->paginate($take);
        } else {//Return request without pagination
            $take ? $query->take($take) : false; //Set parameter take(limit) if is requesting
            return $query->get();
        }
    }

    public function show($param, $include)
    {
        $isID = (int)$param >= 1 ? true : false;

        //Initialize Query
        $query = $this->model->query();

        if ($isID) {//if is by ID
            $query = $this->model->where('id', $param);
        } else {//if is by Slug
            $query = $this->model->where('slug', $param);
        }

        /*== RELATIONSHIPS ==*/
        if (count($include)) {
            //Include relationships for default
            $includeDefault = [];
            $query->with(array_merge($includeDefault, $include));
        }

        /*=== REQUEST ===*/
        return $query->first();
    }

    public function create($data)
    {
     // dd($data);
        $place= $this->model->create($data);
        event(new PlaceWasCreated($place, $data));
        $place->categories()->sync(array_get($data, 'categories', []));
        $place->services()->sync(array_get($data, 'services', []));
        return $this->find($place->id);
    }

    public function update($model, $data)
    {//dd($data);
        $model->update($data);
        $model->categories()->sync(array_get($data, 'categories', []));
        $model->services()->sync(array_get($data, 'services', []));
        return $model;
    }



}
