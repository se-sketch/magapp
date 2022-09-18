<?php 

namespace App\Others;

use Illuminate\Support\Facades\DB;

class SvodnayaTableGoods 
{
	
	function __construct()
	{
		# code...
	}

	public static function getTableGoodsActiveOrders($svodnaya_id)
	{
    	$svodnaya_id = (int) $svodnaya_id;
    	$svodnaya_id = ($svodnaya_id > 0) ? $svodnaya_id : null;

    	$table_goods = DB::table('details')
                ->leftJoin('nomenclatures', 'details.nomenclature_id', '=', 'nomenclatures.id')
                ->leftJoin('orders', 'details.order_id', '=', 'orders.id')
                ->select('nomenclatures.name')
                ->selectRaw('sum(qty) as qty')
                ->where('details.deleted_at', null)
                ->where('orders.deleted_at', null)
                ->where('orders.active', 1)
                ->where('orders.svodnaya_id', $svodnaya_id)
                ->groupBy('nomenclatures.id')
                ->orderBy('name')
                ->get();

		return $table_goods;
	}



}