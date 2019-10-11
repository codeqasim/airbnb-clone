<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Textsliders */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="textsliders-form">

    <?php
    $baseUrl = Yii::$app->request->baseUrl;
			$form = ActiveForm::begin([
				'options' => ['enctype'=>'multipart/form-data','class'=>'form-horizontal row-border'],
				]);
	
				 	
echo $form->field($model, 'slidertext')->textInput(['maxlength' => true])->label(Yii::t('app','Slidertext'));
    $upload = new yii\xupload\models\XUploadForm;
				echo '<div class="form-group">
					
					<label class="col-sm-2 control-label">'.Yii::t('app','Banner Image').'</label>
					<div class="col-sm-5">
						
						<div class="fileinput fileinput-new" style="width: 100%;" data-provides="fileinput">
							<div class="fileinput-preview thumbnail mb20" data-trigger="fileinput" style="width: 50%; height: 100px;">';
                            echo '<img src="'.$baseUrl.'/images/textsliders/'.$model->sliderimage.'">';
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
