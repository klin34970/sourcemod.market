<?php

namespace App\Http\Models\Front;

use Illuminate\Database\Eloquent\Model;

class ScriptModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
	 *
     */
    protected $table = 'scripts';
  
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
		'type',
		'dlc_id',
        'title',
		'description',
		'game_id',
		'category_id',
		'price',
		'price_discount',
		'view',
		'reason_id',
		'activated',
		'tags',
    ];
	
	 /**
     * Get game
	 *
     * @return ORM
     */
	function game()
	{
		return $this->hasOne('App\Http\Models\Front\GameModel', 'id', 'game_id');
	}	 
	
	/**
     * Get category
	 *
     * @return ORM
     */
	function category()
	{
		return $this->hasOne('App\Http\Models\Front\ScriptCategoryModel', 'id', 'category_id');
	}
	
	 /**
     * Get reason
	 *
     * @return ORM
     */
	function reason()
	{
		return $this->hasOne('App\Http\Models\Front\ScriptReasonModel', 'id', 'reason_id');
	}
	
	 /**
     * Get versions
	 *
     * @return ORM
     */
    public function versions()
    {
        return $this->hasMany('App\Http\Models\Front\ScriptVersionModel', 'script_id')->orderBy('id', 'desc');
    }		 
	
	/**
     * Get reports
	 *
     * @return ORM
     */
    public function reports()
    {
        return $this->hasMany('App\Http\Models\Front\ScriptReportModel', 'script_id')->orderBy('id', 'desc');
    }	 
	
	 /**
     * Get versions_downloads
	 *
     * @return ORM
     */
	public function versions_downloads()
    {
        return $this->hasManyThrough('App\Http\Models\Front\ScriptVersionDownloadModel', 'App\Http\Models\Front\ScriptVersionModel', 'script_id', 'version_id');
    }
	
	/**
     * Get issues
	 *
     * @return ORM
     */
    public function issues()
    {
        return $this->hasMany('App\Http\Models\Front\ScriptIssueModel', 'script_id')->orderBy('id', 'desc');
    }	 
	
	/**
     * Get purchases
	 *
     * @return ORM
     */
    public function purchases()
    {
        return $this->hasMany('App\Http\Models\Front\ScriptPurchaseModel', 'script_id')->orderBy('id', 'desc');
    }
	
	/**
     * Get purchases
	 *
     * @return ORM
     */
    public function purchasesBy($user_id, $script_id)
    {
        return $this->hasMany('App\Http\Models\Front\ScriptPurchaseModel', 'script_id')->where('user_id', $user_id)->where('script_id', $script_id);
    }
	
	 /**
     * Get user
	 *
     * @return ORM
     */
	function user()
	{
		return $this->belongsTo('\LaravelAcl\Authentication\Models\User', 'user_id');
	}
	
	 /**
     * Get discussions
	 *
     * @return ORM
     */
	public function discussions()
    {
        return $this->hasMany('App\Http\Models\Front\ScriptDiscussionModel', 'script_id')->orderBy('id', 'desc');
    }
	
	 /**
     * Get user profile
	 *
     * @return ORM
     */
	public function user_profile()
    {
        return $this->hasMany('\LaravelAcl\Authentication\Models\UserProfile', 'user_id', 'user_id');
    }
	
	 /**
     * Get stars
	 *
     * @return ORM
     */
	public function stars()
    {
        return $this->hasMany('App\Http\Models\Front\ScriptStarModel', 'script_id');
    }
	
	 /**
     * Get dlc
	 *
     * @return ORM
     */
	public function dlc($scrip_id)
	{
		return $this->where('id', '=', $scrip_id)->first();
	}
	
	 /**
     * Get dlc
	 *
     * @return ORM
     */
	public function dlcs($scrip_id)
	{
		return $this->where('dlc_id', '=', $scrip_id)->get();
	}
	
	 /**
     * Get reputations user
	 *
     * @return ORM
     */
	public function getReputations($user_id)
	{
		$scripts = $this->where('user_id', '=', $user_id)->orderBy('id', 'desc')->get();
		
		$reputations = ScriptStarModel::orderBy('id', 'desc');
		foreach($scripts as $script)
		{
			$reputations->orWhere('script_id', '=', $script->id);
		}
		return $reputations->get();
	}
	
	 /**
     * Get games list
	 *
     * @return ORM
     */
	public static function _getGamesList()
	{
		$games = GameModel::orderBy('title', 'asc')->select('id', 'title')->get();
		foreach($games as $game)
		{
			$array[$game->id] = $game->title;
		}
		return $array;
	}
	
	 /**
     * Get categories list
	 *
     * @return ORM
     */
	public static function _getCategoriesList()
	{
		$categories = ScriptCategoryModel::orderBy('title', 'asc')->select('id', 'title')->get();
		foreach($categories as $category)
		{
			$array[$category->id] = $category->title;
		}
		return $array;
	}	 
	
	/**
     * Get dlc user list
	 *
     * @return ORM
     */
	public static function _getUserDlc($user_id)
	{
		$dlcs = ScriptModel::where('user_id', '=', $user_id)->where('type', '&', 2)->orderBy('title', 'asc')->select('id', 'title')->get();
		$array = array();
		foreach($dlcs as $dlcs)
		{
			$array[$dlcs->id] = $dlcs->title;
		}
		return $array;
	}
}
