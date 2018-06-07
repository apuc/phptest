<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 07.06.18
 * Time: 12:02
 */

class Language {

	/**
	 * @param string $language
	 * @param string $expression
	 * @param bool $useVariable
	 * @param bool $twoVariable
	 *
	 * @return null|string|string[]
	 */
	public static function trl( $language, $expression, $useVariable = true, $twoVariable = false ) {
		global $defaultLanguage;

		//проверка на язык
		//если языка нет или это русский, то возвращается русский язык
		if ( self::getLanguage( $language ) == $defaultLanguage ) {
			return $expression;
		}

		//проверка на наличие переменных в выражении
		if ( $useVariable ) {
			//проверка на наличие двух переменных в выражении
			if ( $twoVariable ) {

				//вырезание переменных из выражения
				preg_match( '/({([^>]+)})/U', $expression, $matches );
				$columnName = $matches[2];
//				var_dump( $columnName );

				preg_match( '/(<([^>]+)>)/U', $expression, $matches );
				$columnValue = $matches[2];
//				var_dump( $columnValue );


				//замена переменных в выражении на ключевые значения
				$strColumnName = preg_replace( '/({([^>]+)})/U', '{columnName}', $expression );
				$str           = preg_replace( '/(<([^>]+)>)/U', '<columnValue>', $strColumnName );
//				var_dump( $strColumnName );
//				var_dump( $str );

				//получение переведенного значения
				$translate = self::getLanguage( $language )[ $str ];
//				var_dump( $translate );

				//замена ключевых слов на переменные
				$translateColumnName = preg_replace( '/({([^>]+)})/U', $columnName, $translate );
				$translateStr        = preg_replace( '/(<([^>]+)>)/U', $columnValue, $translateColumnName );

				return $translateStr;
			} else {
				preg_match( '/({([^>]+)})/U', $expression, $matches );
//		var_dump($matches);
				$str = preg_replace( '/({([^>]+)})/U', '{columnName}', $expression );

				$translate = self::getLanguage( $language )[ $str ];

				return preg_replace( '/({([^>]+)})/U', $matches[2], $translate );
			}
		} else {
			return preg_replace( "/\{[^\}]*\}/", "", self::getLanguage( $language )[ $expression ] );
		}

	}

	/**
	 * получение массива значений с определенным языком
	 *
	 * @param $language
	 *
	 * @return mixed|string
	 */
	private static function getLanguage( $language ) {
		global $defaultLanguage;
		if ( isset( self::getDictionary()[ $language ] ) ) {
			return self::getDictionary()[ $language ];
		}

		return $defaultLanguage;
	}

	/**
	 * возвращает массив с определенными значениями
	 *
	 * @return array
	 */
	private static function getDictionary() {
		return [

			"en" => [
				"Поле {columnName} обязательно для заполнения"                          => "Required field {columnName}",
				"Ошибка в значении {columnName}. Значение <columnValue> уже существует" => "Error in field {columnName}. Value <columnValue> already exist.",
				"Имя"                                                                   => "Name",
				"Фамилия"                                                               => "Surname",
				"Отчество"                                                              => "Patronymic",
				"Год рождения"                                                          => "Year of birth",
				"Место проживания"                                                      => "Place of residence",
				"Семейное положение"                                                    => "Family status",
				"Образование"                                                           => "Education",
				"Опыт"                                                                  => "Experience",
				"Телефон"                                                               => "Phone",
				"E-mail"                                                                => "E-mail",
				"Информация о себе"                                                     => "Personal information",
				"Картинка"                                                              => "Image",
				"Ошибка сохранения файла: {columnName}"                                 => "Error save image: {columnName}",
				"Файл имеет недопустимое разрешение"                                    => "The file has an invalid resolution",
				"Файл превышает допустимый размер. Можно загрузить файл до 1 мб"        => "The file exceeds the permissible size. You can upload a file up to 1 mb"
			]

		];
	}
}