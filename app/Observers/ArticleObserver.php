<?php

namespace App\Observers;

use Redis;
use App\Models\Tag;
use App\Models\Article;
use App\Contracts\BlogCache;

class ArticleObserver
{
    /**
     * 监听文章查询事件
     *
     * @param Article $article
     */
    public function retrieved(Article $article)
    {
        if (is_admin() || request()->route()->getActionMethod() != 'show') {
            return;
        }

        // 限制访问量
        $ip = request()->ip();
        if ($this->isIPLimit($ip, $article->id)) {
            $this->addView($article, $ip);
        }
    }

    /**
     * 监听文章新增/修改事件
     *
     * @param Article $article
     */
    public function saved(Article $article)
    {
        // 保存标签
        $tags = request('tags');

        $tagIds = collect($tags)->map(function ($tag) use ($article, $tags) {
            $tagModel = Tag::firstOrCreate(['title' => strip_tags($tag)]);

            return $tagModel->id;
        })->toArray();

        $article->tags()->sync($tagIds);

        $this->cacheFlush();// 清除缓存
    }

    /**
     * 清除缓存
     *
     * @param Article $article
     */
    public function deleted(Article $article)
    {
        $this->cacheFlush();
    }

    /**
     * 限制 IP 访问
     *
     * @param $ip
     * @param $articleId
     * @return bool
     */
    protected function isIPLimit($ip, $articleId)
    {
        $cacheConfig = config('api.view.cache');

        $cacheKey = $cacheConfig['key'] . $articleId;

        $existed = Redis::command('SISMEMBER', [$cacheKey, $ip]);
        if (! $existed) {
            Redis::command('SADD', [$cacheKey, $ip]);// 保存数据到集合
            Redis::command('EXPIRE', [$cacheKey, $cacheConfig['expire']]);// 设置访问失效时间，超过设置时间就当重新访问

            return true;
        }

        return false;
    }

    /**
     * 增加访问量
     *
     * @param $article
     * @param $ip
     */
    protected function addView($article, $ip)
    {
        // 保存访问用户信息
        $article->views()->create([
            'ip' => $ip,
            'extra' => geoip($ip)->toArray(),
        ]);
        // 清除缓存
        $this->cacheFlush();
    }

    /**
     * 清除文章缓存
     */
    protected function cacheFlush()
    {
        // 清除缓存
        $cache = app()->make(BlogCache::class);
        $cache->flush(config('api.cache')['article']['tag']);
    }
}
