<?php
declare(strict_types = 1);

namespace App\Services;

use App\Models\About;
use Illuminate\Http\Request;
use App\Services\Traits\CacheTrait;
use App\Http\Resources\AboutResource;

class AboutService
{
    use CacheTrait;

    protected $about;

    protected $attribute;

    /**
     * 注入 About
     *
     * AboutService constructor.
     * @param About $about
     */
    public function __construct(About $about)
    {
        $this->about = $about;
    }

    /**
     * 查询
     *
     * @return AboutResource
     */
    public function getAbout(): AboutResource
    {
        $this->cacheConfig('about'); // 初始化缓存配置

        $about = $this->rememberForever(function () {
            return $this->about->first(['id', 'title', 'markdown']);
        });

        return new AboutResource($about);
    }

    /**
     * 保存
     *
     * @param Request $request
     * @return AboutResource
     */
    public function setAbout(Request $request): AboutResource
    {
        $this->setAttribute($request);
        $about = $this->about->create($this->getAttribute());

        return new AboutResource($about);
    }

    /**
     * 更新
     *
     * @param Request $request
     * @param $id
     * @return AboutResource
     */
    public function updateAbout(Request $request, $id): AboutResource
    {
        $about = $this->about->findOrFail($id);
        $this->setAttribute($request);
        $about->update($this->getAttribute());

        return new AboutResource($about);
    }

    /**
     * @param $request
     */
    protected function setAttribute($request)
    {
        $this->attribute = $request->only(['title', 'markdown']);
    }

    /**
     * @return mixed
     */
    protected function getAttribute()
    {
        return $this->attribute;
    }
}