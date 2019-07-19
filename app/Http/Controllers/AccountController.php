<?php

namespace App\Http\Controllers;

use App\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$accounts = Account::all();
        return view('admin.account.index', array('account' => $accounts));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	$jobs = DB::table('accounts')->select('job')->distinct()->get();
    	$dusuns = DB::table('accounts')->select('dusun')->distinct()->get();

    	$param = array(
    		'number' => $this->generate_account_number(),
		    'jobs' => $jobs,
		    'dusuns' => $dusuns
	    );

        return view('admin.account.form', $param);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
	    $location = DB::table('location_desa')
	              ->select('location_desa.id as desa', 'location_kecamatan.id as kecamatan', 'location_kabkot.id as kabkot')
	              ->join('location_kecamatan', 'location_desa.kecamatan_id', '=', 'location_kecamatan.id')
	              ->join('location_kabkot', 'location_kecamatan.kabkot_id', '=', 'location_kabkot.id')
	              ->where('location_desa.id', $request->input('desa'))
	              ->first();

	    $joined_at = date('Y-m-d',strtotime(str_replace('/', '-', $request->input('joined_at'))));
	    $birth_date = date('Y-m-d',strtotime(str_replace('/', '-', $request->input('birth_date'))));

        $account = new Account([
        	'number' => $request->input('number'),
        	'joined_at' => $joined_at,
        	'fullname' => ucwords($request->input('fullname')),
        	'father_name' => ucwords($request->input('father_name')),
        	'grandfather_name' => ucwords($request->input('grandfather_name')),
        	'birth_place' => ucwords($request->input('birth_place')),
        	'birth_date' => $birth_date,
        	'gender' => $request->input('gender'),
        	'job' => ucwords($request->input('job')),
        	'phone' => $request->input('phone'),
        	'address' => $request->input('address'),
        	'dusun' => ucwords($request->input('dusun')),
        	'desa' => $location->desa,
        	'kecamatan' => $location->kecamatan,
        	'kabkot' => $location->kabkot,
        	'provinsi' => 1,
	        'user_id' => 1,
        ]);
        $account->save();
        return redirect('/admin/account/create')->with('success', 'Akun Anggota Berhasil di Simpan.')->with('account_id', $account->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $account = Account::find($id);
        $transaction = DB::table('deposits')
                         ->where('account_id', $id)
                         ->orderBy('created_at', 'desc')
                         ->get();
        $param = array(
            'account' => $account,
	        'transaction' => $transaction
        );
        return view('admin.account.show', $param);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
	    $jobs = DB::table('accounts')->select('job')->get();
	    $dusuns = DB::table('accounts')->select('dusun')->get();
	    $account = Account::find($id);
	    $param = array(
		    'number' => $this->generate_account_number(),
		    'jobs' => $jobs,
		    'dusuns' => $dusuns,
		    'account' => $account
	    );

	    return view('admin.account.form', $param);
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
	    $account = Account::find($id);
	    if($account != null){

		    $location = DB::table('location_desa')
		                  ->select('location_desa.id as desa', 'location_kecamatan.id as kecamatan', 'location_kabkot.id as kabkot')
		                  ->join('location_kecamatan', 'location_desa.kecamatan_id', '=', 'location_kecamatan.id')
		                  ->join('location_kabkot', 'location_kecamatan.kabkot_id', '=', 'location_kabkot.id')
		                  ->where('location_desa.id', $request->input('desa'))
		                  ->first();

		    $joined_at = date('Y-m-d',strtotime(str_replace('/', '-', $request->input('joined_at'))));
		    $birth_date = date('Y-m-d',strtotime(str_replace('/', '-', $request->input('birth_date'))));

		    $updated = array(
			    'number' => $request->input('number'),
			    'joined_at' => $joined_at,
			    'fullname' => ucwords($request->input('fullname')),
			    'father_name' => ucwords($request->input('father_name')),
			    'grandfather_name' => ucwords($request->input('grandfather_name')),
			    'birth_place' => ucwords($request->input('birth_place')),
			    'birth_date' => $birth_date,
			    'gender' => $request->input('gender'),
			    'job' => ucwords($request->input('job')),
			    'phone' => $request->input('phone'),
			    'address' => $request->input('address'),
			    'dusun' => ucwords($request->input('dusun')),
			    'desa' => $location->desa,
			    'kecamatan' => $location->kecamatan,
			    'kabkot' => $location->kabkot,
			    'provinsi' => 1,
			    'user_id' => 1,
		    );

		    $account->update($updated);
		    return redirect('/admin/account/' . $id)->with('success', ' Akun anggota berhasil diperbarui');
	    }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    	$account = Account::findOrFail($id);
		$account->delete();
	    return redirect('/admin/account/')->with('success', ' Akun anggota berhasil dihapus');
    }

    private function generate_account_number(){
	    $string='';
	    for($i=0;$i<10;$i++) {
		    $string.=rand(0,9);
	    }
	    return $string;
	}
}
