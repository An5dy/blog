<?php

namespace App\Http\Resources;

use App\Http\Resources\Traits\ApiResourcesTrait;
use Illuminate\Http\Resources\Json\JsonResource;

class AboutResource extends JsonResource
{
    use ApiResourcesTrait;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if (! $this->resource) {
            $this->resource = [];
        }

        return parent::toArray($request);
    }
}
