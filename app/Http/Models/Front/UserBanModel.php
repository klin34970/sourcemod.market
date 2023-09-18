<?php

namespace App\Http\Models\Front;

use Illuminate\Database\Eloquent\Model;

class UserBanModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
	 *
     */
    protected $table = 'users_bans';
  
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
		'banner_user_id',
		'activated',
        'reason',
		'from',
		'to',
    ];
	
	 /**
     * Get user
	 *
     * @return ORM
     */
	function banner()
	{
		return $this->belongsTo('\LaravelAcl\Authentication\Models\User', 'banner_user_id');
	}
}
