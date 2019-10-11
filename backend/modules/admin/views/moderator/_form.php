<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use backend\models\Roleandprivilige;

/* @var $this yii\web\View */
/* @var $model backend\models\Users */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="users-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->field($model, 'firstname')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'lastname')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

    <?php //echo $form->field($model, 'birthday')->textInput(['maxlength' => true]) ?>

    <?php //echo $form->field($model, 'userstatus')->textInput(['maxlength' => true]) ?>

    <?php //echo $form->field($model, 'hoststatus')->textInput(['maxlength' => true]) ?>

    <?php //echo $form->field($model, 'verify_pass')->textInput() ?>

    <?php echo $form->field($model, 'verify_passcode')->hiddenInput(['value'=>0])->label(false); ?>
    <?php echo $form->field($model, 'userstatus')->hiddenInput(['value'=>2])->label(false); ?>

    <?php //echo $form->field($model, 'profile_image')->textInput(['maxlength' => true]) ?>

    <?php //echo $form->field($model, 'address1')->textInput(['maxlength' => true]) ?>

    <?php //echo $form->field($model, 'address2')->textInput(['maxlength' => true]) ?>

    <?php //echo $form->field($model, 'city')->textInput(['maxlength' => true]) ?>

    <?php //echo $form->field($model, 'state')->textInput(['maxlength' => true]) ?>

    <?php //echo $form->field($model, 'country')->textInput() ?>

    <?php echo $form->field($model, 'created_at')->hiddenInput(['value'=>date('Y-m-d h:i:s')])->label(false); ?>

    <?php //echo $form->field($model, 'modified_at')->textInput() ?>

    <?php //echo $form->field($model, 'last_login')->textInput() ?>

    <?php //echo $form->field($model, 'login_type')->textInput(['maxlength' => true]) ?>

    <?php //echo $form->field($model, 'facebookid')->textInput(['maxlength' => true]) ?>

    <?php //echo $form->field($model, 'googleid')->textInput(['maxlength' => true]) ?>

    <?php //echo $form->field($model, 'referrer_id')->textInput(['maxlength' => true]) ?>

    <?php //echo $form->field($model, 'credit_total')->textInput(['maxlength' => true]) ?>

    <?php //echo $form->field($model, 'gender')->textInput(['maxlength' => true]) ?>

    <?php //echo $form->field($model, 'activation')->textInput() ?>

    <?php 
        //echo $form->field($model, 'user_level')->dropDownList(['moderator' => 'Moderator']);
        echo $form->field($model, 'user_level')->hiddenInput(['value'=>'Moderator'])->label(false);
     ?>

     <?php 
        //List Role And Priviliges
          $dataRoles=ArrayHelper::map(\backend\models\Roleandprivilige::find()->
     asArray()->all(),'id', 'name');  
        echo $form->field($model, 'privilige_id')->dropDownList($dataRoles)->label('Role and Priviliges');
     ?>

    <?php //echo $form->field($model, 'phoneno')->textInput(['maxlength' => true]) ?>

    <?php //echo $form->field($model, 'about')->textInput(['maxlength' => true]) ?>

    <?php //echo $form->field($model, 'school')->textInput(['maxlength' => true]) ?>

    <?php //echo $form->field($model, 'work')->textInput(['maxlength' => true]) ?>

    <?php //echo $form->field($model, 'timezone')->textInput(['maxlength' => true]) ?>

    <?php //echo $form->field($model, 'language')->textInput(['maxlength' => true]) ?>

    <?php //echo $form->field($model, 'emergencyno')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'emergencyname')->hiddenInput(['value'=>''])->label(false); ?>

    <?php echo $form->field($model, 'emergencyemail')->hiddenInput(['value'=>''])->label(false); ?>

    <?php echo $form->field($model, 'emergencyrelation')->hiddenInput(['value'=>''])->label(false); ?>

    <?php //echo $form->field($model, 'shippingid')->textInput() ?>

    <?php //echo $form->field($model, 'workemail')->textInput(['maxlength' => true]) ?>

    <?php //echo $form->field($model, 'pushnotification')->textInput(['maxlength' => true]) ?>

    <?php //echo $form->field($model, 'notifications')->textarea(['rows' => 6]) ?>

    <?php //echo $form->field($model, 'emailsettings')->textarea(['rows' => 6]) ?>

    <?php //echo $form->field($model, 'socialconnections')->textInput(['maxlength' => true]) ?>

    <?php //echo $form->field($model, 'findability')->textInput(['maxlength' => true]) ?>

    <?php //echo $form->field($model, 'loginnotify')->textInput() ?>

    <?php //echo $form->field($model, 'mobileverify')->textInput() ?>

    <?php //echo $form->field($model, 'verifyno')->textInput(['maxlength' => true]) ?>

    <?php //echo $form->field($model, 'emailverify')->textInput() ?>

    <?php //echo $form->field($model, 'verifycode')->textInput(['maxlength' => true]) ?>

    <?php //echo $form->field($model, 'reservationrequirement')->textInput() ?>

    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
