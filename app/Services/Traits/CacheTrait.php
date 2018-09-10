<?php

namespace App\Services\Traits;

use Closure;
use App\Contracts\BlogCache;

trait CacheTrait
{
    protected $cache;

    protected $cacheKey;

    protected $cacheTag;

    protected $cacheExpire;

    /**
     * 初始化缓存
     *
     * @return mixed
     */
    protected function initCache(): BlogCache
    {
        if (! isset($this->cache)) {
            $this->cache = app()->make(BlogCache::class);
        }

        return $this->cache;
    }

    /**
     * 初始化配置文件
     *
     * @param $key  article | articles | archives | about
     * @return \Illuminate\Config\Repository|mixed
     */
    protected function cacheConfig($option, $key = '', $expire = null)
    {
        $config = config('api.cache.' . $option);

        // 缓存 key
        $keyStr = $key instanceof Closure ? $key() : $key;
        $this->cacheKey = $config['key'] . $keyStr;

        $this->cacheExpire = $config['expire'] ?? 0;// 缓存失效时间

        $this->cacheTag = $config['tag'] ?? null;// 缓存 tag
    }

    /**
     *
     *
     * @param $key
     * @param Closure $callback
     * @param null $expire
     * @param null $tag
     */
    protected function remember(Closure $callback, $key = null, $expire = null, $tag = null)
    {
        return $this->initCache()->remember($this->cacheKey, $callback, $this->cacheExpire, $this->cacheTag);
    }

    /**
     * 永久缓存
     *
     * @param $key
     * @param Closure $closure
     * @param null $tag
     */
    public function rememberForever(Closure $closure)
    {
        return $this->initCache()->rememberForever($this->cacheKey, $closure, $this->cacheTag);
    }
}