<?php

namespace Models;

class Message extends BaseModel {
	protected $guarded = array('id');

    public static $rules = array(
        'id' => 'required|regex:/^\{?[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}\}?$/',
        'household_id' => 'required|exists:households,id|regex:/^\{?[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}\}?$/',
        'sender_id' => 'required|exists:users,id|regex:/^\{?[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}\}?$/',
        'receiver_id' => 'exists:users,id|regex:/^\{?[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}\}?$/',
        'message' => 'required',
    );
	
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

    public function setReceiver(\Models\User $user = null) {
        if ( $user ) {
            $this->receiver()->associate( $user );
            $this->save();
        }
    }

    public function setHousehold(\Models\Household $household) {
        $this->household()->associate( $household );
        $this->save();
    }

}
