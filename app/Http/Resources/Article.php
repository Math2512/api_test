<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class Article extends JsonResource
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
            "id"    => $this->id,
            "title" => $this->title,
            "content" => substr($this->content, 0, 20)." ...",
            "user" => $this->user->name,
            "published" => $this->published_at ? "Publié ".$this->published_at : null,
            "full_content" => $this->content
        ];
    }
}
