<?php

namespace Models;

class Household extends BaseModel {
	protected $guarded = array('id');

	public static $rules = array(
        "name" => "required|between:4,255", 
    );

    public function members() {
        return $this->hasMany('Models\User');
    }

    public function meals() {
        return $this->hasMany('Models\Meal');
    }

    public function documents() {
        return $this->hasManyThrough('\Models\Document', '\Models\User','household_id','owner_id');
    }

    public function messages() {
        return $this->hasManyThrough('\Models\Message', '\Models\User','household_id','receiver_id');
    }

    public function tags() {
        return $this->hasManyThrough('\Models\Tag', '\Models\User','household_id','owner_id');
    }

    public function events() {
        return $this->hasManyThrough('\Models\Event', '\Models\User','household_id','owner_id');
    }

    public function todos() {
        return $this->hasManyThrough('\Models\Todo', '\Models\User','household_id','owner_id');
    }

    public function notifications() {
        return $this->hasManyThrough('\Models\Notification', '\Models\User');
    }

    public function addMember(\Models\User $member) {
        $member->save();
        $this->save();
        $this->members()->save( $member );
        $member->setHousehold( $this );
    }

   public function addMeal(\Models\Meal $meal) {
        $meal->save();
        $this->save();
        $this->meals()->save( $meal );
    }

}
