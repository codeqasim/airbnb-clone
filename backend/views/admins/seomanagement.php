
<?php
use backend\models\Admin;
$baseUrl = Yii::$app->request->baseUrl;
$frontendurl = str_replace('/admin','',$baseUrl);	
use yii\bootstrap\ActiveForm;
$this->title = 'SEO Management';
$this->params['subtitle'] = ''. Yii::t('app','SEO Management').'';
$this->params['breadcrumbs'][]= '';
if(!empty($sitesetting))
{
	$sitetitle = $sitesetting->sitetitle;
	$metakey = $sitesetting->metakey;
	$metadesc = $sitesetting->metadesc;
	$socialmedialinks = json_decode($sitesetting->footercontent);
	$googleanalyticscode = $sitesetting->googleanalyticscode;
	$google_webmaster_link = $sitesetting->google_webmaster_link;
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
			
				echo '
				<div class="form-group">
					<label class="col-sm-2 control-label">'. Yii::t('app','Site Title').'</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="sitetitle" name="sitetitle" value="'.$sitetitle.'">
					</div>
					<div class="sitetitleerrcls errorcls"></div>
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
				<div class="form-group">
					<label class="col-sm-2 control-label">'. Yii::t('app','Google Analytics').'</label>
					<div class="col-sm-8">
						<textarea name="googleanalyticscode" id="googleanalyticscode">'.$googleanalyticscode.'</textarea>
					</div>
					<div class="googleanalyticscodeerrcls errorcls"></div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">'. Yii::t('app','Google Webmaster Link').'</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="google_webmaster_link" name="google_webmaster_link" value="'.$google_webmaster_link.'">
					</div>
					<div class="google_webmaster_linkerrcls errorcls"></div>
				</div>
				<div class="form-group" style="display:none;">
					<label class="col-sm-2 control-label">'. Yii::t('app','Facebook Link').'</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="facebookLink" name="facebooklink" value="'.$socialmedialinks->facebookLink.'">
					</div>
					<div class="facebooklinkerrcls errorcls"></div>
				</div>
				<div class="form-group" style="display:none;">
					<label class="col-sm-2 control-label">'. Yii::t('app','Twitter Link').'</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="twitterLink" name="twitterlink" value="'.$socialmedialinks->twitterLink.'">
					</div>
					<div class="twitterlinkerrcls errorcls"></div>
				</div>
				<div class="form-group" style="display:none;">
					<label class="col-sm-2 control-label">'. Yii::t('app','Linkedin Link').'</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="linkedinlink" name="linkedinlink" value="'.$socialmedialinks->linkedinLink.'">
					</div>
					<div class="linkedinlinkerrcls errorcls"></div>
				</div>
				<div class="form-group" style="display:none;">
					<label class="col-sm-2 control-label">'. Yii::t('app','Youtube Link').'</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="youtubelink" name="youtubelink" value="'.$socialmedialinks->youtubeLink.'">
					</div>
					<div class="youtubelinkerrcls errorcls"></div>
				</div>
				<div class="form-group" style="display:none;">
					<label class="col-sm-2 control-label">'. Yii::t('app','Pinterest Link').'</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="pinterestlink" name="pinterestlink" value="'.$socialmedialinks->pinterestLink.'">
					</div>
					<div class="pinterestlinkerrcls errorcls"></div>
				</div>
				<div class="form-group" style="display:none;">
					<label class="col-sm-2 control-label">'. Yii::t('app','Instagram Link').'</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="instagramlink" name="instagramlink" value="'.$socialmedialinks->instagramLink.'">
					</div>
					<div class="instagramlinkerrcls errorcls"></div>
				</div>
				<div class="form-group" style="display:none;">
					<label class="col-sm-2 control-label">'. Yii::t('app','Google Plus Link').'</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="googlelink" name="googlelink" value="'.$socialmedialinks->googleLink.'">
					</div>
					<div class="googlelinkerrcls errorcls"></div>
				</div>
				<div class="panel-footer">
					<div class="row">
						<div class="col-sm-8 col-sm-offset-2">
							<button id="submitall" class="btn-primary btn" onclick="return seoManagementValidate();">'. Yii::t('app','Submit').'</button>
						</div>
					</div>
				</div>';
				 				
			ActiveForm::end();

		echo '</div>
	</div>';
	?>


