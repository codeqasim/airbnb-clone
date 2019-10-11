
<?php
use backend\models\Admin;
$baseUrl = Yii::$app->request->baseUrl;
use yii\bootstrap\ActiveForm;
$this->title = 'Paypal Settings';
$this->params['subtitle'] = ''. Yii::t('app','Paypal Settings').'';
$this->params['breadcrumbs'][]= '';
if(!empty($model->paymenttype))
{
	$paymenttype = $model->paymenttype;
	$paypaladaptive = json_decode($model->paypaladaptive,true);
	$emailid = $model->paypalid;
	$apiuserid = $paypaladaptive['apiUserId'];
	$apipassword = $paypaladaptive['apiPassword'];
	$apisignature = $paypaladaptive['apiSignature'];
	$appid = $paypaladaptive['apiApplicationId'];
	$braintreepaymenttype = $model->braintreepaymenttype;
	$braintreemerchantid = $model->braintreemerchantid;
	$braintreepublickey = $model->braintreepublickey;
	$braintreeprivatekey = $model->braintreeprivatekey;
}
else
{
	$paymenttype = "";
	$emailid = "";
	$apiuserid = "";
	$apipassword = "";
	$apisignature = "";
	$appid = "";
	$braintreepaymenttype = "";
	$braintreemerchantid = "";
	$braintreepublikey = "";
	$braintreeprivatekey = "";
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
					<label class="col-sm-2 control-label">'. Yii::t('app','Paypal Type').'</label>
					<div class="col-sm-8">';
					if(isset($paymenttype) && $paymenttype!="")
					{
						if($paymenttype=="production")
						{
							echo '<label class="radio-inline icheck">
								<input type="radio" id="inlineradio1" value="production" name="paymenttype" checked>'. Yii::t('app','Live').' 
							</label>
							<label class="radio-inline icheck">
								<input type="radio" id="inlineradio2" value="'. Yii::t('app','sandbox').'" name="paymenttype" > '. Yii::t('app','Sandbox').'
							</label>';
						}
						else if($paymenttype=="sandbox")
						{
							echo '<label class="radio-inline icheck">
								<input type="radio" id="inlineradio1" value="production" name="paymenttype"> '. Yii::t('app','Live').' 
							</label>
							<label class="radio-inline icheck">
								<input type="radio" id="inlineradio2" value="'. Yii::t('app','sandbox').'" name="paymenttype" checked> '. Yii::t('app','Sandbox').'
							</label>';							
						}
					}
					else
					{
						echo '<label class="radio-inline icheck">
							<input type="radio" id="inlineradio1" value="production" name="paymenttype"> '. Yii::t('app','Live').' 
						</label>
						<label class="radio-inline icheck">
							<input type="radio" id="inlineradio2" value="'. Yii::t('app','sandbox').'" name="paymenttype" checked> '. Yii::t('app','Sandbox').'
						</label>';						
					}
					echo '</div>
				</div>
				';
				echo '<div class="form-group">
					<label class="col-sm-2 control-label">'. Yii::t('app','Paypal Email ID').'</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="paypalemailid" name="paypalemailid" value="'.$emailid.'">
					</div>
					<div class="paypalemailerrcls errorcls"></div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">'. Yii::t('app','Paypal API User ID').'</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="apiuserid" name="apiuserid" value="'.$apiuserid.'">
					</div>
					<div class="apiuseriderrcls errorcls"></div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">'. Yii::t('app','Paypal API Password').'</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="apipassword" name="apipassword" value="'.$apipassword.'">
					</div>
					<div class="apipwderrcls errorcls"></div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">'. Yii::t('app','Paypal API Signature').'</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="apisignature" name="apisignature" value="'.$apisignature.'">
					</div>
					<div class="apisignerrcls errorcls"></div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">'. Yii::t('app','Paypal App ID').'</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="appid" name="appid" value="'.$appid.'">
					</div>
					<div class="appiderrcls errorcls"></div>
				</div>
				';
				echo '<div class="form-group">
					<label class="col-sm-2 control-label">'. Yii::t('app','Braintree Paypal Type').'</label>
					<div class="col-sm-8">';
					if(isset($braintreepaymenttype) && $braintreepaymenttype!="")
					{
						if($braintreepaymenttype=="production")
						{
							echo '<label class="radio-inline icheck">
								<input type="radio" id="inlineradio3" value="production" name="braintreepaymenttype" checked> '. Yii::t('app','Live').' 
							</label>
							<label class="radio-inline icheck">
								<input type="radio" id="inlineradio4" value="'. Yii::t('app','sandbox').'" name="braintreepaymenttype" > '. Yii::t('app','Sandbox').'
							</label>';
						}
						else if($braintreepaymenttype=="sandbox")
						{
							echo '<label class="radio-inline icheck">
								<input type="radio" id="inlineradio3" value="production" name="braintreepaymenttype">'. Yii::t('app','Live').' 
							</label>
							<label class="radio-inline icheck">
								<input type="radio" id="inlineradio4" value="'. Yii::t('app','sandbox').'" name="braintreepaymenttype" checked>'. Yii::t('app','Sandbox').'
							</label>';							
						}
					}
					else
					{
						echo '<label class="radio-inline icheck">
							<input type="radio" id="inlineradio3" value="production" name="braintreepaymenttype"> '. Yii::t('app','Live').' 
						</label>
						<label class="radio-inline icheck">
							<input type="radio" id="inlineradio4" value="'. Yii::t('app','sandbox').'" name="braintreepaymenttype" checked> '. Yii::t('app','Sandbox').'
						</label>';						
					}
					echo '</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">'. Yii::t('app','Braintree Merchant ID').'</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="braintreemerchantid" name="braintreemerchantid" value="'.$braintreemerchantid.'">
					</div>
					<div class="braintreemerchantiderrcls errorcls"></div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">'. Yii::t('app','Braintree Public Key').'</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="braintreepublickey" name="braintreepublickey" value="'.$braintreepublickey.'">
					</div>
					<div class="braintreepublickeyerrcls errorcls"></div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">'. Yii::t('app','Braintree Private Key').'</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="braintreeprivatekey" name="braintreeprivatekey" value="'.$braintreeprivatekey.'">
					</div>
					<div class="braintreeprivatekeyerrcls errorcls"></div>
				</div>					
				';
    
			
				echo '<div class="panel-footer">
					<div class="row">
						<div class="col-sm-8 col-sm-offset-2">
							<button class="btn-primary btn" onclick="return paypalSettingsValidate();">'. Yii::t('app','Submit').'</button>
						</div>
					</div>
				</div>';				
			ActiveForm::end();

		echo '</div>
	</div>';
	?>


