<?php

namespace App\Extensions\Image;

use Intervention\Image\Filters\FilterInterface;

class ResizeFilter implements FilterInterface
{
    /**
     * 图片宽
     *
     * @var
     */
    protected $width;

    /**
     * 图片高
     *
     * @var
     */
    protected $height;

    /**
     * 设置宽和高
     *
     * ResizeFilter constructor.
     * @param $width
     * @param $height
     */
    public function __construct($width, $height)
    {
        $this->width = $width;
        $this->height = $height;
    }

    /**
     * 图片缩放处理
     *
     * @param \Intervention\Image\Image $image
     */
    public function applyFilter(\Intervention\Image\Image $image)
    {
        return $image->resize($this->width, $this->height, function ($constraint) {
            $constraint->aspectRatio();// 纵横比
            $constraint->upsize();// 不被放大
        });
    }
}