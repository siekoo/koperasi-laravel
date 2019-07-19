<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{

	protected $guarded = array('id');
	use SoftDeletes;

    public function deposits(){
    	return $this->hasMany('App\Deposit', 'account_id', 'id');
    }

    public function desa(){
    	return $this->hasOne('App\Desa', 'id', 'desa')->get()->first();
    }

    public function kecamatan(){
    	return $this->hasOne('App\Kecamatan', 'id', 'kecamatan')->get()->first();
    }

    public function kabkot(){
    	return $this->hasOne('App\Kabkot', 'id', 'kabkot')->get()->first();
    }

	public function joined_at($format = 'd/m/Y'){
		return date($format,strtotime($this->joined_at));
	}

    public function ttl($format = 'd/m/Y'){
    	return $this->birth_place . ', ' . date($format,strtotime($this->birth_date));
    }

    public function birth_date($format = 'd/m/Y'){
    	return date($format,strtotime($this->birth_date));
    }

    public function address_full(){
		return $this->address . ', Dusun ' . $this->dusun
		       . ', Desa ' . ucwords(strtolower($this->desa()->nama))
		       . ' Kec. ' . ucwords(strtolower($this->kecamatan()->nama))
		       . ', ' . ucwords(strtolower($this->kabkot()->nama));
    }

    public function desa_full(){
	    return $this->desa()->nama
	           . ' KEC. ' . $this->kecamatan()->nama
	           . ', ' . $this->kabkot()->nama;
    }

    public function jenis_kelamin(){
    	return $this->gender == 'M' ? 'Pria' : 'Wanita';
    }

    public function balance(){
    	$balance = 0;
    	foreach($this->deposits as $d){
    		if($d->flow == 'IN') $balance += $d->amount;
    		else $balance -= $d->amount;
	    }
	    return $balance;
    }
}
