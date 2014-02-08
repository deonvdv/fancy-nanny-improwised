<?php

namespace Models;

class UnitOfMeasure extends BaseModel {

	protected $table = 'units_of_measure';

	protected $guarded = array('id');

	public static $rules = array(            
		'id'              => 'required|regex:/^\{?[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}\}?$/',
		'name'            => 'required|min:3|max:50',
		'alias'           => 'required|min:3|max:255',
		'preferred_alias' => 'required|min:3|max:255',
    );

	public function recipe_ingredient()
    {
        return $this->hasMany('Models\RecipeIngredient');
    }	

}
