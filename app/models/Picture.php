<?php

namespace Models;

class Picture extends BaseModel {
	protected $guarded = array('id');

	public static $rules = array();

	public function owner()
    {
        return $this->belongsTo('Models\User');
    }

	public function imageable()
    {
        return $this->morphTo();
    }    

    public function setOwner(\Models\User $user) {
        $this->save();
        $this->owner()->associate( $user );
    }

}
