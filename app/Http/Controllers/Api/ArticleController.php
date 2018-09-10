<?php

namespace App\Http\Controllers\Api;

use App\Services\ArticleService;
use App\Http\Requests\ArticleStoreRequest;
use App\Http\Requests\ArticleSearchRequest;
use App\Http\Requests\ArticleUpdateRequest;

class ArticleController extends ApiController
{
    protected $articleService;

    /**
     * 注入 ArticleService
     *
     * ArticleController constructor.
     * @param ArticleService $articleService
     */
    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }

    /**
     * 列表
     *
     * @param ArticleSearchRequest $request
     * @return \App\Http\Resources\ArticleCollection
     */
    public function index(ArticleSearchRequest $request)
    {
        $response = $this->articleService->getArticles($request);

        return $response;
    }

    /**
     * 归档
     *
     * @return \App\Http\Resources\ArticleCollection
     */
    public function archive()
    {
        $response = $this->articleService->getArchive();

        return $response;
    }

    /**
     * 保存
     *
     * @param ArticleStoreRequest $request
     * @return \App\Http\Resources\ArticleResource
     */
    public function store(ArticleStoreRequest $request)
    {
        $response = $this->articleService->setArticle($request);

        return $response;
    }

    /**
     * 详情
     *
     * @param $id
     * @return \App\Http\Resources\ArticleResource
     */
    public function show($id)
    {
        $response = $this->articleService->getArticle($id);

        return $response;
    }

    /**
     * 更新
     *
     * @param ArticleUpdateRequest $request
     * @param $id
     * @return \App\Http\Resources\ArticleResource
     */
    public function update(ArticleUpdateRequest $request, $id)
    {
        $response = $this->articleService->updateArticle($request, $id);

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
        $this->articleService->deleteArticle($id);

        return $this->successResponseWithJson();
    }
}
