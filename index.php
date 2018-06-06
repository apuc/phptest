<?php

include( "DB/DB_Connection.php" );
include( "Model/Model.php" );
include("Controller/Controller.php");

$db    = new DB_Connection( "localhost", "root", "sancho1995", "test-task2" );
$model = new Model( $db );
$controller = new Controller($db);
//var_dump( $model->getAll() );
//var_dump($db);
//var_dump($db->getMysql()->query("SELECT * FROM {$db->getTable()}")->fetch_fields());
//var_dump($db->getMysql()->fetch_fields);

?>
