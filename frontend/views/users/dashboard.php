<?php
/*
 * Dashboard page of the user.
 *
 * @author: Muthumareeswari
 * @package: Views
 * @PHPVersion: 5.4
 */
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\CurrencyConverter\CurrencyConverter;
use frontend\models\Listing;
$this->title = 'Dashboard';
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
        echo '<li class="active"><a href="'.$baseUrl.'/dashboard">'.Yii::t('app','Dashboard').'</a></li>
        <li><a href="'.$baseUrl.'/user/messages/inbox/traveling">'.Yii::t('app','Inbox').'</a></li>
        <li><a href="'.$baseUrl.'/user/listing/mylistings">'.Yii::t('app','Listings').'</a></li>
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

<div class="container">
	<div class="row">
    	
        <!--div class="col-xs-12 margin_top20">
        	<div class="bg-success pos_rel padding20">
            	<a href="#" class="text_gray pos_abs" style="right:15px;"><i class="fa fa-times dashboard_icon"></i></a>
            	<div class="table1">
                	<div class="tab_cel">                    
                    <div class="pos_rel dashboard_bg text-center ">
                    <i class="fa fa-inr fa-2x dashboard_icon"></i>                    
                    </div>
                    </div>
                    <h4 class="margin_left20"><b>Earn <i class="fa fa-inr"></i> 6,656 travel credit </b>   </h4>
                    <p class="margin_left20 text_gray1">Give your friends ₹1,331 off their first trip on Airbnb and you'll get up to ₹6,656 travel credit. </p>
                    <button class="btn btn_dashboard margin_left20 margin_top20">Invite Friends</button>
                    <button class="btn btn_google margin_top20">Later</button>
            		</div>
                    
            </div>  
        </!--div> <!--col-xs-12 end-->
	
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    	
    	<div class="col-xs-12 col-sm-4 col-md-3 col-lg-3 margin_top20 margin_bottom20">
			<?php
			$usrimg = $userdata->profile_image;

			$profile_image = Yii::$app->urlManager->createAbsoluteUrl ( '/albums/images/users/'.$usrimg);						
			$header_response = get_headers($profile_image, 1);
			if ( strpos( $header_response[0], "404" ) !== false )
			{
				$profile_image = "usrimg.jpg";
			} 
			else 
			{
				$profile_image = Yii::$app->user->identity->profile_image;
			}

			if($usrimg=="")
			$profile_image = "usrimg.jpg";
			$userimage = Yii::$app->urlManager->createAbsoluteUrl('albums/images/users/'.$profile_image);
			$resized_userimage = Yii::$app->urlManager->createAbsoluteUrl ('resized.php?src='.$userimage.'&w=250&h=250');	
			echo '<div class="profile-tag prof-images pos_rel"><div class="airfcfx-profile-img profile_img" style="background-image:url('.$resized_userimage.')" >';
			/*if(isset($userdata->profile_image))
			{
				echo '<div class="profile_img pos_rel" style="background-image:url(albums/images/users/'.$usrimg.')" >';
			}
			else
			{
				echo '<div class="profile_img pos_rel" style="background-image:url(images/user_pic-225x225.png	)" >';
			}*/
			?>
			 <div class="airfcfx-profile_photo profile_photo text-center">
                        <!-- a href="#"><i class="fa fa-camera"></i> <?php echo Yii::t('app','Add Profile Photo');?></a -->
	
	<?php $form = ActiveForm::begin([
		'action' => 'dashboard',
		'method' => 'POST',
 		'options' => ['id' => 'fileupload', 'enctype' => 'multipart/form-data']	,
		'enableAjaxValidation' => true,
 	//	'fieldConfig' => ['class' => ActiveField::className()],
 	]);
	
 	/*$upload = new yii\xupload\models\XUploadForm;
 			 echo yii\xupload\XUpload::widget([
 							'url' => \Yii::$app->getUrlManager()->createUrl("dashboard"),
 							'model' => $upload,
 							'attribute' => 'file',
 	 						'multiple' => true,
							'showForm' => true,
 							'clientOptions'=> [
 									'maxNumberOfFiles' => 4,
 									'maxFileSize'=>2000000,
  									'acceptFileTypes' =>  new yii\web\JsExpression('/(\.|\/)(gif|jpe?g|png)$/i'),
 							//		'beforeSend' => 'js:function(event, files, index, xhr, handler, callBack) {
 							//		handler.uploadRow.find(".upload_start button").click(callBack);
 							//		}',
 									'onComplete' => new yii\web\JsExpression('function (event, files, index, xhr, handler, callBack) {
 									}')],
 				]);*/
	echo '			<a href="" style="top: 0;position: absolute;color:#fff;text-decoration:none;cursor:pointer;width: 100%;left: 0;padding: 10px 0;"> '. Yii::t('app','Edit').'</a>
					<input type="file" id="userfile" name="XUploadForm[file]" accept=".png, .jpg, .jpeg" style="opacity:0;width:100%;cursor:pointer;position:absolute;top:0;height:40px;" onchange="return on_submit();">
					
					<div class="col-xs-4" style="display:none;"><button type="submit" class="btn btn-danger">Save</button></div>
					';

			 
		?>
		 <?php ActiveForm::end(); ?>
                        </div>	
                    
                        </div>
                    </div> <!--profile_img end-->
                    <br />
                    <div class="margin_bottom20 clear">
                        <div class="text-center margin_top10 margin_bottom10">
                        	<h1 class="airfcfx-wordwrap"><?php echo $firstname; ?></h1>
                            <!--<a href="<?php echo $baseUrl.'/profile/'.$username;?>" class="text-danger"><?php echo Yii::t('app','View Profile');?></a>
                            <br/>
                            <a href="<?php echo $baseUrl;?>/editprofile">
								<button class="airfcfx-panel btn btn_email margin_top10"><?php echo Yii::t('app','Complete Profile');?></button>
							</a>-->
                        </div>                  
                    </div> <!--border1 end -->
                    
            		<div class="airfcfx-panel panel panel-default">
                      <div class="airfcfx-panel panel-heading profile_menu1">
                        <h3 class="airfcfx-panel-title panel-title"><?php echo Yii::t('app','Verifications');?> 
                        <i class="fa fa-question-circle hover_tool pos_rel pull-right">
                       <div class="tooltip_text">
                        	<p class="font_size12"><?php echo Yii::t('app','Verifications help build trust between guests and hosts and can make booking easier.');?> </p>
                       </div><!--tooltip_text end-->
						</i>
                        </h3>
                      </div>
                      <div class="airfcfx-dashbd-verify-panel-body panel-body">
                        <div class="row margin_top20"> 
                                <div class="airfcfx-verifications-row table1">
                                <div class="airfcfx-verified-symbol-width tab_cel text-center ">
									<?php
									if($userdata['emailverify']=="1")
									{
										?>
										<i class="tick-circle fa-1x text-success"></i>
								</div>	
                                    <p><?php echo Yii::t('app','Email');?></p>
									<!--<p class="text_gray1"><?php echo Yii::t('app','Verified');?> </p>-->
									<?php
									}
									else
									{
										?>
										<i class="close-circle fa-1x text-danger"></i>
								</div>	
                                    <p>Email</p>
									<p class="text_gray1"><?php //echo Yii::t('app','Not verified');?> </p>										
                                    <?php
									}
									?>
								
                                                                       
                                </div>
						<?php
						if($userdata['mobileverify']!="1" || $userdata['emailverify']!="1")
						{
                                echo '<div class="airfcfx-verifications-row table1">';
						}
						else
						{
							echo '<div class="airfcfx-verifications-row table1" style="border-bottom: none;">';
						}
						
						?>
                                <div class="airfcfx-verified-symbol-width tab_cel text-center ">
									<?php
									if($userdata['mobileverify']=="1")
									{
										?>
										<i class="tick-circle fa-1x text-success"></i>
								</div>	
                                    <p><?php echo Yii::t('app','Mobile');?></p>
									<!--<p class="text_gray1"><?php echo Yii::t('app','Verified');?> </p>-->
									<?php
									}
									else
									{
										?>
										<i class="close-circle fa-1x text-danger"></i>
								</div>	
                                    <p><?php echo Yii::t('app','Mobile');?></p>
									<p class="text_gray1"><?php //echo Yii::t('app','Not verified');?> </p>										
                                    <?php
									}
									?>
								
                                                                       
                                </div> 						
								<?php
								if($userdata['mobileverify']!="1" || $userdata['emailverify']!="1")
								{
									?>
									<br />
                          <div class="margin_bottom15">     <a href="<?php echo $baseUrl.'/trust';?>" class="text-danger margin_left20"><?php echo Yii::t('app','+ Add more verifications');?> </a> </div> 
								<?php
								}
								?>
                             </div> <!--row end --> 
                      </div>
                    </div> <!--Panel end -->
                    <!--div class="panel panel-default">
                      <div class="panel-heading profile_menu1">
                        <h3 class=" panel-title">
                        <?php echo Yii::t('app','Quick Links');?>
                        </h3>
                      </div>
                      <div class="panel-body">
                        <div class="row padd_10_15">
                            	<ul class="list-unstyled quick_link">                                 
                                <li><a href="#" class="text-danger margin_left20"><?php echo Yii::t('app','View/Manage Listing');?> </a></li>
                                <li><a href="#" class="text-danger margin_left20"><?php echo Yii::t('app','Reservations');?> </a></li>
                                <li><a href="#" class="text-danger margin_left20"><?php echo Yii::t('app','Reviews & References');?> </a></li>
                                </ul>
                             </div> 
                      </div>
                   </div--> <!--Panel end -->                   
                    
        </div> <!--col-sm-3 end -->
        
        
        <div class="col-xs-12 col-sm-8 col-md-9 col-lg-9 margin_top20 margin_bottom20">
        
        		<div class="airfcfx-panel panel panel-default">
          <div class="airfcfx-panel airfcfx-panel-padding panel-heading profile_menu1">
            <h3 class="airfcfx-panel-title panel-title "><?php echo Yii::t('app','Welcome to');?> <?php echo $sitesettings->sitename;?>, <?php echo $userdata['firstname'];?></h3>
          </div>
          <div class="airfcfx-panel-padding panel-body">
           <div class="row ">                
                                        <div class="">
                                            <div class="col-xs-12 ">                                                       
                                            <p><p><?php echo Yii::t('app','This is your Dashboard, the place to manage your rental, check messages in your Inbox, respond to Reservation Requests, view upcoming Trip Information, and much more!');?>  </p>                                    <br/>
                                            <a href="<?php echo $baseUrl.'/user/listing/mylistings';?>" class="airfcfx-red-heading text-danger"><?php echo Yii::t('app','Edit Your Properties');?></a>
                                            <p><?php echo Yii::t('app','Update availability and pricing for all of your properties.');?></p>
                                            <br/>
                                            <a href="<?php echo $baseUrl.'/invitefriends';?>" class="airfcfx-red-heading text-danger"><?php echo Yii::t('app','Build Your Reputation');?></a>
                                            <p><?php echo Yii::t('app','Ask friends to write you references.');?></p>
                                            <br/>
                                            <a href="<?php echo $baseUrl.'/user/help/index'?>" class="airfcfx-red-heading text-danger"><?php echo Yii::t('app','Get Help!credit');?></a>
                                            <p><?php echo Yii::t('app','View our help section and FAQs to get started on');?> <?php echo $sitesettings->sitename;?>.</p>
                                            
                                            </div>  
                                        </div> <!--col-xs-12 end -->                            
                                     </div> <!--row end -->
          </div>
        </div> <!--Panel end -->
        	
                    
                   
                   
        </div> <!-- col-sm-9 end -->
	</div>
    </div> <!-- row end -->

</div> <!-- container end -->

<style type="text/css">
	.col-lg-7
	{
		z-index : 1000;
	}
	.cancel,.delete,.start,.toggle
	{
		display: none;
	}
	.fileinput-button
	{
		background: none !important;
		border: none !important;
		text-align: left !important;
	}
	.fileupload-buttonbar
	{
		width:23% !important;
	}
	input[type="file"]
	{
		width: 145%;
		opacity: 0;
	}
</style>
<script>
	function on_submit() {
		if (document.getElementById("userfile").files[0].size > 4194304)
		{
		  alert("File is too big.");
		  return false;
		}
	  $("#fileupload").submit();
		return true;
    }
</script>
