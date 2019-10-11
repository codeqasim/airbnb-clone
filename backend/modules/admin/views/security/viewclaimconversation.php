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
$adminimage = $frontendurl.'/albums/images/users/usrimg.jpg';
$userurl = base64_encode($userdata->id."-".rand(0,999));
$hosturl = base64_encode($hostdata->id."-".rand(0,999));
	echo '<input type="hidden" id="userid" value="'.$userdata->id.'">';
	echo '<input type="hidden" id="hostid" value="'.$hostdata->id.'">';
if($claim->involveadmin==1)
{
	echo '<textarea rows="2" cols="80" class="txtarea" id="claimmessage" maxlength="250"></textarea>';
	echo '<input type="hidden" id="reserveid" value="'.$claim->id.'">';
	echo '<input type="button" value="'.Yii::t('app','Send').'" class="btn btn-danger sendbtn" id="sendbtn" onclick="send_adminclaim_message()">';
	echo '<img id="loadingimg" src="'.$frontendurl.'/images/load.gif" class="loading">';
	echo '<div class="adminclaimerr errcls"></div>';
}
echo '<div id="messagesdiv">';
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
		<a href="'.$frontendurl.'/profile/'.$userurl.'">'.$userdata->firstname.'</a>
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
		<a href="'.$frontendurl.'/profile/'.$hosturl.'">'.$hostdata->firstname.'</a>
		<br />'.$message->message.'
		</div>
		</div>
		</div>
		<div class="clear"></div>';
	}

}
echo '</div>';
?>
		</div></div>
	<script type="text/javascript">
	$(document).ready(function(){
		//getclaimmessage();
	});
	//setInterval(getclaimmessage, 5000);
function getclaimmessage()
{
	var reserveid = $("#reserveid").val();
	$.ajax({
		type : 'POST',
		url : baseurl + '/admin/security/getadminclaimmessage',
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
