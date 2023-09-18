<?php

namespace App\Listeners;
use LRedis;

class UserEventListener
{
    /**
     * Handle user login events.
     */
    public function onUserLogin($event) 
	{
		//error_log('user login' . $event->user_id);
	}

    /**
     * Handle user logout events.
     */
    public function onUserLogout($event) 
	{
		//error_log('user logout' . $event->user_id);
	}    
	
	/**
     * Handle user profile update events.
     */
    public function onUserProfileUpdated($event) 
	{
		//error_log('user profile update' . $event->user_id);
	}    
	
	public function onUserNotification($event) 
	{
		//error_log('user notification' . $event->user_id);
		
	}

    /**
     * Register the listeners for the subscriber.
     *
     * @param  Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {
        $events->listen(
            'App\Events\UserLoggedIn',
            'App\Listeners\UserEventListener@onUserLogin'
        );

        $events->listen(
            'App\Events\UserLoggedOut',
            'App\Listeners\UserEventListener@onUserLogout'
        );
		
		$events->listen(
            'App\Events\UserProfileUpdated',
            'App\Listeners\UserEventListener@onUserProfileUpdated'
        );
		
		$events->listen(
            'App\Events\UserNotification',
            'App\Listeners\UserEventListener@onUserNotification'
        );
		
    }

}