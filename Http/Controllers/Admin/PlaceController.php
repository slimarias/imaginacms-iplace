<?php

namespace Modules\Iplaces\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Iplaces\Entities\Category;
use Modules\Iplaces\Entities\Place;
use Modules\Iplaces\Http\Requests\CreatePlaceRequest;
use Modules\Iplaces\Http\Requests\UpdatePlaceRequest;
use Modules\Iplaces\Events\PlaceWasCreated;
use Modules\Iplaces\Repositories\PlaceRepository;
use Modules\Iplaces\Repositories\CategoryRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Iplaces\Entities\Status;
use Modules\Iplaces\Repositories\ZoneRepository;
use Modules\Iplaces\Repositories\ServiceRepository;
use Modules\User\Repositories\UserRepository;
use Modules\User\Transformers\UserProfileTransformer;

class PlaceController extends AdminBaseController
{
    /**
     * @var PlaceRepository
     */
    private $place;
    public $status;
    private $category;
    private $user;
    private $zone;
    private $service;


    public function __construct(PlaceRepository $place, Status $status, CategoryRepository $category, UserRepository $user, ZoneRepository $zone, ServiceRepository $service)
    {
        parent::__construct();

        $this->place = $place;
        $this->status = $status;
        $this->category=$category;
        $this->user=$user;
        $this->zone=$zone;
        $this->service=$service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $places = $this->place->paginate(20);

        return view('iplaces::admin.places.index', compact('places'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $statuses = $this->status->lists();
       // $place = $this->place->paginate(20);
        $categories=$this->category->all();
        $users=$this->user->all();
        $zones=$this->zone->all();
        $services=$this->service->all();

        return view('iplaces::admin.places.create',compact('categories','statuses','users','zones','services'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreatePlaceRequest $request
     * @return Response
     */
    public function store(CreatePlaceRequest $request)
    {
        //dd($request);
        try{
        $this->place->create($request->all());//envia todas las categorias

        return redirect()->route('admin.iplaces.place.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('iplaces::places.title.places')]));
    }catch (\Exception $e){
            \Log::error($e);
            return redirect()->back()
                ->withError(trans('core::core.messages.resource error', ['name' => trans('iplaces::places.title.places')]))->withInput($request->all());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Place $place
     * @return Response
     */
    public function edit(Place $place)
    {//dd($place);
        $statuses = $this->status->lists();
        $categories=$this->category->all();
        $users=$this->user->all();
        $zones=$this->zone->all();
        $services=$this->service->all();
        return view('iplaces::admin.places.edit', compact('place','statuses','categories','users','zones','services'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Place $place
     * @param  UpdatePlaceRequest $request
     * @return Response
     */
    public function update(Place $place, UpdatePlaceRequest $request)
    {//dd($request);
        try{
            if(isset($request['options'])){
                $options=(array)$request['options'];
            }else{$options = array();}


            isset($request->mainimage) ? $options["mainimage"] = saveImage($request['mainimage'], "assets/iplaces/place/" . $place->id . ".jpg") : false;

            $request['options'] = json_encode($options);
            $this->place->update($place, $request->all());

        return redirect()->route('admin.iplaces.place.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('iplaces::places.title.places')]));
    }catch (\Exception $e){
            \Log::error($e);
            return redirect()->back()
                ->withError(trans('core::core.messages.resource error', ['name' => trans('iplaces::places.title.places')]))->withInput($request->all());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Place $place
     * @return Response
     */
    public function destroy(Place $place)
    {
        try{
            $this->place->destroy($place);

            return redirect()->route('admin.iplaces.place.index')
                ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('iplaces::places.title.places')]));

        }catch (\Exception $e){
            \Log::error($e);
            return redirect()->back()
                ->withError(trans('core::core.messages.resource error', ['name' => trans('iplaces::places.title.places')]));
        }

    }
}
