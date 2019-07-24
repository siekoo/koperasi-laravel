<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $guarded = ['id'];

    public function category(){
    	return $this->belongsTo('App\ExpenseCategory', 'expense_category_id', 'id');
	}

	public function created_at($format = 'd/m/Y'){
    	return date($format,strtotime($this->created_at));
	}

	public function expenseDate($format = 'd/m/Y'){
		return date($format,strtotime($this->expense_date));
	}
}
