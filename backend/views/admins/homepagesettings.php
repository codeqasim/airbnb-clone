
<?php
use backend\models\Admin;
$baseUrl = Yii::$app->request->baseUrl;
use yii\bootstrap\ActiveForm;
$this->title = Yii::t('app', 'Home Page Settings');
$this->params['subtitle'] = Yii::t('app', 'Home Page Settings');
$this->params['breadcrumbs'][]= '';
if(!empty($homesettings))
{
	$bannerimage = $homesettings->banner;
	$bannerimageforapp = $homesettings->bannerforapp;
	$bannertitle = $homesettings->bannertitle;
	$bannerdesc = $homesettings->bannerdesc;
	$bannertextcolor = $homesettings->bannertextcolor;
	$placescount = $homesettings->placescount;
	$placesdesc = $homesettings->placesdesc;
	$customerscount = $homesettings->customerscount;
	$customersdesc = $homesettings->customersdesc;
	$supporttime = $homesettings->supporttime;
	$supportdesc = $homesettings->supportdesc;
}
else
{
	$bannerimage = '';
	$bannerimageforapp = '';
	$bannertitle = '';
	$bannerdesc = '';
	$placescount = '';
	$placesdesc = '';
	$bannertextcolor='';
	$customerscount = '';
	$customersdesc = '';
	$supporttime = '';
	$supportdesc = '';
}
?>

	<div class="panel panel-default" data-widget='{"draggable": "false"}'>
		<div class="panel-heading">
			<h2><?php echo Yii::t('app','Basic Form Elements'); ?></h2>
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
	
				 	$upload = new yii\xupload\models\XUploadForm;

				/*
				echo '<div class="form-group">
					
					<label class="col-sm-2 control-label">'.Yii::t('app', 'Banner Image').'</label>
					<div class="col-sm-5">
						
						<div class="fileinput fileinput-new" style="width: 100%;" data-provides="fileinput">
							<div class="fileinput-preview thumbnail mb20" data-trigger="fileinput" style="width: 50%; height: 100px;">';
							if($bannerimage!="")
							{
								$bannerimagepath = Yii::$app->urlManager->createAbsoluteUrl ( '/albums/images/homepage/'.$bannerimage);
								$bannerimagepath = str_replace("/admin", "", $bannerimagepath);
								echo '<img src="'.$bannerimagepath.'">';
							}
							echo '</div>
							<span class="fileinput-filename" name="logoblack"></span>
							<input class="btn btn-default btn-file" type="file" id="bannerimg" name="" value="'.$bannerimage.'">
							<input type="hidden" id="bannerimgfile" name="bannerimgfile" value="'.$bannerimage.'">
							<div>
								<a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">'.Yii::t('app','Remove').'</a>
								<button type="button" class="btn btn-primary" onclick="start_file_upload(\'bannerimg\')">'.Yii::t('app','Start Upload').'</button>
								<div id="bannerimgupload" class="succcls"></div>
								<div class="logoimgerrcls errcls"></div>
							</div>
						</div>
					</div>
				</div>';
				
				echo '<div class="form-group">
					
					<label class="col-sm-2 control-label">'.Yii::t('app', 'Banner Image for Mobile Apps').'</label>
					<div class="col-sm-5">
						
						<div class="fileinput fileinput-new" style="width: 100%;" data-provides="fileinput">
							<div class="fileinput-preview thumbnail mb20" data-trigger="fileinput" style="width: 50%; height: 100px;">';
							if($bannerimageforapp!="")
							{
								$bannerimageapppath = Yii::$app->urlManager->createAbsoluteUrl ( '/albums/images/homepage/'.$bannerimageforapp);
								$bannerimageapppath = str_replace("/admin", "", $bannerimageapppath);
								echo '<img src="'.$bannerimageapppath.'">';
							}
							echo '</div>
							<span class="fileinput-filename" name="logoblack"></span>
							<input class="btn btn-default btn-file" type="file" name="" id="bannerforapp" value="'.$bannerimageforapp.'">
							<input type="hidden" id="bannerforappfile" name="bannerforappfile" value="'.$bannerimageforapp.'">
							<div>
								<a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">'.Yii::t('app','Remove').'</a>
								<button type="button" class="btn btn-primary" onclick="start_file_upload(\'bannerforapp\')">'.Yii::t('app','Start Upload').'</button>
								<div id="bannerforappupload" class="succcls"></div>
								<div class="logoimgerrcls errcls"></div>
							</div>
						</div>
					</div>
				</div>';
				*/

				echo '<div class="form-group">
					<label class="col-sm-2 control-label">'.Yii::t('app', 'Banner Title').'</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="bannertitle" name="bannertitle" value="'.$bannertitle.'">
					</div>
					<div class="bannertitlecls errorcls"></div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">'.Yii::t('app', 'Banner Description').'</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="bannerdesc" name="bannerdesc" value="'.$bannerdesc.'"> 
					</div>
					<div class="bannerdesccls errorcls"></div>
				</div>';	 ?> 	
				<?php /*<div class="form-group">
					<label class="col-sm-2 control-label">'.Yii::t('app', 'Banner text color').'</label>
					<div class="col-sm-8">
						<input type="text" maxlength="10" class="form-control" id="bannertextcolor" name="bannertextcolor" value="'.$bannertextcolor.'" />
					</div>
					<div class="customerscountcls errorcls"></div>
				</div>		*/?>
				<?php echo '<div class="form-group">
					<label class="col-sm-2 control-label">'.Yii::t('app', 'Places Count').'</label>
					<div class="col-sm-8">
						<input type="text" maxlength="10" class="form-control" id="placescount" name="placescount" value="'.$placescount.'" onkeypress="return isNumber(event);">
					</div>
					<div class="placescountcls errorcls"></div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">'.Yii::t('app', 'Places Description').'</label>
					<div class="col-sm-8"> 
						<input type="text" maxlength="150" class="form-control" id="placesdesc" name="placesdesc" value="'.$placesdesc.'" /> 
					</div>
					<div class="placesdesccls errorcls"></div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">'.Yii::t('app', 'Customers Count').'</label>
					<div class="col-sm-8">
						<input type="text" maxlength="10" class="form-control" id="customerscount" name="customerscount" value="'.$customerscount.'" onkeypress="return isNumber(event);">
					</div>
					<div class="customerscountcls errorcls"></div>
				</div>

				<div class="form-group">
					<label class="col-sm-2 control-label">'.Yii::t('app', 'Customers Description').'</label>
					<div class="col-sm-8">
						<input type="text" maxlength="150" class="form-control" id="customersdesc" name="customersdesc" value="'.$customersdesc.'" />
					</div>
					<div class="customersdesccls errorcls"></div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">'.Yii::t('app', 'Support Time').'</label>
					<div class="col-sm-8">
						<input type="text" maxlength="10" class="form-control" id="supporttime" name="supporttime" value="'.$supporttime.'" onkeypress="return IsAlphaNumericnospace(event);">
					</div>
					<div class="supporttimecls errorcls"></div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">'.Yii::t('app', 'Support Description').'</label>
					<div class="col-sm-8">
						<input type="text" maxlength="150" class="form-control" id="supportdesc" name="supportdesc" value="'.$supportdesc.'" />   
					</div>
					<div class="supportdesccls errorcls"></div>
				</div>				
			
				<div class="panel-footer">
					<div class="row">
						<div class="col-sm-8 col-sm-offset-2">
							<button class="btn-primary btn" onclick="return homepageSettingValidate();">'.Yii::t('app','Submit').'</button>
						</div>
					</div>
				</div>';				
			ActiveForm::end();

		echo '</div>
	</div>';
	?>


