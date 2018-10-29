<?php

namespace Modules\Iplaces\Http\Controllers;

use Log;
use Mockery\CountValidator\Exception;
use Modules\Core\Http\Controllers\BasePublicController;
use Modules\Iplaces\Repositories\CategoryRepository;
use Modules\Iplaces\Repositories\PlaceRepository;
use Modules\Iplaces\Repositories\ServiceRepository;
use Modules\Iplaces\Repositories\ZoneRepository;
use Illuminate\Http\Request;
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

        $oldCat=null;
        $oldServ=null;
        $oldZone=null;
        if ((isset($request->categories) && !empty($request->categories))||(isset($request->services) && !empty($request->services))||(isset($request->zones) && !empty($request->zones)) ) {
            $filter=['categories'=>$request->categories,"services"=>$request->services, "zones"=>$request->zones];

            $places = $this->place->wherebyFilter($request->page,$take=12, json_decode(json_encode($filter)), $include=null);
            $oldCat=$request->categories;
            $oldServ=$request->services;
            $oldZone=$request->zones;
        } else {
            $places = $this->place->paginate(12);
        }

        $services = $this->service->all();
        $zones = $this->zone->all();
        $categories = $this->category->all();
        $tpl = 'iplaces::frontend.index';
        $ttpl = 'iplace.frontend.index';

        if (view()->exists($ttpl)) $tpl = $ttpl;

        Return view($tpl, compact('places', 'categories', 'zones', 'services','oldCat', 'oldServ','oldZone'));

    }

    public function category($slugCategory)
    {

        $category = $this->category->findBySlug($slugCategory);
        $places = $this->place->whereCategory($category->id);
        $services = $this->service->all();
        $zones = $this->zone->all();
        $categories = $this->category->all();
        $tpl = 'iplaces::frontend.index';
        $ttpl = 'iplace.frontend.index';

        if (view()->exists($ttpl)) $tpl = $ttpl;

        Return view($tpl, compact('places', 'category', 'zones', 'services','categories'));

    }

    public function show($slugCategory,$slugPlace)
    {

        $category = $this->category->findBySlug($slugCategory);
      // dd($category);
        $place = $this->place->findBySlug($slugPlace);
        dd($place->category->id,$category->title );
       if($place->category->id ==$category->id){
           $services = $this->service->all();
           $zones = $this->zone->all();
           $tpl = 'iplaces::frontend.show';
           $ttpl = 'iplace.frontend.show';

           if (view()->exists($ttpl)) $tpl = $ttpl;

           Return view($tpl, compact('places', 'category', 'zones', 'services'));
       }

       return abort(404);


    }
}