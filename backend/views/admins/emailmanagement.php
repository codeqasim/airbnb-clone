
<?php
use yii\helpers\Html;
use backend\models\Admin;
$baseUrl = Yii::$app->request->baseUrl;
use yii\bootstrap\ActiveForm;
$this->title = 'Email Management';
$this->params['subtitle'] = ''. Yii::t('app','Email Management').'';
$this->params['breadcrumbs'][]= '';
if(!empty($sitesetting))
{
	$supportemail = $sitesetting->supportemail;
	$noreplyname = $sitesetting->noreplyname;
	$noreplyemail = $sitesetting->noreplyemail;
	$noreplypassword = $sitesetting->noreplypassword;
	$smtpenable = $sitesetting->gmail_smtp;
	$smtpport = $sitesetting->smtp_port;
}
?>

	<div class="panel panel-default" data-widget='{"draggable": "false"}'>
		<div class="panel-heading">
			<h2><?php echo Yii::t('app','Basic Form Elements');?></h2>
				<!--div class="panel-ctrls"
					data-actions-container="" 
					data-action-collapse='{"target": ".panel-body"}'
					data-action-expand=''
					data-action-colorpicker=''
				>
				</div-->
		</div>
		<div class="panel-editbox" data-widget-controls=""></div>
		<div class="panel-body">

			<?php
			$form = ActiveForm::begin([
				'options' => ['enctype'=>'multipart/form-data','class'=>'form-horizontal row-border'],
				]);
				echo '<div class="form-group">
					<label class="col-sm-2 control-label">'. Yii::t('app','Support Email').'</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="supportemail" name="supportemail" value="'.$supportemail.'">
					</div>
					<div class="supporterrcls errorcls"></div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">'. Yii::t('app','Site no-reply name for email').'</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="noreplyname" name="noreplyname" value="'.$noreplyname.'">
					</div>
					<div class="noreplynameerrcls errorcls"></div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">'. Yii::t('app','Site no-reply email').'</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="noreplyemail" name="noreplyemail" value="'.$noreplyemail.'">
					</div>
					<div class="noreplyemailerrcls errorcls"></div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">'. Yii::t('app','Site no-reply email password').'</label>
					<div class="col-sm-8">
						<input type="password" class="form-control" id="noreplypassword" name="noreplypassword" value="'.$noreplypassword.'">
					</div>
					<div class="noreplypwderrcls errorcls"></div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">'. Yii::t('app','Gmail SMTP Gateway').'</label>
					<div class="col-sm-8">';
					if(isset($smtpenable) && $smtpenable!="")
					{
						if($smtpenable=="enable")
						{
							echo '<label class="radio-inline icheck">
								<input type="radio" id="inlineradio1" value="'. Yii::t('app','enable').'" name="smtpenable" class="enablesmtp" checked> '. Yii::t('app','Enable').'
							</label>
							<label class="radio-inline icheck">
								<input type="radio" id="inlineradio2" value="'. Yii::t('app','disable').'" name="smtpenable" class="disablesmtp" > '. Yii::t('app','Disable').'
							</label>';
						}
						else if($smtpenable=="disable")
						{
							echo '<label class="radio-inline icheck">
								<input type="radio" id="inlineradio1" value="'. Yii::t('app','enable').'" name="smtpenable" class="enablesmtp"> '. Yii::t('app','Enable').'
							</label>
							<label class="radio-inline icheck">
								<input type="radio" id="inlineradio2" value="'. Yii::t('app','disable').'" name="smtpenable" checked class="disablesmtp"> '. Yii::t('app','Disable').'
							</label>';							
						}
					}
					else
					{
						echo '<label class="radio-inline icheck">
							<input type="radio" id="inlineradio1" value="'. Yii::t('app','enable').'" name="smtpenable" checked class="enablesmtp">'. Yii::t('app','Enable').'
						</label>
						<label class="radio-inline icheck">
							<input type="radio" id="inlineradio2" value="'. Yii::t('app','disable').'" name="smtpenable" class="disablesmtp" >'. Yii::t('app','Disable').'
						</label>';						
					}
					echo '</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">'. Yii::t('app','Gmail SMTP Port Number').'</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" name="smtpport" id="smtpport" value="'.$smtpport.'" onkeypress="return isNumber(event);">
					</div>
					<div class="smtpporterrcls errorcls"></div>
				</div>';
				echo '<div class="panel-footer">
					<div class="row">
						<div class="col-sm-8 col-sm-offset-2">';
		echo Html::submitButton(''. Yii::t('app','Submit').'', ['class' => 'btn-primary btn', 'name' => 'signup-button','onclick' => 'return emailManagementValidate();']);
							echo '
						</div>
					</div>
				</div>';				
			ActiveForm::end();

		echo '</div>
	</div>';
	?>


