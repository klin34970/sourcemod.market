<?php

namespace App\Http\Models\Front;

use Illuminate\Database\Eloquent\Model;

class ScriptIssueModel extends Model
{
   /**
     * The table associated with the model.
     *
     * @var string
	 *
     */
    protected $table = 'scripts_issues';
  
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
		'user_id',
		'status',
		'closed',
		'title',
		'text',
		'activated',
    ];
	
	 /**
     * Get script
	 *
     * @return ORM
     */
    function script()
	{
		return $this->belongsTo('App\Http\Models\Front\ScriptModel', 'script_id');
	}	 
	
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
     * Get comments
	 *
     * @return ORM
     */
    public function discussions()
    {
        return $this->hasMany('App\Http\Models\Front\ScriptIssueDiscussionModel', 'issue_id')->orderBy('id', 'asc');
    }	
}
