<?php

namespace App\Http\Models\Front;

use Illuminate\Database\Eloquent\Model;

class ScriptReportModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
	 *
     */
    protected $table = 'scripts_reports';
  
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
		'report_user_id',
        'text',
    ];
	
	 /**
     * Get user profile
	 *
     * @return ORM
     */
	public function user_profile()
    {
        return $this->hasMany('\LaravelAcl\Authentication\Models\UserProfile', 'user_id', 'report_user_id');
    }
}
