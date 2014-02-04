<?php

namespace Models;

class UnitOfMeasure extends BaseModel {

	protected $table = 'units_of_measure';

	protected $guarded = array('id');

	public static $rules = array();

	public function recipe_ingredient()
    {
        return $this->hasMany('Models\RecipeIngredient');
    }	

}
