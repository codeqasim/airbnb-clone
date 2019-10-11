<?php
$baseUrl = Yii::$app->request->baseUrl;

$adminimage = Yii::$app->urlManager->createAbsoluteUrl('/albums/images/users/usrimg.jpg');
$senderurl = base64_encode($senderdata->id."-".rand(0,999));
$receiverurl = base64_encode($receiverdata->id."-".rand(0,999));
foreach($messages as $message)
{

		$senderdata = $message->getSender()->where(['id'=>$message->senderid])->one();
		$senderimg = $senderdata->profile_image;
		if($senderimg=="")
			$senderimg = "usrimg.jpg";
		//$senderimage = Yii::$app->urlManager->createAbsoluteUrl('/albums/images/users/'.$senderimg);
		$senderimage = Yii::$app->urlManager->createAbsoluteUrl ( '/albums/images/users/'.$senderimg);
		$resized_sender_image = Yii::$app->urlManager->createAbsoluteUrl ('resized.php?src='.$senderimage.'&w=60&h=60');			
		echo '<div class="claimleft">
			<div class="airfcfx-claimleftimgdiv claimleftimgdiv">
			<span class="airfcfx-user-icon profile_pict inlinedisplay" style="background-image:url('.$resized_sender_image.');"></span>
			</div>
			<div class="airfcfx-admin-right airfcfx-claimrighttextdiv claimrighttextdiv"><span class="airfcfx-left-chat-arrow"></span>
			'.$senderdata->firstname.'
			<span class="airfcfx-message-date padleft">'.date('d,M Y',strtotime($message->cdate)).'</span>
			<br /><span class="mobmsgalgn">'.$message->message.'</span>
			</div>
		</div>
		<div class="clear"></div>';		


}
?>