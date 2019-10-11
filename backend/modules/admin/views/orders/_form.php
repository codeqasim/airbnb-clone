<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Reservations */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="reservations-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'userid')->textInput() ?>

    <?= $form->field($model, 'hostid')->textInput() ?>

    <?= $form->field($model, 'listid')->textInput() ?>

    <?= $form->field($model, 'fromdate')->textInput() ?>

    <?= $form->field($model, 'todate')->textInput() ?>

    <?= $form->field($model, 'guests')->textInput() ?>

    <?= $form->field($model, 'pricepernight')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'totaldays')->textInput() ?>

    <?= $form->field($model, 'commissionfees')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'servicefees')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'taxfees')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'securityfees')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'total')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'booktype')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bookstatus')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cancelby')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'orderstatus')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cdate')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
