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

// Making changes on Chris

// Changes on Master

$row = 0;
if (($handle = fopen("cats.csv", "r")) !== FALSE) {
  while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
    $num = count($data);

    if ($num == 1 && $row > 0){
	    for ($counter=0; $counter < $num; $counter++) {
	        
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


			$table = "catalog_category_entity_varchar";

	        insertData($table, 45, 0, $lastid, $data[$counter]); // name
	        insertData($table, 52, 0, $lastid, 'PRODUCTS'); // display mode

	        // clean the name for url and key paths
			
			$cleanName = str_replace("'", '-', $data[$counter]);
			$cleanName = str_replace("/", '-', $cleanName);
			$cleanName = str_replace(":", '', $cleanName);
			$cleanName = str_replace(".", '', $cleanName);
			$cleanName = str_replace('"', '', $cleanName);
			$cleanName = str_replace(' ', '-', $cleanName);			

			insertData($table, 119, 0, $lastid, $cleanName); // url path
			insertData($table, 120, 0, $lastid, $cleanName); // url key
	        insertData($table, 137, 0, $lastid, 0); // umm_dd_type

	        $table = "catalog_category_entity_int";

	        insertData($table, 46, 0, $lastid, 1);
	        insertData($table, 53, 0, $lastid, 'NULL');
	        insertData($table, 54, 0, $lastid, 1);
	        insertData($table, 69, 0, $lastid, 0);
	        insertData($table, 70, 0, $lastid, 1);
	        insertData($table, 71, 0, $lastid, 1);
											
	    }
	}
	$row++;	
  }
  fclose($handle); 
}

function insertData($table, $attributeId, $storeId, $entityId, $value){

    DB::insert($table, array(
	  'attribute_id' =>  $attributeId,
	  'store_id' =>  $storeId,
	  'entity_id' => $entityId,
	  'value' => $value,
	));	

}

echo "Done!";