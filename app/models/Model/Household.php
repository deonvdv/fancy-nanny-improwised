<?php
namespace Model;
class Household extends BaseModel {
	protected $guarded = array('id');

	public static $rules = array();

    public function members(){
        return $this->hasMany('user');
    }

    public function messages(){
        return $this->hasMany('message');
    }

    public function tags(){
        return $this->hasMany('tag');
    }

    public function meals(){
        return $this->hasMany('meal');
    }

    public function events(){
        return $this->hasMany('event');
    }

    public function todos(){
        return $this->hasMany('todo');
    }

    public function notifications(){
        return $this->hasMany('notification');
    }
}
