<?php
/*
 * This page is for the user to change their password
 *
 * @author: Muthumareeswari
 * @package: Views
 * @PHPVersion: 5.4
 */
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use frontend\models\Listing;
use yii\widgets\LinkPager;
$this->title = Yii::t('app','Account');
?>
<?php
$baseUrl = Yii::$app->request->baseUrl;

?>
<div class="profile_head">
	<div class="container">    
    	<ul class="profile_head_menu list-unstyled">
		<?php 
        echo '<li><a href="'.$baseUrl.'/dashboard">'.Yii::t('app','Dashboard').'</a></li>
        <li><a href="'.$baseUrl.'/user/messages/inbox/traveling">'.Yii::t('app','Inbox').'</a></li> 
        <li><a href="'.$baseUrl.'/user/listing/mylistings">'.Yii::t('app','Listing').'</a></li>
        <li><a href="'.$baseUrl.'/dashboard">'.Yii::t('app','Trips').'</a></li>
        <li><a href="'.$baseUrl.'/editprofile">'.Yii::t('app','Profile').'</a></li>
        <li class="active"><a href="'.$baseUrl.'/user/listing/notifications">'.Yii::t('app','Account').'</a></li>';
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
        <div class="col-xs-12 col-sm-3 margin_top20">
        	<ul class="profile_left list-unstyled">
				<?php
            echo '<li><a href="'.$baseUrl.'/user/listing/notifications">'.Yii::t('app','Notifications').'</a></li>
			<li class="active"><a href="'.$baseUrl.'/user/listing/usernotifications">'.Yii::t('app','User Notifications').'</a></li>
            <li><a href="'.$baseUrl.'/changepassword">'.Yii::t('app','Security').'</a></li>
			<li><a href="'.$baseUrl.'/user/listing/completedtransaction">'.Yii::t('app','Transaction History').'</a></li>';
			?>
            </ul>
           
        </div> <!--col-sm-3 end -->		
	<div class="">
    	
        <div class="col-xs-12 col-sm-9 margin_bottom20">
        	<div class="col-sm-12 no-padding">
                <div class="airfcfx-panel panel panel-default margin_top20">
				  
				  <div class="airfcfx-panel airfcfx-panel-padding panel-heading profile_menu1">
					<h3 class="airfcfx-panel-title panel-title"><?php echo Yii::t('app','User Notifications');?></h3>
				  </div>	
				  
                  <div class="airfcfx-panel-padding panel-body padding10">
					<?php
					if(!empty($logmessages))
					{
						foreach($logmessages as $log)
						{
							$userdata = $log->getUser()->where(['id'=>$log->userid])->one();
							$userimage = $userdata->profile_image;
							if($userimage=="")
							$userimage="usrimg.jpg";
							$userimageurl = Yii::$app->urlManager->createAbsoluteUrl ( '/albums/images/users/'.$userimage);
							$resized_user_image = Yii::$app->urlManager->createAbsoluteUrl ('resized.php?src='.$userimageurl.'&w=60&h=60');							
							if($log->type=="message")
							{
								$username = base64_encode($userdata->id."-".rand(0,999));
							echo '<div class="airfcfx-notifydiv notifydiv">
							<div class="airfcfx-notification-info-row airfcfx-panel-padding d-flex"><span class="airfcfx-user-icon profile_pict inlinedisplay notifyimg" style="background-image:url('.$resized_user_image.');"></span>
							<span class="airfcfx-notifytxt notifytxt align-self-center"><a href="'.$baseUrl.'/profile/'.$username.'">'.$userdata->firstname.'</a>
							'.Yii::t('app',trim($log->notifymessage)).'</span></div>
							<div class="airfcfx-notification-msg-row panel-heading profile_menu1">                  	
							'.$log->message.'</div> 
							</div>';
							}
							else if($log->type=="admin") 
							{
								$username = base64_encode($userdata->id."-".rand(0,999));
							echo '<div class="airfcfx-notifydiv notifydiv">
							<div class="airfcfx-notification-info-row airfcfx-panel-padding d-flex"><span class="airfcfx-user-icon profile_pict inlinedisplay notifyimg" style="background-image:url('.$resized_user_image.');"></span>
							<span class="airfcfx-notifytxt notifytxt align-self-center">'.$userdata->firstname.'
							'.Yii::t('app',trim($log->notifymessage)).'</span></div>
							<div class="airfcfx-notification-msg-row panel-heading profile_menu1">                  	
							'.$log->message.'</div>
							</div>';
							}
							else if($log->type=="adminpayment")
							{
								$username = base64_encode($userdata->id."-".rand(0,999));
							echo '<div class="airfcfx-notifydiv notifydiv">
							<div class="airfcfx-notification-info-row airfcfx-panel-padding d-flex"><span class="airfcfx-user-icon profile_pict inlinedisplay notifyimg" style="background-image:url('.$resized_user_image.');"></span>
							<span class="airfcfx-notifytxt notifytxt align-self-center">'.Yii::t('app',trim($log->notifymessage)).'</span></div>
							<div class="airfcfx-notification-msg-row panel-heading profile_menu1">                  	
							'.$log->message.'</div>
							</div>';
							}							
							else if($log->type=="accept" || $log->type=="cancel" || $log->type=="decline" || $log->type=="claim" || $log->type=="review")
							{
								$username = base64_encode($userdata->id."-".rand(0,999));
								$listid = $log->listingid;
								$listingdata = $log->getListing()->where(['id'=>$listid])->one();
								$listingname = $listingdata->listingname;
								$listingurl = $baseUrl.'/user/listing/view/'.base64_encode($listid."_".rand(1,9999));
							echo '<div class="airfcfx-notifydiv notifydiv">
							<div class="airfcfx-notification-info-row airfcfx-panel-padding d-flex"><span class="airfcfx-user-icon profile_pict inlinedisplay notifyimg" style="background-image:url('.$resized_user_image.');"></span>
							<span class="airfcfx-notifytxt notifytxt align-self-center"><a href="'.$baseUrl.'/profile/'.$username.'">'.$userdata->firstname.'</a>
							'.Yii::t('app',trim($log->notifymessage)).' on <a href="'.$listingurl.'">'.$listingname.'</a></span></div>
							</div><br />';								
							}
							else if($log->type=="reservation")
							{
								$username = base64_encode($userdata->id."-".rand(0,999));
								$listid = $log->listingid;
								$listingdata = $log->getListing()->where(['id'=>$listid])->one();
								$listingname = $listingdata->listingname;
								$listingurl = $baseUrl.'/user/listing/view/'.base64_encode($listid."_".rand(1,9999));
								echo '<div class="airfcfx-notifydiv notifydiv">
								<div class="airfcfx-notification-info-row airfcfx-panel-padding d-flex"><span class="airfcfx-user-icon profile_pict inlinedisplay notifyimg" style="background-image:url('.$resized_user_image.');"></span>
								<span class="airfcfx-notifytxt notifytxt align-self-center">'.Yii::t('app','You got reservation from').' <a href="'.$baseUrl.'/profile/'.$username.'">'.$userdata->firstname.'</a>
								at <a href="'.$listingurl.'">'.$listingname.'</a></span></div>
								</div><br />';									
							}
							else if($log->type=="request")
							{
								$username = base64_encode($userdata->id."-".rand(0,999));
								$listid = $log->listingid;
								$listingdata = $log->getListing()->where(['id'=>$listid])->one();
								$listingname = $listingdata->listingname;
								$listingurl = $baseUrl.'/user/listing/view/'.base64_encode($listid."_".rand(1,9999));
								echo '<div class="airfcfx-notifydiv notifydiv">
								<div class="airfcfx-notification-info-row airfcfx-panel-padding d-flex"><span class="airfcfx-user-icon profile_pict inlinedisplay notifyimg" style="background-image:url('.$resized_user_image.');"></span>
								<span class="airfcfx-notifytxt notifytxt align-self-center">'.Yii::t('app','You made a reservation on ').'<a href="'.$baseUrl.'/profile/'.$username.'"> '.$userdata->firstname.'</a>
								\'s <a href="'.$listingurl.'">'.$listingname.'</a></span></div>
								</div>';								
							} else { 
								$username = base64_encode($userdata->id."-".rand(0,999));
								echo '<div class="airfcfx-notifydiv notifydiv">
								<div class="airfcfx-notification-info-row airfcfx-panel-padding d-flex"><span class="airfcfx-user-icon profile_pict inlinedisplay notifyimg" style="background-image:url('.$resized_user_image.');"></span>
								<span class="airfcfx-notifytxt notifytxt align-self-center">'.$userdata->firstname.'
								'.Yii::t('app',trim($log->notifymessage)).' - </span></div>
								<div class="airfcfx-notification-msg-row panel-heading profile_menu1">                  	
								'.$log->message.'</div>
								</div>'; 
							} 
						}
					}
					else
					{
						echo '<h4 class="text-center">'.Yii::t('app','No notifications yet').'</h4>';
					}
					?>
					
					<?php
					echo '<div align="center" class="clear">';
					 echo LinkPager::widget([
						 'pagination' => $pages,
					]);
					 echo '</div>'
					 ?> 
					
                  </div>
                </div>
                    
            </div> <!--col-sm-12 end-->
        </div> <!--col-xs-12 end-->
    	
    	
     	
           
        
    </div> <!-- row end -->
    </div> <!--container end -->

  
<script>
$(document).ready(function(){    
    $(".show_ph").click(function(){
        $(".add_phone").show();
		$(".show_ph").hide();
    });
	$(".add_cont").click(function(){
        $(".add_contact").toggle();		
    });
	$(".add_ship").click(function(){
        $(".add_shipping").toggle();		
    });
});
</script>  
