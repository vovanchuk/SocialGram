<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
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
            'profile' => [
                'id' => $this->id,
                'username' => $this->username,
                'title' => $this->title,
                'description' => $this->description,
                'url' => $this->url,
                'avatar' => $this->avatar,
                'last_activity' => $this->lastActivity,
            ],
            'posts' => $this->posts,
            'followers' => UserResource::collection($this->followers),
            'followings' => UserResource::collection($this->followings),
            'active_stories' => StoryResource::collection($this->whenLoaded('activeStories')),
            'favorited_stories' => StoryResource::collection($this->whenLoaded('favoritedStories')),
        ];
    }
}
