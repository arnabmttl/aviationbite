<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Auth;

class Reply extends Model
{
    use HasFactory;
    use Favouritable;
    use Flaggable;

    protected $fillable = [
        'user_id',
        'body'
    ];

    protected $with = ['owner', 'favourites'];

    protected $appends = ['favouritesCount', 'isFavourited'];

    /**
     * A reply has an owner
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * */
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the reply's activities.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function activities()
    {
        return $this->morphMany('App\Models\Activity', 'subjectable');
    }

    /**
     * Get the reply's thread.
     *
     * @return \App\Models\Thread
     */
    public function thread()
    {
        return $this->belongsTo('App\Models\Thread');
    }

    public function path()
    {
        return $this->thread->path() . '#reply-' . $this->id;
    }
}
