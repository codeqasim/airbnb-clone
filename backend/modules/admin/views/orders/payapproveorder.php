<?php 
if($sitesettings->paymenttype == 'sandbox'){
 	echo "<form action='https://www.sandbox.paypal.com/cgi-bin/webscr' method='post' id='mobile-paypal-form'>";
 }else if($sitesettings->paymenttype == 'live'){
 	echo "<form action='https://www.paypal.com/cgi-bin/webscr' method='post' id='mobile-paypal-form'>";
 } 	
 ?>
 <?php
 $price = (($reservation->pricepernight * $reservation->totaldays) + $reservation->taxfees) - $reservation->commissionfees;
 ?>
	<input type="hidden" name="business" value="<?php echo $hostdata->paypalid; ?>"/>
	<input type="hidden" name="cmd" value="_xclick" /> 
	<input type="hidden" name="upload" value="1">
	<input type="hidden" name="no_note" value="1" />
	<input type="hidden" name="lc" value="UK" />
	<input type="hidden" name="currency_code" value="<?php echo $reservation->currencycode; ?>" />
	<input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynow_LG.gif:NonHostedGuest" />
	<input type="hidden" name="item_name" value="<?php echo $listdata->listingname; ?>"/>
	<input type="hidden" name="item_number" value="<?php echo $reservation->id; ?>"/>
	<input type="hidden" name="amount" value="<?php echo $price; ?>">
	<input type='hidden' name='custom' value='<?php echo $reservation->id; ?>'>

	<input type="hidden" name="cancel_return" value="<?php echo Yii::$app->urlManager->createAbsoluteUrl('/admin/orders/paidorders',array('status'=>'pending')); ?>">
	<input type="hidden" name="return" value="<?php echo Yii::$app->urlManager->createAbsoluteUrl('/admin/orders/paidorders',array('status'=>'paid')); ?>">	
 	<input type="hidden" name="notify_url" value="<?php echo Yii::$app->urlManager->createAbsoluteUrl('/admin/orders/paidipnprocess'); ?>"/>
</form> 

