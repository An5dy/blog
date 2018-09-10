<?php

namespace App\Extensions\Image;

use App\Contracts\ImageSystem;
use Intervention\Image\ImageManager;

class StoreToLocal implements ImageSystem
{
    public $dirname;

    public $prefix;

    public $extension;

    /**
     * 配置文件
     *
     * StoreToLocal constructor.
     */
    public function __construct()
    {
        $this->configure();
    }

    /**
     * Intervention/Image 驱动
     *
     * @return ImageManager
     */
    public function driver()
    {
        return new ImageManager();
    }

    /**
     * 保存图片
     *
     * @param $image
     * @return string
     */
    public function upload($image): string
    {
        // 保存图片
        $basePath = $this->basePath();
        $this->driver()->make($image)->save($basePath);

        return $basePath;
    }

    /**
     * 下载图片
     *
     * @param \App\Contracts\图片地址 $path
     * @return \Intervention\Image\Image
     */
    public function download($path)
    {

    }

    /**
     * 设置配置文件
     */
    public function configure()
    {
        $config = config('api.image');

        $this->dirname = $config['dirname'];
        $this->prefix = $config['prefix'];
        $this->extension = $config['extension'];
    }

    /**
     * 设置图片路径
     *
     * @return null|string
     */
    public function basePath()
    {
        if ($this->dirname && $this->prefix && $this->extension) {
            return $this->dirname . '/' . $this->baseName();
        }

        return null;
    }

    /**
     * 设置文件名
     *
     * @return string
     */
    public function baseName(): string
    {
        return $this->prefix . date('YmdHis', time()) . random_int(100000, 999999) . $this->extension;
    }
}