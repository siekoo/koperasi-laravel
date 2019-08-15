<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Deposit;
use App\Account;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use GeniusTS\HijriDate;
use App\Kabkot;
use App\Kecamatan;
use App\Desa;
use App\Exports\DepositExport;
use Maatwebsite\Excel\Facades\Excel;

class DepositController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

    	$deposit = DB::table('deposits')
            ->join('accounts', 'deposits.account_id', '=', 'accounts.id')
		    ->select([
		    	'deposits.*',
			    'accounts.number', 'accounts.fullname', 'accounts.phone', 'accounts.gender', 'accounts.address', 'accounts.dusun',
			    'accounts.desa', 'accounts.kecamatan', 'accounts.kabkot',
		    ])
		    ;

	    $param = array(
		    'kabkot' => 'ALL', 'kecamatan' => 'ALL', 'desa' => 'ALL',
		    'startdate' => 'ALL', 'enddate' => 'ALL',
	    );

		$startdate = $request->has('startdate') ? $request->input('startdate') : 'ALL';
	    $enddate = $request->has('enddate') ? $request->input('enddate') : 'ALL';
		if($startdate != 'ALL' && $enddate != 'ALL'){
			$exp = explode('-', $startdate);
			$startgreg = HijriDate\Hijri::convertToGregorian($exp[0], $exp[1], $exp[2])->format('Y-m-d');

		    $exp = explode('-', $enddate);
		    $endgreg = HijriDate\Hijri::convertToGregorian($exp[0], $exp[1], $exp[2])->format('Y-m-d');

		    $deposit->whereRaw('(deposits.created_at >= "' . $startgreg . ' 00:00:00 " AND deposits.created_at <= "' . $endgreg . ' 23:59:59")');
	    }

	    unset($param['startdate']);
	    unset($param['enddate']);

	    foreach($param as $key => $val){
		    if($request->has($key)) {
			    $param[$key] = $request->input($key);
			    if($param[$key] != 'ALL') {
				    $deposit->where($key, $param[$key]);
				    if($key == 'kecamatan') $param['kecamatan_data'] = Kecamatan::find($param['kecamatan']);
				    if($key == 'desa') $param['desa_data'] = Desa::find($param['desa']);
			    }
		    }
	    }

	    $kabkot = Kabkot::orderBy('kode', 'asc')->get();
	    $param['kabkot_data'] = $kabkot;

	    $param['deposits'] = $deposit->get();
	    $param['print'] = $request->has('print') ? true : false;
	    $param['startdate'] = $startdate;
	    $param['enddate'] = $enddate;

	    $filename = 'deposit-' . date('dmy') . '-kabkot=' . $param['kabkot']
	                . '-kecamatan=' . $param['kecamatan']
	                . '-desa=' . $param['desa']
	                . '-rentang=' . $startdate . 'sd' . $enddate;

	    if($request->has('export'))
		    return Excel::download(new DepositExport($param), $filename . '.xls');

        return view('admin.deposit.index', $param);
    }

    public function weekly(Request $request)
    {
    	$startWeek = HijriDate\Date::today()->startOfWeek();
    	$endWeek = HijriDate\Date::today()->endOfWeek();

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
	    	'startdate' => $startWeek->format('d-m-Y'),
		    'enddate' => $endWeek->format('d-m-Y'),
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
	    $param['current'] = 'gregorian' == env('OPT_DATE_FORMAT') ? date('d/m/Y') : HijriDate\Date::today()->format('d/m/Y');
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
