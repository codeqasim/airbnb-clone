<?php

/*
* This page displays the user verification information. User can verify their phone number and email here.
*
* @author: AK
* @package: Views
*/
/* @var $this yii\web\View */

use frontend\models\Users;
use frontend\models\Listing;
use frontend\models\Reservations;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;

$this->title = 'Inbox';
$baseUrl = Yii::$app->request->baseUrl;
?>

<div class="profile_head">
  <div class="container">    
    <ul class="profile_head_menu list-unstyled">
      <?php 
      echo '<li><a href="'.$baseUrl.'/dashboard">'.Yii::t('app','Dashboard').'</a></li>';
      echo '<li class="active"><a href="'.$baseUrl.'/user/messages/inbox/traveling">'.Yii::t('app','Inbox').'</a></li>';
      echo '<li><a href="'.$baseUrl.'/user/listing/mylistings">'.Yii::t('app','Listing').'</a></li>';
      echo '<li><a href="'.$baseUrl.'/user/listing/trips">'.Yii::t('app','Trips').'</a></li>';
      echo '<li><a href="'.$baseUrl.'/editprofile">'.Yii::t('app','Profile').'</a></li>';
      echo '<li><a href="'.$baseUrl.'/user/listing/notifications">'.Yii::t('app','Account').'</a></li>'; 
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
    <div class="row">

      <div class="col-xs-12 margin_top20 margin_bottom20">
        <div class="col-sm-12">
          <div class="airfcfx-panel panel-default">
            <div class="mesg-heading profile_menu1 clearfix"> 

              <ul class="message-navigation nav nav-tabs">
                <?php 
                  if($usertype == "traveling")  {
                    $tr_active = "active";
                    $hs_active = "";
                  } elseif($usertype == "hosting")  {
                    $tr_active = "";
                    $hs_active = "active";
                  } else {
                    $tr_active = "";
                    $hs_active = "";
                  }
                ?>
                <li class="<?php echo $tr_active; ?>">
                  <a class="traveling" href="<?php echo $baseUrl.'/user/messages/inbox/traveling'; ?>"><?= Yii::t('app','Traveling'); ?></a>
                </li>
                <li class="<?php echo $hs_active; ?>">
                  <a class="hosting" href="<?php echo $baseUrl.'/user/messages/inbox/hosting'; ?>"><?= Yii::t('app','Hosting'); ?></a>
                </li>
              </ul>

            </div>

            <div class="airfcfx-panel-body panel panel-default panel-body padding10">
              <div class="msg-tablink tab-content">
                <div id="Traveling" class="tab-pane fade in active">
                  <?php if($allmessagescount > 0) { ?>
                    <div class="airfcfx-message-row col-sm-12 no-hor-padding clearfix">
                      <select class="airfcfx-message-select form-control" style="width:195px;" onchange="change_message_type();" id="selmessage">
                        <?php
                          
                          if($msgtype == "all")
                            echo '<option value="all" selected>'.Yii::t('app','All Messages').'</option>';
                          else
                            echo '<option value="all">'.Yii::t('app','All Messages').'</option>';

                          if($msgtype == "unread")
                            echo '<option value="unread" selected>'.Yii::t('app','Unread').'</option>';
                          else
                            echo '<option value="unread">'.Yii::t('app','Unread').'</option>';

                          if($usertype == "traveling")  {
                            if($msgtype == "trips")
                              echo '<option value="trips" selected>'.Yii::t('app','Trips').'</option>';
                            else
                              echo '<option value="trips">'.Yii::t('app','Trips').'</option>';
                          } elseif($usertype == "hosting")  {
                            if($msgtype == "reservations")
                              echo '<option value="reservations" selected>'.Yii::t('app','Reservations').'</option>';
                            else
                              echo '<option value="reservations">'.Yii::t('app','Reservations').'</option>';
                          }

                          if($msgtype == "inquiry")
                            echo '<option value="inquiry" selected>'.Yii::t('app','Inquiry').'</option>';
                          else
                            echo '<option value="inquiry">'.Yii::t('app','Inquiry').'</option>';

                        ?>
                      </select>
                    </div>
                  <?php } ?>

                  <?php

                  if(count($messages) > 0)
                    echo '<div class="clear"></div><hr class="airfcfx-horizontal-line">';

                  foreach($messages as $message)
                  {
                    if($message['messagetype'] == 'user')
                    {
                      if($usertype == "traveling")  {
                        $senderid = $message['senderid'];
                        $receiverid = $message['receiverid'];
                      } elseif($usertype == "hosting")  {
                        $senderid = $message['receiverid'];
                        $receiverid = $message['senderid']; 
                      }
                      $listingid = $message['listingid'];
                      $senderdata = Users::find()->where(['id'=>$senderid])->one();
                      $receiverdata = Users::find()->where(['id'=>$receiverid])->one();
                      $listingdata = Listing::find()->where(['id'=>$listingid])->one();
                      $senderimage = $senderdata->profile_image;
                      $receiverimage = $receiverdata->profile_image; 

                      if($senderimage!="") {
                        $senderheader_response = get_headers(Yii::$app->urlManager->createAbsoluteUrl('/albums/images/users/'.$senderimage, 1));
                        if(strpos($senderheader_response[0], "404") !== false)
                          $senderimage = "usrimg.jpg";
                        else
                          $senderimage = $senderdata->profile_image;  
                      } else if($senderimage=="") {
                        $senderimage = "usrimg.jpg";
                      }

                      if($receiverimage!="") {
                        $receiverheader_response = get_headers(Yii::$app->urlManager->createAbsoluteUrl('/albums/images/users/'.$receiverimage, 1));
                        if ( strpos( $receiverheader_response[0], "404" ) !== false )
                          $receiverimage = "usrimg.jpg";
                        else
                          $receiverimage = $receiverdata->profile_image;  
                      } else if($receiverimage=="") {
                        $receiverimage = "usrimg.jpg";
                      }           

                      $senderimageurl = Yii::$app->urlManager->createAbsoluteUrl ( '/albums/images/users/'.$senderimage);
                      $resized_sender_image = Yii::$app->urlManager->createAbsoluteUrl ('resized.php?src='.$senderimageurl.'&w=60&h=60');             
                      $receiverimageurl = Yii::$app->urlManager->createAbsoluteUrl ( '/albums/images/users/'.$receiverimage);
                      $resized_receiver_image = Yii::$app->urlManager->createAbsoluteUrl ('resized.php?src='.$receiverimageurl.'&w=60&h=60');   

                      echo '<div class="airfcfx-message-row col-sm-12 no-hor-padding clearfix">';
                        if($loguserid == $senderid) {
                          echo '<div class="airfcfx-imgwdth col-xs-8 col-xs-offset-5 col-sm-2 col-sm-offset-0 imgwdth cenAdjust"><span class="airfcfx-user-icon profile_pict inlinedisplay" style="background-image:url('.$resized_receiver_image.');"></span></div>';
                        } else {
                          echo '<div class="airfcfx-imgwdth col-xs-12 col-xs-offset-5 col-sm-2 col-sm-offset-0 imgwdth"><span class="airfcfx-user-icon profile_pict inlinedisplay" style="background-image:url('.$resized_sender_image.');"></span></div>';
                        }

                        if($loguserid==$senderid) {
                          echo '<div class="airfcfx-namewdth col-xs-12 col-sm-2  namewdth wrdwrp cenAdjust">'.$receiverdata->firstname.'<br /><span class="airfcfx-message-date">';
                        } else {
                          echo '<div class="airfcfx-namewdth col-xs-8 col-xs-offset-4 col-sm-2 col-sm-offset-0 namewdth wrdwrp">'.$senderdata->firstname.'<br /><span class="airfcfx-message-date">';
                        }
                        echo date('d, M Y',$message['cdate']).'</span></div>';

                        

                        echo '<div class="airfcfx-msgwdth col-xs-12 col-sm-4  msgwdth wrdwrp cenAdjust">';
                          
                          echo '<div class="airfcfx-lastmsg col-sm-12 no-hor-padding msgwdth wrdwrp">'.$message['message'].'</div>';

                          if(!empty($listingdata)) {
                            echo '<div class="airfcfx-listingwdth col-sm-12 no-hor-padding msgwdth wrdwrp">'.$listingdata->listingname.'</div>';
                          }

                          
                          echo '<div class="airfcfx-listingdate margin_top5 col-sm-12 no-hor-padding">
                            <span class="airfcfx-message-date">'.date('d M', strtotime($message['checkin'])).' | '.date('d M, Y', strtotime($message['checkout'])).'</span></div>'; 
                          
                        echo '</div>';

                        $reservedurationType = trim($listingdata->booking);
                        if($reservedurationType == "pernight") {
                            $s_datetime = strtotime(date('m/d/Y', strtotime($message['checkin'])));
                            $e_datetime = strtotime(date('m/d/Y', strtotime($message['checkout'])));
                            $otherguestreservations = Reservations::find()->where(['listid'=>$listingdata->id])
                            ->andWhere(['=','fromdate',$s_datetime])
                            ->andWhere(['=','todate',$e_datetime])
                            ->andWhere(['!=','bookstatus','refunded'])
                            ->andWhere(['!=','bookstatus','declined'])
                            ->one();
                        } else {
                            $s_datetime = $message['checkin'];
                            $e_datetime = $message['checkout'];

                            $otherguestreservations = Reservations::find()->where(['listid'=>$listingdata->id])
                            ->andWhere(['=','checkin',$s_datetime])
                            ->andWhere(['=','checkout',$e_datetime])
                            ->andWhere(['!=','bookstatus','refunded'])
                            ->andWhere(['!=','bookstatus','declined']) 
                            ->one();
                        }

                        $today = strtotime(date('m/d/Y'));
                        $reservetime = strtotime(date('m/d/Y',strtotime($message['checkin'])));

                        if(!empty($listingdata)) { 
                          $inquiryid = trim($message['id']);
                          $reservationdata = Reservations::find()->where(['inquiryid'=>$inquiryid])->one(); 
                          
                          if($reservetime < $today && count($reservationdata) == 0) 
                            $bookstatus = "Expired";
                          else if(count($otherguestreservations) > 0 && count($reservationdata) == 0) 
                            $bookstatus = "Not Available";
                          else if(!empty($reservationdata))
                            $bookstatus = $reservationdata->bookstatus; 
                          else 
                            $bookstatus = "Inquiry";
                          
                          echo '<div class="airfcfx-statuswdth col-xs-12 col-sm-2 msgwdth wrdwrp cenAdjust margin_top15" style="font-weight: bold;">'.Yii::t('app',ucfirst($bookstatus)).'</div>';
                        } else {
                          echo '<div class="airfcfx-statuswdth col-xs-12 col-sm-2 msgwdth wrdwrp cenAdjust margin_top15" style="font-weight: bold;">'.Yii::t('app',ucfirst('error')).'</div>';
                        } 

                        $detailsDisable = array('Refunded', 'Claimed', 'Declined'); 
                        echo '<div class="col-xs-12 col-sm-2 msgwdth wrdwrp cenAdjust margin_top10" style="font-weight: bold;">'; 

                          if(in_array(ucfirst($bookstatus), $detailsDisable) && $usertype=="traveling") {                       
                                                                              
                            $messageid = bin2hex(trim($message['id']));
                            $messageid = base64_encode(rand(22222222,99999999).".".$messageid.".".$usertype); 

                             echo '<div class="col-xs-12 col-sm-2 col-md-12 cenAdjust text-center"><a target="_blank" href="'.$baseUrl.'/user/listing/viewdetail/'.$messageid.'" class="airfcfx-msg btn btn-details" style="text-decoration:none;">'.Yii::t('app',ucfirst('details')).'</a></div>';

                             if(!empty($listingdata) && $message['id'] > 0 && !empty($message['id'])) {
                                $messageid = bin2hex(trim($message['id']));
                                $messageid = base64_encode(rand(1000000,9999999).".".$messageid.".".$usertype);  
                         
                                echo '<div class="col-sm-2 col-md-12 margin_top10"><a target="_blank" href="'.$baseUrl.'/user/messages/viewmessage/'.$messageid.'" class="airfcfx-msg btn btn-details" style="text-decoration:none;">'.Yii::t('app',ucfirst('message')).'</a></div>'; 
                              }
                               
                          } else {
                            if(!empty($listingdata) && $message['id'] > 0 && !empty($message['id'])) {
                                $messageid = bin2hex(trim($message['id']));
                                $messageid = base64_encode(rand(1000000,9999999).".".$messageid.".".$usertype);  
                         
                                echo '<div class="col-sm-2 col-md-12"><a target="_blank" href="'.$baseUrl.'/user/messages/viewmessage/'.$messageid.'" class="airfcfx-msg btn btn-details" style="text-decoration:none;">'.Yii::t('app',ucfirst('message')).'</a></div>';  
                              }  
                          }

                        echo '</div>';
                      
                      echo '</div>';
                      echo '<div class="clear"></div>';
                      echo '<hr class="airfcfx-horizontal-line">';
                    }
                  } ?> 

                  <?php if(count($messages) == 0) { ?>
                    <div class="airfcfx-panel-body col-sm-12 no-hor-padding margin_top15 panel panel-default panel-body padding10">
                      <div class="msg-tablink tab-content">
                        <div id="Traveling" class="tab-pane fade in active">
                          <p class="no-msg text-center">No messages yet.</p>
                          <?php if($usertype == "hosting") { ?>
                            <p class="no-msg-ptag">When guests contact you or send you reservation requests, you’ll see their messages here.</p>
                          <?php } else { ?>
                            <p class="no-msg-ptag">When you make plans to travel, read messages from your host here.</p>
                            <div class="text-center">
                              <a href="<?= $exploreUrl; ?>" class=" btn btn_search">Explore Listing</a>
                            </div>
                          <?php } ?>
                        </div>
                      </div>
                    </div>
                  <?php } ?>
                </div>
            
              </div>
            </div>
          </div>
        </div> 
      </div> 

      <?php
        echo '<div align="center" class="clear">';
        echo LinkPager::widget([
          'pagination' => $pages,
          ]);
        echo '</div>';
      ?>     

    </div> <!-- row end -->

  </div> <!-- container end -->
</div>
<script>
  
  function change_message_type()
  {
      var msgtype = $("#selmessage").val();
      var usertype = $('ul.message-navigation > li.active > a').attr('class');

      var sortLink = Math.floor(Math.random() * 90000) + 10000;
      sortLink = btoa(sortLink+"*|*"+$.trim(usertype)+"*|*"+$.trim(msgtype));
      window.location = baseurl+"/user/messages/inbox/"+sortLink;   
  }

</script>
<style type="text/css">
  .btn-details, .btn-details:focus { 
    width: 80px; 
    margin: auto;
    padding: 4px 10px !important;
    color: #008489 !important;
    background-color: #fff !important;
    border-color: #008489 !important; 
  }
  .airfcfx-lastmsg {
    color: #008489 !important;
    font-weight: 600; 
    float: left;
    width: 100%;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
  }
  .airfcfx-statuswdth {
    color: #FE5771; 
  }
  .btn-details:hover {
    background-color: #008489 !important;
    color: #ffffff !important; 
  }
</style>  

