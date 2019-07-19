<?php

use Illuminate\Http\Request;

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

Route::get('desa', function(Request $request){
	if($request->has('keyword')){
		$keyword = $request->input('keyword');
		$desa = DB::table('location_desa')
		          ->select('location_desa.id as id','location_desa.nama as desa', 'location_kecamatan.nama as kecamatan', 'location_kabkot.nama as kabkot')
		          ->join('location_kecamatan', 'location_desa.kecamatan_id', '=', 'location_kecamatan.id')
		          ->join('location_kabkot', 'location_kecamatan.kabkot_id', '=', 'location_kabkot.id')
		          ->where('location_desa.nama', 'like', $keyword . '%')
		          ->get();
		return response()->json($desa, 200);
	}
	return response()->json(null, 400);
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
