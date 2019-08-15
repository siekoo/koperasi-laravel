<?php

namespace App\Http\Controllers;

use App\Expense;
use App\ExpenseCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use GeniusTS\HijriDate;
use App\Exports\ExpenseExport;
use Maatwebsite\Excel\Facades\Excel;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
	    $expenses =  Expense::orderBy('id', 'desc');
	    $expenseCategory = ExpenseCategory::all();

	    $param = array(
		    'category' => 'ALL', 'status' => 'ALL',
		    'startdate' => 'ALL', 'enddate' => 'ALL',
	    );

	    $startdate = $request->has('startdate') ? $request->input('startdate') : 'ALL';
	    $enddate = $request->has('enddate') ? $request->input('enddate') : 'ALL';
	    if($startdate != 'ALL' && $enddate != 'ALL'){
		    $exp = explode('-', $startdate);
		    $startgreg = HijriDate\Hijri::convertToGregorian($exp[0], $exp[1], $exp[2])->format('Y-m-d');

		    $exp = explode('-', $enddate);
		    $endgreg = HijriDate\Hijri::convertToGregorian($exp[0], $exp[1], $exp[2])->format('Y-m-d');

		    $expenses->whereRaw('(expenses.created_at >= "' . $startgreg . ' 00:00:00 " AND expenses.created_at <= "' . $endgreg . ' 23:59:59")');
	    }

	    $category = $request->has('category') ? $request->input('category') : 'ALL';
	    if($category != 'ALL'){
	    	$expenses->where('expense_category_id', '=', $category);
	    }

	    $status = $request->has('status') ? $request->input('status') : 'ALL';
	    if($status != 'ALL'){
		    $expenses->where('status', '=', $status);
	    }



	    $param['expenses'] = $expenses->take(10)->get();
	    $param['category_data'] = $expenseCategory;
	    $param['status_data'] = array('ALL', 'CLEARED', 'PENDING');
	    $param['print'] = $request->has('print') ? true : false;
	    $param['category'] = $category;
	    $param['startdate'] = $startdate;
	    $param['enddate'] = $enddate;
	    $param['status'] = $status;

	    $filename = 'expense-' . date('dmy')
	                . '-rentang=' . $startdate . 'sd' . $enddate;

	    if($request->has('export'))
		    return Excel::download(new ExpenseExport($param), $filename . '.xls');

	    return view('admin.expense.index', $param);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	$param = array(
            'categories' => ExpenseCategory::all(),
		    'current' => 'gregorian' == env('OPT_DATE_FORMAT') ? date('d/m/Y') : HijriDate\Date::today()->format('d/m/Y')
	    );
        return view('admin.expense.form', $param);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	$dt = explode('/', $request->input('expense_date'));
	    $expense_date = 'gregorian' == env('OPT_DATE_FORMAT') ?
		    date('Y-m-d',strtotime(str_replace('/', '-', $request->input('expense_date'))))
		    : HijriDate\Hijri::convertToGregorian($dt[0], $dt[1], $dt[2])->format('Y-m-d');
	    $expense = new Expense([
	    	'expense_date' => $expense_date,
		    'expense_category_id' => $request->input('expense_category_id'),
		    'description' => $request->input('description'),
		    'amount' => $request->input('amount'),
		    'status' => $request->input('status'),
		    'user_id' => Auth::id()
	    ]);
	    $expense->save();
	    return redirect('/admin/expense/create')->with('success', 'Transaksi berhasil disimpan.');
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
	    $expense = Expense::find($id);
    	$categories = ExpenseCategory::all();
	    $param = array(
	        'expense' => $expense,
		    'categories' => $categories
	    );
	    return view('admin.expense.form', $param);
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
	    $dt = explode('/', $request->input('expense_date'));
	    $expense_date = 'gregorian' == env('OPT_DATE_FORMAT') ?
		    date('Y-m-d',strtotime(str_replace('/', '-', $request->input('expense_date'))))
		    : HijriDate\Hijri::convertToGregorian($dt[0], $dt[1], $dt[2])->format('Y-m-d');
	    $request->merge(['expense_date' => $expense_date]);
        $expense = Expense::find($id);
        if($expense != null){
        	$expense->update($request->all());
	        return redirect('/admin/expense/')->with('success', ' Data pengeluaran berhasil diperbarui');
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
	    $expense = Expense::findOrFail($id);
	    $expense->delete();
	    return redirect('/admin/expense/')->with('success', ' Data Pengeluaran berhasil dihapus');
    }
}
