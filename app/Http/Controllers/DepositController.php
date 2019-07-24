<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Deposit;
use App\Account;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DepositController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $deposit = Deposit::orderBy('id','desc')->take(10)->get();
        return view('admin.deposit.index', array('deposits' => $deposit));
    }

    public function weekly(Request $request)
    {
    	$week = $request->has('week') ? $request->input('week') : Date('W');
    	$year = $request->has('week') ? $request->input('year') : Date('Y');
    	$status = $request->has('status') ? strtolower($request->input('status')) : 'all';
	    $account = Account::where('status', 'ACTIVE')->get();
	    $account_payment = array();
	    foreach($account as $a){
		    $trx = DB::table('deposits')
		             ->where('status', 'CLEARED')
		             ->where('account_id', $a->id)
		             ->whereRaw('date_format(created_at,"%Y-%u") = "' . $year . '-' . $week . '"')
		             ->orderBy('id', 'desc')
		             ->first();
		    $a->weekly_payment = $trx == null ? 'pending' : 'paid';
		    if($status == 'all') $account_payment[] = $a;
		    elseif($status == $a->weekly_payment) $account_payment[] = $a;
	    }
	    $param = array(
	    	'year' => $year,
		    'week' => $week,
		    'status' => $status,
		    'account_payment' => $account_payment
	    );
	    return view('admin.deposit.weekly', $param);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
    	$param = array();
    	if($request->has('number')){
    		$account = Account::where('number', $request->input('number'))->first();
		    $param['account'] = $account;
	    }
        return view('admin.deposit.form', $param);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $account = Account::find($request->input('account'));
        if($account != null){
        	$deposit = new Deposit([
				'account_id' => $account->id,
		        'flow' => $request->input('flow'),
		        'amount' => $request->input('amount'),
		        'status' => 'CLEARED',
		        'user_id' => Auth::id()
	        ]);
        	$deposit->save();
        	return redirect('/admin/deposit/create')->with('success', 'Transaksi berhasil disimpan.')->with('account_id', $account->id);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
