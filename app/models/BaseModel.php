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
        // echo "Validating....\n";
        $this->errors = array();

        $validator = \Validator::make($this->attributes, static::$rules);

        // check for failure
        if ( $validator->fails() )
        {
            //echo "Failed....\n";
        
            // set errors and return false
            $this->errors = $validator->messages();
            return false;
        }

        // validation pass
        return true;        
    }

    public function errors() {
        return $this->errors;
    }

    public static function boot() {
        parent::boot();

        static::creating(function($model) {
            // echo "\n\n\n\nCreating....\n";
            // var_dump($model);
            if ( !$model->id ) $model->id = \Rhumsaa\Uuid\Uuid::uuid4()->__toString();
            if ( !$model->validate() ) {
                // echo "Returning false....\n";
                return false;
            }
        });

        static::updating(function($model) {
            // echo "\n\n\n\nUpdating....\n";
            if ( !$model->id ) $model->id = \Rhumsaa\Uuid\Uuid::uuid4()->__toString();
            if ( !$model->validate() ) {
                // echo "Returning false....\n";
                return false;
            }
        });

        static::saving(function($model) {
            // echo "\n\n\n\nSaving....\n";
            if ( !$model->id ) $model->id = \Rhumsaa\Uuid\Uuid::uuid4()->__toString();

            $validates = $model->validate();
            
            // var_dump($validates);
            // var_dump($model);
            if ( !$validates ) {
                // echo "Returning false....\n";
                return false;
            }            
        });


    }

    public function save(array $options = array()) {
        $validates = $this->validate();
            
        // var_dump($validates);
        // var_dump($model);
        if ( !$validates ) {
            // echo "Returning false....\n";
            return false;
        }              
       parent::save($options);
    }

    public static function fields(){
        $table = (new static)->getTable();

        foreach(\DB::select('SHOW COLUMNS FROM '.$table) as $column)
        {
            $columns[] = $column->Field;
        }

        return $columns;
    }
}
