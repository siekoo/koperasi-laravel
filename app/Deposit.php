<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
	protected $table = 'deposits';

	protected $guarded = ['id'];

    public function account(){
    	return $this->belongsTo('App\Account', 'account_id', 'id');
    }

    public function createdAt($format = 'd F Y'){
    	return date($format,strtotime($this->created_at));
    }
}
