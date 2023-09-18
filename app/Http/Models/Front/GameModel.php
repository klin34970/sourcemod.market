<?php

namespace App\Http\Models\Front;

use Illuminate\Database\Eloquent\Model;

class GameModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
	 *
     */
    protected $table = 'games';
  
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
        'genre',
		'images',
		'game_server_query_type',
		'web_hook',
		'game_hook',
    ];
	
	 /**
     * Get scripts
	 *
     * @return ORM
     */
	public function scripts()
	{
		return $this->hasMany('App\Http\Models\Front\ScriptModel', 'game_id');
	}
}
