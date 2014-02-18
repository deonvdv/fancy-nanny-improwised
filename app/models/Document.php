<?php

namespace Models;
use DB;
class Document extends BaseModel {
	protected $guarded = array('id');

	public static $rules = array(
        'id' => 'required|regex:/^\{?[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}\}?$/',
        'owner_id' => 'required|exists:users,id|regex:/^\{?[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}\}?$/',
        'name' => 'required|min:3|max:255',
        'file_name' => 'required|min:3|max:255',
	);

	public function owner() {
        return $this->belongsTo('Models\User');
    }

    public function setOwner(\Models\User $user) {
        // print_r($user);
        $user->save();
        $this->owner()->associate( $user );
        $this->save();
    }

    public static function byHousehold($householdId) {
        return DB::table('documents')
            ->join('users', 'documents.owner_id', '=', 'users.id')
            ->where('users.household_id', '=', $householdId)
            ->select('documents.id','documents.owner_id',
                'documents.name', 'documents.file_name', 
                'documents.cdn_url');
    }
}
