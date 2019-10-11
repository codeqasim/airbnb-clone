<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Sitecharge */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sitecharge-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'min_value')->textInput(['maxlength' => true, 'onkeypress' => 'return isNumber(event);'])->label(Yii::t('app','Min Value')) ?>

    <?= $form->field($model, 'max_value')->textInput(['maxlength' => true, 'onkeypress' => 'return isNumber(event);'])->label(Yii::t('app','Max Value')) ?>

    <?= $form->field($model, 'percentage')->textInput(['maxlength' => true, 'onkeypress' => 'return isNumber(event);'])->label(Yii::t('app','Percentage')) ?>
	<div class="commerr"></div>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app','Create') : Yii::t('app','Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary','onclick' => 'return siteChargeValidate();']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
