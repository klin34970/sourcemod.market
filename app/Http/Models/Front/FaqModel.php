<?php

namespace App\Http\Models\Front;

use Illuminate\Database\Eloquent\Model;

class FaqModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
	 *
     */
    protected $table = 'faq';
  
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
		'category_id',
		'icon',
		'title',
		'text'
    ];
	
	/**
     * Get category
	 *
     * @return ORM
     */
	function category()
	{
		return $this->hasOne('App\Http\Models\Front\FaqCategoryModel', 'id', 'category_id');
	}
}
