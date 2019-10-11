<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Lists */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="lists-form">

    <?php $form = ActiveForm::begin([
    		'enableAjaxValidation'=>false,
    		'options' => array('onsubmit'=>'return createReportValidate()'),
            ]); ?>

    <?= $form->field($model, 'report')->textInput(['maxlength' => '20'])->label(Yii::t('app','Report Name')); ?>
    <?= $form->field($model, 'shortdesc')->textarea(['maxlength' => '60'])->label(Yii::t('app','Short Descriptions')); ?>
    <?php
    echo $form->field($model, 'report_type')->radioList(array('profile'=>'Profile','list'=>'List'))->label(Yii::t('app','Report Type')) ;
            //echo '</div>';
    ?>
    
    
<?php
$userid = Yii::$app->user->identity->id;
?>
    <?= $form->field($model, 'created_time')->hiddenInput(['value'=>''.date('Y-m-d h:i:s').''])->label(false); ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['id'=>'listcreatebtn','class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>