<?php

/*
 * This page displays the user verification information. User can verify their phone number and email here.
 *
 * @author: Muthumareeswari
 * @package: Views
 * @PHPVersion: 5.4
 */
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;
use frontend\models\Currency; 
use common\models\User;
use frontend\models\Listing; 
use backend\components\Myclass;


$this->title = 'Inbox';
$baseUrl = Yii::$app->request->baseUrl;
?> 

<div class="profile_head">
	<div class="container no-hor-padding">    
    <ul class="col-sm-12 profile_head_menu list-unstyled">
		<?php 
      echo '<li><a href="'.$baseUrl.'/dashboard">'.Yii::t('app','Dashboard').'</a></li>
       	<li class="active"><a href="'.$baseUrl.'/user/messages/inbox/traveling">'.Yii::t('app','Inbox').'</a></li> 
        <li><a href="'.$baseUrl.'/user/listing/mylistings">'.Yii::t('app','Listing').'</a></li>
        <li><a href="'.$baseUrl.'/user/listing/trips">'.Yii::t('app','Trips').'</a></li>
        <li><a href="'.$baseUrl.'/editprofile">'.Yii::t('app','Profile').'</a></li>
        <li><a href="'.$baseUrl.'/user/listing/notifications">'.Yii::t('app','Account').'</a></li>';
        if (!Yii::$app->user->isGuest) {
	        $loguserid = Yii::$app->user->identity->id;
	        $userHostStatus = Yii::$app->user->identity->hoststatus;
	        $userListings = Listing::find()->where(['userid'=>$loguserid])->all();

	        	if($userHostStatus == 1 && count($userListings) > 0) {
	        		echo '<li><a href="'.$baseUrl.'/user/listing/calendar">'.Yii::t('app','Calender').'</a></li>';
	        	}
	      } 
		?>
    </ul>
  </div> <!--container end -->
</div> <!--profile_head end -->


