<?php


namespace Modules\Iplaces\Http\Controllers\Api;

use Illuminate\Http\Request;
use Log;
use Mockery\CountValidator\Exception;
use Modules\Iplaces\Http\Controllers\Api\BaseApiController;
use Modules\Iplaces\Entities\Service;
use Modules\Iplaces\Repositories\PlaceRepository;
use Modules\Iplaces\Repositories\ServiceRepository;
use Modules\Iplaces\Transformers\ServiceTransformers;
use Modules\Iplaces\Entities\Status;

use Route;

class ServiceController extends BaseApiController
{
    private $service;
    public $status;


    public function __construct(ServiceRepository $service, Status $status)
    {
        parent::__construct();
        $this->service = $service;
        $this->status = $status;
    }

    public function index(Request $request){
        try {
            //Get Parameters from URL.
            $p = $this->parametersUrl(1, 12, false, []);

            //Request to Repository
            $services = $this->place->index($p->page, $p->take, $p->filter, $p->include);

            //Response
            $response = ["data" => ServiceTransformer::collection($services)];

            //If request pagination add meta-page
            $p->page ? $response["meta"] = ["page" => $this->pageTransformer($services)] : false;
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
            $p = $this->parametersUrl(false, false, false, []);

            //Request to Repository
            $service = $this->place->show($slug, $p->include);

            //Response
            $response = [
                "data" => is_null($service) ? false : new ServiceTransformer($service)];
        } catch (\Exception $e) {
            //Message Error
            $status = 500;
            $response = [
                "errors" => $e->getMessage()
            ];
        }

        return response()->json($response, $status ?? 200);
    }

