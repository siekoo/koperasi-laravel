<?php

namespace App\Exports;

use App\Account;
use App\ExpenseCategory;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use GeniusTS\HijriDate;

class ExpenseExport implements FromCollection, ShouldAutoSize
{
	use Exportable;

	private $data;

	public function __construct($data) {
		$this->data = $data;
	}

	/**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
    	$tableHead = array(
    		'No', 'Tanggal', 'Kategori', 'Deskripsi', 'Jumlah', 'Status', 'Admin',
	    );
    	$tableBody = array();
    	foreach($this->data['expenses'] as $k => $d){
    		$date = HijriDate\Hijri::convertToHijri($d->created_at)->format('d/m/Y');
    		$category = ExpenseCategory::find($d['expense_category_id']);
    		$tableBody[] = array(
    			$k+1,
			    $date,
			    $category,
			    $d->description,
			    $d->amount,
			    $d->status,
		    );
	    }

    	$table = array($tableHead, $tableBody);

        return collect($table);
    }
}
