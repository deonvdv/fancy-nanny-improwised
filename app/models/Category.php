<?php

namespace Models;

class Category extends BaseModel {
	protected $guarded = array('id');

	public static $rules = array(            
        'name' => 'Required|Min:3|Max:255|Alpha',
    );

    private $errors;

    public function validate() {

        $validator = \Validator::make($this->attributes, static::$rules);

        // check for failure
        if ( $validator->fails() )
        {
            // set errors and return false
            $this->errors = $validator->messages();
            return false;
        }

        // validation pass
        return true;        
    }

    public function errors()
    {
        return $this->errors;
    }

	public function recipes()
    {
        return $this->hasMany('Models\Recipe');
    }	

	public function parent()
    {
        return $this->belongsTo('Models\Category');
    }	

    public function setParent(\Models\Category $category) {
        $this->save();
        $this->parent()->associate( $category );
    }

}
