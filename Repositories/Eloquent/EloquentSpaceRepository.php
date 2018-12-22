<?php

namespace Modules\Iplaces\Repositories\Eloquent;

use Modules\Iplaces\Repositories\SpaceRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Iplaces\Events\SpaceWasCreated;

class EloquentSpaceRepository extends EloquentBaseRepository implements SpaceRepository
{

    public function index($page, $take, $filter, $include)
    {
        //Initialize Query
        $query = $this->model->query();

        /*== RELATIONSHIPS ==*/
        if (count($include)) {
            //Include relationships for default
            $includeDefault = ['translations'];
            $query->with(array_merge($includeDefault, $include));
        }

        /*== FILTER ==*/
        if ($filter) {

            //set language translation
            if (isset($filter->locale))
                \App::setLocale($filter->locale ?? null);
            
            //Filter excluding spaces by ID
            if (isset($filter->excludeById) && is_array($filter->excludeById)) {
                $query->whereNotIn('id', $filter->excludeById);
            }

            //Get specific spaces by ID
            if (isset($filter->includeById) && is_array($filter->includeById)) {
                $query->whereIn('id', $filter->includeById);
            }

            //Search filter
            if (isset($filter->search) && !empty($filter->search)) {
                //Get the words separately from the criterion
                $words = explode(' ', trim($filter->search));

                //Add condition of search to query
                $lang = \App::getLocale();//Get language
                $query->whereHas('translations', function ($query) use ($words,$lang){
                $query->where(function ($query) use ($words,$lang) {
                    foreach ($words as $index => $word) {
                    $query->where('locale', $lang)
                    ->where('title', 'like', "%" . $word . "%")
                        ->orWhere('description', 'like', "%" . $word . "%");
                    }
                });
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

    public function show($criteria, $params)
    {
        
        //Initialize Query
        $query = $this->model->query();

        /*== RELATIONSHIPS ==*/
        if (count($params->include)) {
        //Include relationships for default
        $includeDefault = ['translations'];//set translations by default
        $query->with(array_merge($includeDefault, $params->include));
        }

        // FILTERS
        if(isset($params->filter)){
        $filter = $params->filter;
        //set language translation
        if (isset($filter->locale))
            \App::setLocale($params->filter->locale ?? null);
        }

        // First, find record by ID
        $duplicateQuery = clone $query;
        $result = $duplicateQuery->where('id', $criteria)->first();

        // If not give results, find by slug
        if (!$result){
        $lang = \App::getLocale();//Get language
        $result = $query->whereHas('translations', function ($query) use ($criteria, $lang) {
            $query->where('locale', $lang)
            ->where('slug', $criteria);
        })->first();
        }

        return $result;
    }

    public function create($data)
    {
        $space= $this->model->create($data);
        event(new SpaceWasCreated($space, $data));
        return $this->find($space->id);
    }


}
