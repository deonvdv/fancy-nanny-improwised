<?php

namespace Models;

class Message extends BaseModel {
	protected $guarded = array('id');

	public static $rules = array();
	
	protected $table = 'messages';

	public function household()
    {
        return $this->belongsTo('Models\Household');
    }

	public function sender()
    {
        return $this->belongsTo('Models\User','sender_id');
    }

	public function receiver()
    {
        return $this->belongsTo('Models\User','receiver_id');
    }


    public function setSender(\Models\User $user) {
        $this->sender()->associate( $user );
        $this->save();
    }

    public function setReceiver(\Models\User $user) {
        $this->receiver()->associate( $recipe );
        $this->save();
    }


}
