<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Reservations */

$this->title = "View Conversation";
$this->params['subtitle'] = Yii::t('app','View Conversation');
$this->params['breadcrumbs'][]= '';
?>
	<div class="panel panel-default" data-widget='{"draggable": "false"}'>
		<div class="panel-heading">
			<h2><?= Yii::t('app',Html::encode($this->title)) ?></h2>
<!-- 				<div class="panel-ctrls" -->
<!-- 					data-actions-container=""  -->
<!-- 					data-action-collapse='{"target": ".panel-body"}' -->
<!-- 					data-action-expand='' -->
<!-- 					data-action-colorpicker='' -->
<!-- 				> -->
<!-- 				</div> -->
		</div>
		<div class="panel-editbox" data-widget-controls=""></div>
		<div class="panel-body">
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
$userurl = base64_encode($userdata->id."-".rand(0,999));
$hosturl = base64_encode($hostdata->id."-".rand(0,999));
foreach($claimmessages as $message)
{
	if($message->sentby=="Guest")
	{
		echo '<div class="claimleft">
			<div class="claimleftimgdiv">
			<span class="profile_pict inlinedisplay" style="background-image:url('.$userimage.');"></span>
			</div>
			<div class="claimrighttextdiv">
			<a href="'.$frontendurl.'/profile/'.$userurl.'">'.$userdata->firstname.'</a>
			<span class="padleft">'.date('d,M Y',strtotime($message->cdate)).'</span>
			<br /><span class="mobmsgalgn">'.$message->message.'</span>
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
		<a href="'.$frontendurl.'/profile/'.$hosturl.'">'.$hostdata->firstname.'</a>
		<br /><span class="mobmsgalgn">'.$message->message.'</span>
		</div>
		</div>
		</div>
		<div class="clear"></div>';
	}

}
?>
		</div></div>
