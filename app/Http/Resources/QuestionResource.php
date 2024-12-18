<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

// Resources
use App\Http\Resources\QuestionOptionResource;

class QuestionResource extends JsonResource
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
            'question_id' => $this->question_id,
            'description' => $this->description,
            'previous_years' => $this->previous_years,
            'title' => $this->title,
            'explanation' => $this->explanation,
            'image' => $this->question_image ? $this->question_image->path : null,
            'options' => QuestionOptionResource::collection($this->options)
        ];
    }
}
