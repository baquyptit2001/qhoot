<?php

namespace App\Http\Resources\Topic;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
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
            'description' => $this->description,
            'topic_id' => $this->topic_id,
            'user_id' => $this->user_id,
            'sort_order' => $this->sort_order,
            'answers' => AnswerResource::collection($this->answers),
        );
    }
}
