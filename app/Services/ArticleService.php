<?php
declare(strict_types=1);

namespace App\Services;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Services\Traits\CacheTrait;
use App\Http\Resources\ArticleResource;
use App\Http\Resources\ArticleCollection;

class ArticleService
{
    use CacheTrait;

    protected $article;

    protected $attribute;

    /**
     * 注入 Article
     *
     * ArticleService constructor.
     * @param Article $article
     */
    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    /**
     * 新增
     *
     * @param Request $request
     * @return ArticleResource
     */
    public function setArticle(Request $request): ArticleResource
    {
        // 保存文章
        $this->setAttribute($request);
        $article = $this->article->create($this->getAttribute());

        return new ArticleResource($article);
    }

    /**
     * 列表 + 搜索
     *
     * @param Request $request
     * @return ArticleCollection
     */
    public function getArticles(Request $request): ArticleCollection
    {
        $filter = $request->only('title');// 搜索条件

        $page = $request->get('page', 1);// 当前分页

        // 初始化缓存
        $this->cacheConfig('articles', function () use ($page, $filter) {
            return collect(['page' => $page])->merge($filter)->map(function ($item, $index) {
                return $index . ':' . $item;
            })->implode(':');
        });

        // 文章列表
        $articles = $this->remember(function () use ($filter) {
            return $this->article
                ->select(['id', 'category_id', 'title', 'cover_img', 'description', 'created_at'])
                ->withCount('views')
                ->with([
                    'category' => function ($query) {
                        return $query->select(['id', 'title']);
                    },
                    'tags' => function ($query) {
                        return $query->select(['id', 'title']);
                    },
                ])
                ->filter($filter)
                ->paginate(is_admin() ? config('api.paginate.admin') : config('api.paginate.front'));
        });

        return new ArticleCollection($articles);
    }

    /**
     * 归档
     *
     * @return ArticleCollection
     */
    public function getArchive(): ArticleCollection
    {
        $this->cacheConfig('archives');// 初始化缓存配置文件

        // 缓存归档
        $archives = $this->rememberForever(function () {
            return $this->article
                ->orderBy('created_at', 'desc')
                ->get(['id', 'title', 'created_at'])
                ->each(function ($archive) {
                    $archive->published_at = $archive->created_at->format('D, M j, Y');
                    $archive->mark = $archive->created_at->format('M, Y');
                })->groupBy('mark');
        });

        return new ArticleCollection($archives);
    }

    /**
     * 详情
     *
     * @param $id
     * @return ArticleResource
     */
    public function getArticle($id): ArticleResource
    {
        $this->cacheConfig('article', $id);// 初始化缓存配置文件

        // 缓存文章详情
        $article = $this->remember(function () use ($id) {
            return $this->article
                ->withCount('views')
                ->with([
                    'category' => function ($query) {
                        return $query->select(['id', 'title']);
                    },
                    'tags' => function ($query) {
                        return $query->select(['id', 'title']);
                    },
                ])
                ->findOrFail($id, ['category_id', 'title', 'cover_img', 'description', 'created_at']);
        });

        return new ArticleResource($article);
    }

    /**
     * 更新
     *
     * @param Request $request
     * @param $id
     * @return ArticleResource
     */
    public function updateArticle(Request $request, $id): ArticleResource
    {
        $article = $this->article->findOrFail($id);

        // 修改文章
        $this->setAttribute($request);
        $article->update($this->getAttribute());

        return new ArticleResource($article);
    }

    /**
     * 删除文章
     *
     * @param $id
     * @return bool
     */
    public function deleteArticle($id): bool
    {
        // 删除文章
        $article = $this->article->findOrFail($id);
        $article->delete();

        return true;
    }

    /**
     * @param mixed $attribute
     */
    protected function setAttribute($request)
    {
        $this->attribute = [
            'title' => $request->title,
            'category_id' => $request->category_id,
            'cover_img' => $request->cover_img,
            'markdown' => $request->markdown,
            'description' => str_limit(strip_tags(markdown($request->markdown)), config('api.article.description')),
        ];
    }

    /**
     * @return mixed
     */
    protected function getAttribute()
    {
        return $this->attribute;
    }
}