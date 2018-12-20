<?php


namespace Modules\Iplaces\Http\Controllers\Api;

use Illuminate\Http\Request;
use Log;
use Mockery\CountValidator\Exception;
use Modules\Iplaces\Http\Controllers\Api\BaseApiController;
use Modules\Iplaces\Repositories\PlaceRepository;
use Modules\Iplaces\Repositories\ZoneRepository;
use Modules\Iplaces\Entities\Zone;
use Modules\Iplaces\Transformers\ZoneTransformers;

use Route;

class ZoneController extends BaseApiController
{
    private $zone;

    public function __construct()
    {
        parent::__construct();
        $this->zone = app('Modules\Iplaces\Repositories\ZoneRepository');
    }

    public function index(Request $request){
        try {
            //Get Parameters from URL.
            $p = $this->parametersUrl(1, 12, false, []);

            //Request to Repository
            $zones = $this->zone->index($p->page, $p->take, $p->filter, $p->include);

            //Response
            $response = ["data" => ZoneTransformers::collection($zones)];

            //If request pagination add meta-page
            $p->page ? $response["meta"] = ["page" => $this->pageTransformer($zones)] : false;
        } catch (\Exception $e) {
            //Message Error
            $status = 500;
            $response = [
                "errors" => $e->getMessage()
            ];
        }

        return response()->json($response, $status ?? 200);
    }

    public function show($title, Request $request)
    {
        try {
            //Get Parameters from URL.
            $params = $this->parametersUrl(false, false, false, []);

            //Request to Repository
            $zone = $this->zone->show($title, $params);

            //Response
            $response = [
                "data" => is_null($zone) ? false : new ZoneTransformers($zone)];
        } catch (\Exception $e) {
            //Message Error
            $status = 500;
            $response = [
                "errors" => $e->getMessage()
            ];
        }

        return response()->json($response, $status ?? 200);
    }

    public function zones(Request $request)
    {
        try {
            if (isset($request->include)) {
                $includes = explode(",", $request->include);
            } else {
                $includes=null;
            }
            if (isset($request->filters) && !empty($request->filters)) {
                $filters = json_decode($request->filters);
                $results = $this->zone->whereFilters($filters, $includes);

                if (isset($filters->take)) {
                    $response = [
                        'meta' => [
                            "take" => $filters->take ?? 5,
                            "skip" => $filters->skip ?? 0,
                        ],
                        'data' => ZoneTransformers::collection($results),
                    ];
                } else {
                    $response = [
                        'meta' => [
                            "total-pages" => $results->lastPage(),
                            "per_page" => $results->perPage(),
                            "total-item" => $results->total()
                        ],
                        'data' => ZoneTransformers::collection($results),
                        'links' => [
                            "self" => $results->currentPage(),
                            "first" => $results->hasMorePages(),
                            "prev" => $results->previousPageUrl(),
                            "next" => $results->nextPageUrl(),
                            "last" => $results->lastPage()
                        ]

                    ];
                }
            } else {

                $results = $this->zone->paginate($request->paginate ?? 12);
                $response = [
                    'meta' => [
                        "total-pages" => $results->lastPage(),
                        "per_page" => $results->perPage(),
                        "total-item" => $results->total()
                    ],
                    'data' => ZoneTransformers::collection($results),
                    'links' => [
                        "self" => $results->currentPage(),
                        "first" => $results->hasMorePages(),
                        "prev" => $results->previousPageUrl(),
                        "next" => $results->nextPageUrl(),
                        "last" => $results->lastPage()
                    ]

                ];
            }

        } catch (\Exception $e) {
            Log::error($e);
            $status = 500;
            $response = ['errors' => [
                "code" => "501",
                "source" => [
                    "pointer" => url($request->path()),
                ],
                "title" => "Error Query Zones",
                "detail" => $e->getMessage()
            ]
            ];
        }

        return response()->json($response, $status ?? 200);

    }

