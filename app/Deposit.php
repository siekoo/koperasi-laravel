<?php

namespace App;

use GeniusTS\HijriDate\Hijri;
use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
	protected $table = 'deposits';

	protected $guarded = ['id'];

    public function account(){
    	return $this->belongsTo('App\Account', 'account_id', 'id');
    }

    public function createdAt($format = 'd/m/Y H:i'){
    	return 'gregorian' == env('OPT_DATE_FORMAT') ? date($format,strtotime($this->created_at))
		    : Hijri::convertToHijri($this->created_at)->format($format);
    }

    public function createdWeek(){
	    return date('W',strtotime($this->created_at));
    }
}
