<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Users */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="users-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'firstname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'lastname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'birthday')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'userstatus')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'hoststatus')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'verify_pass')->textInput() ?>

    <?= $form->field($model, 'verify_passcode')->textInput() ?>

    <?= $form->field($model, 'profile_image')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'state')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'country')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'modified_at')->textInput() ?>

    <?= $form->field($model, 'last_login')->textInput() ?>

    <?= $form->field($model, 'login_type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'facebookid')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'googleid')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'referrer_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'credit_total')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'gender')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'activation')->textInput() ?>

    <?= $form->field($model, 'user_level')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phoneno')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'about')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'school')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'work')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'timezone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'language')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'emergencyno')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'emergencyname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'emergencyemail')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'emergencyrelation')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'shippingid')->textInput() ?>

    <?= $form->field($model, 'workemail')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pushnotification')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'notifications')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'emailsettings')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'socialconnections')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'findability')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'loginnotify')->textInput() ?>

    <?= $form->field($model, 'mobileverify')->textInput() ?>

    <?= $form->field($model, 'verifyno')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'emailverify')->textInput() ?>

    <?= $form->field($model, 'verifycode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'reservationrequirement')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
