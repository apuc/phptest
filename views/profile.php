<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 07.06.18
 * Time: 17:20
 *
 * @var array $data
 * @var ModelBase $model
 */
$model = $data[0];
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
    <title>Document</title>
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col">
            <img src="image/<?= $model->image ?>" height="240" alt="">
        </div>
        <div class="col">
            <p><?= $model->getLabels( "first_name" ) ?>
                : <?= $model->first_name ?> <?= $model->last_name ?> <?= $model->patronymic ?></p>
            <p>
				<?= $model->getLabels( "year_of_birth" ) ?> : <?= $model->year_of_birth ?>
            </p>
            <p>
				<?= $model->getLabels( "marital_status" ) ?>
                : <?= $model->getMartialStatus( $model->marital_status ); ?>
            </p>
            <p>
				<?= $model->getLabels( "education" ) ?> : <?= $model->getEducation( $model->education ) ?>
            </p>
            <p><?= $model->getLabels( "experience" ) ?> : <?= $model->experience ?></p>
            <p><?= $model->getLabels( "place_of_residence" ) ?> : <?= $model->place_of_residence ?></p>

			<?php if ( $model->phone ): ?>
                <p><?= $model->getLabels( "phone" ) ?> : <?= $model->phone ?></p>
			<?php endif; ?>
			<?php if ( $model->email ): ?>
                <p><?= $model->getLabels( "email" ) ?> : <?= $model->email ?></p>
			<?php endif; ?>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col">
			<?= $model->getLabels( "information_about_yourself" ) ?> : <?= $model->information_about_yourself ?>
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
</body>

<style>
    body {
        background-color: #edeef0;
    }

    img {
        height: 240px;
        display: block;
        margin: 0 auto;
    }

    p {
        margin-bottom: 10px;
    }
</style>
</html>
