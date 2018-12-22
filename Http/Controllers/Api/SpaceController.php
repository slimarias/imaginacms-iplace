<?php


namespace Modules\Iplaces\Http\Controllers\Api;

use Illuminate\Http\Request;
use Log;
use Mockery\CountValidator\Exception;
use Modules\Iplaces\Http\Controllers\Api\BaseApiController;
use Modules\Iplaces\Entities\Space;
use Modules\Iplaces\Repositories\SpaceRepository;
use Modules\Iplaces\Transformers\SpaceTransformers;
use Modules\Iplaces\Entities\Status;

use Route;

class SpaceController extends BaseApiController
{
    private $space;
    public $status;

    public function __construct()
    {
        parent::__construct();
        $this->space = app('Modules\Iplaces\Repositories\SpaceRepository');
        $this->status = app('Modules\Iplaces\Entities\Status');
    }

    public function index(Request $request){
        try {
            //Get Parameters from URL.
            $p = $this->parametersUrl(1, 12, false, []);

            //Request to Repository
            $spaces = $this->space->index($p->page, $p->take, $p->filter, $p->include);

            //Response
            $response = ["data" => SpaceTransformers::collection($spaces)];

            //If request pagination add meta-page
            $p->page ? $response["meta"] = ["page" => $this->pageTransformer($spaces)] : false;
        } catch (\Exception $e) {
            //Message Error
            $status = 500;
            $response = [
                "errors" => $e->getMessage()
            ];
        }

        return response()->json($response, $status ?? 200);
    }

    public function show($slug, Request $request)
    {
        try {
            //Get Parameters from URL.
            $params = $this->parametersUrl(false, false, false, []);

            //Request to Repository
            $space = $this->space->show($slug, $params);

            //Response
            $response = [
                "data" => is_null($space) ? false : new SpaceTransformers($space)];
        } catch (\Exception $e) {
            //Message Error
            $status = 500;
            $response = [
                "errors" => $e->getMessage()
            ];
        }

        return response()->json($response, $status ?? 200);
    }

    
}