<?php


namespace Modules\Iplaces\Http\Controllers\Api;

use Illuminate\Http\Request;
use Log;
use Mockery\CountValidator\Exception;
use Modules\Core\Http\Controllers\BasePublicController;
use Modules\Iplaces\Repositories\ZoneRepository;
use Modules\Iplaces\Entities\Zone;
use Modules\Iplaces\Repositories\PlaceRepository;
use Modules\Iplaces\Transformers\PlaceTransformers;
use Modules\Iplaces\Transformers\ZoneTransformers;
use Modules\Iplaces\Entities\Status;
use Route;

class ZoneController extends BasePublicController
{
    private $zone;

    public function __construct(ZoneRepository $zone)
    {
        parent::__construct();
        $this->zone = $zone;

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
                        'data' => PlaceTransformers::collection($results),
                    ];
                } else {
                    $response = [
                        'meta' => [
                            "total-pages" => $results->lastPage(),
                            "per_page" => $results->perPage(),
                            "total-item" => $results->total()
                        ],
                        'data' => PlaceTransformers::collection($results),
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
                    'data' => PlaceTransformers::collection($results),
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

    public function zone(Place $zone, Request $request)
    { dd($zone);
        try {
            if (isset($zone->id) && !empty($zone->id)) {
                $response = [
                    "meta" => [
                        "metatitle" => $zone->metatitle,
                        "metadescription" => $zone->metadescription
                    ],
                    "type" => "articles",
                    "id" => $zone->id,
                    "attributes" => new PlaceTransformers($zone),

                ];

                $includes = explode(",", $request->include);

                if (in_array('author', $includes)) {
                    $response["relationships"]["author"] = new UserProfileTransformer($zone->user);

                }
                if (in_array('category', $includes)) {
                    $response["relationships"]["category"] = new CategoryTransformer($zone->category);
                }



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

    public function store(Request $request)
    {//dd($request);
        try {
            $options = (array)$request->options ?? array();
            isset($request->metatitle) ? $options['metatitle'] = $request->metatitle : false;
            isset($request->metadescription) ? $options['metadescription'] = $request->metatitle : false;
            $request['options'] = $options;
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

    public function update(Place $zone, Request $request)
    {

        try {

            if (isset($zone->id) && !empty($zone->id)) {
                $options = (array)$request->options ?? array();
                isset($request->metatitle) ? $options['metatitle'] = $request->metatitle : false;
                isset($request->metadescription) ? $options['metadescription'] = $request->metatitle : false;
                isset($request->mainimage) ? $options["mainimage"] = saveImage($request['mainimage'], "assets/iplace/zones/" . $zone->id . ".jpg") : false;
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
                "title" => "Error Query Post",
                "detail" => $e->getMessage()
            ]
            ];
        }

        return response()->json($response, $status ?? 200);
    }

    public function delete(Place $zone, Request $request)
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