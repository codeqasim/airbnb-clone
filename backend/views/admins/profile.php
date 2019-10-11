
<?php
use yii\helpers\Html;
use backend\models\Admin;
$baseUrl = Yii::$app->request->baseUrl;
use yii\bootstrap\ActiveForm;
$this->title = 'Profile';
$this->params['subtitle'] = ''. Yii::t('app','Profile').'';
$this->params['breadcrumbs'][]= '';
if(!empty($user))
{
	$adminemail = $user->email;
	$adminpassword = base64_decode($user->password);
}
else
{
	$adminemail = "";
	$adminpassword = "";
}
?>

	<div class="panel panel-default" data-widget='{"draggable": "false"}'>
		<div class="panel-heading">
			<h2><?php echo Yii::t('app','Profile');?></h2>
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
					<label class="col-sm-2 control-label">'. Yii::t('app','Email').'</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="adminemail" name="adminemail" value="'.$adminemail.'">
					</div>
					<div class="adminemailerrcls errorcls"></div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">'. Yii::t('app','Password').'</label>
					<div class="col-sm-8">
						<input type="password" class="form-control" id="adminpassword" name="adminpassword" value="'.$adminpassword.'">
					</div>
					<div class="adminpasserrcls errorcls"></div>
				</div>';

				echo '<div class="panel-footer">
					<div class="row">
						<div class="col-sm-8 col-sm-offset-2">';
		echo Html::submitButton(''. Yii::t('app','Submit').'', ['class' => 'btn-primary btn', 'name' => 'signup-button','onclick' => 'return adminemailvalidate();']);
							echo '
						</div>
					</div>
				</div>';				
			ActiveForm::end();

		echo '</div>
	</div>';
	?>


