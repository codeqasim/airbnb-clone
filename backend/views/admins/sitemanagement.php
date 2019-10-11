
<?php
use backend\models\Admin;
$baseUrl = Yii::$app->request->baseUrl;
$frontendurl = str_replace('/admin','',$baseUrl);	
use yii\bootstrap\ActiveForm;
$this->title = 'Site Management';
$this->params['subtitle'] = ''. Yii::t('app','Site Management').'';
$this->params['breadcrumbs'][]= '';
if(!empty($sitesetting))
{
	$sitename = $sitesetting->sitename;
	$sitetitle = $sitesetting->sitetitle;
	$metakey = $sitesetting->metakey;
	$metadesc = $sitesetting->metadesc;
	$sitelogoblack = $sitesetting->sitelogoblack;
	$sitelogowhite = $sitesetting->sitelogowhite;
	$favicon = $sitesetting->defaultfavicon; 
	$welcomeemail = $sitesetting->welcomeemail;
	$hour_booking = $sitesetting->hour_booking;
	$defaultimage = $sitesetting->defaultuserimage;
	$pricerange = $sitesetting->pricerange;
	$googleapikey = $sitesetting->googleapikey;
	$fcmKey=$sitesetting->fcmKey;
}
else
{
	$sitename = "";
	$sitetitle = "";
	$metakey = "";
	$metadesc = "";
	$sitelogoblack = "";
	$sitelogowhite = "";
	$welcomeemail = "";
	$hour_booking ="";
	$defaultimage = "";
	$pricerange = "";
	$googleapikey = "";
	$fcmKey="";
	$favicon = "";

}
?>

	<div class="panel panel-default" data-widget='{"draggable": "false"}'>
		<div class="panel-heading">
			<h2><?php echo Yii::t('app','Basic Form Elements');?></h2>
