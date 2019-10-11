
<?php

use backend\models\Admin;
$baseUrl = Yii::$app->request->baseUrl;
use yii\bootstrap\ActiveForm;
$this->title = 'Stripe Settings';
$this->params['subtitle'] = ''. Yii::t('app','Stripe Settings').'';
$this->params['breadcrumbs'][]= '';

?>
	<div class="panel panel-default" data-widget='{"draggable": "false"}'>
		<div class="panel-heading">
			<h2><?php echo Yii::t('app','Stripe Account and Card Details');?></h2>
		</div>
		<div class="panel-editbox" data-widget-controls=""></div>
		<div class="panel-body">
			<?php $details = json_decode($model->stripe_card_details, true); ?>
			<?php
			$form = ActiveForm::begin([
				'options' => ['enctype'=>'multipart/form-data','class'=>'form-horizontal row-border'],
				]);
			
				echo '<div class="form-group">
					<label class="col-sm-2 control-label">'. Yii::t('app','Stripe Publishable Key').'</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="stripe_pk_key" name="stripe_publishkey" value="'.$model->stripe_publishkey.'">
					</div>
					<div class="stripe_pk_keyerrcls errorcls"></div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">'. Yii::t('app','Stripe Secret Key').'</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="stripe_sk_key" name="stripe_secretkey" value="'.$model->stripe_secretkey.'">
					</div>
					<div class="stripe_sk_keyerrcls errorcls"></div>
				</div>';

				echo '<div class="form-group">
					<div class = "col-sm-12">
					<h5>'.Yii::t("app","Add Card Details to Host Pay").'</h5><br><br>
					</div>
					<label class="col-sm-2 control-label">'. Yii::t('app','Card Number').'</label>
					<div class="col-sm-8 col-md-4">
						<input type="text" class="form-control" id="stripe_card" name="stripe_card" value="'.$details['stripe_card'].'" maxlength="16" placeholder="4242424242424242" >
					</div>
					<div class="stripe_card_keyerrcls errorcls"></div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">'. Yii::t('app','Card Expiry').'</label>
					<div class="col-sm-3 col-md-2">
						<input type="text" class="form-control" id="stripe_month" name="stripe_month" value="'.$details['stripe_month'].'" maxlength = "2" placeholder = "1 - 12">
					</div>
					<div class="col-sm-3 col-md-2">
						<input type="text" class="form-control" id="stripe_year" name="stripe_year" value="'.$details['stripe_year'].'" maxlength = "4" placeholder="'.date('Y', strtotime('+1 year')).'">
					</div>
					<div class="stripe_expiry_keyerrcls errorcls"></div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">'. Yii::t('app','Card CVC').'</label>
					<div class="col-sm-3 col-md-1">
						<input type="text" class="form-control" id="stripe_cvc" name="stripe_cvc" value="'.$details['stripe_cvc'].'" maxlength="4" placeholder="314"> 
 					</div>
					<div class="stripe_cvc_keyerrcls errorcls"></div>
				</div>';
				
				if(isset($details['stripe_hostpaydays']) && trim($details['stripe_hostpaydays'])>2)
					$payout_days = trim($details['stripe_hostpaydays']);
				else
					$payout_days = 2;

				echo '<div class="form-group">
					<div class = "col-sm-12">
					<h5>'.Yii::t("app","Days after guest checkout for host payout").'</h5><br><br>
					</div>
					<label class="col-sm-2 control-label">'. Yii::t('app','Host Payout delay days').'</label>
					<div class="col-sm-8 col-md-4">
						<input type="text" class="form-control" id="stripe_hostpaydays" name="stripe_hostpaydays" value="'.$payout_days.'" maxlength="2" placeholder="2" >
					</div>
					<div class="stripe_hostpaydays_keyerrcls errorcls"></div>
				</div>';
				
				echo '<div class="panel-footer" style="background-color: #ffffff;">
					<div class="row">
						<div class="col-sm-8 col-sm-offset-2">
							<button class="btn-primary btn" onclick="return stripeSettingsValidate();">'. Yii::t('app','Submit').'</button>
						</div>
					</div>
				</div>';				
			ActiveForm::end();

		echo '</div>
	</div>';
	?>

