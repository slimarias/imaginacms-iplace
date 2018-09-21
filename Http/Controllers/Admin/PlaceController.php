<?php

namespace Modules\Iplaces\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Iplaces\Entities\Place;
use Modules\Iplaces\Http\Requests\CreatePlaceRequest;
use Modules\Iplaces\Http\Requests\UpdatePlaceRequest;
use Modules\Iplaces\Repositories\PlaceRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Iplaces\Entities\Status;

class PlaceController extends AdminBaseController
{
    /**
     * @var PlaceRepository
     */
    private $place;
    public $status;

    public function __construct(PlaceRepository $place, Status $status)
    {
        parent::__construct();

        $this->place = $place;
        $this->status = $status;
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
        return view('iplaces::admin.places.create',compact('places','statuses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreatePlaceRequest $request
     * @return Response
     */
    public function store(CreatePlaceRequest $request)
    {
        try{
        $this->place->create($request->paginate(20));

        return redirect()->route('admin.iplaces.place.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('iplaces::places.title.places')]));
    }catch (\Exception $e){
            \Log::error($e);
            return redirect()->back()
                ->withError(trans('core::core.messages.resource error', ['name' => trans('iplaces::places.title.places')]));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Place $place
     * @return Response
     */
    public function edit(Place $place)
    {
        $statuses = $this->status->lists();
        return view('iplaces::admin.places.edit', compact('place','statuses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Place $place
     * @param  UpdatePlaceRequest $request
     * @return Response
     */
    public function update(Place $place, UpdatePlaceRequest $request)
    {
        try{
        $this->place->update($place, $request->paginate(20));

        return redirect()->route('admin.iplaces.place.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('iplaces::places.title.places')]));
    }catch (\Exception $e){
            \Log::error($e);
            return redirect()->back()
                ->withError(trans('core::core.messages.resource error', ['name' => trans('iplaces::places.title.places')]));
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
