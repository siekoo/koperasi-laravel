<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('kabkot', function(Request $request){
	if($request->has('keyword')){
		$keyword = $request->input('keyword');
		$kabkot = DB::table('location_kabkot')->where('nama', 'like', $keyword . '%')->get();
		return response()->json($kabkot, 200);
	}
	return response()->json(null, 400);
});

Route::get('kecamatan', function(Request $request){
	$kecamatan = DB::table('location_kecamatan');
	if($request->has('keyword')){
		$keyword = $request->input('keyword');
		$kecamatan->where('nama', 'like', $keyword . '%');
	}
	if($request->has('kabkot')){
		$kabkot = $request->input('kabkot');
		$kecamatan->where('kabkot_id', $kabkot)->get();
	}
	$kecamatan = $kecamatan->get();
	return response()->json($kecamatan, 200);
});

Route::get('desa', function(Request $request){
	$desa = DB::table('location_desa')
	          ->select('location_desa.id as id','location_desa.nama as desa', 'location_kecamatan.nama as kecamatan', 'location_kabkot.nama as kabkot')
	          ->join('location_kecamatan', 'location_desa.kecamatan_id', '=', 'location_kecamatan.id')
	          ->join('location_kabkot', 'location_kecamatan.kabkot_id', '=', 'location_kabkot.id');

	if($request->has('keyword')){
		$keyword = $request->input('keyword');
		$desa->where('location_desa.nama', 'like', $keyword . '%');
	}

	if($request->has('kecamatan')) $desa->where('location_kecamatan.id', $request->input('kecamatan'));
	if($request->has('kabkot')) $desa->where('location_kabkot.id', $request->input('kabkot'));

	return response()->json($desa->get(), 200);
});

Route::get('rekening', function(Request $request){
	if($request->has('number')){
		$number = $request->input('number');
		$rekening = DB::table('accounts')
					->select('id', 'number', 'fullname', 'phone', 'address')
					->where('number', 'like', $number . '%')
					->get();
		return response()->json($rekening, 200);
	}
	return response()->json(null, 400);
});
