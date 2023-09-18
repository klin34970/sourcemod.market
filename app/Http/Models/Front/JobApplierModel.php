<?php

namespace App\Http\Models\Front;

use Illuminate\Database\Eloquent\Model;

class JobApplierModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
	 *
     */
    protected $table = 'jobs_appliers';
  
    /**
     * The guarded.
     *
     * @var array
	 *
     */	
	protected $guarded = ['id'];
	
    /**
     * The fillable.
     *
     * @var array
	 *
     */	
    protected $fillable = [
		'id',
		'job_id',
		'user_id',
		'text',
		'price',
    ];
	
	/**
     * Get user
	 *
     * @return ORM
     */
	function user()
	{
		return $this->belongsTo('\LaravelAcl\Authentication\Models\User', 'user_id');
	}
	
	 /**
     * Get user_profile
	 *
     * @return ORM
     */
	public function user_profile()
    {
        return $this->hasMany('\LaravelAcl\Authentication\Models\UserProfile', 'user_id', 'user_id');
    }
	
	 /**
     * Get jobs
	 *
     * @return ORM
     */
	function job()
	{
		return $this->belongsTo('App\Http\Models\Front\JobModel', 'job_id');
	}
}
