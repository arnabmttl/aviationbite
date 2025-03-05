<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\TakeTest;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role_id',
        'username',
        'name',
        'email',
        'password',
        'phone_number',
        'is_blocked',
        'other_details',
        'credits',
        'referral_code',
        'referred_by_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'other_details' => 'array'
    ];

    /**
     * Relationships
     */

    /**
     * Relationship between users and roles table.
     *
     * @return \App\Models\Role
     */
    public function role()
    {
        return $this->belongsTo('App\Models\Role');
    }

    /**
     * Get the user's actions.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function actions()
    {
        return $this->morphMany('App\Models\UserAction', 'userable');
    }

    /**
     * Get the courses created by the user.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function createdCourses()
    {
        return $this->hasMany('App\Models\Course', 'created_by_id');
    }

    /**
     * Get the user's orders.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }

    /**
     * Get the user's courses.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function courses()
    {
        return $this->hasMany('App\Models\UserCourse');
    }

    /**
     * Get the user's practice tests.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function practiceTests()
    {
        return $this->hasMany('App\Models\PracticeTest');
    }

    /**
     * Get the user's otp.
     *
     * @return \App\Models\UserOtp
     */
    public function otp()
    {
        return $this->hasOne('App\Models\UserOtp');
    }

    /**
     * Get the user's threads.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function threads()
    {
        return $this->hasMany('App\Models\Thread');
    }

    /**
     * Get the user's activities.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function activities()
    {
        return $this->hasMany('App\Models\Activity');
    }

    /**
     * Get the user's subscribed threads.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function subscribedThreads()
    {
        return $this->belongsToMany('App\Models\Thread', 'thread_subscriptions');
    }

    /**
     * Get the user's profile picture.
     *
     * @return \App\Models\Image
     */
    public function profilePicture()
    {
        return $this->morphOne('App\Models\Image', 'imageable');
    }

    /**
     * Get the user's user tests.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function userTests()
    {
        return $this->hasMany('App\Models\UserTest');
    }

    /**
     * Functions
     */

    /**
     * Find out if the user has any of the given roles or not.
     *
     * @param  array  $roles
     * @return boolean
     */
    public function hasRole($roles)
    {
        if (in_array($this->role->label, $roles)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Find out if the user has the provided course or not.
     *
     * @param  int  $courseId
     * @return \App\Models\UserCourse|boolean
     */
    public function getFirstUserCourseByCourseId($courseId)
    {
        /**
         * Check if the course is already bought by user or not.
         * IF it is bought.
         * THEN check the end_on.
         * ELSE return false.
         */
        if ($userCourse = $this->courses()->whereCourseId($courseId)->first()) {
            /**
             * Check if the end_on exists with the user course or not.
             * IF it is null (meaning lifetime access) or not yet passed.
             * THEN return the user course
             * ELSE return false.
             */
            if (!$userCourse->end_on || $userCourse->end_on->gt(now())) {
                return $userCourse;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Get all of the taken_tests for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function taken_tests(): HasMany
    {
        return $this->hasMany(TakeTest::class, 'user_id', 'id');
    }

    public function take_test_course($courseId){
        
        $data = TakeTest::whereUserId($this->id)->whereCourseId($courseId)->get();

        return $data;
    }
}
