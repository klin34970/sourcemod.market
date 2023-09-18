<?php

namespace App\Http\Models\Front;

use Illuminate\Database\Eloquent\Model;

class ScriptTrackerModel extends Model
{
   /**
     * The table associated with the model.
     *
     * @var string
	 *
     */
    protected $table = 'scripts_tracker';
  
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
		'game_id',
		'script_id',
		'script_version_id',
		'purchaser_id',
		'hostname',
		'ip',
		'port',
		'last_activity',
    ];
	
	protected $dates = [
		'last_activity'
	];
	
	 /**
     * Get game
	 *
     * @return ORM
     */
	function game()
	{
		return $this->belongsTo('App\Http\Models\Front\GameModel', 'game_id');
	}	 
	
	/**
     * Get game
	 *
     * @return ORM
     */
	function script()
	{
		return $this->belongsTo('App\Http\Models\Front\ScriptModel', 'script_id');
	}
	
	 /**
     * Get versions
	 *
     * @return ORM
     */
    public function versions()
    {
        return $this->belongsTo('App\Http\Models\Front\ScriptVersionModel', 'script_version_id')->orderBy('id', 'desc');
    }
}
