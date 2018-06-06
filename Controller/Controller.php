<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 05.06.18
 * Time: 14:12
 */
include( "Parser.php" );
include( "Model/Security.php" );
include( "Model/UploadImage.php" );

class Controller {

	public function __construct( DB_Connection $db ) {


//		var_dump($_POST);die;

		$model               = new ModelBase( $db );
		$model->crsfSecurity = new Security();

		if ( ! empty( $_POST ) ) {
			if ( $model->crsfSecurity->validateCrsf() ) {
				$model->load();
				$image = new UploadImage($model);
				var_dump($model);die;
				$model->save();
			} else {
				$model->crsfSecurity->updateCrsf();
			}
		}

		return Parser::render( "views/form.php", [ $model ], true );


	}
}