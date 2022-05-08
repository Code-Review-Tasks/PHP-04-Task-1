<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LinkResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'hash' => $this->hash,
            'long_url' => $this->long_url,
            'tags' => TagResource::collection($this->tags),
            'title' => $this->title,
            'total_views' => $this->total_views,
            'unique_views' => $this->unique_views
        ];
    }
}
