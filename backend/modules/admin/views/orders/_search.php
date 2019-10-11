<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Reservationssearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="reservations-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'userid') ?>

    <?= $form->field($model, 'hostid') ?>

    <?= $form->field($model, 'listid') ?>

    <?= $form->field($model, 'fromdate') ?>

    <?php // echo $form->field($model, 'todate') ?>

    <?php // echo $form->field($model, 'guests') ?>

    <?php // echo $form->field($model, 'pricepernight') ?>

    <?php // echo $form->field($model, 'totaldays') ?>

    <?php // echo $form->field($model, 'commissionfees') ?>

    <?php // echo $form->field($model, 'servicefees') ?>

    <?php // echo $form->field($model, 'taxfees') ?>

    <?php // echo $form->field($model, 'securityfees') ?>

    <?php // echo $form->field($model, 'total') ?>

    <?php // echo $form->field($model, 'booktype') ?>

    <?php // echo $form->field($model, 'bookstatus') ?>

    <?php // echo $form->field($model, 'cancelby') ?>

    <?php // echo $form->field($model, 'orderstatus') ?>

    <?php // echo $form->field($model, 'cdate') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app','Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app','Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