<div class="bg_gray1">
	<div class="container">
    <?php
			if(isset($otherUserData->profile_image) && $otherUserData->profile_image!="") {
				$userprofile = Yii::$app->urlManager->createAbsoluteUrl ( '/albums/images/users/'.$otherUserData->profile_image);
			} else {
				$userprofile = Yii::$app->urlManager->createAbsoluteUrl ( '/albums/images/users/usrimg.jpg');
			}
			$userprofileurl = Yii::$app->urlManager->createAbsoluteUrl ('resized.php?src='.$userprofile.'&w=150&h=150');
		
			$id = $otherUserData->id;
			$receivername = base64_encode($id."-".rand(0,999));
			$receiverurl = Yii::$app->urlManager->createAbsoluteUrl('/profile/'.$receivername);

			if(isset($shippingaddress) && !empty($shippingaddress)) {
				$city = (isset($shippingaddress->city) && $shippingaddress->city != '') ? $shippingaddress->city.', ' : '';
				$state = (isset($shippingaddress->state) && $shippingaddress->state != '') ? $shippingaddress->state.', ' : '';

				$country = (!empty($countrydata)) ? $countrydata->countryname : "";
			} else {
				$city = "";	$state = "";	$country = "";
			}
		?>

	    <div class="no-hor-padding col-xs-12 margin_bottom20"> 
			<div class="airfcfx-message-client-section airfcfx-panel panel panel-default margin_top20 col-xs-12 col-sm-4 col-md-4 col-lg-4 no-hor-padding">
				<div class="airfcfx-message-back col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right"> 
					<?php
						echo '<p><a href="'.$baseUrl.'/user/messages/inbox/'.strtolower($userType).'">'.Yii::t('app','Back').'</a></p>';   
					?>
				</div>
				<div class="airfcfx-message-conv-prof-pic-cnt col-xs-12 col-sm-12 col-md-12 col-lg-12 margin_top30">  
					<?php
						echo '<span class="airfcfx-message-conv-prof-pic profile_pict" style="background-image:url('.$userprofileurl.');">';
						if($otherUserData->emailverify==1 && $otherUserData->mobileverify==1)
							echo '<span class="airfcfx-verified"></span>';
						echo '</span>';
					?>
				</div>
				<?php
					echo '<div class="airfcfx-message-client-name col-xs-12 col-sm-12 col-md-12 col-lg-12"><a href="'.$receiverurl.'" target="_blank">'.$otherUserData->firstname.'</a> 	</div>';   
				?>
				<div class="airfcfx-message-client-address col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<?= ucfirst($city).ucfirst($state).ucfirst($country); ?>				
				</div>

				<div class="airfcfx-message-client-info col-xs-12 col-sm-12 col-md-12 col-lg-12 margin_top30">
					<?php if(count($reservations) == 0) {
						echo '<h3>'.Yii::t('app','Inquiry Details').'</h3>';
					} else {
						if($loguserid == $message->senderid){
							echo '<h3>'.Yii::t('app','Trip Details').'</h3>';
						} else if($loguserid == $message->receiverid){
							echo '<h3>'.Yii::t('app','Reservation Details').'</h3>';
						}
					} ?>				
				</div>
				<div class="airfcfx-message-client-date col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding margin_top10">
					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
					<?php 
						$listingData = $message->getListing()->where(['id'=>$message->listingid])->one();
						$list_url = base64_encode($message->listingid.'_'.rand(1111,9999));
   					$list_url = Yii::$app->urlManager->createAbsoluteUrl ( '/user/listing/view/' . $list_url );
						echo '<a href="'.$list_url.'" target="_blank">'.$listingData->listingname.'</a>';    
					?>				
					</div>
					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right">
						<?php 
							if($resultarray['durationType'] == "pernight")
								echo Yii::t('app','Per Night');
							else
								echo Yii::t('app','Per Hour');
						?>
					</div>
				</div>
				<div class="clear"></div><hr class="airfcfx-horizontal-line">
				<div class="airfcfx-message-client-date col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
						<span><?= Yii::t('app','Check in'); ?></span><br/>
						<span><?= date('d M Y', strtotime($message->checkin)); ?></span>
						
						<?php if($resultarray['durationType'] == "perhour") { ?>
							<br/><span><?= date('(h:i A)', strtotime($message->checkin)); ?></span>
						<?php } elseif ($resultarray['durationType'] == "pernight") {
							$Timing = "";
							if($message->type == "inquiry") {
								$Timing = ($listdata->pernight_availablity!=NULL && $listdata->pernight_availablity!="") ? explode('*|*',trim($listdata->pernight_availablity)) : "";
							} else if($message->type == "booked" && count($reservations) > 0) {
								$Timing = ($reservations->hourly_booked!=NULL && $reservations->hourly_booked!="") ? explode('*|*',trim($reservations->hourly_booked)) : "";
							}
							if(count($Timing)>0) { ?>
								<br/><span><?= date("g:i a", strtotime($Timing[0])); ?></span>
							<?php }

						} ?>
						
					</div>			
					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
						<span><?= Yii::t('app','Check out'); ?></span><br/>
						<span><?= date('d M Y', strtotime($message->checkout)); ?></span>
						<?php if($resultarray['durationType'] == "perhour") { ?>
							<br/><span><?= date('(h:i A)', strtotime($message->checkout)); ?></span>
						<?php } elseif ($resultarray['durationType'] == "pernight") {
							if(count($Timing)>0) { ?> 
								<br/><span><?= date("g:i a", strtotime($Timing[1])); ?></span>
							<?php }

						} ?>
					</div>			
				</div>
				<div class="clear"></div><hr class="airfcfx-horizontal-line">
				<div class="airfcfx-message-client-guest col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
						<span><?= Yii::t('app','Guests'); ?></span><br/>
						<span><?= $message->guest." ". Yii::t('app','Members'); ?></span>
					</div>			
				</div>

				<?php if(count($reservations) > 0) { ?>
					<div class="clear"></div><hr class="airfcfx-horizontal-line">
					<div class="airfcfx-message-client-guest col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
						<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
							<span><?= Yii::t('app','Booking Status'); ?></span><br/>
							<span><?= ucfirst($reservations->bookstatus); ?></span>
						</div>			
					</div>
				<?php } ?>


				<?php if(count($reservations) == 0) { ?>
					<div class="airfcfx-message-client-total col-xs-12 col-sm-12 col-md-12 col-lg-12 margin_top40">
						<h3><?= Yii::t('app','Payment'); ?></h3>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding margin_top20">
							<div class="col-xs-7 col-sm-7 col-md-7 col-lg-8 no-hor-padding">
								<?php 
									if(($resultarray['durationType'] == "pernight") && ($resultarray['totalDays'] > 1)) {
										$durationLabel = "Nights";
									} elseif ($resultarray['durationType'] == "pernight") {
										$durationLabel = "Night";
									} elseif (($resultarray['durationType'] == "perhour") && ($resultarray['totalDays'] > 1)) {
										$durationLabel = "Hours";
									} elseif ($resultarray['durationType'] == "perhour") {
										$durationLabel = "Hour";
									} else {
										$durationLabel = "N/A";
									}
								?>
								<?= $resultarray['currencySymbol'].$resultarray['unitPrice']." X ".$resultarray['totalDays']." ".$durationLabel; ?>

							</div>
							<div class="col-xs-5 col-sm-5 col-md-5 col-lg-4 text-right">
								<?= $resultarray['currencySymbol'].number_format($resultarray['totalListingPrice'],2,".",""); ?>
							</div>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding margin_top5">
							<div class="col-xs-7 col-sm-7 col-md-7 col-lg-8 no-hor-padding">
								<?= Yii::t('app','Security Deposit'); ?>
							</div>
							<div class="col-xs-5 col-sm-5 col-md-5 col-lg-4 text-right">
								<?= $resultarray['currencySymbol'].number_format($resultarray['securityDeposit'],2,".",""); ?>
							</div>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding margin_top5">
							<div class="col-xs-7 col-sm-7 col-md-7 col-lg-8 no-hor-padding">
								<?= Yii::t('app','Commission'); ?>
							</div>
							<div class="col-xs-5 col-sm-5 col-md-5 col-lg-4 text-right">
								<?= $resultarray['currencySymbol'].number_format($resultarray['commissionAmount'],2,".",""); ?>
							</div>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding margin_top5">
							<div class="col-xs-7 col-sm-7 col-md-7 col-lg-8 no-hor-padding">
								<?= Yii::t('app','Site Charge')." + ".Yii::t('app','Taxes'); ?>
							</div>
							<div class="col-xs-5 col-sm-5 col-md-5 col-lg-4 text-right">
								<?php $addCal = $resultarray['siteAmount']+$resultarray['taxAmount']; ?>
								<?=	$resultarray['currencySymbol'].number_format($addCal,2,".",""); ?>
							</div>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding margin_top5">
							<div class="col-xs-7 col-sm-7 col-md-7 col-lg-8 no-hor-padding">
								<?= Yii::t('app','Cleaning fee + Service fee'); ?>
							</div>
							<div class="col-xs-5 col-sm-5 col-md-5 col-lg-4 text-right">
								<?php $addCal = $resultarray['cleaningFees']+$resultarray['serviceFees']; ?>
								<?=	$resultarray['currencySymbol'].number_format($addCal,2,".",""); ?>
							</div>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding margin_top15">
							<div style="border-bottom: 2px solid #9b9b9b;" ></div>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding margin_top15">
							<div class="col-xs-7 col-sm-7 col-md-7 col-lg-8 no-hor-padding">
								<b><?= Yii::t('app','Total'); ?></b>
							</div>
							<div class="col-xs-5 col-sm-5 col-md-5 col-lg-4 text-right">
								<?=	$resultarray['currencySymbol'].number_format($resultarray['grandTotal'],2,".",""); ?> 
							</div> 
						</div> 
					</div>
				<?php } else { 
						if($reservations->booking == "perhour") {
	                  $nightprice = $reservations->pricepernight * $reservations->totalhours;
	                  $totaldays = $reservations->totalhours;
	                } else {
	                  $nightprice = $reservations->pricepernight * $reservations->totaldays;
	                  $totaldays = $reservations->totaldays;
	                }

						if($userType == "traveling" && $loguserid == $reservations->userid) {
		                $currencyData = Currency::find()->where(['currencycode'=>$reservations->convertedcurrencycode])->one();
		                $currencySymbol = $currencyData['currencysymbol'];
		                $rate = $reservations->convertedprice; 

		                $price = number_format(round($reservations->pricepernight/$rate,2),2,".","");  
		                $nightprice = number_format(round($nightprice/$rate,2),2,".","");  
		                $commissionfees = number_format(round($reservations->commissionfees/$rate,2),2,".","");

		                $servicefees = ($reservations->servicefees > 0 && $reservations->servicefees != NULL) ? number_format(round($reservations->servicefees/$rate,2),2,".",""): "0.00" ; 

		                $securityfees = ($reservations->securityfees > 0 && $reservations->securityfees != NULL) ? number_format(round($reservations->securityfees/$rate,2),2,".",""): "0.00" ; 

		                $taxfees = ($reservations->taxfees > 0 && $reservations->taxfees != NULL) ? number_format(round($reservations->taxfees/$rate,2),2,".",""): "0.00" ; 

		                $cleaningfees = ($reservations->cleaningfees > 0 && $reservations->cleaningfees != NULL) ? number_format(round($reservations->cleaningfees/$rate,2),2,".",""): "0.00" ; 

		                $sitefees = ($reservations->sitefees > 0 && $reservations->sitefees != NULL) ? number_format(round($reservations->sitefees/$rate,2),2,".",""): "0.00" ;   

		                $totalprice = $nightprice + $commissionfees + $servicefees + $securityfees + $taxfees + $cleaningfees + $sitefees;
						} elseif ($userType == "hosting" && $loguserid == $reservations->hostid) {
							$currencyData = Currency::find()->where(['currencycode'=>$reservations->currencycode])->one();
		                $currencySymbol = $currencyData['currencysymbol'];

		                $price = number_format(round($reservations->pricepernight,2),2,".","");  
		                $nightprice = number_format(round($nightprice,2),2,".","");  
		                $commissionfees = number_format(round($reservations->commissionfees,2),2,".","");

		                $servicefees = ($reservations->servicefees > 0 && $reservations->servicefees != NULL) ? number_format(round($reservations->servicefees,2),2,".",""): "0.00" ; 

		                $securityfees = ($reservations->securityfees > 0 && $reservations->securityfees != NULL) ? number_format(round($reservations->securityfees,2),2,".",""): "0.00" ; 

		                $taxfees = ($reservations->taxfees > 0 && $reservations->taxfees != NULL) ? number_format(round($reservations->taxfees,2),2,".",""): "0.00" ; 

		                $cleaningfees = ($reservations->cleaningfees > 0 && $reservations->cleaningfees != NULL) ? number_format(round($reservations->cleaningfees,2),2,".",""): "0.00" ; 

		                $sitefees = ($reservations->sitefees > 0 && $reservations->sitefees != NULL) ? number_format(round($reservations->sitefees,2),2,".",""): "0.00" ;   

		                $totalprice = $nightprice + $commissionfees + $servicefees + $securityfees + $taxfees + $cleaningfees + $sitefees;
						}

					?>


					<div class="airfcfx-message-client-total col-xs-12 col-sm-12 col-md-12 col-lg-12 margin_top40">
						<h3><?= Yii::t('app','Payment'); ?></h3>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding margin_top20">
							<div class="col-xs-7 col-sm-7 col-md-7 col-lg-8 no-hor-padding">
								<?php 
									if(($reservations->booking == "pernight") && ($totaldays > 1)) {
										$durationLabel = "Nights";
									} elseif ($reservations->booking == "pernight") {
										$durationLabel = "Night";
									} elseif (($reservations->booking == "perhour") && ($totaldays > 1)) {
										$durationLabel = "Hours";
									} elseif ($reservations->booking == "perhour") {
										$durationLabel = "Hour";
									} else {
										$durationLabel = "N/A";
									}
								?>
								<?= $currencySymbol.$price." X ".$totaldays." ".$durationLabel; ?>

							</div>
							<div class="col-xs-5 col-sm-5 col-md-5 col-lg-4 text-right">
								<?= $currencySymbol.$nightprice; ?>
							</div>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding margin_top5">
							<div class="col-xs-7 col-sm-7 col-md-7 col-lg-8 no-hor-padding">
								<?= Yii::t('app','Security Deposit'); ?>
							</div>
							<div class="col-xs-5 col-sm-5 col-md-5 col-lg-4 text-right">
								<?= $currencySymbol.$securityfees; ?>
							</div>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding margin_top5">
							<div class="col-xs-7 col-sm-7 col-md-7 col-lg-8 no-hor-padding">
								<?= Yii::t('app','Commission'); ?>
							</div>
							<div class="col-xs-5 col-sm-5 col-md-5 col-lg-4 text-right">
								<?= $currencySymbol.$commissionfees; ?>
							</div>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding margin_top5">
							<div class="col-xs-7 col-sm-7 col-md-7 col-lg-8 no-hor-padding">
								<?= Yii::t('app','Site Charge')." + ".Yii::t('app','Taxes'); ?>
							</div>
							<div class="col-xs-5 col-sm-5 col-md-5 col-lg-4 text-right">
								<?php $addCal = $sitefees+$taxfees; ?>
              				<?= $currencySymbol.number_format(round($addCal,2),2,".",""); ?>
							</div>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding margin_top5">
							<div class="col-xs-7 col-sm-7 col-md-7 col-lg-8 no-hor-padding">
								<?= Yii::t('app','Cleaning fee + Service fee'); ?>
							</div>
							<div class="col-xs-5 col-sm-5 col-md-5 col-lg-4 text-right">
								<?php $addCal = $cleaningfees+$servicefees; ?>
              				<?= $currencySymbol.number_format(round($addCal,2),2,".",""); ?> 
							</div>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding margin_top15">
							<div style="border-bottom: 2px solid #9b9b9b;" ></div>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding margin_top15">
							<div class="col-xs-7 col-sm-7 col-md-7 col-lg-8 no-hor-padding">
								<b><?= Yii::t('app','Total'); ?></b>
							</div>
							<div class="col-xs-5 col-sm-5 col-md-5 col-lg-4 text-right">
								<?= $currencySymbol.$totalprice; ?>   
							</div> 
						</div> 
					</div>


				<?php } ?>  




				<?php 
					echo '<input type="hidden" name="checkoutpay_booking" id="checkoutpay_booking" value="'.$resultarray['durationType'].'"/>';
				?>
				<div class="airfcfx-message-client-total col-xs-12 col-sm-12 col-md-12 col-lg-12 margin_top30">
					<?php $aStyle = 'style="width:100%;"';
					if(count($reservations) == 0) {

						$today = strtotime(Myclass::getTime($listingData->timezone)); 
						date_default_timezone_set('UTC');

                  $reservetime = strtotime($message->checkin); 

						if($message->senderid == $loguserid && count($otherguestreservations) == 0 && $reservetime > $today) { 
								if($blockStatus == "enabled") {
									echo '<div class="brightred btn-pad btn btn-danger full_width" style="cursor:default;">'.Yii::t('app','Not Available').'</div>';
								} else { 
									ActiveForm::begin(['id' => 'form-checkoutpay','action'=>''.$baseUrl.'/user/listing/sendrequest']);
									echo '<input type="hidden" name="checkoutpay_listid" id="checkoutpay_listid" value="'.$message->listingid.'"/>'; 
									echo '<input type="hidden" name="checkoutpay_book_type" id="checkoutpay_book_type" value="inquiry"/>'; 
									echo '<input type="hidden" name="checkoutpay_inquiryid" id="checkoutpay_inquiryid" value="'.$message->id.'"/>'; 
									echo '<button type="submit" onclick="" id="requestbtn" class="bold-font btn btn_dashboard margin_top20 full_width">';					 
									     echo '<span>'. Yii::t('app','Pay').'</span>';
									echo '</button>';

									ActiveForm::end();
								} 
						} if($message->senderid == $loguserid && count($otherguestreservations) > 0 && $reservetime > $today) { 
							echo '<div class="brightred btn-pad btn btn-danger full_width" style="cursor:default;">'.Yii::t('app','Not Available').'</div>';
						} else if($reservetime < $today) {
							echo '<div class="brightred btn-pad btn btn-danger full_width" style="cursor:default;">'.Yii::t('app','Expired').'</div>'; 
						}  
					} else {
						$today = strtotime(Myclass::getTime($reservations->timezone)); 
						date_default_timezone_set('UTC');
   
						if($reservations->userid == $loguserid && strtotime($reservations->checkin) > $today && $reservations->bookstatus == "requested") {

							echo '<input type="button" value="'.Yii::t('app','Cancel').'" id="btn_cancel" class="bold-font btn btn_dashboard btn-danger margin_top20" onclick="change_msgreserve_status(\'guest\',\'cancel\',\''.$reservations->id.'\')"'.$aStyle.'>'; 

						} elseif ($reservations->hostid == $loguserid && strtotime($reservations->checkin) > $today && $reservations->bookstatus == "requested") { ?> 
								<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
									<?php echo '<input type="button" value="'.Yii::t('app','Accept').'" id="btn_accept" class="bold-font btn btn_dashboard btn-danger margin_top20" onclick="change_msgreserve_status(\'host\',\'accept\',\''.$reservations->id.'\')"'.$aStyle.'>';
									?>
								</div>
								<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
									<?php echo '<input type="button" value="'.Yii::t('app','Decline').'" id="btn_decline" class="bold-font btn btn_dashboard btn-danger margin_top20" onclick="change_msgreserve_status(\'host\',\'decline\',\''.$reservations->id.'\')"'.$aStyle.'>';
									?>  
								</div> 
						<?php } else {  
							//echo '<div class="errcls centertxt" id="maxstayerr">'.Yii::t('app','Booked').'</div>';
							echo '<div class="brightred btn-pad btn btn-danger full_width" style="cursor:default;">'.ucfirst(Yii::t('app',$reservations->bookstatus)).'</div>';

							if($reservations->userid == $loguserid && strtotime($reservations->checkin) > $today && $reservations->bookstatus == "accepted" && $reservations->sdstatus == "pending" && $reservations->orderstatus == "pending" && $reservations->other_transaction == NULL) {
								echo '<input type="button" value="'.Yii::t('app','Cancel').'" id="btn_cancel" class="bold-font btn btn_dashboard btn-danger margin_top20" onclick="change_msgreserve_status(\'guest\',\'cancel\',\''.$reservations->id.'\')"'.$aStyle.'>';
							} 

						}   
					} ?>

					<div class="airfcfx-message-loader col-xs-12 col-sm-12 col-md-12 col-lg-12 margin_top20 text-center">
						<img id="loadingimg" src="<?php echo $baseUrl; ?>/images/load.gif" class="msgLoader">  
					</div>
				</div>
			</div>
        	
        	<div class="xs-no-hor-padding col-xs-12 col-sm-8 col-md-8 col-lg-8">
            <div class="airfcfx-panel panel panel-default margin_top20">
              <div class="airfcfx-panel airfcfx-panel-padding panel-heading profile_menu1">  
              	<h3><?php echo Yii::t('app','View Conversation Messages');?></h3>
              </div>

              <div class="airfcfx-panel-padding panel-body">
								<?php
									if($loguserid==$message->senderid) {
										$hostid = $message->receiverid;
									}	else if($loguserid==$message->receiverid)	{
										$hostid = $message->senderid;
									}
									$listingid = $message->listingid;
								?>
								<input type="hidden" id="listingid" value="<?php echo $listingid;?>">
								<input type="hidden" id="userid" value="<?php echo $loguserid;?>">					
								<input type="hidden" id="hostid" value="<?php echo $hostid;?>">
								<input type="hidden" id="inquiryid" value="<?php echo $message->id;?>">


								<input type="hidden" id="senderid" value="<?php echo  $senderid?>">
								<input type="hidden" id="receiverid" value="<?php echo  $receiverid?>">
                
                <?php
									$userimage = $userdata->profile_image;
									if($userimage=="")
										$userimage="usrimg.jpg";
									$userimageurl = Yii::$app->urlManager->createAbsoluteUrl ( '/albums/images/users/'.$userimage);
									$resized_user_image = Yii::$app->urlManager->createAbsoluteUrl ('resized.php?src='.$userimageurl.'&w=60&h=60');	
									$hiffen='-';
					
									$newcls=$listingid.$hiffen.$loguserid.$hiffen.$hostid;		
					 				$receiverDetails = User::find()->where(['id' => $hostid])->One();		
									
									echo '<div class="col-xs-12 no-hor-padding">
										<span class="airfcfx-user-icon profile_pict inlinedisplay" style="background-image:url('.$resized_user_image.');float:left;"></span>
										<textarea rows="6" cols="80" class="airfcfx-inbox-txtarea txtarea contactextarea" id="contactmessage" maxlength="500" style="float:left; resize: vertical; "></textarea>
										<input type="button" value="'.Yii::t('app','Send').'" class="airfcfx-panel btn btn-danger sendbtn tripsendbtn" style="top:0px;float:left;">
									</div>';
						
									echo '<div class="live-messages-typing-'.$newcls.' typing-status col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding" style="text-align:center;opacity:0;">'.$receiverDetails->firstname.' '.Yii::t("app","is typing ...").'</div>';
									echo '<div class="msgerrcls" style="margin-left: 70px;margin-top: 70px;"></div>';
									
									echo '<div id="messagesdiv" class="msgbox-'.$newcls.'">';
										$adminimage = Yii::$app->urlManager->createAbsoluteUrl('/albums/images/users/usrimg.jpg');

										if($loguserid==$senderdata->id) {
											$senderurl = base64_encode($senderdata->id."-".rand(0,999));
											$receiverurl = base64_encode($receiverdata->id."-".rand(0,999));
										} else {
											$receiverurl = base64_encode($senderdata->id."-".rand(0,999));
											$senderurl = base64_encode($receiverdata->id."-".rand(0,999));
										} 

										foreach($messages as $message) {
											if($loguserid==$message->senderid) {
												$senderdata = $message->getSender()->where(['id'=>$message->senderid])->one();
												$senderimg = $senderdata->profile_image;
												
												if($senderimg=="")
													$senderimg = "usrimg.jpg";
												
												$senderimage = Yii::$app->urlManager->createAbsoluteUrl ( '/albums/images/users/'.$senderimg);
												$resized_sender_image = Yii::$app->urlManager->createAbsoluteUrl ('resized.php?src='.$senderimage.'&w=60&h=60');	
												
												echo '<div class="claimleft">
													<div class="airfcfx-claimleftimgdiv claimleftimgdiv">
														<span class="airfcfx-user-icon profile_pict inlinedisplay" style="background-image:url('.$resized_sender_image.');"></span>
													</div>
													<div class="airfcfx-claimrighttextdiv claimrighttextdiv">
														<span class="airfcfx-left-chat-arrow"></span>
														<a href="'.Yii::$app->urlManager->createAbsoluteUrl('/profile/'.$senderurl).'">'.$senderdata->firstname.'</a>
														<span class="airfcfx-message-date padleft">'.date('d,M Y',strtotime($message->cdate)).'</span>
														<br />
														<span class="mobmsgalgn">'.$message->message.'</span>
													</div>
												</div>
												<div class="clear"></div>';		
											} else if($loguserid==$message->receiverid) {
												$receiverdata = $message->getSender()->where(['id'=>$message->senderid])->one();
												$receiverimg = $receiverdata->profile_image;
												
												if($receiverimg=="")
													$receiverimg = "usrimg.jpg";

												$receiverimage = Yii::$app->urlManager->createAbsoluteUrl ( '/albums/images/users/'.$receiverimg);
												$resized_receiver_image = Yii::$app->urlManager->createAbsoluteUrl ('resized.php?src='.$receiverimage.'&w=60&h=60');		
												echo '<div class="claimright">
													<div class="claimdiv">
														<div class="airfcfx-claimrightimgdiv claimrightimgdiv">
															<span class="airfcfx-user-icon profile_pict inlinedisplay" style="background-image:url('.$resized_receiver_image.');"></span>
														</div>
														<div class="airfcfx-claimlefttextdiv claimlefttextdiv">
															<span class="airfcfx-right-chat-arrow"></span>
															<span class="airfcfx-message-date padright">'.date('d,M Y',strtotime($message->cdate)).'</span>
															<a href="'.Yii::$app->urlManager->createAbsoluteUrl('/profile/'.$receiverurl).'">'.$receiverdata->firstname.'</a>
															<br />
															<span class="mobmsgalgn">'.$message->message.'</span>
														</div>
													</div>
												</div>
												<div class="clear"></div>';				
											}
										} 
									echo '</div>'; 
								?>
              </div>
            </div>
                  
          </div> <!--col-sm-12 end-->
      	</div> <!--col-xs-12 end-->
		</div> <!-- container end -->
	</div> 

<script src="<?php echo $baseUrl;?>/js/node_modules/socket.io-client/dist/socket.io.js"></script>
<script src="<?php echo $baseUrl;?>/js/nodeClient.js"></script>

<script type="text/javascript">
$(document).ready(function(){
	socket.emit( 'join', { joinId: '<?php echo $inquiryId;?>' } );  
});
</script>
<style type="text/css">
	.msgLoader {
		display: none; 
	}
</style>

