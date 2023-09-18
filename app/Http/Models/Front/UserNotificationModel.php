<?php

namespace App\Http\Models\Front;

use Illuminate\Database\Eloquent\Model;
use URL, DB;

class UserNotificationModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
	 *
     */
    protected $table = 'users_notifications';
  
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
        'icon',
		'text',
		'url',
		'view',
		'last_time'
    ];
	
	protected $dates = [
		'last_time'
	];
}
