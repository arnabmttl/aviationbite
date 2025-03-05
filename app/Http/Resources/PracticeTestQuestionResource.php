<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

// Resources
use App\Http\Resources\QuestionResource;
use App\Models\Comment;
use App\Models\Question;
use App\Models\Note;

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
            'question_pk_id' => encrypt($this->question_id),
            'comments' => Comment::where('question_id',  $this->question_id)->orderBy('id','desc')->get(),
            'notes' => Note::where('question_id',  $this->question_id)->where('user_id', \Auth::user()->id)->orderBy('id', 'desc')->get(),
            'question_master_comment_count' => Question::where('id', $this->question_id)->whereNotNull('practice_test_comment')->count(),
            'count_comments' => Comment::where('question_id',  $this->question_id)->count(),
            'count_notes' => Note::where('question_id',  $this->question_id)->where('user_id', \Auth::user()->id)->count()
        ];
    }
}
