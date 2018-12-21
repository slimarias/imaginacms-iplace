<?php

namespace Modules\Iplaces\Repositories\Eloquent;

use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Iplaces\Entities\Status;
use Modules\Iplaces\Events\PlaceWasCreated;
use Modules\Iplaces\Repositories\Collection;
use Modules\Iplaces\Repositories\PlaceRepository;
use Illuminate\Database\Eloquent\Builder;
use Modules\Iplaces\Entities\Weather;


class EloquentPlaceRepository extends EloquentBaseRepository implements PlaceRepository
{

  public function index($page, $take, $filter, $include)
  {
    //Initialize Query
    $query = $this->model->query();

    /*== RELATIONSHIPS ==*/
    if (count($include)) {
      //Include relationships for default
      $includeDefault = ['translations','categories', 'services'];
      $query->with(array_merge($includeDefault, $include));
    }

    /*== FILTER ==*/
    if ($filter) {

        //set language translation
        if (isset($filter->locale))
          \App::setLocale($filter->locale ?? null);

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


      //Filter specific gama By ID
      if (isset($filter->gama) && is_array($filter->gama)) {
        $query->whereIn('gama', $filter->gama);
      }

      //Filter specific quantity person
      if (isset($filter->qperson)) {
        $query->where('quantity_person', $filter->qperson);
      }

      //Add order by city
      if (isset($filter->cities) && is_array($filter->cities)) {
        is_array($filter->cities) ? true : $filter->cities = [$filter->cities];
        $query->whereIn('city_id', $filter->cities);

      }
      //Add order for zone
      if (isset($filter->zones) && is_array($filter->zones)) {

        is_array($filter->zones) ? true : $filter->zones = [$filter->zones];
        $query->whereIn('zone_id', $filter->zones);
      }
      //Add order for category

      if (isset($filter->categories) && is_array($filter->categories)) {
        is_array($filter->categories) ? true : $filter->categories = [$filter->categories];

        $query->whereHas('categories', function ($q) use ($filter) {
          $q->whereIn('category_id', $filter->categories);
        });

      }
      //Add order by province
      if (isset($filter->provinces) && is_array($filter->provinces)) {
        is_array($filter->provinces) ? true : $filter->cities = [$filter->provinces];
        $query->whereIn('province_id', $filter->cities);

      }


      //Add order for services

      if (isset($filter->services) && is_array($filter->services)) {
        is_array($filter->services) ? true : $filter->services = [$filter->services];
        $query->whereHas('services', function ($q) use ($filter) {
          $q->whereIn('service_id', $filter->services);
        });
      }

      //Add order By
      $orderBy = isset($filter->orderBy) ? $filter->orderBy : 'created_at';
      $orderType = isset($filter->orderType) ? $filter->orderType : 'desc';
      $query->orderBy($orderBy, $orderType);
      $query->whereStatus(Status::ACTIVE);
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

  //Filter Frontend Index
  public function wherebyFilter($page, $take, $filter, $include)
  {
    //Initialize Query
    $query = $this->model->query();

    /*== RELATIONSHIPS ==*/
    if (count($include)) {
      //Include relationships for default
      $includeDefault = ['categories', 'services'];
      $query->with(array_merge($includeDefault, $include));
    }

    /*== FILTER ==*/
    if ($filter) {
      //Filter by slug
      if (isset($filter->slug)) {
        $query->where('slug', $filter->slug);
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

      //Add order by city
      if (isset($filter->cities) && is_array($filter->cities)) {
        is_array($filter->cities) ? true : $filter->cities = [$filter->cities];
        $query->whereIn('city_id', $filter->cities);

      }
      //Add order for zone
      if (isset($filter->zones) && is_array($filter->zones)) {

        is_array($filter->zones) ? true : $filter->zones = [$filter->zones];
        $query->whereIn('zone_id', $filter->zones);
      }
      //Add order for category

      if (isset($filter->categories) && is_array($filter->categories)) {
        is_array($filter->categories) ? true : $filter->categories = [$filter->categories];

        $query->whereHas('categories', function ($q) use ($filter) {
          $q->whereIn('category_id', $filter->categories);
        });

      }
      //Add order by province
      if (isset($filter->provinces) && is_array($filter->provinces)) {
        is_array($filter->provinces) ? true : $filter->cities = [$filter->provinces];
        $query->whereIn('province_id', $filter->cities);

      }


      //Add order for services

      if (isset($filter->services) && is_array($filter->services)) {
        is_array($filter->services) ? true : $filter->services = [$filter->services];
        $query->whereHas('services', function ($q) use ($filter) {
          $q->whereIn('service_id', $filter->services);
        });
      }

      //Add order By
      $orderBy = isset($filter->orderBy) ? $filter->orderBy : 'created_at';
      $orderType = isset($filter->orderType) ? $filter->orderType : 'desc';
      $query->orderBy($orderBy, $orderType);
      $query->whereStatus(Status::ACTIVE);
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
    // dd($data);
    $place = $this->model->create($data);
    event(new PlaceWasCreated($place, $data));
    $place->categories()->sync(array_get($data, 'categories', []));
    $place->services()->sync(array_get($data, 'services', []));
    $place->spaces()->sync(array_get($data, 'spaces', []));


    return $this->find($place->id);
  }

  public function update($model, $data)
  {//dd($data);
    $model->update($data);
    $model->categories()->sync(array_get($data, 'categories', []));
    $model->services()->sync(array_get($data, 'services', []));
    $model->spaces()->sync(array_get($data, 'spaces', []));

    return $model;
  }

  /**
   * @inheritdoc
   */
  public function findBySlug($slug)
  {
    if (method_exists($this->model, 'translations')) {
      return $this->model->whereHas('translations', function (Builder $q) use ($slug) {
        $q->where('slug', $slug);
      })->with('categories', 'city', 'category', 'translations', 'province')->first();
    }

    return $this->model->with('categories', 'city', 'category', 'province')->where('slug', $slug)->first();
  }

  public function whereCategory($id)
  {
    is_array($id) ? true : $id = [$id];
    $query = $this->model->with('city', 'category', 'province');
    $query->whereHas('categories', function (Builder $q) use ($id) {
      $q->whereIn('category_id', $id);
    });
    $query->orderBy("created_at", "desc");
    $query->whereStatus(Status::ACTIVE);
    return $query->paginate(12);
  }


}
