<?php

namespace Models;

class Message extends BaseModel {
	protected $guarded = array('id');

	public static $rules = array();
	
	protected $table = 'messages';

	public function household()
    {
        return $this->belongsTo('Models\Household');
    }

	public function sender()
    {
        return $this->belongsTo('Models\User');
    }

	public function receiver()
    {
        return $this->belongsTo('Models\User');
    }


    public function setSender(\Models\Recipe $recipe) {
        $this->save();
        $this->from_user()->associate( $recipe );
    }

    public function setReceiver(\Models\Recipe $recipe) {
        $this->save();
        $this->to_user()->associate( $recipe );
    }


}
