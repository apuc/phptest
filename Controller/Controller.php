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

		$model = new Model( $db );

		if ( ! empty( $_POST ) ) {
			$model->load();
//			$model->validate();
			var_dump($model->validate());
			var_dump($model);
			die;
		}
//		var_dump($model);die;

//		$model->first_name                 = "Олег";
//		$model->last_name                  = "Засядько";
//		$model->patronymic                 = "Валериевич";
//		$model->year_of_birth              = 1980;
//		$model->place_of_residence         = "г. Екатеринбург";
//		$model->marital_status             = 1;
//		$model->education                  = "полное высшее";
//		$model->experience                 = "5 лет";
//		$model->phone                      = "46565465";
//		$model->email                      = "example.com";
//		$model->information_about_yourself = "ksflskjdflksfkjsdfsdkfldsjfl";



		return Parser::render( "views/form.php", [ $model ], true );


	}
}