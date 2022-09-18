<?php 

namespace App\Others;

use App\Order;

class OrdersExporter
{
	function __construct()
	{
		# code...
	}

	private function getDataOrders()
	{
		$data = [];

		$orders = Order::active()->ofSvodnaya(null)
		->select('id', 'phone', 'name', 'address', 'exchange', 'settlement_id', 'created_at', 'ordclose_id', 
			'svodnaya_id')
		->with('details', 'details.nomenclature', 'settlement', 'settlement.region', 'settlement.region.area')
		->get();

		foreach ($orders as $order)
		{
			$arr_values = [
				'id' => $order->id,
				'phone' => $order->getPhone(), 
				'name' => $order->getName(),
				'exchange' => $order->exchange,
				'area' => $order->settlement->region->area->name,
				'region' => $order->settlement->region->name,
				'settlement' => $order->settlement->name,
				'address' => $order->getAddress(),
				'created_at' => date_format(date_create($order->created_at), 'Y-m-d'),
				'ordclose_id' => $order->ordclose_id,
				'svodnaya_id' => $order->svodnaya_id,
				'qty' => $order->getSummaryCount(),
				'details' => $order->getStringDetails(true),
			];

			$data[] = $arr_values;
		}

		return  $data;
	}

	public function getDataExport()
	{
		$array_export['orders'] = $this->getDataOrders();

		return $array_export;
	}




}