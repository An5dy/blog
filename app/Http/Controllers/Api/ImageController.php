<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ImageUploadRequest;
use Illuminate\Http\Request;
use App\Services\ImageService;

class ImageController extends ApiController
{
    protected $imageService;

    /**
     * 注入 ImageService
     *
     * ImageController constructor.
     * @param ImageService $imageService
     */
    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    /**
     * 上传
     *
     * @param ImageUploadRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(ImageUploadRequest $request)
    {
        $response = $this->imageService->upload($request);

        return $this->successResponseWithJson($response);
    }
}
