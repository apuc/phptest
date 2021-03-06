<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 05.06.18
 * Time: 9:56
 */

/**
 * Class DB_Connection
 *
 * класс для подключения к базе данных
 *
 */


require_once "Migrations.php";

class DB_Connection {


	private $mysql;
	private $table;

	/**
	 * DB_Connection constructor.
	 *
	 * @param string $host
	 * @param string $username
	 * @param string $password
	 * @param string $dbname
	 * @param null|integer $port
	 * @param null|string $socket
	 */
	public function __construct( $host, $username, $password, $dbname, $port = null, $socket = null ) {

		$this->mysql = new mysqli( $host, $username, $password, $dbname, $port, $socket );
		$this->mysql->set_charset( 'utf8' );


		if ( $this->mysql->error ) {
			echo "Ошибка подключения к базе " . $this->mysql->error;
		} else {
			$this->table = "test_table";
			$this->createTable( $this->table );
		}

	}

	public function getMysql() {
		return $this->mysql;
	}


	public function getTable() {
		return $this->table;
	}

	public function getMysqlResult( $tableName ) {
		$getAllRows = "SELECT * FROM {$tableName}";

		$result = $this->mysql->query( $getAllRows );

		return $result;
	}

	/**
	 * создание таблицы
	 *
	 * @param string $tableName
	 *
	 * @return string
	 */
	private function createTable( $tableName ) {
		$result = "false";
		if ( $this->issetTable( $tableName ) ) {

			if ( $this->mysql->query( $this->getQuery( $tableName ) ) === true ) {
				$result = "true";
			} else {
//			var_dump($this->mysql->error);
				$result = "false";
			}
		}

		return $result;

	}

	/**
	 * генерирует текст запроса для создания таблицыш
	 *
	 * @param string $tableName
	 *
	 * @return bool|string
	 */
	private function getQuery( $tableName ) {
		$migrate = new Migrations();

		$query = $migrate->createTable( $tableName, [
			$migrate->primaryKey( "id" ),
			$migrate->string( "first_name" ),
			$migrate->string( "last_name" ),
			$migrate->string( "patronymic" ),
			$migrate->string( "year_of_birth" ),
			$migrate->string( "place_of_residence" ),
			$migrate->string( "image" ),
			$migrate->int( "marital_status", 6 ),
			$migrate->string( "education" ),
			$migrate->string( "experience" ),
			$migrate->string( "phone" ),
			$migrate->string( "email" ),
			$migrate->text( "information_about_yourself" )
		] );

		return $query;
	}

	/**
	 * проверка на существование таблицы в базе данных
	 *
	 * @param $tableName
	 *
	 * @return bool
	 */
	private function issetTable( $tableName ) {


		if ( $this->getMysqlResult( $tableName ) === false ) {
			return true;
		} else {
//			var_dump($result->fetch_all());
//			var_dump( $result->fetch_fields() );
			return false;
		}
	}


}