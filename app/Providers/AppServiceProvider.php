<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use DB;

// Models
use App\Models\Tax;
use App\Models\Topic;
use App\Models\Course;
use App\Models\CourseChapter;
use App\Models\CourseChapterContent;
use App\Models\Thread;
use App\Models\Channel;
use App\Models\Reply;
use App\Models\Favourite;

// Observers
use App\Observers\TaxObserver;
use App\Observers\TopicObserver;
use App\Observers\CourseObserver;
use App\Observers\CourseChapterObserver;
use App\Observers\CourseChapterContentObserver;
use App\Observers\ThreadObserver;
use App\Observers\ReplyObserver;
use App\Observers\FavouriteObserver;
use App\Observers\ChannelObserver;

// Support Facades
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->isLocal()) {
            $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Tax::observe(TaxObserver::class);
        Topic::observe(TopicObserver::class);
        Course::observe(CourseObserver::class);
        CourseChapter::observe(CourseChapterObserver::class);
        CourseChapterContent::observe(CourseChapterContentObserver::class);
        Thread::observe(ThreadObserver::class);
        Reply::observe(ReplyObserver::class);
        Favourite::observe(FavouriteObserver::class);
        Channel::observe(ChannelObserver::class);

        \View::composer('*', function ($view) {
            $channels = Channel::all();
            $channelsToFollow = Channel::inRandomOrder()->take(10)->get();

            $view->with('channels', $channels);
            $view->with('channelsToFollow', $channelsToFollow);

            if (Auth::check()) {
                $myActiveThreads = Thread::whereUserId(Auth::id())->inRandomOrder()->take(5)->get();

                $view->with('myActiveThreads', $myActiveThreads);
            }
        });
    }
}
