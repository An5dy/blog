<?php

namespace App\Http\Controllers\Api;

use App\Services\CategoryService;
use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;

class CategoryController extends ApiController
{
    protected $categoryService;

    /**
     * 注入 CategoryService
     *
     * CategoryController constructor.
     * @param CategoryService $categoryService
     */
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * 列表
     *
     * @return \App\Http\Resources\CategoryCollection
     */
    public function index()
    {
        $response = $this->categoryService->getCategories();

        return $response;
    }

    /**
     * 新增
     *
     * @param CategoryStoreRequest $request
     * @return \App\Http\Resources\CategoryResource
     */
    public function store(CategoryStoreRequest $request)
    {
        $response = $this->categoryService->setCategory($request);

        return $response;
    }

    /**
     * 详情
     *
     * @param $id
     * @return \App\Http\Resources\CategoryResource
     */
    public function show($id)
    {
        $response = $this->categoryService->getCategory($id);

        return $response;
    }

    /**
     * 更新
     *
     * @param CategoryUpdateRequest $request
     * @param $id
     * @return \App\Http\Resources\CategoryResource
     */
    public function update(CategoryUpdateRequest $request, $id)
    {
        $response = $this->categoryService->updateCategory($request, $id);

        return $response;
    }

    /**
     * 删除
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $this->categoryService->deleteCategory($id);

        return  $this->successResponseWithJson();
    }
}
