<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

// Resources
use App\Http\Resources\QuestionResource;
use App\Models\Comment;

class PracticeTestQuestionResource extends JsonResource
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
            'question_id' => encrypt($this->id),
            'is_correct' => $this->is_correct,
            'marks_awarded' => $this->marks_awarded,
            'question' => new QuestionResource($this->question),
            'question_option_id' => $this->question_option_id,
            'status' => $this->status,
            'time_taken' => $this->time_taken,
            'comments' => Comment::where('question_id',  $this->question_id)->orderBy('id','desc')->get()
        ];
    }
}
