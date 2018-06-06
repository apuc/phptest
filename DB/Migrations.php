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


	public function primaryKey( $name ) {
		$this->query .= "{$name} INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, ";

		return $this;
	}

	public function string( $name, $length = 255, $notNull = true ) {
		$this->query .= "{$name} VARCHAR({$length}) {$this->notNull($notNull)}, ";

		return $this;
	}

	public function notNull( $isNotNull ) {
		if ( $isNotNull ) {
			$notNull = "NOT NULL";
		} else {
			$notNull = "";
		}

		return $notNull;
	}

	public function int( $name, $length, $notNull = true ) {
		$this->query .= "{$name} INT({$length}) {$this->notNull($notNull)}, ";

		return $this;
	}

	public function text( $name, $notNull = true ) {
		$this->query .= "{$name} TEXT {$this->notNull($notNull)}, ";

		return $this;
	}

}