    public function zone(Zone $zone, Request $request)
    { //dd($zone);
        try {
            if (isset($zone->id) && !empty($zone->id)) {
                $response = [
                    "type" => "articles",
                    "id" => $zone->id,
                    "attributes" => new ZoneTransformers($zone),

                ];

               // $includes = explode(",", $request->include);
            } else {
                $status = 404;
                $response = ['errors' => [
                    "code" => "404",
                    "source" => [
                        "pointer" => url($request->path()),
                    ],
                    "title" => "Not Found",
                    "detail" => 'Query empty'
                ]
                ];
            }
        } catch (\Exception $e) {
            Log::error($e);
            $status = 500;
            $response = ['errors' => [
                "code" => "501",
                "source" => [
                    "pointer" => url($request->path()),
                ],
                "title" => "Error Query Zones",
                "detail" => $e->getMessage()
            ]
            ];
        }

        return response()->json($response, $status ?? 200);
    }

//get
    public function posts(Zone $zone, Request $request)
    {
        try {
            $includes = explode(",", $request->include);
            if (isset($request->filters) && !empty($request->filters)) {
                $filters = json_decode($request->filters);
                $filters->zones = $zone->id;

                $results = $this->post->whereFilters($filters, $includes);

                if (isset($filters->take)) {
                    $response = [
                        'meta' => [
                            "take" => $filters->take ?? 5,
                            "skip" => $filters->skip ?? 0,
                        ],
                        'data' => ZoneTransformers::collection($results),
                    ];
                } else {
                    $response = [
                        'meta' => [
                            "total-pages" => $results->lastPage(),
                            "per_page" => $results->perPage(),
                            "total-item" => $results->total()
                        ],
                        'data' => ZoneTransformers::collection($results),
                        'links' => [
                            "self" => $results->currentPage(),
                            "first" => $results->hasMorePages(),
                            "prev" => $results->previousPageUrl(),
                            "next" => $results->nextPageUrl(),
                            "last" => $results->lastPage()
                        ]

                    ];
                }
            } else {

                $results = $this->post->whereFilters((object)$filter = ['zones' => $zone->id, 'paginate' => $request->paginate ?? 12], $request->includes ?? false);
                $response = [
                    'meta' => [
                        "total-pages" => $results->lastPage(),
                        "per_page" => $results->perPage(),
                        "total-item" => $results->total()
                    ],
                    'data' => ZoneTransformers::collection($results),
                    'links' => [
                        "self" => $results->currentPage(),
                        "first" => $results->hasMorePages(),
                        "prev" => $results->previousPageUrl(),
                        "next" => $results->nextPageUrl(),
                        "last" => $results->lastPage()
                    ]

                ];
            }
            if (isset($request->zone_id)) {

            } else {

            }

        } catch (\Exception $e) {
            $status = 500;
            $response = ['errors' => [
                "code" => "501",
                "source" => [
                    "pointer" => url($request->path()),
                ],
                "title" => "Error Query Zones",
                "detail" => $e->getMessage()
            ]
            ];
        }

        return response()->json($response, $status ?? 200);
    }

//post
    public function store(Request $request)
    {//dd($request);
        try {
            $zone = $this->zone->create($request->all());
            $status = 200;
            $response = [
                'susses' => [
                    'code' => '201',
                    "source" => [
                        "pointer" => url($request->path())
                    ],
                    "title" => trans('core::core.messages.resource created', ['name' => trans('iplace::common.singular')]),
                    "detail" => [
                        'id' => $zone->id
                    ]
                ]
            ];
        } catch (\Exception $e) {
            Log::error($e);
            $status = 500;
            $response = ['errors' => [
                "code" => "501",
                "source" => [
                    "pointer" => url($request->path()),
                ],
                "title" => "Error Query Zones",
                "detail" => $e->getMessage()
            ]
            ];
        }
        return response()->json($response, $status ?? 200);

    }

    public function update(Zone $zone, Request $request)
    {

        try {

            if (isset($zone->id) && !empty($zone->id)) {
                $options = (array)$request->options ?? array();
                $request['options'] = json_encode($options);
                $zone = $this->zone->update($zone, $request->all());

                $status = 200;
                $response = [
                    'susses' => [
                        'code' => '201',
                        "source" => [
                            "pointer" => url($request->path())
                        ],
                        "title" => trans('core::core.messages.resource updated', ['name' => trans('iplace::zones.singular')]),
                        "detail" => [
                            'id' => $zone->id
                        ]
                    ]
                ];


            } else {
                $status = 404;
                $response = ['errors' => [
                    "code" => "404",
                    "source" => [
                        "pointer" => url($request->path()),
                    ],
                    "title" => "Not Found",
                    "detail" => 'Query empty'
                ]
                ];
            }
        } catch (\Exception $e) {
            Log::error($e);
            $status = 500;
            $response = ['errors' => [
                "code" => "501",
                "source" => [
                    "pointer" => url($request->path()),
                ],
                "title" => "Error Query Zone",
                "detail" => $e->getMessage()
            ]
            ];
        }

        return response()->json($response, $status ?? 200);
    }

    public function delete(Zone $zone, Request $request)
    {
        try {
            $this->zone->destroy($zone);
            $status = 200;
            $response = [
                'susses' => [
                    'code' => '201',
                    "title" => trans('core::core.messages.resource deleted', ['name' => trans('iplace::zones.singular')]),
                    "detail" => [
                        'id' => $zone->id
                    ]
                ]
            ];

        } catch (\Exception $e) {
            Log::error($e);
            $status = 500;
            $response = ['errors' => [
                "code" => "501",
                "source" => [
                    "pointer" => url($request->path()),
                ],
                "title" => "Error Query Post",
                "detail" => $e->getMessage()
            ]
            ];
        }

        return response()->json($response, $status ?? 200);
    }



}