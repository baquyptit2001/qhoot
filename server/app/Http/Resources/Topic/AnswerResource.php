<?php

namespace App\Http\Resources\Topic;

use Illuminate\Http\Resources\Json\JsonResource;

class AnswerResource extends JsonResource
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
            'question_id' => $this->question_id,
            'is_correct' => $this->is_correct,
        );
    }
}
