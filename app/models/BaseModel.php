<?php

namespace Models;

use \Eloquent;

class BaseModel extends Eloquent {
	protected $guarded = array();

	public static $rules = array();

    public $incrementing = false;

    protected $softDelete = true;   // Sets allmodels as softDelete

    public function __construct(array $attributes = array()) {
        parent::__construct( $attributes );

        if ( !$this->id )
            $this->id = \Rhumsaa\Uuid\Uuid::uuid4()->__toString();
    }

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

    public static function boot() {
        parent::boot();

        static::creating(function($model) {
            // var_dump($model);
            if ( !$model->id ) $model->id = \Rhumsaa\Uuid\Uuid::uuid4()->__toString();
            if ( !$model->validate() ) return false;
        });

        static::updating(function($model) {
            if ( !$model->id ) $model->id = \Rhumsaa\Uuid\Uuid::uuid4()->__toString();
            if ( !$model->validate() ) return false;
        });

        static::saving(function($model) {
            if ( !$model->id ) $model->id = \Rhumsaa\Uuid\Uuid::uuid4()->__toString();
            if ( !$model->validate() ) return false;
        });


    }

    public static function fields(){
        $table = (new static)->getTable();

        foreach(DB::select('SHOW COLUMNS FROM '.$table) as $column)
        {
            $columns[] = $column->Field;
        }

        return $columns;
    }
}
