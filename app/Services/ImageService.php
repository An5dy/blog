<?php
declare(strict_types = 1);

namespace App\Services;

use Illuminate\Http\Request;
use App\Contracts\ImageSystem;
use App\Extensions\Common\Code;
use App\Exceptions\ApiException;

class ImageService
{
    protected $image;

    /**
     * 图片处理类
     *
     * ImageService constructor.
     */
    public function __construct()
    {
        $this->image = app()->make(ImageSystem::class);
    }

    /**
     * 图片上传
     *
     * @param Request $request
     * @return array
     */
    public function upload(Request $request): array
    {
        $image = $request->file('image');
        if (! $image->isValid()) {
            throw new ApiException('请上传正确的图片', Code::VALIDATE_FAIL);
        }
        $basePath = $this->image->upload($image);

        $basePath = '/images/medium/' . str_cut($basePath, '/', -1);

        return compact('basePath');
    }

    public function download()
    {

    }
}