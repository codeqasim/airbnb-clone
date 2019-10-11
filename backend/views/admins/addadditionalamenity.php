
<?php
use backend\models\Admin;
$baseUrl = Yii::$app->request->baseUrl;
use yii\bootstrap\ActiveForm;
$this->title = 'Add Additional Amenity';
$this->params['subtitle'] = 'Add Additional Amenity';
$this->params['breadcrumbs'][]= '<ol class="breadcrumb">
<li class=""><a href="index.html">Home</a></li>
<li class="active"><a href="index.html">Dashboard</a></li>
</ol>';

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
			
				echo '<div class="form-group">
					<label class="col-sm-2 control-label">Amenity Name</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" name="amenityname" value="">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Amenity Description</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" name="amenitydesc" value="">
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


