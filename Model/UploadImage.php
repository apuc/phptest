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


	/**
	 * получить имя файла картинки
	 *
	 * @return string
	 */
	public function getFileName() {
		return $this->fileName;
	}

	/**
	 * установить имя файла картинки
	 *
	 * @param string $typeFile
	 */
	private function setFileName( $typeFile ) {
		$this->fileName = $this->generateRandomString() . $typeFile;
	}

	/**
	 * создать директорию для хранения картинок
	 */
	private function createDir() {
		if ( ! file_exists( "image" ) ) {
			mkdir( "image" );
		}
	}

	/**
	 * получить расширение загруженного файла
	 * @return bool|string
	 */
	private function getTypeFile() {
		return ( substr( $_FILES['file']['name'], strrpos( $_FILES['file']['name'], "." ) ) );
	}

	/**
	 * получить путь хранения файла
	 *
	 * @return string
	 */
	private function getSrcSaveFile() {
		return "image/" . $this->fileName;
	}

	/**
	 * генерация случайной строки для названия картинки
	 *
	 * @return string
	 */
	private function generateRandomString() {
		return md5( uniqid( rand(), true ) );
	}

	/**
	 * сохранить файл
	 *
	 * @param ModelBase $model
	 */
	private function saveFile( ModelBase $model ) {
		if ( ! @copy( $_FILES['file']['tmp_name'], $this->getSrcSaveFile() ) ) {
			$model->addError( "imageFile", "Ошибка сохранения файла" );
		}
	}

	/**
	 * валидация
	 *
	 * @param string $typeFile
	 * @param ModelBase $model
	 *
	 * @return bool
	 */
	private function validateFile( $typeFile, $model ) {
		$validateTypeFile = $this->validateTypeFile( $typeFile, $model );
		if ( $validateTypeFile === false ) {
			return $validateTypeFile;
		}

		$validateSizeFile = $this->validateSizeFile( $model );
		if ( $validateSizeFile === false ) {
			return $validateSizeFile;
		}

		return true;

	}


	/**
	 * валидирует файл по типу
	 * @param string $typeFile
	 * @param ModelBase $model
	 *
	 * @return bool
	 */
	private function validateTypeFile( $typeFile, ModelBase $model ) {
		$types = [ ".jpg", ".png", ".gif" ];

		foreach ( $types as $type ) {
			if ( $type == $typeFile ) {
				return true;
			}
		}
		$model->addError( "imageFile", "Файл имеет недопустимое разрешение" );

		return false;
	}

	/**
	 * валидация файла по размеру
	 *
	 * @param ModelBase $model
	 *
	 * @return bool
	 */
	private function validateSizeFile( ModelBase $model ) {
		if ( $_FILES["file"]["size"] > 1000000 ) {
			$model->addError( "imageFile", "Файл превышает допустимый размер" );

			return false;
		}

		return true;
	}

}