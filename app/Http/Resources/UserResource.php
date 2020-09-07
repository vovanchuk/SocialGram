<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'title' => $this->title,
            'description' => $this->description,
            'url' => $this->url,
            'lastActivity' => $this->lastActivity,
            'avatar' => $this->avatar,
        ];
    }
}
