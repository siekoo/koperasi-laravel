<?php

namespace App;

use GeniusTS\HijriDate\Hijri;
use Illuminate\Database\Eloquent\Model;


class Expense extends Model
{
    protected $guarded = ['id'];

    public function category(){
    	return $this->belongsTo('App\ExpenseCategory', 'expense_category_id', 'id');
	}

	public function user(){
    	return $this->hasOne('App\User', 'id', 'user_id')->get()->first();
	}

	public function created_at($format = 'd/m/Y H:i'){
		return 'gregorian' == env('OPT_DATE_FORMAT') ? date($format,strtotime($this->created_at))
			: Hijri::convertToHijri($this->created_at)->format($format);
	}

	public function expenseDate($format = 'd/m/Y'){
    	return 'gregorian' == env('OPT_DATE_FORMAT') ? date($format,strtotime($this->expense_date))
		    : Hijri::convertToHijri($this->expense_date)->format($format);
	}
}
