<?php

namespace App\Listeners;

class ScriptEventListener
{
    /**
     * Handle user login events.
     */
    public function onScriptAdded($event) 
	{
		//error_log('script added' . $event->user_id);
	}

    /**
     * Handle user logout events.
     */
    public function onScriptUpdated($event) 
	{
		//error_log('script updated' . $event->user_id);
	}

    /**
     * Register the listeners for the subscriber.
     *
     * @param  Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {
        $events->listen(
            'App\Events\ScriptAdded',
            'App\Listeners\ScriptEventListener@onScriptAdded'
        );
		
		$events->listen(
            'App\Events\ScriptUpdated',
            'App\Listeners\ScriptEventListener@onScriptUpdated'
        );
    }

}