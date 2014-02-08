<?php

namespace Models;

class Meal extends BaseModel {
	protected $guarded = array('id');

    public static $rules = array(
        'id' => 'required|regex:/^\{?[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}\}?$/',
        'household_id' => 'required|exists:households,id|regex:/^\{?[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}\}?$/',
        'week_number' => 'numeric|between:1,52',
        'day_of_week' => 'numeric|between:1,7',
        'slot' => 'required|min:3|max:100',
    );

	protected $table = 'meals';

	public function household() {
        return $this->belongsTo('Models\Household');
    }

	public function tags() {
        return $this->morphMany('\Models\Tag', 'tagable');
    }

	public function recipes() {
        return $this->belongsToMany('Models\Recipe', 'meals_recipes');
    }	

    public function addRecipe(\Models\Recipe $recipe) {
        $this->save();
        $this->recipes()->attach( $recipe );
    }
}
