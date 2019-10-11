<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use frontend\components\MyClass;
use frontend\models\Logs; 

AppAsset::register($this);
?>
<?php
      $sitesetting = Yii::$app->mycomponent->getLogo();
		if(isset($sitesetting->metakey))
			$metakey = $sitesetting->metakey;
		else
			$metakey = "";
		if(isset($sitesetting->metadesc))
			$metadesc = $sitesetting->metadesc;
		else
			$metadesc = "";

$adminUrl = Yii::$app->request->baseUrl.'/admin';		
?>   
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
<meta charset="<?= Yii::$app->charset ?>">
<meta name="description" content="<?php echo $metakey; ?>">
<meta name="keywords" content="<?php echo $metadesc; ?>">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no" /> 
<link href="<?php echo $adminUrl."/images/".$sitesetting->defaultfavicon; ?>" type="image/x-icon" rel="icon">   
<?php 
	$shareImg = Yii::$app->urlManager->createAbsoluteUrl ("/admin/images/shareimg.jpg");
	$ogurl = Yii::$app->urlManager->createAbsoluteUrl ('/');
	Yii::$app->controller->view->registerMetaTag(['property'=>'og:type', 'content'=>'website'], 'og:type');
	Yii::$app->controller->view->registerMetaTag(['property'=>'og:url', 'content'=>$ogurl], 'og:url');
	Yii::$app->controller->view->registerMetaTag(['property'=>'og:description', 'content'=>$metadesc], 'og:description'); 
	Yii::$app->controller->view->registerMetaTag(['property'=>'fb:app_id', 'content'=>'525099564335172'], 'fb:app_id'); 
	Yii::$app->controller->view->registerMetaTag(['property'=>'og:image:type', 'content'=>'image/jpeg'], 'og:image:type');
	Yii::$app->controller->view->registerMetaTag(['property'=>'og:image:width', 'content'=>"300"], 'og:image:width');
	Yii::$app->controller->view->registerMetaTag(['property'=>'og:image:height', 'content'=>"300"], 'og:image:height');
	Yii::$app->controller->view->registerMetaTag(['property'=>'og:image', 'content'=>$shareImg], 'og:image'); 
?>

<?= Html::csrfMetaTags() ?>
<?php
	$sitesetting = Yii::$app->mycomponent->getLogo();
	if(isset($sitesetting->googleapikey) && $sitesetting->googleapikey!="")
		$googleapikey = $sitesetting->googleapikey;
	else
		$googleapikey = "";
?>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=<?php echo $googleapikey;?>&libraries=places">
    </script>
<?php
$baseUrl = Yii::$app->request->baseUrl;

$this->registerJsFile($baseUrl.'/js/jquery.js', array('position' => $this::POS_HEAD), 'jquery');
$this->registerJsFile($baseUrl.'/js/bootstrap.js', array('position' => $this::POS_HEAD), 'bootstrap');

$this->registerJsFile($baseUrl.'/js/jquery.slider.bundle.js', array('position' => $this::POS_HEAD), 'jquery.slider.bundle');
$this->registerJsFile($baseUrl.'/js/jquery.slider.js', array('position' => $this::POS_HEAD), 'jquery.slider');

$this->registerJsFile($baseUrl.'/js/front.js', array( 'position' => $this::POS_HEAD), 'scripts');

$this->registerCssFile($baseUrl.'/css/style.css');
$this->registerCssFile($baseUrl.'/css/bootstrap.css');
$this->registerCssFile($baseUrl.'/css/jquery-ui.min.css');
$this->registerCssFile($baseUrl.'/css/style1.css');


$this->registerCssFile($baseUrl.'/css/font-awesome.min.css');
$this->registerCssFile($baseUrl.'/css/jslider.css');
?>

<script>
var baseurl="<?php print Yii::$app->request->baseUrl;?>";
</script>
<style type="text/css">
.alert-success {
	position: absolute;
	right: -50%;
	width: 50%;
	transition: all 0.5s !important;
	overflow: hidden !important;
	z-index: 1001 !important;
}
#closebutton {
	margin-right: 15px;
}

.flashcss {
	right: 0%;
}
</style>
<title><?= Html::encode($this->title) ?></title>
<?php $this->head() ?>
</head>
<body>
	<?php $this->beginBody() ?>


	<?php 
	$countLogs = 0;
	$lastLogs = 0;
	if (! Yii::$app->user->isGuest) {
		$loguserid = \Yii::$app->user->identity->id;
	 	$countLogs = Logs::find()->where(['notifyto'=>$loguserid, 'messageread'=>'1'])->count();

	 	$lastLogs = Logs::find()->where(['notifyto'=>$loguserid, 'messageread'=>'1'])->orderBy('id desc')->limit('5')->all();  
	}

	?>

