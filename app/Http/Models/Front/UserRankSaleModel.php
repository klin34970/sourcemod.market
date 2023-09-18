<?php

namespace App\Http\Models\Front;

use Illuminate\Database\Eloquent\Model;

class UserRankSaleModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
	 *
     */
    protected $table = 'users_ranks_sales';
  
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
		'amount_min',
		'amount_max',
        'comission',
    ];
}
