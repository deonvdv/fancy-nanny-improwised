<?php

namespace Models;

class Picture extends BaseModel {
	protected $guarded = array('id');

    public static $rules = array(
        'id' => 'required|regex:/^\{?[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}\}?$/',
        'owner_id' => 'required|exists:users,id|regex:/^\{?[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}\}?$/',
        'name' => 'required|min:3|max:255',
        'file_name' => 'required|min:3|max:255',
        'imageable_id' => 'required|regex:/^\{?[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}\}?$/',
        'imageable_type' => 'required|min:3|max:255',
    );

	public function owner()
    {
        return $this->belongsTo('Models\User');
    }

	public function imageable()
    {
        return $this->morphTo();
    }    

    public function setOwner(\Models\User $user) {
        $user->save();
        $this->owner()->associate( $user );
        $this->imageable_id = $user->id;
        $this->imageable_type = '\Models\User';
        $this->save();
    }

}
