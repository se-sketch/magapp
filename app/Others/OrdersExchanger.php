<?php

namespace App\Others;

use Illuminate\Support\Facades\DB;

class OrdersExchanger 
{
	
	function __construct()
	{
		# code...
	}

    public static function exchangeOrdersSvodnoy($arr_left, $arr_right, $svodnaya_id)
    {
    	$svodnaya_id = (int) $svodnaya_id;

    	if (!($svodnaya_id > 0)) return false;

        if (!is_array($arr_left)) return false;

        if (!is_array($arr_right)) return false;

        if (sizeof($arr_right) == 0 && sizeof($arr_left) == 0) {
            return false;
        }

        DB::beginTransaction();

        try {

            if (sizeof($arr_left) > 0) {
                DB::table('orders')->whereIn('id', $arr_left)->update([
                    'svodnaya_id' => null,
                    'approved' => false,
                    'kilter' => 0,
                ]);
            }

            if (sizeof($arr_right) > 0) {
                DB::table('orders')->whereIn('id', $arr_right)->update(['svodnaya_id' => $svodnaya_id]);
            }

            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollback();

            //exit($e->getMessage());
            return false;
        }

        return false;
    }

}
