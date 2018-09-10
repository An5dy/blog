<?php
declare(strict_types = 1);

namespace App\Services;

use App\Models\Tag;

class TagService
{
    protected $tag;

    /**
     * 注入 Tag
     *
     * TagService constructor.
     * @param Tag $tag
     */
    public function __construct(Tag $tag)
    {
        $this->tag = $tag;
    }

    /**
     * 删除
     *
     * @param $id
     * @return bool
     */
    public function delete($id): bool
    {
        $tag = $this->tag->findOrFail($id);

        return $tag->delete($id);
    }
}