<?php

namespace App\Http\Controllers\Api;

use App\Services\AboutService;
use App\Http\Controllers\Controller;
use App\Http\Requests\AboutStoreRequest;
use App\Http\Requests\AboutUpdateRequest;

class AboutController extends Controller
{
    protected $aboutService;

    /**
     * 注入 AboutService
     *
     * AboutController constructor.
     * @param AboutService $aboutService
     */
    public function __construct(AboutService $aboutService)
    {
        $this->aboutService = $aboutService;
    }

    /**
     * 关于详情
     *
     * @return \App\Http\Resources\AboutResource
     */
    public function index()
    {
        $response = $this->aboutService->getAbout();

        return $response;
    }

    /**
     * 保存
     *
     * @param AboutStoreRequest $request
     * @return \App\Http\Resources\AboutResource
     */
    public function store(AboutStoreRequest $request)
    {
        $response = $this->aboutService->setAbout($request);

        return $response;
    }

    /**
     * 更新
     *
     * @param AboutUpdateRequest $request
     * @param $id
     * @return \App\Http\Resources\AboutResource
     */
    public function update(AboutUpdateRequest $request, $id)
    {
        $response = $this->aboutService->updateAbout($request, $id);

        return $response;
    }
}
