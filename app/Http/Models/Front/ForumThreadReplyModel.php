<?php

namespace App\Http\Models\Front;

use Illuminate\Database\Eloquent\Model;

class ForumThreadReplyModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
	 *
     */
    protected $table = 'forum_threads_replies';
  
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
		'thread_id',
        'user_id',
		'text',
    ];
	
	 /**
     * Get thread
	 *
     * @return ORM
     */
	function thread()
	{
		return $this->belongsTo('App\Http\Models\Front\ForumThreadModel', 'thread_id');
	}
	
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
     * Get user profile
	 *
     * @return ORM
     */
	public function user_profile()
    {
        return $this->hasMany('\LaravelAcl\Authentication\Models\UserProfile', 'user_id', 'user_id');
    }
}
