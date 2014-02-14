<?php

namespace Models;

class Notification extends BaseModel {
	protected $guarded = array('id');

    public static $rules = array(
        'id' => 'required|regex:/^\{?[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}\}?$/',
        'user_id' => 'required|exists:users,id|regex:/^\{?[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}\}?$/',
        'to' => 'required|min:3|max:255',
        'message' => 'required|min:3',
    );

	public function user() {
        return $this->belongsTo('Models\User');
    }

	public function setUser(\Models\User $user) {
        $user->save();
        $this->user()->associate( $user );
        $this->save();
    }    
}
