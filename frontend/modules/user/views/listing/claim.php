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
use frontend\models\Listing;
$this->title = 'Claim Security Deposit';
?>
<?php
$baseUrl = Yii::$app->request->baseUrl;
//echo $userdata['firstname'];die;
$firstname = $userdata['firstname'];
$lastname = $userdata['lastname'];
$id = $userdata['id'];
$username = base64_encode($id."-".rand(0,999));
?>
<div class="profile_head">
	<div class="container">    
    	<ul class="profile_head_menu list-unstyled">
		<?php 
         		
     echo '<li><a href="'.$baseUrl.'/dashboard">'.Yii::t('app','Dashboard').'</a></li>
       <li><a href="'.$baseUrl.'/user/messages/inbox/traveling">'.Yii::t('app','Inbox').'</a></li>
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
        <div class="col-xs-12 col-sm-3 margin_top20">


        </div> <!--col-sm-3 end -->
        
        <div class="col-xs-12 col-sm-9 margin_top20">        
        
        <div class="airfcfx-panel panel panel-default">
          <div class="airfcfx-panel-padding panel-heading profile_menu1">
            <h3 class="panel-title"><?php echo Yii::t('app','Claim Security Deposit');?></h3>
          </div>
          
          <div class="airfcfx-panel-padding panel-body">
            <div class="col-sm-12 no-hor-padding">
				<?php
				$usrimg = $userdata->profile_image;
				if($usrimg=="")
					$usrimg = "usrimg.jpg";
					$userimage = Yii::$app->urlManager->createAbsoluteUrl ( '/albums/images/users/'.$usrimg);
					$resized_userimage = Yii::$app->urlManager->createAbsoluteUrl ('resized.php?src='.$userimage.'&w=40&h=40');				
				$currencydata = $trips->getCurrency()->where(['currencycode'=>$trips->currencycode])->one();
				if(!empty($currencydata))
				$currencysymbol = $currencydata->currencysymbol;
				else
				$currencysymbol = "";
				echo '<div class="claim-page" style="float:left;">
						<div class="col-xs-12 no-hor-padding col-sm-12 margin_bottom10">
							<p class="margin_bottom10">'.Yii::t('app','Security Deposit:').' '.$currencysymbol.$trips->securityfees.'</p>
							<p class="margin_bottom10">'.Yii::t('app','Listing Name:').' '.$listdata->listingname.'</p>';
							if(empty($claimdata))
							{
								if($userid==$trips->userid)
								echo '<p class="margin_bottom10"><input type="button" id="claimbtn" value="Confirm" class="btn btn_dashboard" onclick="claim_securityfee('.$trips->id.',\'Guest\')"></p>';
								else if($userid==$trips->hostid)
								echo '<p class="margin_bottom10"><input type="button" id="claimbtn" value="Confirm" class="btn btn_dashboard" onclick="claim_securityfee('.$trips->id.',\'Host\')"></p>';
							}
							else
							{
								if($userid!=$claimdata->userid && $claimdata->receiverstatus!="accepted" && $claimdata->receiverstatus!="declined" && $claimdata->receiverstatus!="solved" && $claimdata->claimstatus!="solved")
								{
									if($claimdata->claimby == 'Guest' && $userid!=$claimdata->userid)
									{	
									echo '<p style="color:red; margin-top:5px;" class="margin_bottom10">"Guest Initiate the Claim, would like to Accept OR decline the claim fund. If you did not response within 48 hours the security deposit amount will be sent to Guest."</p>';
									}
									if($claimdata->claimby == 'Host' && $userid!=$claimdata->userid)
									{
									echo '<p style="color:red; margin-top:5px;" class="margin_bottom10">"Host Initiate the Claim, would like to Accept OR decline the claim fund. If you did not response within 48 hours the security deposit amount will be sent to Host."</p>';
									}		
									echo '<p class="margin_bottom10"><input type="button" id="acceptbtn" value="Accept" onclick="change_receiver_status('.$claimdata->reservationid.',\'accepted\')" class="btn btn-success margin_bottom20 margin_top10">
									<input type="button" id="declinebtn" value="Decline" onclick="change_receiver_status('.$claimdata->reservationid.',\'declined\')" class="btn btn-danger margin_bottom20 margin_top10 margin_left10">
									</p>';
								}
								else if($claimdata->receiverstatus=="accepted" || $userid==$claimdata->userid && $claimdata->receiverstatus=="solved" && $claimdata->claimstatus!='solved')
								{
									if($userid==$claimdata->userid)
									echo '<p id="acceptbtn" style="color:red; margin-top:5px;" class="margin_bottom10">"Your claim was accepted"</p>';
									else
									echo '<p id="acceptbtn" style="color:red; margin-top:5px;" class="margin_bottom10">"You accepted the '.$claimdata->claimby.' \'s claim"</p>';
									/*if($userid==$claimdata->userid)
									echo '<p><input type="button" value="Solve" onclick="change_claim_status('.$claimdata->id.',\'solved\');" id="solvebtn" class="btn btn-danger"></p>';
									else
									echo '<p><input type="button" value="Solve" onclick="change_receiver_status('.$claimdata->reservationid.',\'solved\');" id="solvebtn" class="btn btn-danger"></p>';
									*/
								}
								else if($claimdata->receiverstatus=='declined')
								{
									if($userid==$claimdata->userid)
									{
										//echo '<p><input type="button" value="Solve" onclick="change_claim_status('.$claimdata->id.',\'solved\');" id="solvebtn" class="btn btn-danger">';
										if($claimdata->involveadmin!=1)
										{
											if($userid==$claimdata->userid)
											echo '<p style="color:red; margin-top:5px;" class="margin_bottom10">"Your claim was declined"</p>';
											else
											echo '<p style="color:red; margin-top:5px;" class="margin_bottom10">"You declined the '.$claimdata->claimby.' \'s claim"</p>';
											echo '<input type="button" value="Involve Admin" onclick="involve_admin('.$claimdata->id.');" id="involvebtn" class="btn btn-primary">';
										}
										else if($claimdata->involveadmin==1)
										{
											echo '<p style="color:red; margin-top:5px;" class="margin_bottom10">"Admin has been Involved"</p>';
										}
										echo '</p>';
									}
									else
									{
										//echo '<p><input type="button" value="Solve" onclick="change_receiver_status('.$claimdata->reservationid.',\'solved\');" id="solvebtn" class="btn btn-danger">';
										if($claimdata->involveadmin!=1)
										{
											if($userid==$claimdata->userid)
											echo '<p style="color:red; margin-top:5px;" class="margin_bottom10">"Your claim was declined"</p>';
											else
											echo '<p style="color:red; margin-top:5px;" class="margin_bottom10">"You declined the '.$claimdata->claimby.' \'s claim"</p>';
											echo '<input type="button" value="Involve Admin" onclick="involve_admin('.$claimdata->id.');" id="involvebtn" class="btn btn-primary">';
										}
										else if($claimdata->involveadmin==1)
										{
											echo '<p style="color:red; margin-top:5px;" class="margin_bottom10">"Admin has been Involved"</p>';
										}										
										echo '</p>';
									}									
								}
							}
							/*if(!empty($claimdata))
							{
							echo '<div class="hiddencls" id="solvediv">';
							if($userid==$claimdata->userid)
							echo '<input type="button" value="Solve" onclick="change_claim_status('.$claimdata->id.',\'solved\');" id="solvebtn" class="btn btn-danger">';
							else
							echo '<input type="button" value="Solve" onclick="change_receiver_status('.$claimdata->reservationid.',\'solved\');" id="solvebtn" class="btn btn-danger">';
							echo '</div>';
							}*/
							echo '<div id="claimsuccess" class="successtxt hiddencls " class="margin_bottom10">Claim initiated successfully</div>';
							echo '
							<span class="claim-img profile_pict tripprofile inlinedisplay left-float" style="background-image:url('.$resized_userimage.');"></span>
							<textarea rows="2" cols="80" class="txtarea left-float" id="claimmessage" maxlength="250"></textarea>';
							
							echo '<input type="hidden" id="userid" value="'.$trips->userid.'">';
							echo '<input type="hidden" id="hostid" value="'.$trips->hostid.'">';							
							if(empty($claimdata))
							{
								echo '<input type="hidden" id="reserveid" value="">';
								echo '<input type="button" disabled value="'.Yii::t('app','Send').'" class="btn btn-danger sendbtn tripsendbtn left-float" id="sendbtn" onclick="send_claim_message()">';
							}
							else
							{
								echo '<input type="hidden" id="reserveid" value="'.$claimdata->id.'">';
								echo '<input type="button" value="'.Yii::t('app','Send').'" class="btn btn-danger sendbtn tripsendbtn left-float" id="sendbtn" onclick="send_claim_message()">';
							}
							echo '<div class="claimerrcls"></div><br/>';
							echo '<img id="loadingimg" src="'.$baseUrl.'/images/load.gif" class="loading">
						</div>
					</div>';
					echo '<div id="messagesdiv"></div>';
				?>
                 </div> <!--row end -->

          </div>
          
        </div> <!--Panel end -->
        
         
        
        
        
    </div> <!--container end -->
	</div>
  
<script type="text/javascript">
	$(document).ready(function(){
		getclaimmessage();
	});
	//setInterval(getclaimmessage, 5000);
function getclaimmessage()
{
	var reserveid = $("#reserveid").val();
	$.ajax({
		type : 'POST',
		url : baseurl + '/user/listing/getclaimmessage',
        async: false,
		data : {
			reserveid : reserveid
		},
		success : function(data) {
			$("#messagesdiv").html(data);
        }
	});	
}
</script>
