
<?php
use backend\models\Admin;
$baseUrl = Yii::$app->request->baseUrl;
use yii\bootstrap\ActiveForm;
$this->title = 'Listing Properties';
$this->params['subtitle'] = ''. Yii::t('app','Listing Properties').'';
$this->params['breadcrumbs'][]= '';

if(!empty($listing))
{
	$accommodate = $listing->accommodates;
	$bedrooms = $listing->bedrooms;
	$beds = $listing->beds;
	$bathrooms = $listing->bathrooms;
}
else
{
	$accommodate = "";
	$bedrooms = "";
	$beds = "";
	$bathrooms = "";
}
?>

	<div class="panel panel-default" data-widget='{"draggable": "false"}'>
		<div class="panel-heading">
			<h2><?php echo Yii::t('app','Basic Form Elements');?></h2>
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
			
				echo '
				<div class="form-group">
					<label class="col-sm-2 control-label">'. Yii::t('app','Bedrooms').'</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="bedrooms" maxlength="3" name="bedrooms" value="'.$bedrooms.'" onkeypress="return isNumber(event);">
					</div>
					<div class="bedroomerrcls errorcls"></div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">'. Yii::t('app','Beds').'</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="beds" maxlength="3" name="beds" value="'.$beds.'" onkeypress="return isNumber(event);">
					</div>
					<div class="bederrcls errorcls"></div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">'. Yii::t('app','Bathrooms').'</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="bathrooms" maxlength="3" name="bathrooms" value="'.$bathrooms.'" onkeypress="return isNumber(event);">
					</div>
					<div class="bathroomerrcls errorcls"></div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">'. Yii::t('app','Accommodates').'</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="accommodates" maxlength="3" name="accommodates" value="'.$accommodate.'" onkeypress="return isNumber(event);">
					</div>
					<div class="accommodateerrcls errorcls"></div>
				</div>				
		
				<div class="panel-footer">
					<div class="row">
						<div class="col-sm-8 col-sm-offset-2">
							<button class="btn-primary btn" onclick="return listingValidate();">'. Yii::t('app','Submit').'</button>
						</div>
					</div>
				</div>';				
			ActiveForm::end();

		echo '</div>
	</div>';
	?>


