<?php

namespace App\Models;

use App\Models\User;
use App\Models\Reply;
use App\Models\Channel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Thread extends Model
{
    use HasFactory;
    use Flaggable;

    protected $fillable = [
        'user_id',
        'title',
        'body',
        'channel_id'
    ];

    protected $with = ['creator', 'channel'];

    protected $appends = ['is_subscribed_to'];

    /**
     * Links a thread to its path and return proper URI.
     * */
    public function path()
    {
        return asset('')."forum/{$this->channel->slug}/{$this->id}";
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function addReply($reply)
    {
        $reply = $this->replies()->create($reply);

        $this->subscriptions
             ->filter(function ($sub) use ($reply) {
                return $sub->user_id != $reply->user_id;
             })
             ->each->notify($reply);

        return $reply;
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    /**
     * Apply all relevant thread filters.
     *
     * @param  Builder       $query
     * @param  ThreadFilters $filters
     * @return Builder
     */
    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }

    /**
     * Get the thread's activities.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function activities()
    {
        return $this->morphMany('App\Models\Activity', 'subjectable');
    }

    public function subscribe($userId = null)
    {
        $this->subscriptions()->create([
            'user_id' => $userId ?: auth()->id()
        ]);

        return $this;
    }

    public function unsubscribe($userId = null)
    {
        $this->subscriptions()
             ->where('user_id', $userId ?: auth()->id())
             ->delete();
    }

    public function subscriptions()
    {
        return $this->hasMany('App\Models\ThreadSubscription');
    }

    public function getIsSubscribedToAttribute()
    {
        return $this->subscriptions()
                    ->where('user_id', auth()->id())
                    ->exists();
    }
}
