<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Lists */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="lists-form">

    <?php $form = ActiveForm::begin([
    		'enableAjaxValidation'=>false,
    		'options' => array('onsubmit'=>'return createListValidate()'),
            ]); ?>

    <?= $form->field($model, 'listname')->textInput(['maxlength' => '20'])->label(Yii::t('app','List Name')); ?>
<?php
$userid = Yii::$app->user->identity->id;
?>
    <?= $form->field($model, 'createdby')->hiddenInput(['value'=>''.$userid.''])->label(false); ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['id'=>'listcreatebtn','class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>