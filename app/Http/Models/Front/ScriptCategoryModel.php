<?php

namespace App\Http\Models\Front;

use Illuminate\Database\Eloquent\Model;

class ScriptCategoryModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
	 *
     */
    protected $table = 'scripts_categories';
  
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
