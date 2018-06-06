<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 06.06.18
 * Time: 16:32
 */

class Security {
	private $crsf;


	public function __construct() {
		session_start();
		if ( ! $this->validateCreatedAt() ) {
			$this->updateCrsf();
		}

		if ( is_null( $this->crsf ) ) {
			$this->crsf = $_SESSION["crsf"];
		}
	}

	public function getCrsf() {
		return $this->crsf;
	}

	public function updateCrsf(){
		$this->crsf = $this->generateToken();

		$this->setCrsfInSession();
	}

	public function validateCrsf() {
		if ( $this->validateCreatedAt() ) {
			if ( $this->issetCrsfSession() && $this->issetCrsfPost() ) {
				if ( $this->compareCrsfSessionAndCrsfPost() ) {
					return true;
				}
			}
		}

		return false;
	}

	private function setCrsfInSession() {
		$_SESSION["created_at"] = time() + 300;
		$_SESSION["crsf"]       = $this->crsf;
	}

	private function validateCreatedAt() {
		return ( isset( $_SESSION["created_at"] ) && $_SESSION["created_at"] > time() );
	}

	private function issetCrsfSession() {
		return isset( $_SESSION["crsf"] );
	}

	private function issetCrsfPost() {
		return isset( $_POST["crsf"] );
	}

	private function compareCrsfSessionAndCrsfPost() {
		return ( $_SESSION["crsf"] == $_POST["crsf"] );
	}

	private function generateToken() {
		return bin2hex( random_bytes( 32 ) );
	}

}