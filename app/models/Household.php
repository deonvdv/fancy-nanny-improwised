<?php

namespace Models;

class Household extends BaseModel {
	protected $guarded = array('id');

	public static $rules = array(
        "name" => "required|between:4,255", 
    );

    public function documents() {
        return $this->hasMany('Models\Document');
    }

    public function members() {
        return $this->hasMany('Models\User');
    }

    public function messages() {
        return $this->hasMany('Models\Message');
    }

    public function tags() {
        return $this->hasMany('Models\Tag');
    }

    public function meals() {
        return $this->hasMany('Models\Meal');
    }

    public function events() {
        return $this->hasMany('Models\Event');
    }

    public function todos() {
        return $this->hasMany('Models\Todo');
    }

    public function notifications() {
        return $this->hasMany('Models\Notification');
    }
}
