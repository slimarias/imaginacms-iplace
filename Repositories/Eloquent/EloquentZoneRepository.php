<?php

namespace Modules\Iplaces\Repositories\Eloquent;

use Modules\Iplaces\Events\ZoneWasCreated;
use Modules\Iplaces\Repositories\ZoneRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentZoneRepository extends EloquentBaseRepository implements ZoneRepository
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
       /*     if (isset($filter->parentSlug) && is_array($filter->parentSlug)) {
                $query->whereIn('parent_id', function ($query) use ($filter) {
                    $query->select('iblog__zones.id')
                        ->from('iblog__zones')
                        ->whereIn('iblog__zones.slug', $filter->parentSlug);
                });
            }*/

            //Filter excluding zones by ID
            if (isset($filter->excludeById) && is_array($filter->excludeById)) {
                $query->whereNotIn('id', $filter->excludeById);
            }

            //Get specific zones by ID
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
        $zone= $this->model->create($data);
        event(new ZoneWasCreated($zone, $data));
        return $this->find($zone->id);
    }


}
