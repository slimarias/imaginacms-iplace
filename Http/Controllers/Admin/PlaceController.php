<?php

namespace Modules\Iplaces\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Iplaces\Entities\Place;
use Modules\Iplaces\Http\Requests\CreatePlaceRequest;
use Modules\Iplaces\Http\Requests\UpdatePlaceRequest;
use Modules\Iplaces\Repositories\PlaceRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class PlaceController extends AdminBaseController
{
    /**
     * @var PlaceRepository
     */
    private $place;

    public function __construct(PlaceRepository $place)
    {
        parent::__construct();

        $this->place = $place;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$places = $this->place->all();

        return view('iplaces::admin.places.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('iplaces::admin.places.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreatePlaceRequest $request
     * @return Response
     */
    public function store(CreatePlaceRequest $request)
    {
        $this->place->create($request->all());

        return redirect()->route('admin.iplaces.place.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('iplaces::places.title.places')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Place $place
     * @return Response
     */
    public function edit(Place $place)
    {
        return view('iplaces::admin.places.edit', compact('place'));
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
        $this->place->update($place, $request->all());

        return redirect()->route('admin.iplaces.place.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('iplaces::places.title.places')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Place $place
     * @return Response
     */
    public function destroy(Place $place)
    {
        $this->place->destroy($place);

        return redirect()->route('admin.iplaces.place.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('iplaces::places.title.places')]));
    }
}
