<?php


global $language;
global $defaultLanguage;

$defaultLanguage = "ru";

//установка языка
if ( isset( $_GET["lang"] ) && ! empty( $_GET["lang"] ) ) {
	$language = $_GET["lang"];
} else {
	$language = "ru";
}



require_once( "DB/DB_Connection.php" );
require_once( "Model/ModelBase.php" );
require_once( "Controller/Controller.php" );

$db         = new DB_Connection( "localhost", "root", "sancho1995", "test-task2" );
$model      = new ModelBase( $db );
$controller = new Controller( $db );
//var_dump( $model->getAll() );
//var_dump($db);
//var_dump($db->getMysql()->query("SELECT * FROM {$db->getTable()}")->fetch_fields());
//var_dump($db->getMysql()->fetch_fields);

?>
