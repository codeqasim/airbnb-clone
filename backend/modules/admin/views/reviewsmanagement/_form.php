<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use backend\models\Users;
use backend\models\Listing;

/* @var $this yii\web\View */
/* @var $model backend\models\Lists */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="lists-form">
    <?php $form = ActiveForm::begin([
    		'enableAjaxValidation'=>false,
    		'options' => array('onsubmit'=>'return updateRateValidate()'),
            ]); ?>
    <div class="form-group field-reviews-rating has-success">
    <span style="font-weight: bold;">Listing Name: </span>
    <?php
        $getListname = Listing::find()->select('listingname')->where(['id'=>$model->listid])->one();
        echo (isset($getListname->listingname) && $getListname->listingname != '') ? $getListname->listingname : '';
    ?>
    </div>
    <div class="form-group field-reviews-rating has-success">
    <span style="font-weight: bold;">User Name: </span>
    <?php
        $getUsername = Users::find()->select('firstname')->where(['id'=>$model->listid])->one();
        echo (isset($getUsername->firstname) && $getUsername->firstname != '') ? $getUsername->firstname : '';
    ?></div>
    <?= $form->field($model, 'rating')->textInput(['maxlength' => '150'])->label(Yii::t('app','Rating')); ?>
    <?= $form->field($model, 'review')->textarea(['maxlength' => '350'])->label(Yii::t('app','Reviews')); ?>
    <?php
    $userid = Yii::$app->user->identity->id;
    ?>
    <?= $form->field($model, 'cdate')->hiddenInput(['value'=>''.date('Y-m-d h:i:s').''])->label(false); ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['id'=>'listcreatebtn','class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>

