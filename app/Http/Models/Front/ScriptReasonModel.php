<?php

namespace App\Http\Models\Front;

use Illuminate\Database\Eloquent\Model;

class ScriptReasonModel extends Model
{
   /**
     * The table associated with the model.
     *
     * @var string
	 *
     */
    protected $table = 'scripts_reasons';
  
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
		'reason',
		'class',
		'action',
    ];
	
	
	public static function _getReasonsList()
	{
		$reasons = self::orderBy('reason', 'asc')->select('id', 'reason')->get();
		foreach($reasons as $reason)
		{
			$array[$reason->id] = $reason->reason;
		}
		return $array;
	}
}
