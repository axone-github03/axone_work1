<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model {
	//
	protected $table = 'mst_company';
	function city() {
		return $this->belongsTo(CityList::class, 'city_id', 'id');
	}
	function state() {
		return $this->belongsTo(StateList::class, 'state_id', 'id');
	}
	function country() {
		return $this->belongsTo(CountryList::class, 'country_id', 'id');
	}
}
