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
$this->title = 'Inbox';
$baseUrl = Yii::$app->request->baseUrl;
?>

<div class="profile_head">
	<div class="container">    
    	<ul class="profile_head_menu list-unstyled">
		<?php 
        echo '<li><a href="'.$baseUrl.'/dashboard">'.Yii::t('app','Dashboard').'</a></li>
       <li class="active"><a href="'.$baseUrl.'/user/messages/inbox">'.Yii::t('app','Inbox').'</a></li>
        <li><a href="'.$baseUrl.'/user/listing/mylistings">'.Yii::t('app','Your Listing').'</a></li>
        <li><a href="'.$baseUrl.'/user/listing/trips">'.Yii::t('app','Your Trips').'</a></li>
        <li><a href="'.$baseUrl.'/editprofile">'.Yii::t('app','Profile').'</a></li>
        <li><a href="'.$baseUrl.'/user/listing/notifications">'.Yii::t('app','Account').'</a></li>';
		?>
        </ul>
    </div> <!--container end -->
</div> <!--profile_head end -->


<div class="bg_gray1">
<div class="container">
	<div class="row">
    	
        <div class="col-xs-12 margin_top20 margin_bottom20">
        	<div class="col-sm-12">
                <div class="airfcfx-panel panel panel-default margin_top30">
                  <div class="airfcfx-panel panel-heading profile_menu1">                  	
					<h3><?php echo Yii::t('app','View Conversation Messages');?></h3>
                  </div>
                  <div class="panel-body padding20">
					<input type="hidden" id="senderid" value="<?php echo  $senderid?>">
					<input type="hidden" id="receiverid" value="<?php echo  $receiverid?>">
                    <?php
					
					$userimage = $userdata->profile_image;
					if($userimage=="")
					$userimage="usrimg.jpg";
					$userimageurl = $baseUrl.'/albums/images/users/'.$userimage;
						/*echo '<div class="col-xs-12">
						<span class="profile_pict inlinedisplay tripprofile" style="background-image:url('.$userimageurl.');"></span>
						<textarea rows="2" cols="80" class="txtarea contactextarea" id="contactmessage"></textarea>
						<input type="button" value="Send" class="btn btn-danger sendbtn tripsendbtn" style="top:-12px;" onclick="send_contact_message();">
						</div>';
						echo '<div class="msgerrcls" style="margin-left: 70px;margin-top: 70px;"></div>';*/
						echo '<div id="messagesdiv"></div>';
						
					?>
                  </div>
                </div>
                    
            </div> <!--col-sm-12 end-->
        </div> <!--col-xs-12 end-->
    	
    	
        
        
    </div> <!-- row end -->

</div> <!-- container end -->
</div>

<script type="text/javascript">
	$(document).ready(function(){
		getcontactmessage();
	});
	//setInterval(getcontactmessage, 5000);
function getcontactmessage()
{
	var listingid = $("#listingid").val();
	var senderid = $("#senderid").val();
	var receiverid = $("#receiverid").val();
	$.ajax({
		type : 'POST',
		url : baseurl + '/user/messages/getadmincontactmessage',
        async: false,
		data : {
			listingid : listingid,
			senderid : senderid,
			receiverid : receiverid
		},
		success : function(data) {
			$("#messagesdiv").html(data);
        }
	});	
}
</script>
