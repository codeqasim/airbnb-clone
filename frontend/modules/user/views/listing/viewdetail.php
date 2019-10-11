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
use common\models\User;
use frontend\models\Currency;
use frontend\models\Listing;

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
              echo '<li class="active"><a href="'.$baseUrl.'/user/listing/calendar">'.Yii::t('app','Calender').'</a></li>';
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
        $city = ""; $state = "";  $country = "";
      }
    ?>
    <div class="no-hor-padding col-xs-12 margin_bottom20 margin_top40"> 
      <div class="airfcfx-iti"> 
        <?php if($loguserid == $senderid) {
          echo Yii::t('app','Your itinerary details').', '.$userdata->firstname;
        } else {
          echo Yii::t('app','Itinerary for your guest').', '.$otherUserData->firstname; 
        } ?>
      </div>
    </div>
    <div class="no-hor-padding col-xs-12"> 
      <div class="airfcfx-message-client-section airfcfx-panel panel panel-default col-xs-12 col-sm-8 col-md-8 col-lg-8"> 
        <div class="airfcfx-message-client-info col-xs-12 col-sm-12 col-md-12 col-lg-12 margin_top10 margin_bottom20 no-padding">  
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

        <div class="airfcfx-message-client-date col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
          <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 no-hor-padding">
            <div class="air-label col-xs-12 col-sm-6 no-hor-padding"><?= ucwords(Yii::t('app','Check in')); ?></div>
            <div class="col-xs-12 col-sm-6 no-hor-padding"><?= date('d M Y', strtotime($message->checkin)); ?><br/>
            
            <?php if($reservations->booking == "perhour") { ?>
              <br/><span><?= date('(h:i A)', strtotime($message->checkin)); ?></span>
            <?php } elseif ($reservations->booking == "pernight") {
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
          </div>   
          <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 no-hor-padding">
            <div class="air-label col-xs-12 col-sm-6 no-hor-padding"><?= ucwords(Yii::t('app','Check out')); ?></div>
            <div class="col-xs-12 col-sm-6 no-hor-padding"><?= date('d M Y', strtotime($message->checkout)); ?><br/>
            
            <?php if($reservations->booking == "perhour") { ?>
              <br/><span><?= date('(h:i A)', strtotime($message->checkout)); ?></span>
            <?php } elseif ($reservations->booking == "pernight") {
              if(count($Timing)>0) { ?> 
                <br/><span><?= date("g:i a", strtotime($Timing[0])); ?></span>
              <?php }

            } ?>
            </div>
          </div>      
            
        </div>

        <div class="clear"></div><hr class="airfcfx-horizontal-line">

        <div class="airfcfx-message-client-date col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding margin_top10">
          <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9 no-hor-padding">
            <div class="air-label col-xs-12 col-sm-4 no-hor-padding">
                <?= ucwords(Yii::t('app','Listing')); ?> 
            </div>
            <div class="col-xs-12 col-sm-8" style="padding:0px 10px 0px 0px !important;">
              <?php 
                $listingData = $message->getListing()->where(['id'=>$message->listingid])->one();
                $list_url = base64_encode($message->listingid.'_'.rand(1111,9999));
                $list_url = Yii::$app->urlManager->createAbsoluteUrl ( '/user/listing/view/' . $list_url );
                echo '<a href="'.$list_url.'" target="_blank">'.$listingData->listingname.'</a><br/><span>'.$roomData->roomtype.' / '.$homeData->hometype.'</span>';    
              ?> 
            </div>       
          </div>
          <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 text-left no-hor-padding">

            <?php 
                if(($reservations->booking == "pernight") && ($reservations->totaldays > 1)) {
                  $durationLabel = $reservations->totaldays." ".Yii::t('app','nights'); 
                } elseif ($reservations->booking == "pernight") {
                  $durationLabel = $reservations->totaldays." ".Yii::t('app','night');;
                } elseif (($reservations->booking == "perhour") && ($reservations->totalhours > 1)) {
                  $durationLabel = $reservations->totalhours.' '.Yii::t('app','hours');
                } elseif ($reservations->booking == "perhour") {
                  $durationLabel = $reservations->totalhours.' '.Yii::t('app','hour');
                } else {
                  $durationLabel = "N/A";
                }
                echo $durationLabel; 
            ?>
          </div>
        </div>
        
        
        
        <?php if(count($reservations) > 0) { ?>
          <div class="clear"></div><hr class="airfcfx-horizontal-line">
          <div class="airfcfx-message-client-guest col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 no-hor-padding">
              <div class="air-label col-xs-12 col-sm-6 no-hor-padding">
                <span><?= Yii::t('app','Booking Status'); ?></span><br/>
              </div>
              <div class="airfcfx-status col-xs-12 col-sm-6 col-md-6 col-lg-6 no-hor-padding text-left">
                <span><?= ucfirst($reservations->bookstatus); ?></span> 
              </div>
            </div>      
          </div>

          <div class="clear"></div><hr class="airfcfx-horizontal-line">
          <div class="airfcfx-message-client-guest col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding margin_bottom20">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 no-hor-padding">
              <div class="air-label col-xs-12 col-sm-6 no-hor-padding">
                <span><?= Yii::t('app','Transaction Details'); ?></span><br/>
              </div>
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-`2 no-hor-padding text-left">
              <?php   $invoices = $reservations->getInvoices()->where(['orderid'=>$reservations->id])->one();
                if(!empty($invoices) && isset($invoices->stripe_transactionid))
                $transactionid = $invoices->stripe_transactionid;
                else
                $transactionid = "";
              ?>
                <span><?= $transactionid; ?></span> 
              </div>
            </div>      
          </div>

          <?php 
          if($reservations->bookstatus == "refunded" && $reservations->orderstatus == "paid") {
            if($reservations->other_transaction!="") {
                $other_transaction = json_decode($reservations->other_transaction, true);
                echo '<br><p><b>'.Yii::t('app','Amount Refund To Guest').'</b></p>';
                echo '<p>'.Yii::t('app','Refund ID').' : '.$other_transaction['refund_id'].'</p>';
                echo '<p>'.Yii::t('app','Refund Status').' : '.ucfirst($other_transaction['status']).'</p>';

                echo '<p>'.Yii::t('app','Refund Amount').' : '.($other_transaction['amount']/100).' '.$other_transaction['currency'].'</p>';

                echo '<p>'.Yii::t('app','Cancel Percentage').' : '.$other_transaction['percentage'].' % </p>';

                echo '<p>'.Yii::t('app','Refund Date').' : '.date('M - d, Y',$other_transaction['cdate']).'</p>';
            } 

        } else if($reservations->bookstatus == "declined" && $reservations->orderstatus == "paid") {
            if($reservations->other_transaction!="") {
                $other_transaction = json_decode($reservations->other_transaction, true);
                echo '<br><p><b>'.Yii::t('app','Amount Refund To Guest').'</b></p>';
                echo '<p>'.Yii::t('app','Refund ID').' : '.$other_transaction['refund_id'].'</p>';
                echo '<p>'.Yii::t('app','Refund Status').' : '.ucfirst($other_transaction['status']).'</p>';

                echo '<p>'.Yii::t('app','Refund Amount').' : '.($other_transaction['amount']/100).' '.$other_transaction['currency'].'</p>';

                echo '<p>'.Yii::t('app','Refund Date').' : '.date('M - d, Y',$other_transaction['cdate']).'</p>';  
            } 

        } else if($reservations->bookstatus == "claimed" && $reservations->orderstatus == "pending" && $reservations->claim_status =="pending") {
            echo '<p>'.Yii::t('app','Booking Status').' : '.ucfirst($reservations->bookstatus).' '.Yii::t('app','by Host').'</p>';
        } else if($reservations->bookstatus == "claimed" && $reservations->orderstatus == "paid" && $reservations->claim_status =="declined") { 
            echo '<p>'.Yii::t('app','Booking Status').' : '.ucfirst($reservations->bookstatus).' '.Yii::t('app','by Host').'</p>';
            $other_transaction = json_decode($reservations->other_transaction, true);
            echo '<br><p><b>'.Yii::t('app','Security Deposit Refund To Guest').'</b></p>';
            echo '<p>'.Yii::t('app','Refund ID').' : '.$other_transaction['refund_id'].'</p>';
            echo '<p>'.Yii::t('app','Refund Status').' : '.ucfirst($other_transaction['status']).'</p>';

            echo '<p>'.Yii::t('app','Refund Amount').' : '.($other_transaction['amount']/100).' '.$other_transaction['currency'].'</p>';

            echo '<p>'.Yii::t('app','Refund Date').' : '.date('M - d, Y',$other_transaction['cdate']).'</p>'; 
        } 

          ?>




        <?php } ?>

        <?php 
          echo '<input type="hidden" name="checkoutpay_booking" id="checkoutpay_booking" value="'.$reservations->booking.'"/>';
        ?>

      </div>

      <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
        <div class="airfcfx-message-client-section airfcfx-panel panel panel-default col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
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
          echo '<div class="airfcfx-message-client-othername col-xs-12 col-sm-12 col-md-12 col-lg-12 margin_top20 text-center"><a href="'.$receiverurl.'" target="_blank">'.$otherUserData->firstname.'</a>   </div>';
          $created = $userdata->created_at;
          $month = date('F',$created);
          $year = date('Y',$created); 
          echo '<div class="airfcfx-message-client-join col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center"><span>'.Yii::t('app','Joined in').'</span> <span>'.$month.' '.$year.'</span></div>'; 
        ?>
        <div class="airfcfx-message-client-join col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center"> 
          <?= ucfirst($city).ucfirst($country); // ucfirst($state)?>        
        </div>

        <div class="clear"></div>
        <div class="airfcfx-message-client-total col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
          <hr class="airfcfx-horizontal-line">
          <h3><?= Yii::t('app','Payment'); ?></h3>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding margin_top20">

            <?php 

                if($reservations->booking == "perhour"){
                  $nightprice = $reservations->pricepernight * $reservations->totalhours;
                  $totaldays = $reservations->totalhours;
                } else {
                  $nightprice = $reservations->pricepernight * $reservations->totaldays;
                  $totaldays = $reservations->totaldays;
                }

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
            ?>
            <div class="col-xs-7 col-sm-7 col-md-7 col-lg-8 no-hor-padding">
             
              <?= $currencySymbol.$price." X ".$totaldays; ?> 

            </div>
            <div class="col-xs-5 col-sm-5 col-md-5 col-lg-4 no-hor-padding text-right">
              <?= $currencySymbol.$nightprice; ?>
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding margin_top5">
            <div class="col-xs-7 col-sm-7 col-md-7 col-lg-8 no-hor-padding">
              <?= Yii::t('app','Security Deposit'); ?>
            </div>
            <div class="col-xs-5 col-sm-5 col-md-5 col-lg-4 no-hor-padding text-right">
              <?= $currencySymbol.$securityfees; ?>
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding margin_top5">
            <div class="col-xs-7 col-sm-7 col-md-7 col-lg-8 no-hor-padding">
              <?= Yii::t('app','Commission'); ?>
            </div>
            <div class="col-xs-5 col-sm-5 col-md-5 col-lg-4 no-hor-padding text-right">
              <?= $currencySymbol.$commissionfees; ?>
            </div> 
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding margin_top5">
            <div class="col-xs-7 col-sm-7 col-md-7 col-lg-8 no-hor-padding">
              <?= Yii::t('app','Site Charge')." + ".Yii::t('app','Taxes'); ?>
            </div>
            <div class="col-xs-5 col-sm-5 col-md-5 col-lg-4 no-hor-padding text-right">
              <?php $addCal = $sitefees+$taxfees; ?>
              <?= $currencySymbol.number_format(round($addCal,2),2,".",""); ?>
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding margin_top5">
            <div class="col-xs-7 col-sm-7 col-md-7 col-lg-8 no-hor-padding">
              <?= Yii::t('app','Cleaning fee + Service fee'); ?>
            </div>
            <div class="col-xs-5 col-sm-5 col-md-5 col-lg-4 no-hor-padding text-right">
              <?php $addCal = $cleaningfees+$servicefees; ?>
              <?= $currencySymbol.number_format(round($addCal,2),2,".",""); ?> 
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding margin_top15">
            <hr class="airfcfx-horizontal-line"> 
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding margin_top15">
            <div class="col-xs-7 col-sm-7 col-md-7 col-lg-8 no-hor-padding">
              <b><?= Yii::t('app','Total'); ?></b>
            </div>
            <div class="col-xs-5 col-sm-5 col-md-5 col-lg-4 no-hor-padding text-right">
              <?= $currencySymbol.$totalprice; ?>  
            </div> 
          </div> 
        </div>

        <div class="airfcfx-message-client-guest col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center margin_top30 no-hor-padding"> 
          <?php echo $message->guest.' '.Yii::t('app','guest going on this trip'); ?> 
        </div>

        
      </div>
    </div>
          
          
        </div> <!--col-xs-12 end-->
    </div> <!-- container end -->
  </div>

<style type="text/css">
  .msgLoader {
    display: none; 
  }

  .airfcfx-iti {
    font-size: 32px;
    font-weight: 500;

  }

  .airfcfx-message-client-othername a{
    font-size: 18px;
    font-weight: bold;
    color: #484848;
    text-align: center;
    word-wrap: break-word;
  }
  .airfcfx-message-client-guest {
    font-size: 15px;
    font-weight: bold;
    word-wrap: break-word;
  }
  .air-label
  {
    font-weight: bold;
    font-size: 15px; 
  }
  .airfcfx-status {
    color: #FE5771; 
  }
</style>

