<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use backend\models\Helptopic;
/* @var $this yii\web\View */
/* @var $model backend\models\Help */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="help-form">

    <?php $form = ActiveForm::begin(array(
    		'id'=>'help-form',
			'action' => '',
    		'enableAjaxValidation'=>false,
    		'options' => array('onsubmit'=>'return helpPageValidate()'),
    )); ?>

    <?= $form->field($model, 'name')->textInput()->label(Yii::t('app','Name')) ?>

    <?php //echo $form->dropDownList($model,'topicid', CHtml::listData(Helptopic::model()->findAll(), 'id', 'topic'), array('empty'=>'select Type')); ?>

    <?= $form->field($model, 'topicid')->dropDownList(ArrayHelper::map(Helptopic::find()->all(),'id','topic'),['prompt'=>'Select Topic']) ?>

    <?= $form->field($model, 'subcontent')->textarea(['rows' => 6, 'class'=> 'ckeditor'])->label(Yii::t('app','subcontent'))?>
    
    <?= $form->field($model, 'maincontent')->textarea(['rows' => 6, 'class'=> 'ckeditor'])->label(Yii::t('app','maincontent'))?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app','Create') : Yii::t('app','Update'), ['id'=>'submitbtn','class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
