<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$getlimits = json_decode($model->policylimit);
//use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Cancellation */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="cancellation-form">
    <?php $form = ActiveForm::begin(array(
			'action' => '',
    		'enableAjaxValidation'=>false,
    		'options' => array('onsubmit'=>'return cancellationPageValidate()'),
    )); ?>
    <?= $form->field($model, 'policyname')->label(Yii::t('app','Policy Name')); ?>
    <!-- 
    <p>Policy Limit</p>
    <input type="checkbox" name="policylimit[]" id="policylimit" value="servicefees" 
    <?= (isset($getlimits[0]) && $getlimits[0] == 'servicefees') ? 'checked': ''; ?> > Service fees
    <input type="checkbox" name="policylimit[]" id="policylimit" value="cleaningfees" 
    <?= (isset($getlimits[1]) && $getlimits[1] == 'cleaningfees') ? 'checked': ''; ?>
    > Cleaning fees
    <?= $form->field($model, 'cancelfrom')->textInput(['onkeypress' => 'return isNumber(event);'])->label(Yii::t('app','Cancel From (in days)')); ?> -->

    <?= $form->field($model, 'cancelto')->textInput(['onkeypress' => 'return isNumber(event);', 'maxlength'=> '2'])->label(Yii::t('app','Days before cancel')); ?>
    <?= $form->field($model, 'cancelpercentage')->textInput(['onkeypress' => 'return isNumber(event);', 'maxlength'=> '2'])->label(Yii::t('app','Cancel Percentage')) ?>

    <?= $form->field($model, 'canceldesc')->textarea(['rows' => '5'])->label(Yii::t('app','Describe Cancellation Policy')) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
