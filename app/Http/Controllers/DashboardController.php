<?php

namespace App\Http\Controllers;

use App\Account;
use App\Deposit;
use App\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    function index(){
    	$active_account = DB::table('accounts')
	                         ->select('status')
	                         ->where('status', 'ACTIVE')
		                     ->count();

	    $all_account = DB::table('accounts')
	                        ->select('status')
	                        ->count();

	    $income = DB::table('deposits')
	                ->where('status', 'CLEARED')
		            ->where('flow', 'IN')
	                ->sum('amount');
	    $outcome = DB::table('deposits')
	                 ->where('status', 'CLEARED')
		             ->where('flow', 'OUT')
	                 ->sum('amount');
	    $kas = $income - $outcome;

	    $monthly_expense = DB::table('expenses')
		                     ->whereRaw('date_format(expense_date, "%Y-%c") = date_format(now(), "%Y-%c")')
		                     ->where('status', 'CLEARED')->sum('amount');

	    $account = Account::where('status', 'ACTIVE')->get();
		$pending_account = array();
		foreach($account as $a){
			$trx = DB::table('deposits')
			         ->where('status', 'CLEARED')
					 ->where('account_id', $a->id)
					 ->whereRaw('date_format(created_at,"%Y-%u") = date_format(now(), "%Y-%u")')
					 ->orderBy('id', 'desc')
					 ->first();
			if($trx == null) $pending_account[] = $a;
		}

		$week = $flowin = $flowout = array();
		$deposit_cashflow = DB::select('select date_format(created_at, "%u") as week, 
				sum( if(flow = "IN", amount, 0) ) as flowin, 
				sum( if(flow = "OUT", amount, 0) ) as flowout 
				from deposits where date_format(created_at, "%Y") = date_format(now(), "%Y") group by week');

		foreach($deposit_cashflow as $d){
			$week[] = $d->week;
			$flowin[] = $d->flowin;
			$flowout[] = $d->flowout;
		}

		$new_account = Account::orderBy('id', 'desc')->take(5)->get();

		$last_transaction = Deposit::orderBy('id', 'desc')->take(10)->get();

		$last_expense = Expense::orderBy('id', 'desc')->take(10)->get();

    	$param = array(
			'active_account' => $active_account,
		    'all_account' => $all_account,
		    'kas' => $kas,
		    'monthly_expense' => $monthly_expense,
		    'pending_account' => $pending_account,
		    'deposit_cashflow'=> $deposit_cashflow,
		    'deposit_week' => $week,
		    'deposit_in' => $flowin,
		    'deposit_out' => $flowout,
		    'new_account' => $new_account,
		    'last_transaction' => $last_transaction,
		    'last_expense' => $last_expense
	    );
    	return view('admin.dashboard', $param);
    }
}
