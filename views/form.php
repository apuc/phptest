<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 05.06.18
 * Time: 16:05'
 * @var $data array
 * @var $model ModelBase
 */

//include( "Model/Language.php" );
global $language;
global $defaultLanguage;
$model     = $data[0];
$viewModal = $data[1];


if ( $language == $defaultLanguage ) {
	$url = "/?lang=en";

} else {
	$language = "en";
	$url      = "/?lang=ru";
}

?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css"
          integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <title>Форма регистрации</title>
</head>
<body>
<form id="form" role="form" action="../index.php?lang=<?= $language ?>" method="post" class="needs-validation form-registration"
      novalidate
      enctype="multipart/form-data">
    <div class="container">
        <div class="row">
            <input type="hidden" name="crsf" value="<?= $model->crsfSecurity->getCrsf() ?>">
            <div class="form-group col-md-4">
                <label for="first_name"><?= $model->getLabels( "first_name" ) ?></label>
                <input name="first_name" type="text" class="form-control border-radius form-registration_input"
                       value="<?= $model->first_name ?>" required/>
                <div class="invalid-feedback">

					<?= Language::trl( $language, "Поле {" . $model->getLabels( "first_name" ) . "} обязательно для заполнения" ) ?>

                </div>
            </div>

            <div class="form-group col-md-4">
                <label for="last_name"><?= $model->getLabels( "last_name" ) ?></label>
                <input name="last_name" type="text" class="form-control border-radius form-registration_input"
                       value="<?= $model->last_name ?>" required/>
                <div class="invalid-feedback">
					<?= Language::trl( $language, "Поле {" . $model->getLabels( "last_name" ) . "} обязательно для заполнения" ) ?>
                </div>
            </div>

            <div class="form-group col-md-4">
                <label for="patronymic"><?= $model->getLabels( "patronymic" ) ?></label>
                <input name="patronymic" type="text" class="form-control border-radius form-registration_input"
                       value="<?= $model->patronymic ?>" required/>
                <div class="invalid-feedback">
					<?= Language::trl( $language, "Поле {" . $model->getLabels( "patronymic" ) . "} обязательно для заполнения" ) ?>
                </div>
            </div>

            <div class="form-group col-md-4">
                <label for="year_of_birth"><?= $model->getLabels( "year_of_birth" ) ?></label>
                <input name="year_of_birth" type="date" class="form-control border-radius form-registration_input"
                       value="<?= $model->year_of_birth ?>" required/>
                <div class="invalid-feedback">
					<?= Language::trl( $language, "Поле {" . $model->getLabels( "year_of_birth" ) . "} обязательно для заполнения" ) ?>
                </div>
            </div>

            <div class="form-group col-md-4">
                <label for="marital_status"><?= $model->getLabels( "marital_status" ) ?></label>
                <!--<input name="marital_status" type="text" class="form-control"
                   value="<? /*= $model->marital_status */ ?>" required/>-->

                <div class="select-div">
                    <select name="marital_status" class="form-control border-radius form-registration_input" required>

						<?php foreach ( $model->getMartialStatus() as $key => $value ): ?>
                            <option value="<?= $key ?>"><?= $value ?></option>
						<?php endforeach; ?>
                    </select>
                </div>
                <div class="invalid-feedback">
					<?= Language::trl( $language, "Поле {" . $model->getLabels( "marital_status" ) . "} обязательно для заполнения" ) ?>
                </div>
            </div>

            <div class="form-group col-md-4">
                <label for="place_of_residence"><?= $model->getLabels( "place_of_residence" ) ?></label>
                <input name="place_of_residence" type="text" class="form-control border-radius form-registration_input"
                       value="<?= $model->place_of_residence ?>" required/>
                <div class="invalid-feedback">
					<?= Language::trl( $language, "Поле {" . $model->getLabels( "place_of_residence" ) . "} обязательно для заполнения" ) ?>
                </div>
            </div>

            <div class="form-group col-md-4">
                <label for="education"><?= $model->getLabels( "education" ) ?></label>
                <!--            <input name="education" type="text" class="form-control"-->
                <!--                   value="<? //= $model->education ?>--><!--" required/>-->

                <div class="select-div">
                    <select name="education" class="form-control border-radius form-registration_input" required>
						<?php foreach ( $model->getEducation() as $key => $value ): ?>
                            <option value="<?= $key ?>"><?= $value ?></option>
						<?php endforeach; ?>
                    </select>
                </div>


                <div class="invalid-feedback">
					<?= Language::trl( $language, "Поле {" . $model->getLabels( "education" ) . "} обязательно для заполнения" ) ?>
                </div>
            </div>

            <div class="col-md-4">
                <label for="experience"><?= $model->getLabels( "experience" ) ?></label>
                <input name="experience" type="text" class="form-control border-radius form-registration_input"
                       value="<?= $model->experience ?>" required/>
                <div class="invalid-feedback">
					<?= Language::trl( $language, "Поле {" . $model->getLabels( "experience" ) . "} обязательно для заполнения" ) ?>
                </div>
            </div>

            <div class="form-group col-md-4">
                <label for="phone"><?= $model->getLabels( "phone" ) ?></label>
                <input name="phone" type="text"
                       class="form-control border-radius form-registration_input <?php if ( $model->isError( "phone" ) ): ?>form-control-invalid<?php endif; ?>"
                       min="16"
                       value="<?= ( $model->isError( "phone" ) ) ? "" : $model->phone ?>"/>
                <div class="invalid-feedback">

					<?php if ( $model->isError( "phone" ) ): ?>
						<?= trim( $model->getError( "phone" ) ) ?>
					<?php else: ?>
						<?= Language::trl( $language, "Поле {" . $model->getLabels( "phone" ) . "} обязательно для заполнения" ) ?>
					<?php endif; ?>
                </div>
            </div>

            <div class="form-group col-md-4">
                <label for="email"><?= $model->getLabels( "email" ) ?></label>
                <input name="email" type="email"
                       class="form-control border-radius form-registration_input <?php if ( $model->isError( "email" ) ): ?>form-control-invalid<?php endif; ?>"
                       value="<?= $model->email ?>"/>
                <div class="invalid-feedback">

					<?php if ( $model->isError( "email" ) ): ?>
						<?= trim( $model->getError( "email" ) ) ?>
					<?php else: ?>
                        Укажите Ваш email
					<?php endif; ?>
                </div>
            </div>

            <div class="form-group col-md-4">
                <label for="information_about_yourself"><?= $model->getLabels( "information_about_yourself" ) ?></label>
                <input name="information_about_yourself" type="text"
                       class="form-control border-radius form-registration_input"
                       value="<?= $model->information_about_yourself ?>" required/>
                <div class="invalid-feedback">
					<?= Language::trl( $language, "Поле {" . $model->getLabels( "information_about_yourself" ) . "} обязательно для заполнения" ) ?>
                </div>
            </div>
            <div class="form-group col-md-4">
                <label for="file"><?= $model->getLabels( "image" ) ?></label>
                <input name="file" type="file" required
                       class="form-control border-radius form-registration_input <?php if ( $model->isError( "imageFile" ) ): ?>form-control-invalid<?php endif; ?>"/>

                <div class="invalid-feedback">
					<?php if ( $model->isError( "imageFile" ) ): ?>
						<?= trim( $model->getError( "imageFile" ) ) ?>
					<?php else: ?>
						<?= Language::trl( $language, "Поле {" . $model->getLabels( "imageFile" ) . "} обязательно для заполнения" ) ?>
					<?php endif; ?>
                </div>

            </div>


        </div>
        <div class="form-group text-center">
            <input type="submit" class="btn btn-info border-radius" value="Отправить"/>

            <a href="<?= $url ?>" class="btn btn-primary border-radius">
				<?php if ( $language == $defaultLanguage ) {
					echo "Переключить на английский";

				} else {
					echo "Переключить на русский";
				} ?>
            </a>
        </div>
    </div>
