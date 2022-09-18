<?php

namespace App\Others;

use Illuminate\Support\Facades\Storage;
//use Illuminate\Support\Facades\DB;
//use League\Flysystem\File;

use App\Models\Area;
use App\Models\Region;
use App\Models\Settlement;

class StanceSettlements
{
	function __construct()
	{
		# code...
	}

    public static function getFileSettlements()
    {
        $settlements = Settlement::with('region', 'region.area')->get();

        $settlements = $settlements->sortBy(function($settlement){
            return $settlement->region->area_id;
        })->sortBy(function($settlement){
            return $settlement->region_id;
        });

        foreach ($settlements as $settlement) {

            $pieces = [
                "area_id" => $settlement->region->area_id,
                "area_name" => $settlement->region->area->name,
                "region_id" => $settlement->region_id,
                "region_name" => $settlement->region->name,
                "settlement_id" => $settlement->id,
                "settlement_name" => $settlement->name,
                "latitude" => $settlement->latitude,
                "longitude" => $settlement->longitude,
            ];

            $str = implode(" ; ", $pieces);
            echo $str;
            echo "<br>";
        }

        exit;
    }

    public static function upload_settlements($fullupload, $flag_update)
    {
        $arr_areas = [];
        $arr_regions = [];
        $arr_settlements = [];

        $filename = 'settlements.csv';

        if (!Storage::exists($filename)){
            echo 'file dosn\'t exists: ' . $filename;
            return false;
        }

        $contents = Storage::get($filename);

        $lines = explode("\n", $contents);

        foreach ($lines as $key => $line) {
            if (empty($line)){
                continue;
            }

            $pieces = explode(";", $line);

            $area_id = (int) $pieces[0];
            $area_name = trim($pieces[1]);

            $region_id = (int) $pieces[2];
            $region_name = trim($pieces[3]);
            
            $settlement_id = (int) $pieces[4];
            $settlement_name = trim($pieces[5]);

            $longitude = (float) $pieces[6];
            $latitude = (float) $pieces[7];


            $arr_areas[$area_id] = [
                'id' => $area_id,
                'name' => $area_name,
            ];

            $arr_regions[$region_id] = [
                'id' => $region_id,
                'name' => $region_name,
                'area_id' => $area_id,
            ];

            $arr_settlements[$settlement_id] = [
                'id' => $settlement_id,
                'name' => $settlement_name,
                'latitude' => $latitude,
                'longitude' => $longitude,
                'region_id' => $region_id,
            ];
        }

        set_time_limit(5400);

        foreach ($arr_areas as $key => $value) {
            Area::updateOrInsert(['id' => $key], $value);
        }

        
        Region::insertOrIgnore($arr_regions);

        
        if (!$fullupload){
            return true;
        }

        if ($flag_update){
            foreach ($arr_settlements as $key => $value) {
                Settlement::updateOrInsert(['id' => $key], $value);
            }
        }else{

            $arr_chunk = [];
            $i = 0;

            foreach ($arr_settlements as $key => $value) {
                $i++;

                $arr_chunk[] = $value;
                
                if ($i > 10000){
                    Settlement::insertOrIgnore($arr_chunk);
                    $arr_chunk = [];
                    $i = 0;
                }
            }

            if (sizeof($arr_chunk)){
                Settlement::insertOrIgnore($arr_chunk);
            }

            //Settlement::insertOrIgnore($arr_settlements);// error - too many placeholders
        }
        
        return true;
    }

    public static function upload()
    {
        //$filename = 'storage/uploads/ua-list.csv';
        //$filename = 'storage/ua-list.csv';
        $filename = 'ua-list.csv';

        $result = file_exists($filename);

        if (!$result) {
            exit('file dosn\'t exists: ' . $filename);
        }

        $handle = fopen($filename, "r") or exit("unable to open file ($filename)");

        set_time_limit(7200);

        $row = 1;
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $num = count($data);

            $row++;
            for ($c = 0; $c < $num; $c++) {

                $line = $data[$c];

                $line = iconv("Windows-1251", "UTF-8", $line);

                $pieces = explode(";", $line);

                $name_area = trim($pieces[0]);
                $name_region = trim($pieces[1]);
                $name_settlements = trim($pieces[2]);
                $longitude = $pieces[3];
                $latitude = $pieces[4];
                
                $area = Area::where('name', $name_area)->first();

                if (empty($area)) {
                    //echo 'empty area: ' . $name_area;
                    $area = Area::create([
                        'name' => $name_area,
                    ]);
                }

                $region = Region::where([
                        'area_id' => $area->id,
                        'name' => $name_region,
                    ])->first();


                if (empty($region)) {
                    //echo 'empty region: ' . $name_region;
                    $region = Region::create([
                        'area_id' => $area->id,
                        'name' => $name_region,
                    ]);
                }

                if (empty($name_settlements)){
                    continue;
                }

                $settlement = Settlement::where([
                    'region_id' => $region->id,
                    'name' => $name_settlements,
                ])->first();

                if (empty($settlement)){
                    $settlement = Settlement::create([
                        'region_id' => $region->id,
                        'name' => $name_settlements,
                        'latitude' => $latitude,
                        'longitude' => $longitude,
                    ]);
                }

            }
        }
        fclose($handle);
    }


}