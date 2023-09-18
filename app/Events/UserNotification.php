<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Http\Models\Front\UserNotificationModel as UserNotificationModel;
use Carbon\Carbon;
use App;

class UserNotification extends Event implements ShouldBroadcast
{
    use SerializesModels;

	public $ref;
	
	public $user_id;
	
	public $icon;
	
	public $text;
	
	public $url;
	
	public $created_at;
	
	public $id;
	
	public $view;
	
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($ref, $user_id, $icon, $text, $url, $created_at = '', $view = false)
    {
        $this->user_id = $user_id;
		$this->icon = $icon;
		$this->text = $text;
		$this->url = $url;
		$this->view = $view;
		
		if(!$created_at)
		{
			$this->created_at = Carbon::now()->diffForHumans();
		}
		else
		{
			$this->created_at = $created_at;
		}
		
		
		$notification = UserNotificationModel::where('user_id', $user_id)
					->where('ref', $ref)
					->first();
					
		if(isset($notification->id))
		{
			if($notification->view != $view)
			{
				if($view == 0)
				{
					$notification->update(
						[
							'view' => $view,
							'last_time' => date('Y-m-d H:i:s')
						]
					);
				}
				else
				{
					$notification->update(
						[
							'view' => $view,
						]
					);
				}
			}
			$this->id = $notification->id;
		}
		else
		{
			$lastid = UserNotificationModel::insertGetId(
				[
					'ref' => $ref,
					'user_id' => $user_id,
					'icon' => $icon,
					'text' => $text,
					'url' => $url,
					'view' => $view,
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s'),
					'last_time' => date('Y-m-d H:i:s'),
				]
			);
			$this->id = $lastid;
		}
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return ['user_' . $this->user_id];
    }
}
