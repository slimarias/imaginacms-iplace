<?php

namespace Modules\Iplaces\Repositories\Eloquent;

use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Ihelpers\Events\CreateMedia;
use Modules\Ihelpers\Events\DeleteMedia;
use Modules\Ihelpers\Events\UpdateMedia;
use Modules\Iplaces\Entities\Status;
use Modules\Iplaces\Events\PlaceWasCreated;
use Modules\Iplaces\Repositories\Collection;
use Modules\Iplaces\Repositories\PlaceRepository;
use Illuminate\Database\Eloquent\Builder;
use Modules\Iplaces\Entities\Weather;
use Illuminate\Support\Facades\Log;


class EloquentPlaceRepository extends EloquentBaseRepository implements PlaceRepository
{

  public function getItemsBy($params = false)
  {
    /*== initialize query ==*/
    $query = $this->model->query();

    /*== RELATIONSHIPS ==*/
    if (in_array('*', $params->include)) {//If Request all relationships
      $query->with([]);
    } else {//Especific relationships
      $includeDefault = [];//Default relationships
      if (isset($params->include))//merge relations with default relationships
        $includeDefault = array_merge($includeDefault, $params->include);
      $query->with($includeDefault);//Add Relationships to query
    }

    /*== FILTERS ==*/
    if (isset($params->filter)) {
      $filter = $params->filter;//Short filter

      //Filter by date
      if (isset($filter->date)) {
        $date = $filter->date;//Short filter date
        $date->field = $date->field ?? 'created_at';
        if (isset($date->from))//From a date
          $query->whereDate($date->field, '>=', $date->from);
        if (isset($date->to))//to a date
          $query->whereDate($date->field, '<=', $date->to);
      }

      //Order by
      if (isset($filter->order)) {
        $orderByField = $filter->order->field ?? 'created_at';//Default field
        $orderWay = $filter->order->way ?? 'desc';//Default way
        $query->orderBy($orderByField, $orderWay);//Add order to query
      }

      //add filter by search
      if (isset($filter->search)) {
        //find search in columns
        $query->where('id', 'like', '%' . $filter->search . '%')
          ->orWhere('updated_at', 'like', '%' . $filter->search . '%')
          ->orWhere('created_at', 'like', '%' . $filter->search . '%');
      }
    }

    /*== FIELDS ==*/
    if (isset($params->fields) && count($params->fields))
      $query->select($params->fields);

    /*== REQUEST ==*/
    if (isset($params->page) && $params->page) {
      return $query->paginate($params->take);
    } else {
      $params->take ? $query->take($params->take) : false;//Take
      return $query->get();
    }
  }


  public function getItem($criteria, $params = false)
  {
    //Initialize query
    $query = $this->model->query();

    /*== RELATIONSHIPS ==*/
    if (in_array('*', $params->include)) {//If Request all relationships
      $query->with([]);
    } else {//Especific relationships
      $includeDefault = [];//Default relationships
      if (isset($params->include))//merge relations with default relationships
        $includeDefault = array_merge($includeDefault, $params->include);
      $query->with($includeDefault);//Add Relationships to query
    }

    /*== FILTER ==*/
    if (isset($params->filter)) {
      $filter = $params->filter;

      if (isset($filter->field))//Filter by specific field
        $field = $filter->field;
    }

    /*== FIELDS ==*/
    if (isset($params->fields) && count($params->fields))
      $query->select($params->fields);

    /*== REQUEST ==*/
    return $query->where($field ?? 'id', $criteria)->first();
  }

  public function create($data)
  {
      // dd($data);
      $place = $this->model->create($data);
      event(new PlaceWasCreated($place, $data));
      $place->categories()->sync(array_get($data, 'categories', []));
      $place->services()->sync(array_get($data, 'services', []));
      $place->spaces()->sync(array_get($data, 'spaces', []));
      event(new CreateMedia($place,$data));
  }


  public function updateBy($criteria, $data, $params = false)
  {
    /*== initialize query ==*/
    $query = $this->model->query();

    /*== FILTER ==*/
    if (isset($params->filter)) {
      $filter = $params->filter;

      //Update by field
      if (isset($filter->field))
        $field = $filter->field;
    }

    /*== REQUEST ==*/
    $model = $query->where($field ?? 'id', $criteria)->first();
    if($model){
      $model->update((array)$data);
      $model->categories()->sync(array_get($data, 'categories', []));
      event(new UpdateMedia($model,$data));
    }


  }

  public function deleteBy($criteria, $params = false)
  {
    /*== initialize query ==*/
    $query = $this->model->query();

    /*== FILTER ==*/
    if (isset($params->filter)) {
      $filter = $params->filter;

      if (isset($filter->field))//Where field
        $field = $filter->field;
    }

    /*== REQUEST ==*/
    $model = $query->where($field ?? 'id', $criteria)->first();
    $model ? $model->delete() : false;
    event(new DeleteMedia($model->id, get_class($model)));
  }

    public function update($model, $data)
    {

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
        $query=$this->model->query();
        if (method_exists($this->model, 'translations')) {
            $query->whereHas('translations', function (Builder $q) use ($slug) {
                $q->where('slug', $slug);
            })->with('categories', 'city', 'category', 'translations', 'province');
        }else{
            $query->where('slug', $slug)->with('categories', 'city', 'category', 'province');
        }
        $query->whereStatus(Status::ACTIVE);
        return $query->firstOrFail();
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
