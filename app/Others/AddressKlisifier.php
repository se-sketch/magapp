<?php

namespace App\Others;

use Illuminate\Support\Facades\Http;

class AddressKlisifier 
{
	
	function __construct()
	{
		# code...
	}

	private function execute_http_query($name_fun, $params){

		/*
		curl -X GET --header 'Authorization: Bearer 11111111-2222-3333-aaaa-bcdef1234567' --header 'Accept: application/json' 'https://ukrposhta.ua/address-classifier-ws/get_postoffices_by_postindex?pi=01001'
		*/

		// GETRequest URI:/get_regions_by_region_ua?region_name={region_name}&region_name_en={region_name_en}

		$str_params = '';
		$str_razd = '?';
		foreach ($params as $key => $value) {
			$str_params .= $str_razd. trim($key) ."=". trim($value);
			$str_razd = '&';
		}

		$server_name = 'https://ukrposhta.ua/address-classifier/';

		$strURI = $server_name.$name_fun.$str_params;

		//echo($strURI);

		$response = Http::withHeaders([
			//'Content-Type' => 'application/json',
			'Accept' => 'application/json',
		])->get($strURI);

		if (!$response->successful()){
			return [];
		}

		$result_json = $response->json();

		if (is_null($result_json)){
			return [];
		}

		$Entries = $result_json['Entries'];

		if (sizeof($Entries) == 0){
			return [];
		}

		return $Entries['Entry'];
	}

	private function getParamLanguage($lang){
		$lang = strtoupper(trim($lang));
		$lang = ($lang == 'RU' || $lang == 'EN') ? $lang : 'UA';

		return $lang;
	}

	public function getRegions($region_name){

		$params = [];

		if (!empty(trim($region_name))) {
			$params['region_name'] = trim($region_name);
		}

		//$params['region_name_en'] = ;

		$name_fun = "get_regions_by_region_ua";

		$result = $this->execute_http_query($name_fun, $params);

		return $result;
	}

	public function getRegions_lang($region_name, $lang){

		$lang = $this->getParamLanguage($lang);

		$result = $this->getRegions($region_name);

		$collection = collect($result);

		$field_name = 'REGION_'.$lang;

		$keyed = $collection->mapWithKeys(function ($item) use ($field_name) {
		    return [$item['REGION_ID'] => $item[$field_name]];
		});

		return $keyed->all();
	}

	public function getDistricts($region_id, $district_ua){

		//URI:/get_districts_by_region_id_and_district_ua?region_id={id}&district_ua={district}

		$params = [];

		if (!empty(trim($region_id))) {
			$params['region_id'] = trim($region_id);
		}

		if (!empty(trim($district_ua))) {
			$params['district_ua'] = trim($district_ua);
		}

		$name_fun = "get_districts_by_region_id_and_district_ua";

		$result = $this->execute_http_query($name_fun, $params);

		return $result;
	}

	public function getDistricts_lang($region_id, $district_ua, $lang){

		$lang = $this->getParamLanguage($lang);

		$result = $this->getDistricts($region_id, $district_ua);

		$collection = collect($result);

		$field_name = 'DISTRICT_'.$lang;

		$keyed = $collection->mapWithKeys(function ($item) use ($field_name) {
		    return [$item['DISTRICT_ID'] => $item[$field_name]];
		});

		return $keyed->all();
	}

	public function getCities($region_id, $district_id, $city_ua, $koatuu){

		//URI:/get_city_by_region_id_and_district_id_and_city_ua?district_id={districtId}&region_id= {regionId}&city_ua={cityUa}&koatuu={koatuuCode}

		$params = [];

		if (!empty(trim($region_id))) {
			$params['region_id'] = trim($region_id);
		}
		if (!empty(trim($district_id))) {
			$params['district_id'] = trim($district_id);
		}
		if (!empty(trim($city_ua))) {
			$params['city_ua'] = trim($city_ua);
		}
		if (!empty(trim($koatuu))) {
			$params['koatuu'] = trim($koatuu);
		}


		$name_fun = "get_city_by_region_id_and_district_id_and_city_ua";

		$result = $this->execute_http_query($name_fun, $params);

		return $result;
	}

	public function getCities_lang($region_id, $district_id, $city_ua, $koatuu, $lang){

		$lang = $this->getParamLanguage($lang);

		$result = $this->getCities($region_id, $district_id, $city_ua, $koatuu);

		$collection = collect($result);

		$field_name = 'CITY_'.$lang;

		$keyed = $collection->mapWithKeys(function ($item) use ($field_name) {
		    return [$item['CITY_ID'] => $item[$field_name]];
		});

		return $keyed->all();
	}	

	public function getStreets($region_id, $district_id, $city_id, $street_ua){

		//URI:/get_street_by_region_id_and_district_id_and_city_id_and_street_ua?region_id={regionId}&district_id={districtId}&city_id={cityId}&street_ua={street}

		$params = [];

		if (!empty(trim($region_id))) {
			$params['region_id'] = trim($region_id);
		}
		if (!empty(trim($district_id))) {
			$params['district_id'] = trim($district_id);
		}
		if (!empty(trim($city_id))) {
			$params['city_id'] = trim($city_id);
		}
		if (!empty(trim($street_ua))) {
			$params['street_ua'] = trim($street_ua);
		}

		$name_fun = "get_street_by_region_id_and_district_id_and_city_id_and_street_ua";

		$result = $this->execute_http_query($name_fun, $params);

		return $result;
	}

