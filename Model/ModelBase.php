<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 05.06.18
 * Time: 13:25
 */

include( "DB/ActiveRecord.php" );
include( "Model/Language.php" );
//include ("Model/Security.php");

/**
 * Class ModelBase
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $patronymic
 * @property string $year_of_birth
 * @property string $place_of_residence
 * @property int $marital_status
 * @property int $education
 * @property string $experience
 * @property string $phone
 * @property string $email
 * @property string $information_about_yourself
 * @property string $image
 *
 *
 *
 * @property $imageFile
 * в свойство $imageFile записываются все ошибки связанные с валидацией картинки
 *
 * @property $crsf
 * @property $crsfSecurity Security
 *
 * свойства $crsf, $crsfSecurity нужны для работы crsf защиты
 *
 *
 * @property array $errors
 * массив с ошибками валидации
 *
 * @property DB_Connection $db экземпляр класса соединения с базой данных
 *
 * @property array $arrayColumns массив колонок, которые есть в таблице
 *
 * @property array $arrayNameColumns массив с именем колонок таблицы
 *
 */
class ModelBase {

	private $db;
	private $arrayColumns;
	private $arrayNameColumns = [];
	private $errors = [];
	public $crsfSecurity;
	public $crsf;
	public $image;
	public $imageFile;

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
		global $language;
		$labels = [
			"first_name"                 => Language::trl( $language, "Имя", false ),
			"last_name"                  => Language::trl( $language, "Фамилия", false ),
			"patronymic"                 => Language::trl( $language, "Отчество", false ),
			"year_of_birth"              => Language::trl( $language, "Год рождения", false ),
			"place_of_residence"         => Language::trl( $language, "Место проживания", false ),
			"marital_status"             => Language::trl( $language, "Семейное положение", false ),
			"education"                  => Language::trl( $language, "Образование", false ),
			"experience"                 => Language::trl( $language, "Опыт", false ),
			"phone"                      => Language::trl( $language, "Телефон", false ),
			"email"                      => Language::trl( $language, "E-mail", false ),
			"",
			"information_about_yourself" => Language::trl( $language, "Информация о себе", false ),
			"image"                      => Language::trl( $language, "Картинка", false ),
			"imageFile"                  => Language::trl( $language, "Картинка", false ),
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
//					"image",
					"year_of_birth",
					"information_about_yourself"
				],
				"string"
			],
			[
				[
					"id",
					"marital_status"
				],
				"integer"
			],

			[
				[
					"email",
					"phone"
				],
				"unique"
			],

			[
				[
					"imageFile"
				],
				"image"
			]
		];
	}

	/**
	 * сохранение данных в бд
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


//		$query = "INSERT INTO {$this->db->getTable()} ({$columns}) VALUES ({$value})";


		$query = ActiveRecord::find()->insert( $this->db->getTable(), $columns, $value )->getQuery();


//		var_dump($query);die;

		return $this->db->getMysql()->query( $query );
	}

	/**
	 * выборка всех значение из таблицы
	 * @return mixed
	 */
	public function getAll() {
		return $this->db->getMySqlResult( $this->db->getTable() )->fetch_all();
	}

	/**
	 * получить массив с названиями колонок
	 * @return array
	 */
	public function getArrayNameColumns() {
		return $this->arrayNameColumns;
	}

	/**
	 * валидация полей, в случае ошибки выводит массив с ошибками
	 * @return array|bool
	 */
	public function validate() {
		foreach ( $this->rules() as $rule ) {
			$nameFunction = $rule[1];

//			if ( $this->$nameFunction( $rule[0] ) !== true ) {
////				return $this->$nameFunction( $rule[0] );
//				return $this->errors;
//			}
			$this->$nameFunction( $rule[0] );
		}

		if ( ! empty( $this->errors ) ) {
			return $this->errors;
		}

		return true;
	}

	/**
	 * получить определенную ошибку из общего массива ошибок
	 *
	 * @param $argument
	 *
	 * @return mixed
	 */
	public function getError( $argument ) {
		return $this->errors[ $argument ];
	}

	/**
	 * проверить наличие ошибки в массиве
	 *
	 * @param $argument
	 *
	 * @return bool
	 */
	public function isError( $argument ) {
		return array_key_exists( $argument, $this->errors );
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
				$this->errors[ $argument ] = "Ошибка в значении '{$this->getLabels($argument)}'. Значение должно быть строкой";

				return false;
//				return "Ошибка в значении '{$this->getLabels($argument)}'. Значение должно быть строкой";
			}

			if ( strlen( $this->$argument ) > 255 ) {
				$this->errors[ $argument ] = "Ошибка в значении '{$this->getLabels($argument)}'. Значение должно содержать не более 255 символов";

				return false;
//				return "Ошибка в значении '{$this->getLabels($argument)}'. Значение должно содержать не более 255 символов";
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
			$this->$argument = (integer) $this->$argument;
			if ( ! is_int( $this->$argument ) ) {
				$this->errors[ $argument ] = "Ошибка в значении '{$this->getLabels($argument)}'. Значение должно быть цифрой";

				return false;
//				return "Ошибка в значении '{$this->getLabels($argument)}'. Значение должно быть цифрой";
			}
		}

		return true;

	}

	/**
	 * правило валидации для уникального значения
	 *
	 * @param $arguments
	 *
	 * @return bool|string
	 */
	public function unique( $arguments ) {
		global $language;
		foreach ( $arguments as $argument ) {

			$query  = ActiveRecord::find()->select( "*" )->table( $this->db->getTable() )->where( [ $argument => $this->$argument ] )->getQuery();
			$result = $this->db->getMysql()->query( $query )->fetch_all();
			if ( ! empty( $result ) ) {
				$this->errors[ $argument ] = Language::trl( $language, "Ошибка в значении {'{$this->getLabels($argument)}'}. Значение <{$this->$argument}> уже существует", true, true );

				return false;

//				return "Ошибка в значении '{$this->getLabels($argument)}'. Значение {$this->$argument} уже существует";
			}
		}

		return true;

	}

	/**
	 * правило валидации для картинки
	 *
	 * @param $arguments
	 *
	 * @return bool|mixed
	 */
	public function image( $arguments ) {
		foreach ( $arguments as $argument ) {
			if ( isset( $this->errors[ $argument ] ) ) {
				return $this->errors[ $argument ];
			}
		}

		return true;
	}

	/**
	 * добавление своих ошибок
	 *
	 * @param $argument
	 * @param $stringError
	 */
	public function addError( $argument, $stringError ) {
		$this->errors[ $argument ] = $stringError;
	}


	/**
	 * загрузка данных в модель
	 */
	public function load() {

		foreach ( $_POST as $key => $item ) {
			$this->$key = $item;
		}
	}

}