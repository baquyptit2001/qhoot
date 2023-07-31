<?php

namespace App\Http\Resources\Topic;

use App\Http\Resources\CategoryResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;

class TopicResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return array(
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'category' => CategoryResource::make($this->category),
            'image' => env('APP_URL') . '/' . $this->image,
            'questions' => QuestionResource::collection($this->questions),
            'user' => $this->user,
        );
    }
}