<div class="container-section">
	
			<?php
			if (Yii::$app->controller->action->id != 'listcreate') { 
			?>
				<nav class="navbar navbar-default norm_nav topHeader search-header">
			<?php
			}
			else {
			?>
				<nav class="navbar navbar-default norm_nav listcreat-head">
			<?php
			}
			?>

		<div class="airfcfx-home-cnt-width-header">
		<div class="navbar-header">
			<button aria-controls="navbar" aria-expanded="false"
				data-target="#navbar" data-toggle="collapse"
				class="airfcfx-mobile-navbar navbar-toggle collapsed" type="button">
				<span class="sr-only"><?php echo Yii::t('app','Toggle navigation');?></span> <span
					class="icon-bar"></span> <span class="icon-bar"></span> <span
					class="icon-bar"></span>
			</button>
			<a href="<?php echo $baseUrl.'/';?>" class="navbar-brand"> <?php
			$sitesetting = Yii::$app->mycomponent->getLogo();
			?> <img
				src="<?php echo $adminUrl;?>/images/<?php echo $sitesetting->sitelogoblack;?>"
				alt="<?php echo $sitesetting->sitename;?>" class="logoimg" />
			</a>
			<?php
			if (Yii::$app->controller->action->id != 'listcreate') { 
			?>
			<div class="pos_rel pull-left search_sec">
				<input id="where-to-go" type="text" class="form-control" placeholder="<?php echo Yii::t('app','Search');?>"> 
				<svg class="over_input viewBox="0 0 24 24" role="presentation" aria-hidden="true" focusable="false" style="display:block;fill:#767676;height:22px;width:22px;" data-reactid="134">
<path d="M10.4 18.2c-4.2-.6-7.2-4.5-6.6-8.8.6-4.2 4.5-7.2 8.8-6.6 4.2.6 7.2 4.5 6.6 8.8-.6 4.2-4.6 7.2-8.8 6.6M23 22l-5-5c1.4-1.4 2.3-3.1 2.6-5.2.7-5.1-2.8-9.7-7.8-10.5-5-.7-9.7 2.8-10.5 7.9-.7 5.1 2.8 9.7 7.8 10.5 2.5.4 4.9-.3 6.7-1.7v.1l5 5c.3.3.8.3 1.1 0 .3-.3.4-.8.1-1.1" fill-rule="evenodd" data-reactid="135">
</svg>
           			<input id="place-lat" type="hidden" value="<?php if(isset($_SESSION['lat'])){ echo $_SESSION['lat']; unset($_SESSION['lat']); } ?>">
           			<input id="place-lng" type="hidden" value="<?php if(isset($_SESSION['lng'])){ echo $_SESSION['lng']; unset($_SESSION['lng']); } ?>">				
			</div>
			<?php
			} 
			?>
		</div>

		<div class="navbar-collapse collapse" id="navbar">

			<ul class="nav navbar-nav navbar-right">
				<!--  <li class="dropdown">
						<form action="<?php echo $baseUrl.'/language';?>" method="GET">
							<?= Html::dropDownList('language', Yii::$app->language, ['fr' => 'French','en' => 'English', 'zh' => 'Chinese']) ?>
							<?= Html::submitButton('Change') ?>
						</form>				
					</li>	 -->		
				<?php
				if(!(Yii::$app->user->isGuest))
				{
					
					if(Yii::$app->user->identity->hoststatus=="1")
					{	
					?>
				<li class="dropdowns"><a href="#" aria-expanded="false"
					aria-haspopup="true" role="button" data-toggle="dropdown"
					class="airfcfx-menu-link dropdown-toggle pos_rel"><!--<span class="airfcfx-menu-host-icon"></span>-->
					<span class="airfcfx-menu"><?php echo Yii::t('app','Host');?></span><!--span
						class="pos_abs notifi_up">!</span><i class="fa fa-home text_gray "></i-->
				</a>
					<!--ul class="dropdown-menu">
						<li class="margin_top10 margin_bottom10"><a href="<?php echo $baseUrl.'/user/listing/mylistings';?>">Manage Listings</a></li>
						<a href="<?php echo $baseUrl;?>/user/listing/mylistings" class="rm_text_deco"><li
							class="margin_top10 margin_bottom10"><?php echo Yii::t('app','Your Listings');?></li> </a>					
						<div class="border_bottom"></div>
					</ul-->
					<ul class="dropdown-menu padding20 profil_menu">
						<a href="<?php echo $baseUrl;?>/user/listing/mylistings" class="rm_text_deco"><li
							class="margin_top10 margin_bottom10"><?php echo Yii::t('app','Listings');?></li> </a>					
						<div class="border_bottom"></div>

						<a href="<?php echo $baseUrl;?>/user/listing/reservations" class="rm_text_deco"><li
							class="margin_top10 margin_bottom10"><?php echo Yii::t('app','Reservations');?></li> </a>
						<div class="border_bottom"></div>
						<a href="<?php echo $baseUrl;?>/user/listing/listcreate" class="rm_text_deco"><li
							class="margin_top10 margin_bottom10"><?php echo Yii::t('app','Add listing');?></li> </a>
						<div class="border_bottom"></div>
						<a href="<?php echo $baseUrl;?>/user/listing/completedtransaction" class="rm_text_deco">
							<li class="margin_top10 margin_bottom10"><?php echo Yii::t('app','Transaction History');?></li>
						</a>
					</ul>					
				</li>
				<?php }?>

				<li class="dropdown">
					<a href="<?php echo $baseUrl.'/user/messages/inbox/traveling';?>"  class="dropdown-toggle airfcfx-menu-link"><span class="airfcfx-menu"><?php echo Yii::t('app','Messages');?></span> 
					</a> 
				</li>
				<li class="dropdowns ">
           		<a href="<?php echo $baseUrl.'/user/listing/usernotifications';?>" aria-expanded="false"
						aria-haspopup="true" role="button" data-toggle="dropdown"
						class="airfcfx-menu-link dropdown-toggle pos_rel">
							<span class="airfcfx-menu">
								<?php echo Yii::t('app','Notification');?> 
								<?php if($countLogs > 0) { ?>
									<svg class="notify-round" focusable="false" aria-label="" role="img">
										<circle cx="3" cy="3" r="3"></circle>
									</svg>
								<?php } ?>
							</span>  
					</a>

					<ul class="home-menu dropdown-menu profil_menu">						
						<li class="margin_top15 margin_bottom15">
							<a href="<?php echo $baseUrl.'/user/listing/usernotifications';?>" class="home-menu-text">
								<?php echo Yii::t('app','Notification');?> 
								<span class="note_count">(<?php echo $countLogs; ?>)</span>

								<span class="note_view"><?php echo Yii::t('app', 'View all'); ?></span>   
							</a>
						</li> 
						<?php 
							foreach ($lastLogs as $key => $log) {
								$loguserdata = $log->getUser()->where(['id'=>$log->userid])->one();
								
								echo '<li class="border_bottom"></li>'; 
								echo '<li class="note-msg margin_top15 margin_bottom15">'; 

								if($log->type=="message")  
								{
									$logusername = base64_encode($loguserdata->id."-".rand(0,999));
									echo '<span class=""><a href="'.$baseUrl.'/profile/'.$logusername.'">'.$loguserdata->firstname.'</a>'.' '.Yii::t('app',$log->notifymessage);

									if(trim($log->message) != ""){
										echo ' "'.substr(trim($log->message), 0, 50).'..."'; 
									}
									echo '</span>';  
								}
								else if($log->type=="admin") 
								{
									$logusername = base64_encode($loguserdata->id."-".rand(0,999));
									echo '<span class="">'.$loguserdata->firstname.'
								'.Yii::t('app',$log->notifymessage);

									if(trim($log->message) != ""){
										echo ' "'.substr(trim($log->message), 0, 50).'..."'; 
									}
									echo '</span>';  
								}
								else if($log->type=="adminpayment")
								{
									$logusername = base64_encode($loguserdata->id."-".rand(0,999));
									echo '<span class="">'.Yii::t('app',$log->notifymessage).'</span>';
								}							
								else if($log->type=="accept" || $log->type=="cancel" || $log->type=="decline" || $log->type=="claim" || $log->type=="review")
								{
									$logusername = base64_encode($loguserdata->id."-".rand(0,999));
									$listid = $log->listingid;
									$listingdata = $log->getListing()->where(['id'=>$listid])->one();
									$listingname = $listingdata->listingname;
									$listingurl = $baseUrl.'/user/listing/view/'.base64_encode($listid."_".rand(1,9999));
								echo '<span class=""><a href="'.$baseUrl.'/profile/'.$logusername.'">'.$loguserdata->firstname.'</a>
								'.Yii::t('app',$log->notifymessage).' on <a href="'.$listingurl.'">'.$listingname.'</a></span>';								
								}
								else if($log->type=="reservation")
								{
									$logusername = base64_encode($loguserdata->id."-".rand(0,999));
									$listid = $log->listingid;
									$listingdata = $log->getListing()->where(['id'=>$listid])->one();
									$listingname = $listingdata->listingname;
									$listingurl = $baseUrl.'/user/listing/view/'.base64_encode($listid."_".rand(1,9999));
									echo '<span class="">'.Yii::t('app','You got reservation from').' <a href="'.$baseUrl.'/profile/'.$logusername.'">'.$loguserdata->firstname.'</a>
									at <a href="'.$listingurl.'">'.$listingname.'</a></span>';		 							
								}
								else if($log->type=="request")
								{
									$logusername = base64_encode($loguserdata->id."-".rand(0,999));
									$listid = $log->listingid;
									$listingdata = $log->getListing()->where(['id'=>$listid])->one();
									$listingname = $listingdata->listingname;
									$listingurl = $baseUrl.'/user/listing/view/'.base64_encode($listid."_".rand(1,9999));
									echo '<span class="">'.Yii::t('app','You made a reservation on ').'<a href="'.$baseUrl.'/profile/'.$logusername.'"> '.$loguserdata->firstname.'</a>
									\'s <a href="'.$listingurl.'">'.$listingname.'</a></span>';								
								} else { 
									$logusername = base64_encode($loguserdata->id."-".rand(0,999));
									echo '<span class="">'.$loguserdata->firstname.'
									'.Yii::t('app',$log->notifymessage).'</span>'; 
								}   

								echo '</li>'; 
							}


						?>									
					</ul>	 			
				</li>

				<li class="dropdown"><a href="<?php echo $baseUrl.'/user/help/index';?>"  class="dropdown-toggle airfcfx-menu-link"><span class="airfcfx-menu"><?php echo Yii::t('app','Help');?></span>
				</a> 
					
				<?php
				}
				else
				{
					?>
						<li class="dropdown"><a href="<?php echo $baseUrl.'/user/help/index';?>" 
							class="airfcfx-menu-link dropdown-toggle pos_rel"><span class="airfcfx-menu"><?php echo Yii::t('app','Help');?></span></a>
						</li>
						<li class="dropdown"><a href="<?php echo $baseUrl.'/register';?>" aria-expanded="false"
							aria-haspopup="true" role="button" data-toggle="modal"
							class="airfcfx-menu-link dropdown-toggle pos_rel"><span class="airfcfx-menu"><?php echo Yii::t('app','Signup');?></span></a>
						</li>
						<li class="dropdown"><a href="<?php echo $baseUrl.'/signin';?>" aria-expanded="false"
							aria-haspopup="true" role="button" data-toggle="modal"
							class="airfcfx-menu-link dropdown-toggle pos_rel"><span class="airfcfx-menu"><?php echo Yii::t('app','Login');?></span></a>
						</li>
						<?php
				}
				?>

					
				</li>
				<?php
				if(!(Yii::$app->user->isGuest))
				{
					?>
				<li class="dropdowns">
				<a href="<?php echo $baseUrl;?>/dashboard"aria-expanded="false"
					aria-haspopup="true" role="button" data-toggle="dropdown"
					class="airfcfx-menu-link dropdown-toggle pos_rel margin_right padd_right_60"> <span class="airfcfx-profilename"><?php echo \Yii::$app->user->identity->firstname;
					echo '</span>';
					if(isset(Yii::$app->user->identity->profile_image) && Yii::$app->user->identity->profile_image!="")
					{
						$profile_image = Yii::$app->user->identity->profile_image;
						$profile_image = Yii::$app->urlManager->createAbsoluteUrl ( '/albums/images/users/'.$profile_image);						
						$header_response = get_headers($profile_image, 1);
						if ( strpos( $header_response[0], "404" ) !== false )
						{
							$profile_image = "usrimg.jpg";
							$profile_image = Yii::$app->urlManager->createAbsoluteUrl ( '/albums/images/users/'.$profile_image);
						} 
						else 
						{
							$profile_image = Yii::$app->user->identity->profile_image;
							$profile_image = Yii::$app->urlManager->createAbsoluteUrl ( '/albums/images/users/'.$profile_image);	
						}
						$resized_profile_image = Yii::$app->urlManager->createAbsoluteUrl ('resized.php?src='.$profile_image.'&w=40&h=40');
						echo '<span class="profile_pict" style="background-image:url('.$resized_profile_image.');"></span>';
					}
					else
					{
						$profile_image = "usrimg.jpg";
						$profile_image = Yii::$app->urlManager->createAbsoluteUrl ( '/albums/images/users/'.$profile_image);
						$resized_profile_image = Yii::$app->urlManager->createAbsoluteUrl ('resized.php?src='.$profile_image.'&w=40&h=40');						
						echo '<span class="profile_pict" style="background-image:url('.$resized_profile_image.');"></span>';
					}
					?>
				</a>
					<ul class="dropdown-menu padding20 profil_menu">
						<a href="<?php echo $baseUrl;?>/dashboard"
							class="rm_text_deco"><li class=" margin_bottom10"><?php echo Yii::t('app','Dashboard');?></li> 
						</a>
						<div class="border_bottom"></div>
						<a href="<?php echo $baseUrl;?>/user/listing/trips"
							class="rm_text_deco"><li class="margin_top10 margin_bottom10"><?php echo Yii::t('app','Trips');?></li>
						</a>
						<div class="border_bottom"></div>

						<a href="<?php echo $baseUrl;?>/user/listing/mywishlists" class="rm_text_deco"><li
							class="margin_top10 margin_bottom10"><?php echo Yii::t('app','Saved');?></li> </a>
						<div class="border_bottom"></div> 
						<a href="<?php echo $baseUrl;?>/editprofile" class="rm_text_deco"><li
							class="margin_top10 margin_bottom10"><?php echo Yii::t('app','Edit Profile');?></li> </a>
						<div class="border_bottom"></div>
						<a href="<?php echo $baseUrl;?>/invitefriends"
							class="rm_text_deco"><li class="margin_top10 margin_bottom10">
								<?php echo Yii::t('app','Invite Friends');?></li> </a>
						<div class="border_bottom"></div>
						<a href="<?php echo $baseUrl;?>/user/listing/notifications" class="rm_text_deco">
							<li class="margin_top10 margin_bottom10"><?php echo Yii::t('app','Account Settings');?></li>
						</a>
						<div class="border_bottom"></div>
						<a href="<?php echo $baseUrl;?>/logout" class="rm_text_deco"><li
							class="margin_top10"><?php echo Yii::t('app','Logout');?></li> </a>
					</ul>
				</li>
				<?php
				}
				?>

			</ul>
		</div>
		<!--/.nav-collapse -->
		</div>
	</nav>
	
	<!--search drop down calendar-->
	<?php
	$listingproperty = Yii::$app->mycomponent->getListingproperty();
	echo'
	<div class="container hiddencls" id="searchcalendardiv">
	<div class="col-lg-12 airfcfx-dd-calendar-cnt">
	<div class="airfcfx-dd-calendar border1  bg_white caltxt">
	
	<div class="table1 margin_top10 margin_left5 margin_bottom10 padd_5_10 checkinalgn">

	<div class="checkindivcls">
	<label>'.Yii::t('app','Check In').'</label>
	<input id="check-in-main" type="text" class="form-control" placeholder="DD-MM-YYYY" value="">
	</div>
	<div class="checkindivcls">
	<label>'.Yii::t('app','Check Out').'</label>
	<input id="check-out-main" type="text" class="form-control" placeholder="DD-MM-YYYY" value="">
	</div>
	<div class="guestdivcls">
	<label>'.Yii::t('app','Guests').'</label>
	<select class="form-control margin10" id="guest-count">';
	$accommodates = $listingproperty->accommodates;
	for($i=1;$i<=$accommodates;$i++)
	{
		echo '<option value="'.$i.'">'.$i.'</option>';
	}
	
	echo '</select>
	</div>
	</div><!--table1 end-->';
	$roomtypes = Yii::$app->mycomponent->getRoomtype();
	echo '<div class="airfcfx-dd-calendar-rt-txt col-lg-12">'.Yii::t('app','Room Type').'</div>';

	echo '<div class="airfcfx-dd-cal-RT"><div class="pull-left padleft">
		<label><input id="roomtype1" class="airfcfx-search-drop-checkbox" type="checkbox" name="roomtype" value="'.$roomtypes[0]->id.'">
		<div class="airfcfx-search-checkbox-text">'.$roomtypes[0]->roomtype.'</div></label></div></div>
	
	<div class="airfcfx-dd-cal-RT"><div class="pull-left padleft">
		<label><input id="roomtype2" class="airfcfx-search-drop-checkbox" type="checkbox" name="roomtype" value="'.$roomtypes[1]->id.'">
		<div class="airfcfx-search-checkbox-text">'.$roomtypes[1]->roomtype.'</div></label></div></div>
	
	<div class="airfcfx-dd-cal-RT"><div class="pull-left padleft">
		<label><input id="roomtype3" class="airfcfx-search-drop-checkbox" type="checkbox" name="roomtype" value="'.$roomtypes[2]->id.'">
		<div class="airfcfx-search-checkbox-text">'.$roomtypes[2]->roomtype.'</div></label></div></div>';

	/*echo '<div class="airfcfx-dd-cal-RT"><div class="pull-left"><input type="hidden" name="SignupForm[rememberMe]" value="0"><input id="login-rememberMe" type="checkbox" name="SignupForm[rememberMe]"><div class="airfcfx-search-dd-checkbox-text">Entire home / APT</div></div></div>
	<div class="airfcfx-dd-cal-RT"><div class="pull-left"><input type="hidden" name="SignupForm[rememberMe]" value="0"><input id="login-rememberMe" type="checkbox" name="SignupForm[rememberMe]"><div class="airfcfx-search-dd-checkbox-text">Private Room</div></div></div>
	<div class="airfcfx-dd-cal-RT"><div class="pull-left"><input type="hidden" name="SignupForm[rememberMe]" value="0"><input id="login-rememberMe" type="checkbox" name="SignupForm[rememberMe]"><div class="airfcfx-search-dd-checkbox-text">Shared Room</div></div>
	</div>';*/
	echo '<div class="airfcfx-search-dd-findplace-btn"><button class="airfcfx-findplace-btn airfcfx-panel btn btn_email" onclick="searchlistmains()">'.Yii::t('app','Find a place').'</button></div>
	</div><!--border1 end-->
	</div></div>';
	?>

	<?= Breadcrumbs::widget([
			'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
	<?= Alert::widget() ?>
	<div class="contentBody topMargin">
		<?= $content ?>
	</div>

	<?php 
	$sitesetting = Yii::$app->mycomponent->getLogo();
	$footercontent = json_decode($sitesetting->footercontent,true);
	$helppages = Yii::$app->mycomponent->getHelp();
	?>
	<div class="footer">
		<div class="airfcfx-home-cnt-width container margin_bottom30">
		
			<div class="res-pading0 airfcfx-footer-info col-xs-12 col-sm-5 col-md-4 margin_bottom20">
				
				<div class="col-xs-6 col-sm-12 airfcfx-footer-dd-cnt hor-padding">
					<select id="language_select" class="col-xs-12 col-sm-6 airfcfx-footer-select form-control margin10 no-hor-padding" onchange="change_language()">
						<?php 
						if(!isset($_SESSION['language'])) {
							$_SESSION['language'] = 'en';
						}
						if($_SESSION['language'] == 'en') {
							echo '<option selected value="en">English</option>';
						} else {
							echo '<option value="en">English</option>';
						}?>
						<?php if($_SESSION['language'] == 'fr') {
							echo '<option selected value="fr">French</option>';
						} else {
							echo '<option value="fr">French</option>';
						}?>
						<?php if($_SESSION['language'] == 'zh') {
							echo '<option selected value="zh">Chinese</option>';
						} else {
							echo '<option value="zh">Chinese</option>';
						}?>
		
						
					</select>
				</div>

				<div class="col-xs-6 col-sm-12 airfcfx-footer-dd-cnt hor-padding">
				<?php 
					$currencies = Yii::$app->mycomponent->getCurrency();
					if(!isset($_SESSION['currency_code']) && !isset($_SESSION['currency_symbol']))
					{
						foreach($currencies as $currencydata)
						{
							if($currencydata->defaultcurrency=="1")
							{
								$_SESSION['currency_code'] = $currencydata->currencycode;
								$_SESSION['currency_symbol'] = $currencydata->currencysymbol;
							}
						}
					}
					echo '<select id="currency_select" class="col-xs-12 col-sm-6 airfcfx-footer-select form-control margin10 no-hor-padding" onchange="change_currency()">';
						foreach($currencies as $currency)
		                {
		                    if(isset($_SESSION['currency_code']) && $_SESSION['currency_code']!="")
		                    {
		                        if($_SESSION['currency_code']==$currency['currencycode'])
		                        {
		                            echo '<option selected value="'.$currency['id'].'">'.$currency['currencycode'].'</option>';
		                        }
		                        else
		                        echo '<option value="'.$currency['id'].'">'.$currency['currencycode'].'</option>';
		                    }
		                    else
		                    echo '<option value="'.$currency['id'].'">'.$currency['currencycode'].'</option>';
		                }
		                echo '</select>';
					?>
				</div>		
				
				<?php

				$iosStatus = $footercontent['ioslinkstatus'];
				$androidStatus = $footercontent['androidlinkstatus'];

				if($iosStatus == "yes" || $androidStatus == "yes") {
				
				?>
				<div class="airfcfx-footer-app-section col-xs-12 col-sm-12 hor-padding">
					<div class="airfcfx-app-section-txt"><?php echo Yii::t('app','Native Apps');?></div>
					<div class="airfcfx-footer-app-link">
					<?php if($iosStatus == "yes") {
						$iosicon = Yii::$app->urlManager->createAbsoluteUrl ('/images/ios-app-link.png');
				 	?>
						<a href="<?php echo $footercontent['ioslink']; ?>" target="_blank" class="airfcfx-app-link"><img src="<?php echo $iosicon;?>" width="32px" height="32px" alt="ios link"></a>
					<?php }

					if($androidStatus == "yes") { 
						$andriodicon = Yii::$app->urlManager->createAbsoluteUrl ('/images/android-app-link.png'); ?>
						<a href="<?php echo $footercontent['androidlink']; ?>" target="_blank" class="airfcfx-app-link"><img src="<?php echo $andriodicon;?>" width="32px" height="32px" alt="ios link"></a> 
					<?php } ?> 
					</div>
				</div>
				<?php } ?> 
			</div>
			<!-- col-sm-4 end -->
		
			<div class="airfcfx-footer-info col-xs-12 col-sm-7 col-md-8 hor-padding">
                <h4 class="text_black bold-font"><?php echo Yii::t('app','Informations');?></h4>
                
                <?php
                $i = 0;
                echo '<ul class="airfcfx-footer-ul footer_menu list-unstyled">';
                foreach($helppages as $helps)
                {
                    echo '<li><a href="'.$baseUrl.'/user/help/view/'.$helps->id.'">'.Yii::t('app',$helps->name).'</a></li>';
                    $i++;
                    if($i%5==0)
                    echo '</ul><ul class="airfcfx-footer-ul footer_menu list-unstyled">';
                }
                echo '</ul>';
                ?>
              
            </div>
		</div>
		<!-- container end -->

		<div class="airfcfx-home-cnt-width container margin_bottom20">
			<div class="airfcfx-footer-border border_bottom1 margin_top20 margin_bottom20"></div>
			<div class="text-center">
			<!--<div class="airfcfx-joinus-txt margin_bottom0 bold-font"><?php echo Yii::t('app','Join Us On');?></div>-->
			<?php 
				echo '<div class="footer-social-icons margin_bottom10"><a class="airfcfx-socialicon-padding" href="'.$footercontent['facebookLink'].'" target="_blank"><i class="fa fa-facebook social_icon"></i></a> 
				<a class="airfcfx-socialicon-padding" href="'.$footercontent['twitterLink'].'" target="_blank"><i class="fa fa-twitter social_icon"></i></a> 
				<a class="airfcfx-socialicon-padding" href="'.$footercontent['googleLink'].'" target="_blank"><i class="fa fa-google-plus social_icon"></i></a> 
				<a class="airfcfx-socialicon-padding" href="'.$footercontent['linkedinLink'].'" target="_blank"><i class="fa fa-linkedin social_icon"></i></a> 
				<a class="airfcfx-socialicon-padding" href="'.$footercontent['youtubeLink'].'" target="_blank"><i class="fa fa-youtube-play social_icon"></i></a> 
				<a class="airfcfx-socialicon-padding" href="'.$footercontent['pinterestLink'].'" target="_blank"><i class="fa fa-pinterest-p social_icon"></i></a> 
				<a class="airfcfx-socialicon-padding" href="'.$footercontent['instagramLink'].'" target="_blank"><i class="fa fa-instagram social_icon"></i></a></div>
				<div class="foter-copyright"><p class="airfcfx-copyright">Copyright &copy; '.$sitesetting->sitename.'
					'.date('Y').'</p></div>';
				
					?>
			</div>
		</div>
		<!-- container end -->

	</div>
	<!-- footer end -->

	<?php $this->endBody() ?>
<?php 
if(isset($sitesetting) && !empty($sitesetting) && isset($sitesetting->googleanalyticsactive) && $sitesetting->googleanalyticsactive=="yes") {
print_r($sitesetting->googleanalyticscode);
}
 ?>	
 </div>

 <style type="text/css">
	ul.home-menu {
		padding: 0px 20px !important;
	}
	ul.home-menu li a.home-menu-text,ul.home-menu li a.home-menu-text:focus {
		padding: 0px;
		background: transparent;
		color: #484848 !important;
		font-size: 15px !important; 
		font-family: Circular, -apple-system, BlinkMacSystemFont, Roboto, Helvetica Neue, sans-serif;
		font-weight: 600;
		/*letter-spacing: 0.5px !important;*/
		opacity: 0.9;
	}
	ul.home-menu li a.home-menu-text:hover {
		background: transparent !important;
		color: #484848 !important; 
	}
	ul.home-menu li.note-msg a:hover {
		background: transparent !important;
		color:#FE5771 !important; 
	}
	.note_count {
		font-size: 14px !important;
	}
	.note_view {
		font-size: 14px !important;
	 	font-weight: 500 !important;
	 	float: right;
	} 
	.notify-round {
		fill: rgb(0, 132, 137) !important;
		height: 6px !important; 
		position: absolute !important;
		top: 50% !important;
		transform: translate3d(4px, -8px, 0px) !important;
		width: 6px !important;
		animation-name: keyframe_p1skye !important;
		animation-duration: 0.5s !important;
		animation-timing-function: ease !important;
		animation-fill-mode: both !important;
		opacity: 1 !important;
		right: 10px !important;
	}
</style>

</body>
</html>
<?php $this->endPage() ?>
<script type="text/javascript" src="<?php echo $baseUrl.'/js/fileinput.js'; ?>"></script>
<script
	type="text/javascript" src="<?php echo $baseUrl;?>/js/owl.carousel.js"></script>
	
<script
	type="text/javascript" src="<?php echo $baseUrl;?>/js/jquery-ui.min.js"></script>
<script>
	google.maps.event.addDomListener(window, 'load', initialize);
	
	$(document).ready(function(){
$("#check-in-main").keydown(function(event){
if (event.which == 13) {
$("#check-in-main").readonlyDatepicker(true);
}
});
$("#check-out-main").keydown(function(event){
if (event.which == 13) {
$("#check-out-main").readonlyDatepicker(true);
}
});		
	$("#check-in-main").datepicker({
		minDate:new Date(),
        onSelect: function (selected) {
            var dt = new Date(selected);
            dt.setDate(dt.getDate() + 1);
            $("#check-out-main").datepicker("option", "minDate", dt);
        },
		onClose: function (selectedDate) {
		$("#check-out-main").datepicker('show');
		}		
    });
edate = new Date();
edate.setDate(edate.getDate()+1);	
    $("#check-out-main").datepicker({
		minDate:edate,
        onSelect: function (selected) {
            var dt = new Date(selected);
            dt.setDate(dt.getDate() - 1);
            $("#check-in-main").datepicker("option", "maxDate", dt);
        }
    });		
		
		var docHeight = $(window).height();
		   var footerHeight = $('.footer').height();
		   var footerTop = $('.footer').position().top + footerHeight;
	
		   if (footerTop < docHeight) {
		    $('.footer').css('margin-top', 10+ (docHeight - footerTop) + 'px');
		   }	
		
		$("body").css("overflow-x","hidden");
		$(".alert-success").addClass("flashcss");
	
		$("#closebutton").click(function(){
			$(".alert-success").removeClass("flashcss");
		});

		if($('body > div > div.alert').hasClass('alert-success')){
			setTimeout(function(){
            $(".alert-success").removeClass("flashcss");
      	},5000);
		} 
		

		/* loginSession = readCookie('PHPSESSID');
		function readCookie(name) {
		    var nameEQ = escape(name) + "=";
		    var ca = document.cookie.split(';');//console.log(document.cookie);
		    for (var i = 0; i < ca.length; i++) {
		        var c = ca[i];
		        while (c.charAt(0) === ' ') c = c.substring(1, c.length);
		        if (c.indexOf(nameEQ) === 0) return unescape(c.substring(nameEQ.length, c.length));
		    }
		    return null;
		}
		if (typeof timerId != 'undefined'){
			clearInterval(timerId);
		}
		var timerId = setInterval(function() {
			var currentSession = readCookie('PHPSESSID');
		    if(loginSession != currentSession) {
			    console.log('in reload '+loginSession+" "+currentSession);
			    window.location = '<?php echo Yii::$app->urlManager->createAbsoluteUrl('/'); ?>';
			    clearInterval(timerId);
		        //Or whatever else you want!
		    }
		    
		},1000);*/
	});

function initMapmain() {
	autocomplete = new google.maps.places.Autocomplete((document
			.getElementById('where-to-go')), { 
		types : [ 'geocode' ]
	});
}
google.maps.event.addDomListener(window, 'load', initMapmain);
</script>
