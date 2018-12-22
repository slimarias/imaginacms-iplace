<?php


namespace Modules\Iplaces\Http\Controllers\Api;

use Illuminate\Http\Request;
use Log;
use Mockery\CountValidator\Exception;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;
use Modules\Iplaces\Entities\Category;
use Modules\Iplaces\Repositories\PlaceRepository;
use Modules\Iplaces\Repositories\CategoryRepository;
use Modules\Iplaces\Transformers\CategoryTransformers;
use Modules\Iplaces\Entities\Status;

use Route;

class CategoryController extends BaseApiController
{
    private $category;
    public $status;

    public function __construct()
    {
        parent::__construct();
        $this->category = app('Modules\Iplaces\Repositories\CategoryRepository');
        $this->status = app('Modules\Iplaces\Entities\Status');
    }

    public function index(Request $request){

        try {
            //Get Parameters from URL.
            $p = $this->parametersUrl(1, 12, false, []);

            //Request to Repository
            $categories = $this->category->index($p->page, $p->take, $p->filter, $p->include);

            //Response
            $response = ["data" => CategoryTransformers::collection($categories)];

            //If request pagination add meta-page
            $p->page ? $response["meta"] = ["page" => $this->pageTransformer($categories)] : false;
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
            $category = $this->category->show($slug, $params);

            //Response
            $response = [
                "data" => is_null($category) ? false : new CategoryTransformers($category)];
        } catch (\Exception $e) {
            //Message Error
            $status = 500;
            $response = [
                "errors" => $e->getMessage()
            ];
        }

        return response()->json($response, $status ?? 200);
    }


//get
    public function categories(Request $request)
    {
       //dd($request)
        try {;
            if(isset($request->include)){
                $includes = explode(",", $request->include);
            }else{
                $includes=null;
            }
            if (isset($request->filters) && !empty($request->filters)) {
                $filters = json_decode($request->filters);
                $results = $this->category->whereFilters($filters, $includes);

                if (isset($filters->take)) {
                    $response = [
                        'meta' => [
                            "take" => $filters->take ?? 5,
                            "skip" => $filters->skip ?? 0,
                        ],
                        'data' => CategoryTransformers::collection($results),
                    ];
                } else {
                    $response = [
                        'meta' => [
                            "total-pages" => $results->lastPage(),
                            "per_page" => $results->perPage(),
                            "total-item" => $results->total()
                        ],
                        'data' => CategoryTransformers::collection($results),
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

                $results = $this->category->paginate($paginate);
                $response = [
                    'meta' => [
                        "total-pages" => $results->lastPage(),
                        "per_page" => $results->perPage(),
                        "total-item" => $results->total()
                    ],
                    'data' => CategoryTransformers::collection($results),
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
    public function category(Category $category, Request $request)
    {
       // dd($request);
        try {

            if (isset($category->id) && !empty($category->id)) {

                $response = [
                    "meta" => [
                        "metatitle" => $category->metatitle,
                        "metadescription" => $category->metadescription
                    ],
                    "type" => "category",
                    "id" => $category->id,
                    "attributes" => new CategoryTransformers($category),
                ];

                $includes = explode(",", $request->include);
                // is_array($request->include) ? true : $request->include = [$request->include];

                if (in_array('parent', $includes)) {
                    if ($category->parent) {
                        $response["relationships"]["parent"] = new CategoryTransformers($category->parent);
                    } else {
                        $response["relationships"]["parent"] = array();
                    }
                }
                if (in_array('children', $includes)) {

                    $response["relationships"]["children"] = CategoryTransformers::collection($category->children()->paginate(12));
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
                "title" => "Error Query Category",
                "detail" => $e->getMessage()
            ]
            ];
        }

        return response()->json($response, $status ?? 200);
    }
//get
    public function posts(Category $category, Request $request)
    {
        try {
            $includes = explode(",", $request->include);
            if (isset($request->filters) && !empty($request->filters)) {
                $filters = json_decode($request->filters);
                $filters->categories = $category->id;

                $results = $this->post->whereFilters($filters, $includes);

                if (isset($filters->take)) {
                    $response = [
                        'meta' => [
                            "take" => $filters->take ?? 5,
                            "skip" => $filters->skip ?? 0,
                        ],
                        'data' => CategoryTransformers::collection($results),
                    ];
                } else {
                    $response = [
                        'meta' => [
                            "total-pages" => $results->lastPage(),
                            "per_page" => $results->perPage(),
                            "total-item" => $results->total()
                        ],
                        'data' => CategoryTransformers::collection($results),
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

                $results = $this->post->whereFilters((object)$filter = ['categories' => $category->id, 'paginate' => $request->paginate ?? 12], $request->includes ?? false);
                $response = [
                    'meta' => [
                        "total-pages" => $results->lastPage(),
                        "per_page" => $results->perPage(),
                        "total-item" => $results->total()
                    ],
                    'data' => CategoryTransformers::collection($results),
                    'links' => [
                        "self" => $results->currentPage(),
                        "first" => $results->hasMorePages(),
                        "prev" => $results->previousPageUrl(),
                        "next" => $results->nextPageUrl(),
                        "last" => $results->lastPage()
                    ]

                ];
            }if(isset($request->category_id)){

            }else{

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
            $category = $this->category->create($request->all());
            $status = 200;
            $response = [
                'susses' => [
                    'code' => '201',
                    "source" => [
                        "pointer" => url($request->path())
                    ],
                    "title" => trans('core::core.messages.resource created', ['name' => trans('iplace::categories.singular')]),
                    "detail" => [
                        'id' => $category->id
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
    public function update(Category $category, Request $request)
    {

        try {

            if (isset($category->id) && !empty($category->id)) {
                $options = (array)$request->options ?? array();
                isset($request->mainimage) ? $options["mainimage"] = saveImage($request['mainimage'], "assets/iplace/category/" . $category->id . ".jpg") : false;
                $request['options'] = json_encode($options);
                $category = $this->category->update($category, $request->all());

                $status = 200;
                $response = [
                    'susses' => [
                        'code' => '201',
                        "source" => [
                            "pointer" => url($request->path())
                        ],
                        "title" => trans('core::core.messages.resource updated', ['name' => trans('iplace::categories.singular')]),
                        "detail" => [
                            'id' => $category->id
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
                "title" => "Error Query Category",
                "detail" => $e->getMessage()
            ]
            ];
        }

        return response()->json($response, $status ?? 200);
    }
//delete
    public function delete(Category $category, Request $request)
    {
        try {

            $this->category->destroy($category);
            $status = 200;
            $response = [
                'susses' => [
                    'code' => '201',
                    "title" => trans('core::core.messages.resource deleted', ['name' => trans('iplace::categories.singular')]),
                    "detail" => [
                        'id' => $category->id
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
                "title" => "Error Query Category",
                "detail" => $e->getMessage()
            ]
            ];
        }

        return response()->json($response, $status ?? 200);
    }



}