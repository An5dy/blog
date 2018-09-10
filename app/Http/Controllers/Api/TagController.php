<?php

namespace App\Http\Controllers\Api;

use App\Services\TagService;

class TagController extends ApiController
{
    protected $tagService;

    /**
     * 注入 TagService
     *
     * TagController constructor.
     * @param TagService $tagService
     */
    public function __construct(TagService $tagService)
    {
        $this->tagService = $tagService;
    }

    /**
     * 删除
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $this->tagService->delete($id);

        return $this->successResponseWithJson();
    }
}
