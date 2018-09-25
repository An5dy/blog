<?php
declare(strict_types=1);

namespace App\Services;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CategoryCollection;

class CategoryService
{
    protected $category;

    protected $attribute;

    /**
     * 注入 Category
     *
     * CategoryService constructor.
     * @param Category $category
     */
    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    /**
     * 列表
     *
     * @return CategoryCollection
     */
    public function getCategories(): CategoryCollection
    {
        $categories = $this->category->get(['id', 'title', 'created_at', 'updated_at']);

        return new CategoryCollection($categories);
    }

    /**
     * 详情
     *
     * @param $id
     * @return CategoryResource
     */
    public function getCategory($id): CategoryResource
    {
        $category = $this->category->findOrFail($id);

        return new CategoryResource($category);
    }

    /**
     * 新增
     *
     * @param Request $request
     * @return CategoryResource
     */
    public function setCategory(Request $request): CategoryResource
    {
        $this->setAttribute($request);

        $category = $this->category->create($this->getAttribute());

        return new CategoryResource($category);
    }

    /**
     * 更新
     *
     * @param Request $request
     * @param $id
     * @return CategoryResource
     */
    public function updateCategory(Request $request, $id): CategoryResource
    {
        $category = $this->category->findOrFail($id);
        $this->setAttribute($request);
        $category->update($this->getAttribute());

        return new CategoryResource($category);
    }

    /**
     * 删除
     *
     * @param $id
     * @return bool
     */
    public function deleteCategory($id): bool
    {
        $category = $this->category->findOrFail($id);

        return $category->delete($id);
    }

    /**
     * @param $request
     */
    protected function setAttribute($request): void
    {
        $this->attribute = $request->only(['title']);
    }

    /**
     * @return array
     */
    protected function getAttribute(): array
    {
        return $this->attribute;
    }
}