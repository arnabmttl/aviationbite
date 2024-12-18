<?php

namespace App\Repositories;

// Model for this repository
use App\Models\Comment;

// Support Facades
use Illuminate\Support\Facades\Log;

// Exception
use Exception;

class CommentRepository extends BaseRepository
{
    /**
     * Create a new repository instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Create a new comment.
     *
     * @param  array  $commentDetails
     * @return \App\Models\Comment|boolean
     */
    public function createComment($commentDetails)
    {
        try {
            return Comment::create($commentDetails);
        } catch (Exception $e) {
            Log::channel('test')->error('[CommentRepository:createComment] New comment not created because an exception occurred: ');
            Log::channel('test')->error($e->getMessage());

            return false;
        }
    }
}
