<?php

namespace App\Http\Models\Front;

use Illuminate\Database\Eloquent\Model;

class ScriptVersionModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
	 *
     */
    protected $table = 'scripts_versions';
  
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
		'script_id',
        'name',
		'changes',
		'download',
    ];
	
	 /**
     * Get scripts
	 *
     * @return ORM
     */
	function script()
	{
		return $this->belongsTo('App\Http\Models\Front\ScriptModel', 'script_id');
	}
	
	/**
     * Get downloads
	 *
     * @return ORM
     */
    public function downloads()
    {
        return $this->hasMany('App\Http\Models\Front\ScriptVersionDownloadModel', 'version_id')->orderBy('id', 'desc');
    }	
}
