<?php

namespace App\Http\Controllers;

use App\Expense;
use App\ExpenseCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $expenses = Expense::orderBy('id', 'desc')->take(10)->get();
        return view('admin.expense.index', array('expenses' => $expenses));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	$categories = ExpenseCategory::all();
        return view('admin.expense.form', array('categories' => $categories));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
	    $expense_date = date('Y-m-d',strtotime(str_replace('/', '-', $request->input('expense_date'))));
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
	    $expense_date = date('Y-m-d',strtotime(str_replace('/', '-', $request->input('expense_date'))));
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
