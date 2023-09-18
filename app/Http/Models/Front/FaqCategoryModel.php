<?php

namespace App\Http\Models\Front;

use Illuminate\Database\Eloquent\Model;

class FaqCategoryModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
	 *
     */
    protected $table = 'faq_categories';
  
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
}
