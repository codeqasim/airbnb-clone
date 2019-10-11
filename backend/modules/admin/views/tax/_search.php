<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Taxsearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tax-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'countryid') ?>

    <?= $form->field($model, 'countryname') ?>

    <?= $form->field($model, 'taxname') ?>

    <?= $form->field($model, 'percentage') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app','Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app','Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
