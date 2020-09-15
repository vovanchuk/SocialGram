<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
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
            'id'          => $this->id,
            'user_id'     => $this->user_id,
            'description' => $this->description,
            'image_path'  => $this->imagePath,
            'created_at'  => $this->created_at,
            'author'      => new UserResource($this->user),
            'comments'    => CommentResource::collection($this->comments),
            'likes'       => UserResource::collection($this->likes),
        ];
    }
}
