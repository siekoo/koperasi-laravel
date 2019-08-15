<?php

namespace App\Exports;

use App\Account;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use GeniusTS\HijriDate;

class DepositExport implements FromCollection, ShouldAutoSize
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
    		'No', 'Tanggal', 'Registrasi', 'Nama', 'Alamat', 'Kecamatan', 'Kabupaten/Kota', 'Telepon', 'Aliran', 'Jumlah'
	    );
    	$tableBody = array();
    	foreach($this->data['deposits'] as $k => $d){
    		$date = HijriDate\Hijri::convertToHijri($d->created_at)->format('d/m/Y');
    		$kecamatan = ucfirst(strtolower(\App\Kecamatan::find($d->kecamatan)->nama));
    		$kabkot = \App\Kabkot::find($d->kabkot)->nama;
    		$tableBody[] = array(
    			$k+1,
			    $date,
			    $d->number,
			    $d->fullname,
			    $d->address . ', ' . $d->dusun,
			    $kecamatan,
			    $kabkot,
			    $d->phone,
			    $d->flow,
			    $d->amount,
		    );
	    }

    	$table = array($tableHead, $tableBody);

        return collect($table);
    }
}
