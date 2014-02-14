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
