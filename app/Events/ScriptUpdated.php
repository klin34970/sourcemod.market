<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ScriptUpdated extends Event
{
    use SerializesModels;
	
	public $user_id;
	
	public $script_id;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($user_id, $script_id)
    {
        $this->user_id = $user_id;
		$this->script_id = $script_id;
    }
}
