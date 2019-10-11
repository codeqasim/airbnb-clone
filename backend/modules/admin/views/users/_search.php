<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Userssearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="users-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'firstname') ?>

    <?= $form->field($model, 'lastname') ?>

    <?= $form->field($model, 'username') ?>

    <?= $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'password') ?>

    <?php // echo $form->field($model, 'birthday') ?>

    <?php // echo $form->field($model, 'userstatus') ?>

    <?php // echo $form->field($model, 'hoststatus') ?>

    <?php // echo $form->field($model, 'verify_pass') ?>

    <?php // echo $form->field($model, 'verify_passcode') ?>

    <?php // echo $form->field($model, 'profile_image') ?>

    <?php // echo $form->field($model, 'address1') ?>

    <?php // echo $form->field($model, 'address2') ?>

    <?php // echo $form->field($model, 'city') ?>

    <?php // echo $form->field($model, 'state') ?>

    <?php // echo $form->field($model, 'country') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'modified_at') ?>

    <?php // echo $form->field($model, 'last_login') ?>

    <?php // echo $form->field($model, 'login_type') ?>

    <?php // echo $form->field($model, 'facebookid') ?>

    <?php // echo $form->field($model, 'googleid') ?>

    <?php // echo $form->field($model, 'referrer_id') ?>

    <?php // echo $form->field($model, 'credit_total') ?>

    <?php // echo $form->field($model, 'gender') ?>

    <?php // echo $form->field($model, 'activation') ?>

    <?php // echo $form->field($model, 'user_level') ?>

    <?php // echo $form->field($model, 'phoneno') ?>

    <?php // echo $form->field($model, 'about') ?>

    <?php // echo $form->field($model, 'school') ?>

    <?php // echo $form->field($model, 'work') ?>

    <?php // echo $form->field($model, 'timezone') ?>

    <?php // echo $form->field($model, 'language') ?>

    <?php // echo $form->field($model, 'emergencyno') ?>

    <?php // echo $form->field($model, 'emergencyname') ?>

    <?php // echo $form->field($model, 'emergencyemail') ?>

    <?php // echo $form->field($model, 'emergencyrelation') ?>

    <?php // echo $form->field($model, 'shippingid') ?>

    <?php // echo $form->field($model, 'workemail') ?>

    <?php // echo $form->field($model, 'pushnotification') ?>

    <?php // echo $form->field($model, 'notifications') ?>

    <?php // echo $form->field($model, 'emailsettings') ?>

    <?php // echo $form->field($model, 'socialconnections') ?>

    <?php // echo $form->field($model, 'findability') ?>

    <?php // echo $form->field($model, 'loginnotify') ?>

    <?php // echo $form->field($model, 'mobileverify') ?>

    <?php // echo $form->field($model, 'verifyno') ?>

    <?php // echo $form->field($model, 'emailverify') ?>

    <?php // echo $form->field($model, 'verifycode') ?>

    <?php // echo $form->field($model, 'reservationrequirement') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
