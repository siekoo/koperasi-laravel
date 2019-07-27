<?php

namespace App\Exports;

use App\Account;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class AccountExport implements FromCollection, ShouldAutoSize
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
    		'No', 'Pendaftaran', 'Registrasi', 'Nama Lengkap', 'J/K', 'Telepon', 'Alamat', 'Desa', 'Kecamatan', 'Kabupaten', 'Status'
	    );
    	$tableBody = array();
    	foreach($this->data['accounts'] as $k => $d){
    		$tableBody[] = array($k+1, $d->joined_at(), $d->number, $d->fullname,
			    $d->jenis_kelamin(), $d->phone,
			    $d->address, $d->desa()->nama, $d->kecamatan()->nama, $d->kabkot()->nama, $d->status
		    );
	    }

    	$table = array($tableHead, $tableBody);

        return collect($table);
    }
}
