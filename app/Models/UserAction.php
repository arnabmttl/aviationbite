<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAction extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'session_id',
        'action',
        'actionable_id',
        'actionable_type',
        'remarks',
    ];

    /**
     * Relationships
     */
	
    /**
	 * Get the owning userable model.
	 */
    public function userable()
    {
        return $this->morphTo();
    }

    /**
	 * Get the owning actionable model.
	 */
    public function actionable()
    {
        return $this->morphTo();
    }
}
