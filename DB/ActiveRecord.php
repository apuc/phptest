<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 06.06.18
 * Time: 14:33
 */

class ActiveRecord {
	private $query;


	public static function find() {
		return new self;
	}

	/**
	 * задает выбор выводимых полей
	 *
	 * @param string|array $columns
	 *
	 * @return ActiveRecord
	 */
	public function select( $columns ) {
		$this->query = "SELECT ";
		if ( is_string( $columns ) ) {
			$this->query .= $columns;
		}

		if ( is_array( $columns ) ) {
			$this->query .= implode( ", ", $columns );
		}

		$this->query .= " FROM ";

		return $this;
	}


	/**
	 * указываем таблицу из которой выбираем
	 *
	 * @param string $table
	 *
	 * @return ActiveRecord
	 */
	public function table( $table ) {
		$this->query .= "`{$table}`";

		return $this;
	}

	/**
	 * задает условие для поиска
	 *
	 * @param array $options
	 *
	 * @return ActiveRecord
	 */
	public function where( array $options ) {
		$query = " WHERE ";
		foreach ( $options as $key => $option ) {
			$query .= "`{$key}` = '{$option}'";
		}

		$this->query .= $query;

		return $this;

	}

	/**
	 * вставка значения в базу
	 *
	 * @param string $table
	 * @param string $columns
	 * @param string $values
	 *
	 * @return $this
	 */
	public function insert($table, $columns, $values){
		$this->query = "INSERT INTO `{$table}` ({$columns}) VALUES ({$values})";
		return $this;
	}

	/**
	 * получить строку запроса
	 * @return string
	 */
	public function getQuery(){
		return $this->query;
	}
}