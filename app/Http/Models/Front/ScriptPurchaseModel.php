<?php

namespace App\Http\Models\Front;

use Illuminate\Database\Eloquent\Model;

class ScriptPurchaseModel extends Model
{
   /**
     * The table associated with the model.
     *
     * @var string
	 *
     */
    protected $table = 'scripts_purchases';
  
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
		'amount',
		'status',
		'sender_email',
		'transaction_0_id_for_sender_txn',
		'transaction_0_receiver',
		'transaction_0_amount',
		'transaction_1_id_for_sender_txn',
		'transaction_1_receiver',
		'transaction_1_amount',
		'pay_key',
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
     * Get user_profile
	 *
     * @return ORM
     */
    function user()
	{
		return $this->belongsTo('\LaravelAcl\Authentication\Models\User', 'user_id');
	}
}
