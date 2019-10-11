<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Listingsearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="listing-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'userid') ?>

    <?= $form->field($model, 'hometype') ?>

    <?= $form->field($model, 'roomtype') ?>

    <?= $form->field($model, 'accommodates') ?>

    <?php // echo $form->field($model, 'bedrooms') ?>

    <?php // echo $form->field($model, 'beds') ?>

    <?php // echo $form->field($model, 'bathrooms') ?>

    <?php // echo $form->field($model, 'city') ?>

    <?php // echo $form->field($model, 'listingname') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'country') ?>

    <?php // echo $form->field($model, 'streetaddress') ?>

    <?php // echo $form->field($model, 'accesscode') ?>

    <?php // echo $form->field($model, 'state') ?>

    <?php // echo $form->field($model, 'zipcode') ?>

    <?php // echo $form->field($model, 'commonamenities') ?>

    <?php // echo $form->field($model, 'additionalamenities') ?>

    <?php // echo $form->field($model, 'specialfeatures') ?>

    <?php // echo $form->field($model, 'safetychecklist') ?>

    <?php // echo $form->field($model, 'fireextinguisher') ?>

    <?php // echo $form->field($model, 'firealarm') ?>

    <?php // echo $form->field($model, 'gasshutoffvalve') ?>

    <?php // echo $form->field($model, 'emergencyexitinstruction') ?>

    <?php // echo $form->field($model, 'medicalno') ?>

    <?php // echo $form->field($model, 'fireno') ?>

    <?php // echo $form->field($model, 'policeno') ?>

    <?php // echo $form->field($model, 'nightlyprice') ?>

    <?php // echo $form->field($model, 'currency') ?>

    <?php // echo $form->field($model, 'bookingstyle') ?>

    <?php // echo $form->field($model, 'whocanbook') ?>

    <?php // echo $form->field($model, 'houserules') ?>

    <?php // echo $form->field($model, 'bookingavailability') ?>

    <?php // echo $form->field($model, 'startdate') ?>

    <?php // echo $form->field($model, 'enddate') ?>

    <?php // echo $form->field($model, 'minstay') ?>

    <?php // echo $form->field($model, 'maxstay') ?>

    <?php // echo $form->field($model, 'advancenotice') ?>

    <?php // echo $form->field($model, 'priceforextrapeople') ?>

    <?php // echo $form->field($model, 'weeklydiscount') ?>

    <?php // echo $form->field($model, 'monthlydisocunt') ?>

    <?php // echo $form->field($model, 'cancellation') ?>

    <?php // echo $form->field($model, 'liststatus') ?>

    <?php // echo $form->field($model, 'cdate') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
