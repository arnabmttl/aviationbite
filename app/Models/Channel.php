<?php

namespace App\Models;

use App\Models\Thread;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Channel extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'name'
    ];

    /**
    * Get the route key name for Laravel
    *
    * @return string
    *
    */

    public function getRouteKeyName()
    {
        return 'slug' ;
    }

    public function threads()
    {
        return $this->hasMany(Thread::class);
    }
}
