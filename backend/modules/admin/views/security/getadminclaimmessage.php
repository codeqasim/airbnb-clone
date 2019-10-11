<?php
$baseUrl = Yii::$app->request->baseUrl;
$usrimg = $userdata->profile_image;
$hostimg = $hostdata->profile_image;
if($usrimg=="")
	$usrimg = "usrimg.jpg";
if($hostimg=="")
	$hostimg = "usrimg.jpg";
$frontendurl = str_replace('/admin','',$baseUrl);	
$userimage = $frontendurl.'/albums/images/users/'.$usrimg;

$hostimage = $frontendurl.'/albums/images/users/'.$hostimg;
$adminimage = $frontendurl.'/albums/images/users/usrimg.jpg';
$userurl = base64_encode($userdata->id."-".rand(0,999));
$hosturl = base64_encode($hostdata->id."-".rand(0,999));
foreach($claimmessages as $message)
{
	if($message->sentby=="Admin")
	{
		echo '<div class="claimleft">
			<div class="claimleftimgdiv">
			<span class="profile_pict inlinedisplay" style="background-image:url('.$adminimage.');"></span>
			</div>
			<div class="claimrighttextdiv">
			Admin
			<span class="padleft">'.date('d,M Y',strtotime($message->cdate)).'</span>
			<br />'.$message->message.'
			</div>
		</div>
		<div class="clear"></div>';
	}	
	else if($message->sentby=="Guest")
	{
		echo '<div class="claimright">
		<div class="claimdiv">
		<div class="claimrightimgdiv">
		<span class="profile_pict inlinedisplay" style="background-image:url('.$userimage.');"></span>
		</div>
		<div class="claimlefttextdiv">
		<span class="padright">'.date('d,M Y',strtotime($message->cdate)).'</span>
		<a href="'.$baseUrl.'/profile/'.$userurl.'">'.$userdata->firstname.'</a>
		<br />'.$message->message.'
		</div>
		</div>
		</div>
		<div class="clear"></div>';
	}

	else if($message->sentby=="Host")
	{
		echo '<div class="claimright">
		<div class="claimdiv">
		<div class="claimrightimgdiv">
		<span class="profile_pict inlinedisplay" style="background-image:url('.$hostimage.');"></span>
		</div>
		<div class="claimlefttextdiv">
		<span class="padright">'.date('d,M Y',strtotime($message->cdate)).'</span>
		<a href="'.$baseUrl.'/profile/'.$hosturl.'">'.$hostdata->firstname.'</a>
		<br />'.$message->message.'
		</div>
		</div>
		</div>
		<div class="clear"></div>';
	}

}
?>