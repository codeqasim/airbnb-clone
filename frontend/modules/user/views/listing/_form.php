<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Listing */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="listing-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'userid')->textInput() ?>

    <?= $form->field($model, 'hometype')->textInput() ?>

    <?= $form->field($model, 'roomtype')->textInput() ?>

    <?= $form->field($model, 'accommodates')->textInput() ?>

    <?= $form->field($model, 'bedrooms')->textInput() ?>

    <?= $form->field($model, 'beds')->textInput() ?>

    <?= $form->field($model, 'bathrooms')->textInput() ?>

    <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'listingname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'country')->textInput() ?>

    <?= $form->field($model, 'streetaddress')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'accesscode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'state')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'zipcode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'commonamenities')->textInput() ?>

    <?= $form->field($model, 'additionalamenities')->textInput() ?>

    <?= $form->field($model, 'specialfeatures')->textInput() ?>

    <?= $form->field($model, 'safetychecklist')->textInput() ?>

    <?= $form->field($model, 'fireextinguisher')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'firealarm')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'gasshutoffvalve')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'emergencyexitinstruction')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'medicalno')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fireno')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'policeno')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nightlyprice')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'currency')->textInput() ?>

    <?= $form->field($model, 'bookingstyle')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'whocanbook')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'houserules')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'bookingavailability')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'startdate')->textInput() ?>

    <?= $form->field($model, 'enddate')->textInput() ?>

    <?= $form->field($model, 'minstay')->textInput() ?>

    <?= $form->field($model, 'maxstay')->textInput() ?>

    <?= $form->field($model, 'advancenotice')->textInput() ?>

    <?= $form->field($model, 'priceforextrapeople')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'weeklydiscount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'monthlydisocunt')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cancellation')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'liststatus')->textInput() ?>

    <?= $form->field($model, 'cdate')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