</form>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ошибка отправки формы</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                На сервере возникла ошибка во время обработки данных. Пожалуйста введите данные заново.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>


<script
        src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"
        integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm"
        crossorigin="anonymous"></script>

<?php if ( $viewModal ): ?>
    <script>
        $('#exampleModal').modal('show')
    </script>
<?php endif; ?>

<script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function () {
        'use strict';

        var phone = $("input[name=phone]"),
            email = $("input[name=email]"),
            input = $("#form").find('input');

        window.addEventListener('load', function () {

            //валидация от бутстрапа
            $(".needs-validation").submit(function (event) {

                if (phone.val().indexOf("_") > 0) {
                    var phoneVal = phone.val();
                    phone.val("");
                }

                //
                if (phone.val().length === 0 && email.val().length === 0) {
                    phone.attr('required', 'required');
                    email.attr('required', 'required');
                } else if (phone.val().length > 0 || email.val().length > 0) {
                    phone.removeAttr('required');
                    email.removeAttr('required');

                }

                if ($(this)[0].checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                //
                $(this).addClass("was-validated");

            });

            //маска для телефона
            function setCursorPosition(pos, elem) {
                elem.focus();
                if (elem.setSelectionRange) elem.setSelectionRange(pos, pos);
                else if (elem.createTextRange) {
                    var range = elem.createTextRange();
                    range.collapse(true);
                    range.moveEnd("character", pos);
                    range.moveStart("character", pos);
                    range.select()
                }
            }

            function mask(event) {
                var matrix = this.defaultValue,
                    i = 0,
                    def = matrix.replace(/\D/g, ""),
                    val = this.value.replace(/\D/g, "");
                def.length >= val.length && (val = def);
                matrix = matrix.replace(/[_\d]/g, function (a) {
                    return val.charAt(i++) || "_"
                });
                this.value = matrix;
                i = matrix.lastIndexOf(val.substr(-1));
                i < matrix.length && matrix !== this.defaultValue ? i++ : i = matrix.indexOf("_");
                setCursorPosition(i, this)
            }


            phone[0].addEventListener("input", mask, false);


            //активация маски при фокусе
            phone.focus(function () {
                var val = "+38(___)___-____";

                if ($(this).val() === val || $(this).val().length === 0) {
                    this.defaultValue = val;
                    $(this).val(val);
                    $(this)[0].addEventListener("input", mask, false);
                }

            });

            //деактивация маски при блуре, если пользователь не ввел свои значения
            phone.blur(function () {
                var val = "+38(___)___-____";

                if ($(this).val() === val) $(this).val("");

            });


            if (input.hasClass("form-control-invalid")) {
                $(".form-control-invalid").next().show();
            }


        }, false);
    })();
</script>

<style>
    .form-control-invalid {
        border: 1px solid #dc3545;
    }

    .form-registration_input {
        background-color: #eff0f4;

    }

    .border-radius {
        border-radius: 20px;
    }

    .select-div {
        position: relative;

    }

    .select-div::before {
        content: ">";
        position: absolute;
        right: 20px;
        transform: rotate(90deg);
        top: 5px;
        z-index: 20;
    }

    select {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        position: relative;
    }

    @media (max-width: 349px) {
        input[type=submit] {
            margin-bottom: 15px;
        }
    }

</style>

</body>
</html>

