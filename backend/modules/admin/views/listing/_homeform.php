<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Hometype */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="hometype-form">

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'hometype')->textInput(['maxlength' => true,'onkeypress'=>'return isAlpha(event);'])->label(Yii::t('app','Hometype')) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ?Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary','onclick'=> $model->isNewRecord ? '' : 'return hometypeValidate();']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
