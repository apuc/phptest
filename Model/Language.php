<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 07.06.18
 * Time: 12:02
 */

class Language {

	public static function trl( $language, $expression, $useVariable = true ) {
		if ($language == "ru"){
			return $expression;
		}
		if ( $useVariable ) {
			preg_match( '/({([^>]+)})/U', $expression, $matches );
//		var_dump($matches);
			$str = preg_replace( '/({([^>]+)})/U', '{test}', $expression );

			$translate = self::getDictionary()[ $language ][ $str ];

			return preg_replace( '/({([^>]+)})/U', $matches[2], $translate );
		} else {
			return preg_replace("\{[^\}]*\}", "", self::getDictionary()[ $language ][ $expression ]);
		}

	}

	private static function getDictionary() {
		return [

			"en" => [
				"Поле {test} обязательно для заполнения" => "Required field {test}",
				"Имя"                                    => "Name",
				"Фамилия"                                => "Surname",
				"Отчество"                               => "Patronymic",
				"Год рождения"                           => "Year of birth",
				"Место проживания"                       => "Place of residence",
				"Семейное положение"                     => "Family status",
				"Образование"                            => "Education",
				"Опыт"                                   => "Experience",
				"Телефон"                                => "Phone",
				"E-mail"                                 => "E-mail",
				"Информация о себе"                      => "Personal information",
				"Картинка"                               => "Image"
			]

		];
	}
}