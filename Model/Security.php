<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 06.06.18
 * Time: 16:32
 */

/**
 * Class Security
 *
 * @property string $crsf
 */
class Security {
	private $crsf;


	/**
	 * Security constructor.
	 * @throws Exception
	 */
	public function __construct() {
		session_start();
//		var_dump(time());
//		var_dump($_SESSION);die;
		if ( ! $this->validateCreatedAt() ) {
			$this->updateCrsf();
		}

		if ( is_null( $this->crsf ) ) {
			$this->crsf = $_SESSION["crsf"];
		}
	}

	/**
	 * получить crsf
	 * @return string
	 */
	public function getCrsf() {
		return $this->crsf;
	}

	/**
	 * обновить crsf
	 * @throws Exception
	 */
	public function updateCrsf(){
		$this->crsf = $this->generateToken();

		$this->setCrsfInSession();
	}

	/**
	 * валидация crsf
	 * @return bool
	 */
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

	/**
	 * установить crsf в сессии
	 */
	private function setCrsfInSession() {
		$_SESSION["created_at"] = time() + 300;
		$_SESSION["crsf"]       = $this->crsf;
	}

	/**
	 * валидация crsf по дате создания
	 * @return bool
	 */
	private function validateCreatedAt() {
		return ( isset( $_SESSION["created_at"] ) && $_SESSION["created_at"] > time() );
	}

	/**
	 * проверка наличия crsf в сессии
	 * @return bool
	 */
	private function issetCrsfSession() {
		return isset( $_SESSION["crsf"] );
	}

	/**
	 * проверка наличия crsf в почте
	 * @return bool
	 */
	private function issetCrsfPost() {
		return isset( $_POST["crsf"] );
	}

	/**
	 * сравнение crsf из сессии и почты
	 * @return bool
	 */
	private function compareCrsfSessionAndCrsfPost() {
		return ( $_SESSION["crsf"] == $_POST["crsf"] );
	}

	/**
	 * генерация случайно строки
	 * @return string
	 * @throws Exception
	 */
	private function generateToken() {
		return bin2hex( random_bytes( 32 ) );
	}

}