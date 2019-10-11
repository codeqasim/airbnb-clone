<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Safetycheck */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="safetycheck-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true,'onkeypress'=>'return isAlpha(event);'])->label(Yii::t('app','Name')) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true])->label(Yii::t('app','Description')) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary','onclick' => $model->isNewRecord ? '' : 'return safetyValidate();']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
