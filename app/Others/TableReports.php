<?php 

namespace App\Others;

use Illuminate\Support\Facades\DB;

class TableReports 
{
	
	function __construct()
	{
		# code...
	}

    public static function getTableReports($user_id)
    {
        $user_id = (int) $user_id;

        $parameters = [];

        $cond_user = "";
        if ($user_id > 0){
            $cond_user = " and orders.user_id = $user_id ";
            //$cond_user = " and orders.user_id = :user_id ";
            //$parameters['user_id'] = $user_id;
        }

        $str_dateformat = '%v';
        /*
        $str_dateformat = '%Y-%m-%d';
        if ($mod = 'week'){
            $str_dateformat = '%v';
        }
        */

        //SELECT DATE_FORMAT("2017-06-15", "%M %d %Y"); 
        
        $data = "select users.id, users.name,
        orders.created_at,
        DATE_FORMAT(orders.created_at, '%Y') as date_year_ord,
        DATE_FORMAT(orders.created_at, '$str_dateformat') as date_doc_ord,
        DATE_FORMAT(svodnayas.created_at, '%Y') as date_year_svod,
        DATE_FORMAT(svodnayas.created_at, '$str_dateformat') as date_doc_svod,
        ifnull(details.qty, 0) as qty1, 
        if (orders.svodnaya_id is null, 0, details.qty) as qty2,

        if (orders.ordclose_id is not null, details.qty, 0) as qty3

        from orders
        left join details
        on orders.id = details.order_id
        left join users
        on orders.user_id = users.id
        left join svodnayas
        on orders.svodnaya_id = svodnayas.id
        where orders.active = 1 and orders.deleted_at is null and orders.exchange = 0
        $cond_user
        and details.deleted_at is null
        and details.qty > 0
        and details.qty is not null

        order by orders.created_at
        ";


        $sql = "select id, name, date_year_ord as date_year, date_doc_ord as date_doc, 
        sum(qty1) as qty1, sum(qty2) - sum(qty3) as qty2, sum(qty3) as qty3
        from 
        
        (select id, name, date_year_ord, date_doc_ord, sum(qty1) as qty1, 0 as qty2, 0 as qty3
        from ($data) as data
        group by id, name, date_year_ord, date_doc_ord

        union 

        select id, name, date_year_svod, date_doc_svod, 0, sum(qty2), sum(qty3)
        from ($data) as data
        group by id, name, date_year_svod, date_doc_svod
        ) as zapros

        where date_year_ord is not null

        group by id, name, date_year, date_doc
        order by id desc, date_doc desc
        ";

        $table = DB::select($sql, $parameters);

        return $table;
        
        //strtotime(sprintf("%4dW%02d", $year, $week));
        //$date = new DateTime('midnight'); $date->setISODate($year, $week);
    }

}