<?php

namespace Models;

class Tag extends BaseModel {
	protected $guarded = array('id');

    public static $rules = array(
        'id' => 'required|regex:/^\{?[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}\}?$/',
        'owner_id' => 'required|exists:users,id|regex:/^\{?[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}\}?$/',
        'name' => 'required|min:3|max:255',
        'color' => array('required','min:4','max:7','regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'),
        'tagable_id' => 'required|regex:/^\{?[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}\}?$/',
        'tagable_type' => 'required|min:3|max:255',
    );

	public function owner()
    {
        return $this->belongsTo('Models\User');
    }

	public function tagable()
    {
        return $this->morphTo();
    }    


    public function setOwner(\Models\User $user) {
        $user->save();
        $this->owner()->associate( $user );
        $this->tagable_id = $user->id;
        $this->tagable_type = '\Models\User';
        $this->save();
    }
}
