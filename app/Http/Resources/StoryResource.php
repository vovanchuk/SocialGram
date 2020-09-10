<?php

namespace App\Http\Resources;

use App\Entity\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpKernel\Profiler\Profile;

class StoryResource extends JsonResource
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
            'user' => new ProfileResource($this->whenLoaded('user')),
            'url' => $this->url,
            'type' => $this->type,
            'viewers' => UserResource::collection($this->viewers),
            'duration' => $this->when($this->type === 'video', $this->duration),
            'preview_url' => $this->when($this->type === 'video', $this->preview_url),
        ];
    }
}
