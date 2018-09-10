<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Article extends Model
{
    use SoftDeletes;

    protected $guarded = [];
    public function newQueryWithoutScope($scope)
    {
        return parent::newQueryWithoutScope($scope); // TODO: Change the autogenerated stub
    }

    /**
     * 追加字段
     *
     * @var array
     */
    protected $appends = [
        'published_at'
    ];

    /**
     * 隐藏字段
     *
     * @var array
     */
    protected $hidden = [
        'deleted_at'
    ];

    /**
     * 发布时间访问器
     *
     * @return mixed
     */
    public function getPublishedAtAttribute()
    {
        return $this->created_at->format('D, M j, Y');
    }

    /**
     * 搜索
     *
     * @param $query
     * @param $filterData
     * @return Builder
     */
    public function scopeFilter($query, $filterData): Builder
    {
        if (empty($filterData)) {
            return $query;
        }

        foreach ($filterData as $key => $value) {
            if ($filterData[$key]) {
                $query->{camel_case($key)}($value);
            }
        }

        return $query;
    }

    /**
     * 标题搜索
     *
     * @param $query
     * @param $title
     * @return Builder
     */
    public function scopeTitle($query, $title): Builder
    {
        return $query->where('title', 'like', '%' . $title .'%');
    }

    /**
     * 所属分类
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo('App\Models\Category');
    }

    /**
     * 拥有标签
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany('App\Models\Tag');
    }

    /**
     * 访问详情
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function views(): HasMany
    {
        return $this->hasMany('App\Models\ArticleView');
    }
}
