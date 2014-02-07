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

    public static function boot() {
        parent::boot();
        static::creating(function($model) {
            // echo "Adding Id....\n";
            // echo "Model: " . print_r($model);
            $model->id = \Rhumsaa\Uuid\Uuid::uuid4()->__toString();
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
