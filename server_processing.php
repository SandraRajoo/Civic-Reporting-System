<?php
 
// DB table to use
$table = 'alerts';
 
// Table's primary key
$primaryKey = 'Alert_Id';
 
// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
    array( 'db' => 'type',     'dt' => 0 ),
    array( 'db' => 'description',  'dt' => 1 ),
    array( 'db' => 'lat',   'dt' => 2 ),
    array( 'db' => 'lng',     'dt' => 3 ),
    array( 'db' => 'name', 'dt' => 4 ),
    array( 'db' => 'close_reason',     'dt' => 5 ),
    array( 'db' => 'Completed', 'dt' => 6),
   array( 'db' => 'priority', 'dt' => 7),
    array( 'db' => 'IsComplete', 'dt' =>8)



    
);
 
// SQL server connection information

$sql_details = array(
    'user' => 'sandra',
    'pass' => 'tiger',
    'db'   => 'beautifymycity',
    'host' => 'localhost'
);
 
 
require( 'classes/ssp.class.php' );
 
echo json_encode(
    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
);