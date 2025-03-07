<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Notifications\ThreadWasUpdated;

class ThreadSubscription extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
    	return $this->belongsTo('App\Models\User');
    }

    public function thread()
    {
    	return $this->belongsTo('App\Models\Thread');
    }

    public function notify($reply)
    {
    	$this->user->notify(new ThreadWasUpdated($this->thread, $reply));
    }
}
