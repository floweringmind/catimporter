<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'db.php';
DB::$host = 'localhost';
DB::$user = 'username';
DB::$password = 'password';
DB::$dbName = 'databasename';

$now = date('Y/m/d H:i:s');
$rootcat = '4632';

$row = 0;
if (($handle = fopen("cats.csv", "r")) !== FALSE) {
  while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
    $num = count($data);

    if ($num == 1 && $row > 0){
	    for ($c=0; $c < $num; $c++) {
	        
	    	// create catlog entry

	        DB::insert('catalog_category_entity', array(
			  'attribute_set_id' => '3',
			  'parent_id' => $rootcat,
			  'created_at' => $now,
			  'updated_at' => $now,
			  'path' => '',
			  'position' => '1',
			  'level' => '0',
			  'children_count' => '0',
			));

	        $lastid = DB::insertId();

			// update path
			DB::update('catalog_category_entity', array(
			  'path' => '1/'.$rootcat.'/'.$lastid
			  ), "entity_id=%s", $lastid);


			//catalog_category_entity_varchar

	        // name
	        DB::insert('catalog_category_entity_varchar', array(
			  'attribute_id' => '45',
			  'store_id' => '0',
			  'entity_id' => $lastid,
			  'value' => $data[$c],
			));

	        // display mode
	        DB::insert('catalog_category_entity_varchar', array(
			  'attribute_id' => '52',
			  'store_id' => '0',
			  'entity_id' => $lastid,
			  'value' => 'PRODUCTS',
			));

	        // clean the name for url and key paths
			
			$cleanName = str_replace("'", '-', $data[$c]);
			$cleanName = str_replace("/", '-', $cleanName);
			$cleanName = str_replace(":", '', $cleanName);
			$cleanName = str_replace(".", '', $cleanName);
			$cleanName = str_replace('"', '', $cleanName);
			$cleanName = str_replace(',', '', $cleanName);


			$cleanName = str_replace(' ', '-', $cleanName);


			// url path
	        DB::insert('catalog_category_entity_varchar', array(
			  'attribute_id' => '119',
			  'store_id' => '0',
			  'entity_id' => $lastid,
			  'value' => $cleanName,
			));

			// url key
	        DB::insert('catalog_category_entity_varchar', array(
			  'attribute_id' => '120',
			  'store_id' => '0',
			  'entity_id' => $lastid,
			  'value' => $cleanName,
			));

	        //	umm_dd_type

	        DB::insert('catalog_category_entity_varchar', array(
			  'attribute_id' => '137',
			  'store_id' => '0',
			  'entity_id' => $lastid,
			  'value' => '0',
			));


	        //catalog_category_entity_int

	        DB::insert('catalog_category_entity_int', array(
			  'attribute_id' => '46',
			  'store_id' => '0',
			  'entity_id' => $lastid,
			  'value' => '1',
			));

	        DB::insert('catalog_category_entity_int', array(
			  'attribute_id' => '69',
			  'store_id' => '0',
			  'entity_id' => $lastid,
			  'value' => '0',
			));

	        DB::insert('catalog_category_entity_int', array(
			  'attribute_id' => '53',
			  'store_id' => '0',
			  'entity_id' => $lastid,
			  'value' => 'NULL',
			));

	        DB::insert('catalog_category_entity_int', array(
			  'attribute_id' => '54',
			  'store_id' => '0',
			  'entity_id' => $lastid,
			  'value' => '1',
			));

	        DB::insert('catalog_category_entity_int', array(
			  'attribute_id' => '70',
			  'store_id' => '0',
			  'entity_id' => $lastid,
			  'value' => '1',
			));

	        DB::insert('catalog_category_entity_int', array(
			  'attribute_id' => '71',
			  'store_id' => '0',
			  'entity_id' => $lastid,
			  'value' => '1',
			));												
	    }
	}
	$row++;	
  }
  fclose($handle); 
}

echo "Done!";