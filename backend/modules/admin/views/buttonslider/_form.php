<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Buttonsliders */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="buttonsliders-form">

<?php
$baseUrl = Yii::$app->request->baseUrl;
			$form = ActiveForm::begin([
				'options' => ['enctype'=>'multipart/form-data','class'=>'form-horizontal row-border'],
				]);
	
				 	
echo $form->field($model, 'title')->textInput(['maxlength' => true])->label(Yii::t('app','Title'));
echo $form->field($model, 'description')->textInput(['maxlength' => true])->label(Yii::t('app','Description'));
echo $form->field($model, 'buttonname')->textInput(['maxlength' => true])->label(Yii::t('app','Buttonname'));
echo $form->field($model, 'buttonlink')->textInput(['rows' => 6])->label(Yii::t('app','Buttonlink'));
    $upload = new yii\xupload\models\XUploadForm;
				echo '<div class="form-group">
					
					<label class="col-sm-2 control-label">'.Yii::t('app','Banner Image').'</label>
					<div class="col-sm-5">
						
						<div class="fileinput fileinput-new" style="width: 100%;" data-provides="fileinput">
							<div class="fileinput-preview thumbnail mb20" data-trigger="fileinput" style="width: 50%; height: 100px;">';
							echo '<img src="'.$baseUrl.'/images/buttonsliders/'.$model->sliderimage.'">';
							echo '</div>
							<span class="fileinput-filename" name="logoblack"></span>
							<input class="btn btn-default btn-file" type="file" name="XUploadForm[file][0]" value="'.$model->sliderimage.'">
							<div>
								<a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">'.Yii::t('app','Remove').'</a>
								<span class="fileinput-exists">'.Yii::t('app','Change').'</span>
								
							</div>
						</div>
					</div>
				</div>
			
			
				<div class="panel-footer">
					<div class="row">
						<div class="col-sm-8 col-sm-offset-2">
							<button class="btn-primary btn">'.Yii::t('app','Submit').'</button>
						</div>
					</div>
				</div>';				
			ActiveForm::end();
			?>

</div>
