<?php

namespace Models;

class Document extends BaseModel {
	protected $guarded = array('id');

	public static $rules = array(
        'id' => 'required|regex:/^\{?[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}\}?$/',
        'owner_id' => 'required|exists:users,id|regex:/^\{?[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}\}?$/',
        'household_id' => 'required|exists:households,id|regex:/^\{?[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}\}?$/',
        'name' => 'required|min:3|max:255',
        'file_name' => 'required|min:3|max:255',
	);

	public function owner() {
        return $this->belongsTo('Models\User');
    }

	public function household() {
        return $this->belongsTo('Models\Household');
    }

    public function setOwner(\Models\User $user) {
        // print_r($user);
        $this->owner()->associate( $user );
        $this->household()->associate( $user->household );
        $this->save();
    }

    public function setHousehold(\Models\Household $household) {
        $this->household()->associate( $household );
        $this->save();
    }

	
}
