<?php

namespace App\Http\Resources\Quiz;

use App\Http\Resources\Auth\UserResource;
use App\Http\Resources\Topic\TopicResource;
use Illuminate\Http\Resources\Json\JsonResource;

class RoomResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return parent::toArray([
            "id" => $this->id,
            "user" => UserResource::make($this->user),
            "topics" => TopicResource::make($this->topics),
            "competitors" => RoomUserResource::collection($this->competitors),
            "name" => $this->name,
            "description" => $this->description,
            "password" => $this->password
        ]);
    }
}
