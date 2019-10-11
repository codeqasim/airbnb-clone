<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
$baseUrl = Yii::$app->request->baseUrl;
$this->title = 'Social Login Settings';
$this->params['subtitle'] = ''. Yii::t('app','Social Login Settings').'';
$this->params['breadcrumbs'][]= '';

/* @var $this yii\web\View */
/* @var $model backend\models\Sitesettings */
/* @var $form ActiveForm */
?>
	<div class="panel panel-default" data-widget='{"draggable": "false"}'>
		<div class="panel-heading">
			<h2><?= Yii::t('app',Html::encode($this->title)) ?></h2>
<!-- 				<div class="panel-ctrls" -->
<!-- 					data-actions-container=""  -->
<!-- 					data-action-collapse='{"target": ".panel-body"}' -->
<!-- 					data-action-expand='' -->
<!-- 					data-action-colorpicker='' -->
<!-- 				> -->
<!-- 				</div> -->
		</div>
		<div class="panel-editbox" data-widget-controls=""></div>
		<div class="panel-body">
<div class="admins-socialloginsettings">

    <?php $form = ActiveForm::begin(array(
    		'id'=>'sitesettings-form',
			'action' => '',
    		'enableAjaxValidation'=>false,
    		'options' => array('onsubmit'=>'return socialLoginSettingsValidate();'),
    )); ?>
    
   <?php echo $form->field($model, 'socialstatus')->checkBox(array('name'=>'socialstatus', 
    		'class'=>'socialstatus'));  ?>
   <?php echo $form->field($model, 'facebookstatus')->hiddenInput(array('name'=>'facebookstatus', 
    		'class'=>'facebookstatus')); ?>
    <?php echo $form->field($model, 'facebookappid')->textInput(['class' => 'form-control facebookappid', 
    	'name'=>'facebookappid'])->label(Yii::t('app','Facebook App id')); ?>
 	<?php echo $form->field($model, 'facebooksecret')->textInput(['class' => 'form-control facebooksecret', 
    	'name'=>'facebooksecret'])->label(Yii::t('app','Facebook Secret Key')); ?>
    
    <?php echo $form->field($model, 'googlestatus')->hiddenInput(array('name'=>'googlestatus', 
    		'class'=>'googlestatus'));  ?>
    <?php echo $form->field($model, 'googleappid')->textInput(['class' => 'form-control googleappid', 
    	'name'=>'googleappid'])->label(Yii::t('app','Google App id')); ?>
 	<?php echo $form->field($model, 'googlesecret')->textInput(['class' => 'form-control googlesecret', 
    	'name'=>'googlesecret'])->label(Yii::t('app','Google Secret Key')); ?>
        <div class="form-group">
            <?= Html::submitButton(''. Yii::t('app','Submit').'', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- admins-socialloginsettings -->        </div>
    </div>


<style>
.field-sitesettings-facebookstatus label{
display: none;
}
.field-sitesettings-googlestatus label{
display: none;
}
</style>
