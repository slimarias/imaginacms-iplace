<?php

namespace Modules\Iplaces\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Iplaces\Entities\Category;
use Modules\Iplaces\Http\Requests\CreateCategoryRequest;
use Modules\Iplaces\Http\Requests\UpdateCategoryRequest;
use Modules\Iplaces\Repositories\CategoryRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Iplaces\Entities\Status;

class CategoryController extends AdminBaseController
{
    /**
     * @var CategoryRepository
     */
    private $category;
    public $status;

    public function __construct(CategoryRepository $category, Status $status)
    {
        parent::__construct();

        $this->category = $category;
        $this->status=$status;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $categories = $this->category->paginate(20);

        return view('iplaces::admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()

    {   $statuses = $this->status->lists();
        $categories = $this->category->paginate(20);
        return view('iplaces::admin.categories.create',compact('categories','statuses','categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateCategoryRequest $request
     * @return Response
     */
    public function store(CreateCategoryRequest $request)
    {

        try{
            $this->category->create($request->all());

            return redirect()->route('admin.iplaces.category.index')
                ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('iplaces::categories.title.categories')]));
        }
        catch (\Exception $e){
            \Log::error($e);
            return redirect()->back()
                ->withError(trans('core::core.messages.resource error', ['name' => trans('iplaces::categories.title.categories')]));

        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Category $category
     * @return Response
     */
    public function edit(Category $category)
    {
     //   dd($category);
        $statuses = $this->status->lists();
        return view('iplaces::admin.categories.edit', compact('category', 'statuses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Category $category
     * @param  UpdateCategoryRequest $request
     * @return Response
     */
    public function update(Category $category, UpdateCategoryRequest $request)
    {
//dd($request);
        try{
            $this->category->update($category, $request->all());

            return redirect()->route('admin.iplaces.category.index')
                ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('iplaces::categories.title.categories')]));

        }catch (\Exception $e){
            \Log::error($e);
            return redirect()->back()
                ->withError(trans('core::core.messages.resource error', ['name' => trans('iplaces::categories.title.categories')]));

    }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Category $category
     * @return Response
     */
    public function destroy(Category $category)
    {
        try{
            $this->category->destroy($category);

            return redirect()->route('admin.iplaces.category.index')
                ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('iplaces::categories.title.categories')]));

        }catch (\Exception $e){
            \Log::error($e);
            return redirect()->back()
                ->withError(trans('core::core.messages.resource error', ['name' => trans('iplaces::categories.title.categories')]));
        }

    }
}