	public function getStreets_lang($region_id, $district_id, $city_id, $street_ua, $lang){

		$lang = $this->getParamLanguage($lang);

		$result = $this->getStreets($region_id, $district_id, $city_id, $street_ua);

		$collection = collect($result);

		$field_name = 'STREET_'.$lang;

		$keyed = $collection->mapWithKeys(function ($item) use ($field_name) {
		    return [$item['STREET_ID'] => $item[$field_name]];
		});

		return $keyed->all();
	}	


	public function getAddrHouseByStreetId($street_id, $housenumber){
		//URI:/get_addr_house_by_street_id?street_id={streetId}&housenumber={houseNumber}

		$params = [];

		if (empty(trim($street_id))){
			return [];
		}

		$params['street_id'] = trim($street_id);

		if (!empty(trim($housenumber))) {
			$params['housenumber'] = trim($housenumber);
		}

		$name_fun = "get_addr_house_by_street_id";

		$result = $this->execute_http_query($name_fun, $params);

		return $result;
	}

	public function getAddrHouseByStreetId_HOUSENUMBER_UA($street_id, $housenumber){

		$result = $this->getAddrHouseByStreetId($street_id, '');

		$collection = collect($result);

		$plucked = $collection->pluck('HOUSENUMBER_UA');

		if ($housenumber > 0){
			$plucked = $plucked->filter(function ($value, $key) use ($housenumber) {
			    return strpos($value, $housenumber);
			});
		}

		$plucked = $plucked->take(20);

		return $plucked->all();	
	}


	public function getDistrictByName($region_id, $district_name, $lang, $fuzzy){

		//URI:/get_district_by_name?region_id={region_id}&district_name={district_name}&lang={EN}&fuzzy={usefuzzyserch}

		$params = [];

		if (!empty(trim($region_id))) {
			$params['region_id'] = trim($region_id);
		}
		if (!empty(trim($district_name))) {
			$params['district_name'] = trim($district_name);
		}
		if (!empty(trim($fuzzy))) {
			$params['fuzzy'] = trim($fuzzy);
		}

		$lang = strtoupper(trim($lang));
		$params['lang'] = ($lang == 'RU' || $lang == 'EN') ? $lang : 'UA';

		$name_fun = "get_district_by_name";

		$result = $this->execute_http_query($name_fun, $params);

		return $result;
	}

	public function getDistrictByName_Name($region_id, $district_name, $lang, $fuzzy){

		$result = $this->getDistrictByName($region_id, $district_name, $lang, $fuzzy);

		$collection = collect($result);

		$keyed = $collection->mapWithKeys(function ($item) {
		    return [$item['DISTRICT_ID'] => $item['DISTRICT_NAME']];
		});

		return $keyed->all();
	}

	public function getCityByName($region_id, $district_id, $city_name, $lang, $fuzzy){

		//URI:/get_city_by_name?region_id={region_id}&district_id={district_id}&city_name={city_name}&lang={EN}&fuzzy={usefuzzyserch}


		$params = [];

		if (!empty(trim($region_id))) {
			$params['region_id'] = trim($region_id);
		}
		if (!empty(trim($district_id))) {
			$params['district_id'] = trim($district_id);
		}
		if (!empty(trim($city_name))) {
			$params['city_name'] = trim($city_name);
		}
		if (!empty(trim($fuzzy))) {
			$params['fuzzy'] = trim($fuzzy);
		}

		$lang = strtoupper(trim($lang));
		$params['lang'] = ($lang == 'RU' || $lang == 'EN') ? $lang : 'UA';

		$name_fun = "get_city_by_name";

		$result = $this->execute_http_query($name_fun, $params);

		return $result;
	}

	public function getCityByName_Name($region_id, $district_id, $city_name, $lang, $fuzzy)
	{
		$result = $this->getCityByName($region_id, $district_id, $city_name, $lang, $fuzzy);

		$collection = collect($result);

		$keyed = $collection->mapWithKeys(function ($item) {
		    return [$item['CITY_ID'] => $item['CITY_NAME']];
		});

		return $keyed->all();
	}

	public function getStreetByName($city_id, $street_name, $lang, $fuzzy){
		//URI:/get_street_by_name?city_id={city_id}&street_name={street_name}&lang={EN}&fuzzy={usefuzzyserch}

		$params = [];

		if (!empty(trim($city_id))) {
			$params['city_id'] = trim($city_id);
		}
		if (!empty(trim($street_name))) {
			$params['street_name'] = trim($street_name);
		}
		if (!empty(trim($fuzzy))) {
			$params['fuzzy'] = trim($fuzzy);
		}

		$lang = strtoupper(trim($lang));
		$params['lang'] = ($lang == 'RU' || $lang == 'EN') ? $lang : 'UA';		

		$name_fun = "get_street_by_name";

		$result = $this->execute_http_query($name_fun, $params);

		return $result;
	}

	public function getStreetByName_Name($city_id, $street_name, $lang, $fuzzy){

		$result = $this->getStreetByName($city_id, $street_name, $lang, $fuzzy);

		$collection = collect($result);

		$keyed = $collection->mapWithKeys(function ($item) {
			return [$item['STREET_ID'] => $item['STREETTYPE_NAME'].' '. $item['STREET_NAME']];
		    //return [$item['STREET_ID'] => $item['STREET_NAME']];
		});

		return $keyed->all();
	}

}