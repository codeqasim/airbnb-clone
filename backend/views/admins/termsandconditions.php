<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\Admin;
$baseUrl = Yii::$app->request->baseUrl;
$this->title = 'Terms and Conditions';
$this->params['subtitle'] = ''. Yii::t('app','Terms and Conditions').'';
$this->params['breadcrumbs'][]= '';
?>
	<div class="panel panel-default" data-widget='{"draggable": "false"}'>
		<div class="panel-heading">
			<h2><?php echo Yii::t('app','Terms and Conditions');?></h2>
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
			<div class="help-create">
					
    <?php $form = ActiveForm::begin(array(
    		'id'=>'help-form',
			'action' => '',
    		'enableAjaxValidation'=>false,
    )); ?>

<?php
if(isset($homesettings->sub_termsandconditions) && $homesettings->sub_termsandconditions!="")
$subcontent = $homesettings->sub_termsandconditions;
else
$subcontent = "";
if(isset($homesettings->main_termsandconditions) && $homesettings->main_termsandconditions!="")
$maincontent = $homesettings->main_termsandconditions;
else
$maincontent = "";
?>
    <?= $form->field($model, 'sub_termsandconditions')->textarea(['rows' => 6, 'class'=> 'ckeditor','value'=>''.$subcontent.''])->label(Yii::t('app', 'Sub terms and conditions')) ?>
    
    <?= $form->field($model, 'main_termsandconditions')->textarea(['rows' => 6, 'class'=> 'ckeditor','value'=>''.$maincontent.''])->label(Yii::t('app', 'Main terms and conditions')) ?>

    <div class="form-group">
         <?= Html::submitButton(''. Yii::t('app','Submit').'', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>


				</div>
        </div>
    </div>
