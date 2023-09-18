<?php

namespace App\Http\Models\Front;

use Illuminate\Database\Eloquent\Model;

class UserMessageModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
	 *
     */
    protected $table = 'users_messages';
  
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
		'target_id',
        'title',
		'text',
		'read',
		'closed',
		'updated_at',
    ];
	
	 /**
     * Get user_profile
	 *
     * @return ORM
     */
    function user()
	{
		return $this->belongsTo('\LaravelAcl\Authentication\Models\User', 'user_id');
	}	
	
	 /**
     * Get user profile
	 *
     * @return ORM
     */
	public function user_profile()
    {
        return $this->hasMany('\LaravelAcl\Authentication\Models\UserProfile', 'user_id', 'user_id');
    }		

	/**
     * Get user profile
	 *
     * @return ORM
     */
	public function target_profile()
    {
        return $this->hasMany('\LaravelAcl\Authentication\Models\UserProfile', 'user_id', 'target_id');
    }	 
	
	/**
     * Get user profile
	 *
     * @return ORM
     */
	public function user_messages_replies()
    {
        return $this->hasMany('App\Http\Models\Front\UserMessageReplyModel', 'user_message_id');
    }	 
}
