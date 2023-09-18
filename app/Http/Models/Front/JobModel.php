<?php

namespace App\Http\Models\Front;

use Illuminate\Database\Eloquent\Model;

class JobModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
	 *
     */
    protected $table = 'jobs';
  
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
		'game_id',
		'title',
		'description',
		'price',
		'activated',
		'finished',
		'tags',
		'view',
    ];
	
	 /**
     * Get game
	 *
     * @return ORM
     */
	function game()
	{
		return $this->hasOne('App\Http\Models\Front\GameModel', 'id', 'game_id');
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

	 /**
     * Get discussions
	 *
     * @return ORM
     */
	public function discussions()
    {
        return $this->hasMany('App\Http\Models\Front\JobDiscussionModel', 'job_id')->orderBy('id', 'desc');
    }	 
	
	/**
     * Get appliers
	 *
     * @return ORM
     */
	public function appliers()
    {
        return $this->hasMany('App\Http\Models\Front\JobApplierModel', 'job_id')->orderBy('id', 'desc');
    }
	
	 /**
     * Get games list
	 *
     * @return ORM
     */
	public static function _getGamesList()
	{
		$games = GameModel::orderBy('title', 'asc')->select('id', 'title')->get();
		foreach($games as $game)
		{
			$array[$game->id] = $game->title;
		}
		return $array;
	}
}