<!--				<div class="panel-ctrls"
					data-actions-container="" 
					data-action-collapse='{"target": ".panel-body"}'
					data-action-expand=''
					data-action-colorpicker=''
				>
				</div>-->
		</div>
		<div class="panel-editbox" data-widget-controls=""></div>
		<div class="panel-body">
			<?php
			$form = ActiveForm::begin([
				'options' => ['enctype'=>'multipart/form-data','class'=>'form-horizontal row-border'],
				]);
			
				echo '<div class="form-group">
					<label class="col-sm-2 control-label">'. Yii::t('app','Site Name').'</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="sitename" name="sitename" value="'.$sitename.'">
					</div>
					<div class="siteerrcls errorcls"></div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">'. Yii::t('app','Site Title').'</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="sitetitle" name="sitetitle" value="'.$sitetitle.'">
					</div>
					<div class="sitetitleerrcls errorcls"></div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">'. Yii::t('app','Google Map Api Key').'</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="googleapikey" name="googleapikey" value="'.$googleapikey.'">
					</div>
					<div class="googleapikeyerrcls errorcls"></div>
				</div>	
				<div class="form-group">
					<label class="col-sm-2 control-label">'. Yii::t('app','FCM Key').'</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="fcmKey" name="fcmKey" value="'.$fcmKey.'">
					</div>
					<div class="googleapikeyerrcls errorcls"></div>
				</div>			
				<div class="form-group">
					<label class="col-sm-2 control-label">'. Yii::t('app','Meta Keyword').'</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="metakey" name="metakey" value="'.$metakey.'">
					</div>
						<div class="metakeyerrcls errorcls"></div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">'. Yii::t('app','Meta Description').'</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="metadesc" name="metadesc" value="'.$metadesc.'">
					</div>
					<div class="metadescerrcls errorcls"></div>
				</div>
				<!--div class="form-group">
					<label class="col-sm-2 control-label">'. Yii::t('app','Maximum Price').'</label>
					<div class="col-sm-8">
						<input type="text" maxlength="10" class="form-control" id="pricerange" name="pricerange" value="'.$pricerange.'">
					</div>
					<div class="pricerangeerrcls errorcls"></div>
				</div-->				
				<div class="form-group">
					<label class="col-sm-2 control-label">'. Yii::t('app','Welcome Email').'</label>
					<div class="col-sm-8">';
					if(isset($welcomeemail) && $welcomeemail!="")
					{
						if($welcomeemail=="yes")
						{
							echo '<label class="radio-inline icheck">
								<input type="radio" id="inlineradio1" value="'. Yii::t('app','yes').'" name="welcomeemail" checked> '. Yii::t('app','Yes').'
							</label>
							<label class="radio-inline icheck">
								<input type="radio" id="inlineradio2" value="'. Yii::t('app','no').'" name="welcomeemail" > '. Yii::t('app','No').'
							</label>';
						}
						else if($welcomeemail=="no")
						{
							echo '<label class="radio-inline icheck">
								<input type="radio" id="inlineradio1" value="'. Yii::t('app','yes').'" name="welcomeemail"> '. Yii::t('app','Yes').'
							</label>
							<label class="radio-inline icheck">
								<input type="radio" id="inlineradio2" value="'. Yii::t('app','no').'" name="welcomeemail" checked> '. Yii::t('app','No').'
							</label>';							
						}
					}
					else
					{
						echo '<label class="radio-inline icheck">
							<input type="radio" id="inlineradio1" value="'. Yii::t('app','yes').'" name="welcomeemail" checked> '. Yii::t('app','Yes').'
						</label>
						<label class="radio-inline icheck">
							<input type="radio" id="inlineradio2" value="'. Yii::t('app','no').'" name="welcomeemail" > '. Yii::t('app','No').'
						</label>';						
					}
					echo '</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">'. Yii::t('app','Hourly based booking').'</label>
					<div class="col-sm-8">';
					if(isset($hour_booking) && $hour_booking!="")
					{
						if($hour_booking=="yes")
						{
							echo '<label class="radio-inline icheck">
								<input type="radio" id="inlineradio11" value="'. Yii::t('app','yes').'" name="hour_booking" checked> '. Yii::t('app','Yes').'
							</label>
							<label class="radio-inline icheck">
								<input type="radio" id="inlineradio21" value="'. Yii::t('app','no').'" name="hour_booking" > '. Yii::t('app','No').'
							</label>';
						}
						else if($hour_booking=="no")
						{
							echo '<label class="radio-inline icheck">
								<input type="radio" id="inlineradio11" value="'. Yii::t('app','yes').'" name="hour_booking"> '. Yii::t('app','Yes').'
							</label>
							<label class="radio-inline icheck">
								<input type="radio" id="inlineradio21" value="'. Yii::t('app','no').'" name="hour_booking" checked> '. Yii::t('app','No').'
							</label>';							
						}
					}
					else
					{
						echo '<label class="radio-inline icheck">
							<input type="radio" id="inlineradio11" value="'. Yii::t('app','yes').'" name="hour_booking" checked> '. Yii::t('app','Yes').'
						</label>
						<label class="radio-inline icheck">
							<input type="radio" id="inlineradio21" value="'. Yii::t('app','no').'" name="hour_booking" > '. Yii::t('app','No').'
						</label>';						
					}
					echo '</div>
				</div>
				';
				 	$upload = new yii\xupload\models\XUploadForm;

    
				echo '<div class="form-group">
					
					<label class="col-sm-2 control-label">'. Yii::t('app','Logo Image (Black)').'</label>
					<div class="col-sm-5">
						
						<div class="fileinput fileinput-new" style="width: 100%;" data-provides="fileinput">
							<div class="fileinput-preview thumbnail mb20" data-trigger="fileinput" style="width: 50%; height: 100px;">';
							if($sitelogoblack!="")
							echo '<img src="'.$baseUrl.'/images/'.$sitelogoblack.'?'.rand(1,100).'">';
							echo '</div>
							<span class="fileinput-filename" name="logoblack"></span>
							<input class="btn btn-default btn-file" type="file" id="logoblack" name="" value="'.$sitelogoblack.'">
							<input type="hidden" id="logoblackfile" name="logoblackfile" value="'.$sitelogoblack.'">
							<div>
								<a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">'. Yii::t('app','Remove').'</a>
								<button type="button" class="btn btn-primary" onclick="start_file_upload(\'logoblack\')">'. Yii::t('app','Start Upload').'</button>
								<div id="logoblackupload" class="succcls"></div>
								<div class="logoimgerrcls errcls"></div>
							</div>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">'. Yii::t('app','Logo Image (White)').'</label>
					<div class="col-sm-5">
						<div class="fileinput fileinput-new" style="width: 100%;" data-provides="fileinput">
							<div class="fileinput-preview thumbnail mb20" data-trigger="fileinput" style="width: 50%; height: 100px;">';
							if($sitelogowhite!="")
							echo '<img src="'.$baseUrl.'/images/'.$sitelogowhite.'?'.rand(1,100).'">';
							echo '</div>
							<span class="fileinput-filename" name="logowhite"></span>
							<input class="btn btn-default btn-file" type="file" id="logowhite" name="" value="'.$sitelogowhite.'">
							<input type="hidden" id="logowhitefile" name="logowhitefile" value="'.$sitelogowhite.'">
							<div>
								<a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">'. Yii::t('app','Remove').'</a>
								<button type="button" class="btn btn-primary" onclick="start_file_upload(\'logowhite\')">'. Yii::t('app','Start Upload').'</button>
								<div id="logowhiteupload" class="succcls"></div>
								<div class="logoimgwhiteerrcls errcls"></div>
							</div>
						</div>					
					</div>
					<div class="col-sm-4">
						<div class="alert alert-info">'. Yii::t('app','Image preview only works in IE10+, FF3.6+, Safari6.0+, Chrome6.0+ and Opera11.1+. In older browsers the filename is shown instead.').'</div>
					</div>
				</div>

				<div class="form-group">
					<label class="col-sm-2 control-label">'. Yii::t('app','Default User Image').'</label>
					<div class="col-sm-5">
						<div class="fileinput fileinput-new" style="width: 100%;" data-provides="fileinput">
							<div class="fileinput-preview thumbnail mb20" data-trigger="fileinput" style="width: 50%; height: 100px;">';
							if($defaultimage!="")
							echo '<img src="'.$frontendurl.'/albums/images/users/'.$defaultimage.'?'.rand(1,100).'">';
							echo '</div>
							<span class="fileinput-filename" name="defaultuserimage"></span>
							<input class="btn btn-default btn-file" type="file"  id="defaultuserimage" name="" value="'.$defaultimage.'">
							<input type="hidden" id="defaultuserimagefile" name="defaultuserimagefile" value="'.$defaultimage.'">
							<div>
								<a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">'. Yii::t('app','Remove').'</a>
								<button type="button" class="btn btn-primary" onclick="start_file_upload(\'defaultuserimage\')">'. Yii::t('app','Start Upload').'</button>
								<div id="defaultuserimageupload" class="succcls"></div>
								<div class="defaultusererrcls errcls"></div>
							</div>
						</div>					
					</div>
					<div class="col-sm-4">
						<div class="alert alert-info">'. Yii::t('app','Image preview only works in IE10+, FF3.6+, Safari6.0+, Chrome6.0+ and Opera11.1+. In older browsers the filename is shown instead.').'</div>
					</div>
				</div>

				<div class="form-group">
					<label class="col-sm-2 control-label">'. Yii::t('app','Favicon').'</label>
					<div class="col-sm-5">
						<div class="fileinput fileinput-new" style="width: 100%;" data-provides="fileinput">
							<div class="fileinput-preview thumbnail mb20" data-trigger="fileinput" style="width: 50%; height: 100px;">';
								echo '<img src="'.$baseUrl.'/images/'.$favicon.'">'; 
							echo '</div>
							<span class="fileinput-filename" name="favicon"></span>
							<input class="btn btn-default btn-file" type="file"  id="favicon" name="" value="'.$favicon.'">
							<input type="hidden" id="faviconfile" name="faviconfile" value="'.$favicon.'">
							<div>
								<a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">'. Yii::t('app','Remove').'</a>
								<button type="button" class="btn btn-primary" onclick="start_file_upload(\'favicon\')">'. Yii::t('app','Start Upload').'</button>
								<div id="faviconupload" class="succcls"></div>
								<div class="faviconerrcls errcls"></div>
							</div>
						</div> 		 			
					</div>
					<div class="col-sm-4">
						<div class="alert alert-info">'. Yii::t('app','Image preview only works in IE10+, FF3.6+, Safari6.0+, Chrome6.0+ and Opera11.1+. In older browsers the filename is shown instead.').'</div>
					</div>
				</div>


				<div class="panel-footer">
					<div class="row">
						<div class="col-sm-8 col-sm-offset-2">
							<button id="submitall" class="btn-primary btn" onclick="return siteManagementValidate();">'. Yii::t('app','Submit').'</button>
						</div>
					</div>
				</div>';				
			ActiveForm::end();

		echo '</div>
	</div>';
	?>


