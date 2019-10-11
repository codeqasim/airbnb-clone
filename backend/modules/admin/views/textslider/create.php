
<?php
use backend\models\Admin;
$baseUrl = Yii::$app->request->baseUrl;
use yii\bootstrap\ActiveForm;
$this->title = 'Add Slider';
$this->params['subtitle'] = Yii::t('app','Add Slider');
$this->params['breadcrumbs'][]= '';

?>

	<div class="panel panel-default" data-widget='{"draggable": "false"}'>
		<div class="panel-heading">
			<h2><?php echo Yii::t('app','Add Slider');?></h2>
				<div class="panel-ctrls"
					data-actions-container="" 
					data-action-collapse='{"target": ".panel-body"}'
					data-action-expand=''
					data-action-colorpicker=''
				>
				</div>
		</div>
		<div class="panel-editbox" data-widget-controls=""></div>
		<div class="panel-body">
			<?php
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
							echo '</div>
							<span class="fileinput-filename" name="logoblack"></span>
							<input class="btn btn-default btn-file" type="file" name="XUploadForm[file][0]" value="" id="inputfile">
							<div>
								<a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">'.Yii::t('app','Remove').'</a>
								
							</div>
						</div>
					</div>
					<div id="imageerrcls" class="errcls"></div>
				</div>
			
			
				<div class="panel-footer">
					<div class="row">
						<div class="col-sm-8 col-sm-offset-2">
							<button class="btn-primary btn" onclick="return validatetext();" id="submitbtn">'.Yii::t('app','Submit').'</button>
						</div>
					</div>
				</div>';				
			ActiveForm::end();

		echo '</div>
	</div>';
	?>


