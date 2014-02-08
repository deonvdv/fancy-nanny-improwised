<?php

namespace Models;

class Tag extends BaseModel {
	protected $guarded = array('id');

    public static $rules = array(
        'id' => 'required|regex:/^\{?[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}\}?$/',
        'owner_id' => 'required|exists:users,id|regex:/^\{?[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}\}?$/',
        'household_id' => 'required|exists:households,id|regex:/^\{?[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}\}?$/',
        'name' => 'required|min:3|max:255',
        'color' => array('required','min:4','max:7','regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'),
        'tagable_id' => 'required|regex:/^\{?[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}\}?$/',
        'tagable_type' => 'required|min:3|max:255',
    );

	public function household()
    {
        return $this->belongsTo('Models\Household');
    }

	public function owner()
    {
        return $this->belongsTo('Models\User');
    }

	public function tagable()
    {
        return $this->morphTo();
    }    


    public function setOwner(\Models\User $user) {
        $this->owner()->associate( $user );
        $this->household()->associate( $user->household );
        $this->tagable_id = $user->id;
        $this->tagable_type = '\Models\User';
        $this->save();
    }

    public function setHousehold(\Models\Household $household) {
        $this->save();
        $this->household()->associate( $household );
    }


}
