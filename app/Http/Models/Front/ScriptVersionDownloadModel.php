<?php

namespace App\Http\Models\Front;

use Illuminate\Database\Eloquent\Model;

class ScriptVersionDownloadModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
	 *
     */
    protected $table = 'scripts_versions_downloads';
  
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
		'version_id',
		'ip_address',
		'latitude',
		'longitude',
		'city',
		'country',
		'country_code',
		'region',
		'region_code',
		'postal_code',
		'timezone',
    ];
}
