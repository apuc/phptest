<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 06.06.18
 * Time: 20:43
 */

class UploadImage {

	private $fileName;

	public function __construct( ModelBase $model ) {

		if ( ! empty( $_FILES ) ) {
			$error = $_FILES["file"]["error"];
			if ( $error > 0 ) {
				$model->addError( "imageFile", "Ошибка сохранения файла: {$error}" );

				return null;
			}


			$this->createDir();
			$typeFile = $this->getTypeFile();
			var_dump( $this->validateFile( $typeFile, $model ) );
			if ( $this->validateFile( $typeFile, $model ) ) {
				$this->setFileName( $typeFile );
				$this->saveFile( $model );
				$model->image = $this->fileName;
			}
			unset( $_FILES["file"] );

		}

		return null;

	}


	public function getFileName() {
		return $this->fileName;
	}

	private function setFileName( $typeFile ) {
		$this->fileName = $this->generateRandomString() . $typeFile;
	}

	private function createDir() {
		if ( ! file_exists( "image" ) ) {
			mkdir( "image" );
		}
	}

	private function getTypeFile() {
		return ( substr( $_FILES['file']['name'], strrpos( $_FILES['file']['name'], "." ) ) );
	}

	private function getSrcSaveFile() {
		return "image/" . $this->fileName;
	}

	private function generateRandomString() {
		return md5( uniqid( rand(), true ) );
	}

	private function saveFile( ModelBase $model ) {
		if ( ! @copy( $_FILES['file']['tmp_name'], $this->getSrcSaveFile() ) ) {
			$model->addError( "imageFile", "Ошибка сохранения файла" );
		}
	}

	/**
	 * @param string $typeFile
	 * @param ModelBase $model
	 *
	 * @return bool
	 */
	private function validateFile( $typeFile, $model ) {
		$validateTypeFile = $this->validateTypeFile( $typeFile );
		if ( $validateTypeFile !== true ) {
			$model->addError( "imageFile", $validateTypeFile );

			return false;
		}

		$validateSizeFile = $this->validateSizeFile();
		if ( $validateSizeFile !== true ) {
			$model->addError( "imageFile", $validateSizeFile );

			return false;
		}

		return true;

	}


	private function validateTypeFile( $typeFile ) {
		$types = [ ".jpg", ".png", ".gif" ];

		foreach ( $types as $type ) {
			if ( $type == $typeFile ) {
				return true;
			}
		}

		return "файл имеет недопустимое разрешение";
	}

	private function validateSizeFile() {
		if ( $_FILES["file"]["size"] > 1000000 ) {
			return "файл превышает допустимый размер";
		}

		return true;
	}

}