<?php
namespace Model;
use \Eloquent;

class BaseModel extends Eloquent {
	protected $guarded = array();

	public static $rules = array();
    public $incrementing = false;

    public static function boot() {
        parent::boot();
        static::creating(function($model) {
            $model->id = Rhumsaa\Uuid\Uuid::uuid4()->__toString();
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