<?php
$baseUrl = Yii::$app->request->baseUrl;

$adminimage = Yii::$app->urlManager->createAbsoluteUrl('/albums/images/users/usrimg.jpg');
$senderurl = base64_encode($senderdata->id."-".rand(0,999));
$receiverurl = base64_encode($receiverdata->id."-".rand(0,999));
foreach($messages as $message)
{
	if($loguserid==$message->senderid)
	{
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
			<div class="airfcfx-claimrighttextdiv claimrighttextdiv"><span class="airfcfx-left-chat-arrow"></span>
			<a href="'.Yii::$app->urlManager->createAbsoluteUrl('/profile/'.$senderurl).'">'.$senderdata->firstname.'</a>
			<span class="airfcfx-message-date padleft">'.date('d,M Y',strtotime($message->cdate)).'</span>
			<br /><span class="mobmsgalgn">'.$message->message.'</span>
			</div>
		</div>
		<div class="clear"></div>';		

	}
	else if($loguserid==$message->receiverid)
	{
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
		<div class="airfcfx-claimlefttextdiv claimlefttextdiv"><span class="airfcfx-right-chat-arrow"></span>
		<span class="airfcfx-message-date padright">'.date('d,M Y',strtotime($message->cdate)).'</span>
		<a href="'.Yii::$app->urlManager->createAbsoluteUrl('/profile/'.$receiverurl).'">'.$receiverdata->firstname.'</a>
		<br /><span class="mobmsgalgn">'.$message->message.'</span>
		</div>
		</div>
		</div>
		<div class="clear"></div>';				
	}
	/*if($loguserid==$message->senderid && $message->messagetype=="user")
	{
		echo '<div class="claimleft">
			<div class="claimleftimgdiv">
			<span class="profile_pict inlinedisplay" style="background-image:url('.$senderimage.');"></span>
			</div>
			<div class="claimrighttextdiv">
			<a href="'.$baseUrl.'/profile/'.$senderurl.'">'.$senderdata->firstname.'</a>
			<span class="padleft">'.date('d,M Y',strtotime($message->cdate)).'</span>
			<br />'.$message->message.'
			</div>
		</div>
		<div class="clear"></div>';
	}
	if($loguserid==$message->receiverid && $message->messagetype=="user")
	{
		echo '<div class="claimright">
		<div class="claimdiv">
		<div class="claimrightimgdiv">
		<span class="profile_pict inlinedisplay" style="background-image:url('.$receiverimage.');"></span>
		</div>
		<div class="claimlefttextdiv">
		<span class="padright">'.date('d,M Y',strtotime($message->cdate)).'</span>
		<a href="'.$baseUrl.'/profile/'.$receiverurl.'">'.$receiverdata->firstname.'</a>
		<br />'.$message->message.'
		</div>
		</div>
		</div>
		<div class="clear"></div>';
	}
	else if($message->messagetype=="admin")
	{
		echo '<div class="claimright">
		<div class="claimdiv">
		<div class="claimrightimgdiv">
		<span class="profile_pict inlinedisplay" style="background-image:url('.$adminimage.');"></span>
		</div>
		<div class="claimlefttextdiv">
		<span class="padright">'.date('d,M Y',strtotime($message->cdate)).'</span>
		Admin
		<br />'.$message->message.'
		</div>
		</div>
		</div>
		<div class="clear"></div>';
	}*/
}
?>