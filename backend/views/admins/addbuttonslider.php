
<?php
use backend\models\Admin;
$baseUrl = Yii::$app->request->baseUrl;
use yii\bootstrap\ActiveForm;
$this->title = 'Add Slider';
$this->params['subtitle'] = 'Add Slider';
$this->params['breadcrumbs'][]= '';

?>

	<div class="panel panel-default" data-widget='{"draggable": "false"}'>
		<div class="panel-heading">
			<h2>Basic Form Elements</h2>
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
			<?php
			$form = ActiveForm::begin([
				'options' => ['enctype'=>'multipart/form-data','class'=>'form-horizontal row-border'],
				]);
	
				 	
echo $form->field($model, 'title')->textInput(['maxlength' => true]);
echo $form->field($model, 'description')->textInput(['maxlength' => true]);
echo $form->field($model, 'buttonname')->textInput(['maxlength' => true]);
echo $form->field($model, 'buttonlink')->textInput(['rows' => 6]);
    $upload = new yii\xupload\models\XUploadForm;
				echo '<div class="form-group">
					
					<label class="col-sm-2 control-label">Banner Image</label>
					<div class="col-sm-5">
						
						<div class="fileinput fileinput-new" style="width: 100%;" data-provides="fileinput">
							<div class="fileinput-preview thumbnail mb20" data-trigger="fileinput" style="width: 50%; height: 100px;">';
							echo '</div>
							<span class="fileinput-filename" name="logoblack"></span>
							<input class="btn btn-default btn-file" type="file" name="XUploadForm[file][0]" value="">
							<div>
								<a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
								<span class="fileinput-exists">Change</span>
								
							</div>
						</div>
					</div>
				</div>
			
			
				<div class="panel-footer">
					<div class="row">
						<div class="col-sm-8 col-sm-offset-2">
							<button class="btn-primary btn">Submit</button>
						</div>
					</div>
				</div>';				
			ActiveForm::end();

		echo '</div>
	</div>';
	?>


