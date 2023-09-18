<?php

namespace App\Http\Models\Front;

use Illuminate\Database\Eloquent\Model;

class ForumThreadModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
	 *
     */
    protected $table = 'forum_threads';
  
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
		'forum_id',
        'user_id',
		'title',
		'text',
		'closed',
    ];
	
	 /**
     * Get thread
	 *
     * @return ORM
     */
	function forum()
	{
		return $this->belongsTo('App\Http\Models\Front\ForumModel', 'forum_id');
	}
	
	 /**
     * Get replies
	 *
     * @return ORM
     */
    public function replies()
    {
        return $this->hasMany('App\Http\Models\Front\ForumThreadReplyModel', 'thread_id');
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
