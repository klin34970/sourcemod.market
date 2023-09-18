<?php

namespace App\Http\Models\Front;

use Illuminate\Database\Eloquent\Model;

class UserAPIModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
	 *
     */
    protected $table = 'users_api_keys';
  
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
		'user_id',
		'key',
		'permissions',
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
}
