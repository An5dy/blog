<?php

namespace App\Observers;

use App\Models\About;
use App\Contracts\BlogCache;

class AboutObserver
{
    /**
     * 监听关于新增/修改事件
     *
     * @param About $about
     */
    public function saved(About $about)
    {
        $this->clearCache();
    }

    /**
     * 清除缓存
     */
    protected function clearCache()
    {
        // 清除缓存
        $cache = app()->make(BlogCache::class);
        $cache->forget(config('api.cache.about.key'));
    }
}
