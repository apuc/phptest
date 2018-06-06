<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 05.06.18
 * Time: 14:12
 */
include( "Parser.php" );

class Controller {

	public function __construct( DB_Connection $db ) {


//		var_dump($_POST);die;

		$model = new ModelBase( $db );

		if ( ! empty( $_POST ) ) {
			$model->load();
			var_dump($model);
			var_dump($model->save());
			var_dump($model);
		}
//		var_dump($model);die;



		return Parser::render( "views/form.php", [ $model ], true );


	}
}