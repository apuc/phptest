<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 05.06.18
 * Time: 11:58
 */

class Migrations {

	private $query;


	/**
	 * создание таблицы
	 *
	 * @param string $tableName
	 * @param array $columns
	 *
	 * @return bool|string
	 */
	public function createTable( $tableName, array $columns ) {
		$query = "CREATE TABLE {$tableName}(";
		$query .= $this->query;
		$query = substr($query, 0, -2);
		$query .= ")";
		return $query;
	}


	/**
	 * @param $name
	 *
	 * @return $this
	 */
	public function primaryKey( $name ) {
		$this->query .= "{$name} INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, ";

		return $this;
	}

	/**
	 * генерация строкового столбца
	 * @param $name
	 * @param int $length
	 * @param bool $notNull
	 *
	 * @return $this
	 */
	public function string( $name, $length = 255, $notNull = false ) {
		$this->query .= "{$name} VARCHAR({$length}) {$this->notNull($notNull)}, ";

		return $this;
	}

	/**
	 * указывает будет ли столбец равнятся null или нет
	 *
	 * @param bool $isNotNull
	 *
	 * @return string
	 */
	public function notNull( $isNotNull ) {
		if ( $isNotNull ) {
			$notNull = "NOT NULL";
		} else {
			$notNull = "";
		}

		return $notNull;
	}

	/**
	 * генерация числового столбца
	 *
	 * @param $name
	 * @param $length
	 * @param bool $notNull
	 *
	 * @return $this
	 */
	public function int( $name, $length, $notNull = false ) {
		$this->query .= "{$name} INT({$length}) {$this->notNull($notNull)}, ";

		return $this;
	}

	/**
	 * генерация текстового столбца
	 * @param $name
	 * @param bool $notNull
	 *
	 * @return $this
	 */
	public function text( $name, $notNull = false ) {
		$this->query .= "{$name} TEXT {$this->notNull($notNull)}, ";

		return $this;
	}

}