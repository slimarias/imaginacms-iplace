<?php

namespace Modules\Iplaces\Http\Controllers;

use Log;
use Mockery\CountValidator\Exception;
use Modules\Core\Http\Controllers\BasePublicController;
use Modules\Iplaces\Repositories\CategoryRepository;
use Modules\Iplaces\Repositories\PlaceRepository;
use Modules\Iplaces\Repositories\ServiceRepository;
use Modules\Iplaces\Repositories\ZoneRepository;
use Request;
use Route;

class PublicController extends BasePublicController
{

    public $place;
    public $category;
    public $service;
    public $zone;

    public function __construct(PlaceRepository $place, CategoryRepository $category, ServiceRepository $service, ZoneRepository $zone)
    {
        parent::__construct();
        $this->place = $place;
        $this->category = $category;
        $this->service = $service;
        $this->zone = $zone;
    }

    public function index(Request $request)
    {

        if (isset($request->filter) && !empty($request->filter)) {
            $places = $this->place->whereFilter($request->filter);
        } else {
            $places = $this->place->paginate(12);
        }

        $services = $this->service->all();
        $zones = $this->zone->all();
        $category = $this->category->all();
        $tpl = 'iplaces::frontend.index';
        $ttpl = 'iplace.frontend.index';

        if (view()->exists($ttpl)) $tpl = $ttpl;

        Return view($tpl, compact('places', 'category', 'zones', 'services'));

    }

    public function category($slugCategory)
    {

        $category = $this->category->findBySlug($slugCategory);
        $places = $this->place->WhereCategory($category->id);
        $services = $this->service->all();
        $zones = $this->zone->all();
        $category = $this->category->all();
        $tpl = 'iplaces::frontend.index';
        $ttpl = 'iplace.frontend.index';

        if (view()->exists($ttpl)) $tpl = $ttpl;

        Return view($tpl, compact('places', 'category', 'zones', 'services'));

    }

    public function show($slugCategory,$slug)
    {

        $category = $this->category->findBySlug($slugCategory);
        $place = $this->place->findBySlug($slug);
       if($place->category->id ==$category->id){
           $services = $this->service->all();
           $zones = $this->zone->all();
           $category = $this->category->all();
           $tpl = 'iplaces::frontend.show';
           $ttpl = 'iplace.frontend.show';

           if (view()->exists($ttpl)) $tpl = $ttpl;

           Return view($tpl, compact('places', 'category', 'zones', 'services'));
       }

       return abort(404);


    }
}