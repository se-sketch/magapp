<?php 

namespace App\Others;

use Illuminate\Support\Facades\DB;
use App\Order;

class OrdersKilter 
{
	
	function __construct()
	{
		# code...
	}

	public static function setKilterData($data)
    {
        if (!is_array($data)) return false;

        if (sizeof($data) == 0) return false;

        DB::beginTransaction();

        try {

            foreach ($data as $key => $value) {
                $order_id = (int) $key;
                $kilter = (int) $value;

                if ($kilter < 0) continue;

                if ($order_id > 0){
                    Order::where('id', $order_id)->update(['kilter' => $kilter]);
                }
            }

            DB::commit();

        } catch (\Exception $e) {
            
            DB::rollback();

            exit($e->getMessage());
            
            return false;
        }

        return true;
    }

}