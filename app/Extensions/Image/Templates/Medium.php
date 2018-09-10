<?php

namespace App\Extensions\Image\Templates;

use Intervention\Image\Image;
use Intervention\Image\Filters\FilterInterface;

class Medium implements FilterInterface
{
    public function applyFilter(Image $image)
    {
        return $image->fit(600, 300, function ($constraint) {
            $constraint->upsize();
            $constraint->aspectRatio();
        });
    }
}