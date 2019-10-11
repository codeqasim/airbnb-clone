<?php
$baseUrl = Yii::$app->request->baseUrl;
$usrimg = $userdata->profile_image;
$hostimg = $hostdata->profile_image;
if($usrimg=="")
	$usrimg = "usrimg.jpg";
if($hostimg=="")
	$hostimg = "usrimg.jpg";
$userimage = Yii::$app->urlManager->createAbsoluteUrl ( '/albums/images/users/'.$usrimg);
$resized_userimage = Yii::$app->urlManager->createAbsoluteUrl ('resized.php?src='.$userimage.'&w=40&h=40');	

$hostimage = Yii::$app->urlManager->createAbsoluteUrl ( '/albums/images/users/'.$hostimg);
$resized_hostimage = Yii::$app->urlManager->createAbsoluteUrl ('resized.php?src='.$hostimage.'&w=40&h=40');	
$adminimage = Yii::$app->urlManager->createAbsoluteUrl ( '/albums/images/users/usrimg.jpg');
$resized_adminimage = Yii::$app->urlManager->createAbsoluteUrl ('resized.php?src='.$adminimage.'&w=40&h=40');	
$userurl = base64_encode($userdata->id."-".rand(0,999));
$hosturl = base64_encode($hostdata->id."-".rand(0,999));
foreach($claimmessages as $message)
{
	if($loguserid==$message->userid && $message->sentby=="Guest")
	{
		echo '<div class="claimleft">
			<div class="claimleftimgdiv">
			<span class="claim-img profile_pict tripleftprofile inlinedisplay" style="background-image:url('.$resized_userimage.');"></span>
			</div>
			<div class="claimrighttextdiv">
			<a class="airfcfx-txt-capitalize" href="'.$baseUrl.'/profile/'.$userurl.'">'.$userdata->firstname.'</a>
			<span class="padleft small-txt">'.date('d,M Y',strtotime($message->cdate)).'</span>
			<br />'.$message->message.'
			</div>
		</div>
		<div class="clear"></div>';
	}
	else if($loguserid==$message->hostid && $message->sentby=="Host")
	{
		echo '<div class="claimleft">
		<div class="claimleftimgdiv">
			<span class="claim-img profile_pict tripprofile inlinedisplay" style="background-image:url('.$resized_hostimage.');"></span>
		</div>
		<div class="claimrighttextdiv">
			<a class="airfcfx-txt-capitalize" href="'.$baseUrl.'/profile/'.$hosturl.'">'.$hostdata->firstname.'</a>
			<span class="padleft small-txt">'.date('d,M Y',strtotime($message->cdate)).'</span>
			<br/>'.$message->message.'
		</div>
		</div>
		<div class="clear"></div>';
	}
	else if($message->sentby=="Host")
	{
		echo '<div class="claimright">
		<div class="claimdiv">
		<div class="claimrightimgdiv">
		<span class="claim-img profile_pict tripprofile inlinedisplay" style="background-image:url('.$resized_hostimage.');"></span>
		</div>
		<div class="claimlefttextdiv">
		<span class="padright small-txt">'.date('d,M Y',strtotime($message->cdate)).'</span>
		<a class="airfcfx-txt-capitalize" href="'.$baseUrl.'/profile/'.$hosturl.'">'.$hostdata->firstname.'</a>
		<br />'.$message->message.'
		</div>
		</div>
		</div>
		<div class="clear"></div>';
	}
	else if($message->sentby=="Guest")
	{
		echo '<div class="claimright">
		<div class="claimdiv">
		<div class="claimrightimgdiv">
		<span class="claim-img profile_pict tripprofile inlinedisplay" style="background-image:url('.$resized_userimage.');"></span>
		</div>
		<div class="claimlefttextdiv">
		<span class="padright small-txt">'.date('d,M Y',strtotime($message->cdate)).'</span>
		<a class="airfcfx-txt-capitalize" href="'.$baseUrl.'/profile/'.$userurl.'">'.$userdata->firstname.'</a>
		<br />'.$message->message.'
		</div>
		</div>
		</div>
		<div class="clear"></div>';
	}	
	else if($message->sentby=="Admin")
	{
		echo '<div class="claimright">
		<div class="claimdiv">
		<div class="claimrightimgdiv">
		<span class="claim-img profile_pict inlinedisplay" style="background-image:url('.$resized_adminimage.');"></span>
		</div>
		<div class="claimlefttextdiv">
		<span class="padright small-txt">'.date('d,M Y',strtotime($message->cdate)).'</span>
		Admin
		<br />'.$message->message.'
		</div>
		</div>
		</div>
		<div class="clear"></div>';
	}	
}
?>