    public function services(Request $request)
    {
        //dd($request)
        try {
            if (isset($request->include)) {
                $includes = explode(",", $request->include);
            } else {
                $includes = null;
            }
            if (isset($request->filters) && !empty($request->filters)) {
                $filters = json_decode($request->filters);
                $results = $this->service->whereFilters($filters, $includes);

                if (isset($filters->take)) {
                    $response = [
                        'meta' => [
                            "take" => $filters->take ?? 5,
                            "skip" => $filters->skip ?? 0,
                        ],
                        'data' => ServiceTransformers::collection($results),
                    ];
                } else {
                    $response = [
                        'meta' => [
                            "total-pages" => $results->lastPage(),
                            "per_page" => $results->perPage(),
                            "total-item" => $results->total()
                        ],
                        'data' => ServiceTransformers::collection($results),
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
                $paginate = $request->paginate ?? 12;

                $results = $this->service->paginate($paginate);
                $response = [
                    'meta' => [
                        "total-pages" => $results->lastPage(),
                        "per_page" => $results->perPage(),
                        "total-item" => $results->total()
                    ],
                    'data' => ServiceTransformers::collection($results),
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
                "title" => "Error Query Categories",
                "detail" => $e->getMessage()
            ]
            ];
        }

        return response()->json($response, $status ?? 200);

    }

//get
    public function service(Service $service, Request $request)
    {
        // dd($request);
        try {

            if (isset($service->id) && !empty($service->id)) {

                $response = [
                    "meta" => [
                        "metatitle" => $service->metatitle,
                        "metadescription" => $service->metadescription
                    ],
                    "type" => "service",
                    "id" => $service->id,
                    "attributes" => new ServiceTransformers($service),
                ];

             //   $includes = explode(",", $request->include);
                // is_array($request->include) ? true : $request->include = [$request->include];


                /*

                 if (in_array('parent', $includes)) {
                     if ($service->parent) {
                         $response["relationships"]["parent"] = new ServiceTransformers($service->parent);
                     } else {
                         $response["relationships"]["parent"] = array();
                     }
                 }
                 if (in_array('children', $includes)) {

                     $response["relationships"]["children"] = ServiceTransformers::collection($service->children()->paginate(12));
                 }
 */

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
                "title" => "Error Query Service",
                "detail" => $e->getMessage()
            ]
            ];
        }

        return response()->json($response, $status ?? 200);
    }

//get
    public function posts(Service $service, Request $request)
    {
        try {
            $includes = explode(",", $request->include);
            if (isset($request->filters) && !empty($request->filters)) {
                $filters = json_decode($request->filters);
                $filters->services = $service->id;

                $results = $this->post->whereFilters($filters, $includes);

                if (isset($filters->take)) {
                    $response = [
                        'meta' => [
                            "take" => $filters->take ?? 5,
                            "skip" => $filters->skip ?? 0,
                        ],
                        'data' => ServiceTransformers::collection($results),
                    ];
                } else {
                    $response = [
                        'meta' => [
                            "total-pages" => $results->lastPage(),
                            "per_page" => $results->perPage(),
                            "total-item" => $results->total()
                        ],
                        'data' => ServiceTransformers::collection($results),
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

                $results = $this->post->whereFilters((object)$filter = ['services' => $service->id, 'paginate' => $request->paginate ?? 12], $request->includes ?? false);
                $response = [
                    'meta' => [
                        "total-pages" => $results->lastPage(),
                        "per_page" => $results->perPage(),
                        "total-item" => $results->total()
                    ],
                    'data' => ServiceTransformers::collection($results),
                    'links' => [
                        "self" => $results->currentPage(),
                        "first" => $results->hasMorePages(),
                        "prev" => $results->previousPageUrl(),
                        "next" => $results->nextPageUrl(),
                        "last" => $results->lastPage()
                    ]

                ];
            }
            if (isset($request->category_id)) {

            } else {

            }

        } catch (\Exception $e) {
            $status = 500;
            $response = ['errors' => [
                "code" => "501",
                "source" => [
                    "pointer" => url($request->path()),
                ],
                "title" => "Error Query Categories",
                "detail" => $e->getMessage()
            ]
            ];
        }

        return response()->json($response, $status ?? 200);
    }

//post
    public function store(Request $request)
    {
        try {
            $service = $this->service->create($request->all());
            $status = 200;
            $response = [
                'susses' => [
                    'code' => '201',
                    "source" => [
                        "pointer" => url($request->path())
                    ],
                    "title" => trans('core::core.messages.resource created', ['name' => trans('iplace::common.singular')]),
                    "detail" => [
                        'id' => $service->id
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
                "title" => "Error Query Categories",
                "detail" => $e->getMessage()
            ]
            ];
        }
        return response()->json($response, $status ?? 200);

    }

    //put
    public function update(Service $service, Request $request)
    {

        try {

            if (isset($service->id) && !empty($service->id)) {
                $options = (array)$request->options ?? array();
                isset($request->metatitle) ? $options['metatitle'] = $request->metatitle : false;
                isset($request->metadescription) ? $options['metadescription'] = $request->metatitle : false;
                isset($request->mainimage) ? $options["mainimage"] = saveImage($request['mainimage'], "assets/iplace/service/" . $service->id . ".jpg") : false;
                $request['options'] = json_encode($options);
                $service = $this->service->update($service, $request->all());

                $status = 200;
                $response = [
                    'susses' => [
                        'code' => '201',
                        "source" => [
                            "pointer" => url($request->path())
                        ],
                        "title" => trans('core::core.messages.resource updated', ['name' => trans('iplace::services.singular')]),
                        "detail" => [
                            'id' => $service->id
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
                "title" => "Error Query Service",
                "detail" => $e->getMessage()
            ]
            ];
        }

        return response()->json($response, $status ?? 200);
    }

//delete
    public function delete(Service $service, Request $request)
    {
        try {

            $this->service->destroy($service);
            $status = 200;
            $response = [
                'susses' => [
                    'code' => '201',
                    "title" => trans('core::core.messages.resource deleted', ['name' => trans('iplace::services.singular')]),
                    "detail" => [
                        'id' => $service->id
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
                "title" => "Error Query Service",
                "detail" => $e->getMessage()
            ]
            ];
        }

        return response()->json($response, $status ?? 200);
    }


}