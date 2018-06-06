<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 05.06.18
 * Time: 13:25
 */


/**
 * Class Model
 *
 * @property int $id
 * @property $first_name
 * @property $last_name
 * @property $patronymic
 * @property $year_of_birth
 * @property $place_of_residence
 * @property $marital_status
 * @property $education
 * @property $experience
 * @property $phone
 * @property $email
 * @property $information_about_yourself
 *
 */
class Model {

	private $db;
	private $arrayColumns;
	private $arrayNameColumns = [];

	public function __construct( DB_Connection $db ) {

		$this->db = $db;

		$this->arrayColumns = $this->db->getMySqlResult( $this->db->getTable() )->fetch_fields();

		foreach ( $this->arrayColumns as $column ) {
			$nameColumns              = get_object_vars( $column )["name"];
			$this->arrayNameColumns[] = $nameColumns;
			$this->$nameColumns       = null;
		}

	}


	/**
	 * выводит леблы к полям
	 *
	 * @param null|string $key
	 *
	 * @return array|mixed
	 */
	public function getLabels( $key = null ) {
		$labels = [
			"first_name"                 => "Имя",
			"last_name"                  => "Фамилия",
			"patronymic"                 => "Отчество",
			"year_of_birth"              => "Год рождения",
			"place_of_residence"         => "Место проживания",
			"marital_status"             => "Семейное положение",
			"education"                  => "Образование",
			"experience"                 => "Опыт",
			"phone"                      => "Телефон",
			"email"                      => "E-mail",
			"information_about_yourself" => "Информация о себе"
		];

		return isset( $labels[ $key ] ) ? $labels[ $key ] : $labels;
	}


	/**
	 * правила валидации для полей
	 * @return array
	 */
	public function rules() {
		return [
			[
				[
					"first_name",
					"last_name",
					"patronymic",
					"place_of_residence",
					"education",
					"experience",
					"phone",
					"email",
					"information_about_yourself"
				],
				"string"
			],
			[
				[
					"year_of_birth",
					"id",
					"marital_status"
				],
				"integer"
			]
		];
	}

	/**
	 * сохранение строчки
	 * @return bool|mysqli_result
	 */
	public function save() {

		$validate = $this->validate();

		if ( $validate !== true ) {
			return $validate;
		}

		$columns = implode( ", ", $this->arrayNameColumns );
		$value   = [];

		foreach ( $this->arrayNameColumns as $key => $column ) {


			$value[] = ( $this->$column == null ) ? "null" : "'" . $this->$column . "'";


		}

		$value = implode( ", ", $value );


		$query = "INSERT INTO {$this->db->getTable()} ({$columns}) VALUES ({$value})";


		return $this->db->getMysql()->query( $query );
	}

	/**
	 * выборка всех значение из таблицы
	 * @return mixed
	 */
	public function getAll() {
		return $this->db->getMySqlResult( $this->db->getTable() )->fetch_all();
	}

	public function getArrayNameColumns() {
		return $this->arrayNameColumns;
	}


	public function validate() {
		foreach ( $this->rules() as $rule ) {
			$nameFunction = $rule[1];
			if ( $this->$nameFunction( $rule[0] ) !== true ) {
				return $this->$nameFunction( $rule[0] );
			}
		}

		return true;
	}


	/**
	 * правило валидации для строковых переменных
	 *
	 * @param $arguments
	 *
	 * @return bool|string
	 */
	public function string( $arguments ) {
		foreach ( $arguments as $argument ) {
			if ( ! is_string( $this->$argument ) ) {
				return "Ошибка в значении '{$this->getLabels($argument)}'. Значение должно быть строкой";
			}

			if ( strlen( $this->$argument ) > 255 ) {
				return "Ошибка в значении '{$this->getLabels($argument)}'. Значение должно содержать не более 255 символов";
			}
		}

		return true;
	}

	/**
	 * правило валидации для числовых значений
	 *
	 * @param $arguments
	 *
	 * @return bool|string
	 */
	public function integer( $arguments ) {
		foreach ( $arguments as $argument ) {
			$this->$argument = (integer)$this->$argument;
			if ( ! is_int( $this->$argument ) ) {
				return "Ошибка в значении '{$this->getLabels($argument)}'. Значение должно быть цифрой";
			}
		}

		return true;

	}


	public function load() {
		foreach ( $_POST as $key => $item ) {
			$this->$key = $item;
		}
	}

}