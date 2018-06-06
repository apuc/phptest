<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 06.06.18
 * Time: 20:43
 */

class UploadImage {

	private $fileName;

	public function __construct() {
		if ( ! empty( $_FILES ) ) {
			$error = $_FILES["file"]["error"];
			if ( $error > 0 ) {
				return "ошибка сохранения файла";
			}

			$this->createDir();
			$typeFile = $this->getTypeFile();
			$this->setFileName( $typeFile );
			$this->saveFile();
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

	private function saveFile() {
		if ( ! @copy( $_FILES['file']['tmp_name'], $this->getSrcSaveFile() ) ) {
			echo "ошибка сохранения файла";
		}
	}

}