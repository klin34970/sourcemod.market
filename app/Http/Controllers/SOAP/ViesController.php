<?php

namespace App\Http\Controllers\SOAP;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use SoapWrapper;

class ViesController extends Controller
{
    public function checkVAT($country, $vat)
	{
		SoapWrapper::add(function ($service) 
		{
			$service
				->name('vies')
				->wsdl('http://ec.europa.eu/taxation_customs/vies/checkVatService.wsdl')
				->cache(WSDL_CACHE_NONE);
		});
		$data = [
			'countryCode' => $country,
			'vatNumber'   => $vat,
		];

		SoapWrapper::service('vies', function ($service) use ($data) 
		{
			//var_dump($service->getFunctions());
			//var_dump($service->call('checkVat', [$data]));
			echo json_encode($service->call('checkVat', [$data])->valid);
		});
	}
}
