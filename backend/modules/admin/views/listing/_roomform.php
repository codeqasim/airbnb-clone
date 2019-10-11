<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Roomtype */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="roomtype-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'roomtype')->textInput(['maxlength' => true,'onkeypress'=>'return isAlpha(event);'])->label(Yii::t('app','Roomtype')) ?>
    <?= $form->field($model, 'description')->textArea(['maxlength' => true,'onkeypress'=>'return isAlpha(event);'])->label(Yii::t('app','Roomtype description')) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary','onclick'=> $model->isNewRecord ? '' : 'return roomtypeValidate();']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
