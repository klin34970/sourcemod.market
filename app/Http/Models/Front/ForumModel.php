<?php

namespace App\Http\Models\Front;

use Illuminate\Database\Eloquent\Model;

class ForumModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
	 *
     */
    protected $table = 'forum_forums';
  
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
		'title',
        'subtitle',
		'icon',
		'category',
		'closed',
    ];
	
	 /**
     * Get threads
	 *
     * @return ORM
     */
    public function threads()
    {
        return $this->hasMany('App\Http\Models\Front\ForumThreadModel', 'forum_id');
    }
	
	 /**
     * Get versions_downloads
	 *
     * @return ORM
     */
	public function replies()
    {
        return $this->hasManyThrough('App\Http\Models\Front\ForumThreadReplyModel', 'App\Http\Models\Front\ForumThreadModel', 'forum_id', 'thread_id');
    }
	
}
