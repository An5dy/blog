<?php

namespace App\Contracts;

interface ImageSystem
{
    /**
     * 图像处理驱动
     *
     * @return mixed
     */
    public function driver();

    /**
     * 图片上传
     *
     * @param $image
     * @return mixed
     */
    public function upload($image);

    /**
     * 下载图片
     *
     * @param $path 图片地址
     * @return mixed
     */
    public function download($path);

    /**
     * 图片保存配置文件
     *
     * @return mixed
     */
    public function configure();
}