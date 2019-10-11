<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
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

				$this->registerCssFile($baseUrl.'/css/style.css');
				$this->registerCssFile($baseUrl.'/css/bootstrap.css');
				$this->registerCssFile($baseUrl.'/css/jquery-ui.min.css');
				$this->registerCssFile($baseUrl.'/css/style1.css');
	
		$this->registerCssFile($baseUrl.'/css/font-awesome.min.css');

	?>  
	<script>
		var baseurl="<?php print Yii::$app->request->baseUrl;?>";
	</script> 
	
	<style type="text/css">.alert-success{position:absolute;right:-50%;width:50%;transition:all 1s !important;overflow:hidden !important;z-index: 1001 !important;}.flashcss{right:0%;}</style>   

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
 	<nav class="navbar navbar-default menu_bg">
    
    <div class="airfcfx-home-cnt-width-header">
    
            <div class="padding-left-15 navbar-header">
                <button aria-controls="navbar" aria-expanded="false" data-target="#navbar" data-toggle="collapse" class="airfcfx-mobile-navbar navbar-toggle collapsed" type="button">
                    <span class="sr-only"><?php echo Yii::t('app','Toggle navigation');?></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a href="<?php echo $baseUrl; ?>" class="navbar-brand">
                <?php
                $sitesetting = Yii::$app->mycomponent->getLogo();
                ?>                
                    <img src="<?php echo $adminUrl;?>/images/<?php echo $sitesetting->sitelogowhite;?>" alt="<?php echo $sitesetting->sitename;?>" class="logoimg logomobile" />
                </a>
            </div>

            <div class="navbar-collapse collapse" id="navbar">
                <ul class="airfcfx-home-menu nav navbar-nav navbar-right">
				 <!--<li class="dropdown">
						<form action="<?php echo $baseUrl.'/language';?>" method="GET">
							<?= Html::dropDownList('language', Yii::$app->language, ['en' => 'English','fr' => 'French', 'zh' => 'Chinese']) ?>
							<?= Html::submitButton('Change') ?>
						</form>				
					</li>  -->
					<?php
					if(Yii::$app->user->isGuest)
					{
					?>
						<li>
							<a href="<?php echo $baseUrl.'/user/help/index';?>" class="airfcfx-menu-help-txt">		<?php echo Yii::t('app','Help');?>
							</a>
                  </li>
						<li><a href="#" data-toggle="modal" data-target="#signupModal" > <?php echo Yii::t('app','Sign up'); ?></a>
						</li>
						<li><a href="#" id="modellogin" data-toggle="modal" data-target="#loginModal"><?php echo Yii::t('app','Login');?></a>
						</li>
               <?php
					}
					else {
                    ?>
                    
                    <li><a href="<?php echo $baseUrl.'/user/listing/listcreate';?>" class="airfcfx-list-space-btn"> <?php echo Yii::t('app','Add listing');?></a>
                    </li>

                    <li><a href="<?php echo $baseUrl.'/user/listing/mywishlists';?>" class="airfcfx-list-space-btn"> <?php echo Yii::t('app','Saved');?></a>
                    </li>

                    <li><a href="<?php echo $baseUrl.'/user/listing/trips';?>" class="airfcfx-list-space-btn"> <?php echo Yii::t('app','Trips');?></a> 
                    </li>

                    <li class="dropdowns respNotis">
                    		<a href="<?php echo $baseUrl.'/user/listing/usernotifications';?>" aria-expanded="false"
									aria-haspopup="true" role="button" data-toggle="dropdown"
									class="airfcfx-menu-link dropdown-toggle pos_rel">
										<?php echo Yii::t('app','Notification');?> 
										<?php if($countLogs > 0) { ?>
											<svg class="notify-round" focusable="false" aria-label="" role="img">
												<circle cx="3" cy="3" r="3"></circle>
											</svg>
										<?php } ?>  
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

					
							<li class="respNoti">
								<a href="<?php echo $baseUrl.'/user/listing/usernotifications';?>" class="airfcfx-menu-help-txt">		<?php echo Yii::t('app','Notifications');?>
								</a>
		               </li>



                    <li>
								<a href="<?php echo $baseUrl.'/user/help/index';?>" class="airfcfx-menu-help-txt">		<?php echo Yii::t('app','Help');?>
								</a>
		               </li>

                     <li>
								<a href="<?php echo $baseUrl;?>/dashboard"aria-expanded="false"
									aria-haspopup="true" role="button" data-toggle="dropdown"
									class="dropdown-toggle pos_rel margin_right padd_right_60"> 
										<?php //echo \Yii::$app->user->identity->firstname;?>
									<?php
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
						$resized_profile_image = Yii::$app->urlManager->createAbsoluteUrl ('resized.php?src='.$profile_image.'&w=35&h=35');
						echo '<span class="profile_pict" style="background-image:url('.$resized_profile_image.');"></span>';
					}
					else
					{
						$profile_image = "usrimg.jpg";
						$profile_image = Yii::$app->urlManager->createAbsoluteUrl ( '/albums/images/users/'.$profile_image);
						$resized_profile_image = Yii::$app->urlManager->createAbsoluteUrl ('resized.php?src='.$profile_image.'&w=35&h=35');			 			
						echo '<span class="profile_pict" style="background-image:url('.$resized_profile_image.');"></span>';
					}
									?>
								</a>						
								<ul class="airfcfx-arrow-dropdown dropdown-menu padding20 profil_menu">
									<!-- div class="airfcfx-dd-arrow">
										<svg class="top-arw-drop"><path d="M0,10 20,10 10,0z" class="arw-bg"></path><path d="M0,10 10,0 20,10" class="arw-border"></path></svg>
									</div -->
									<!--a href="<?php //echo $baseUrl;?>/dashboard"
										class="rm_text_deco"><li class=" margin_bottom10"><?php //echo Yii::t('app','My Profile');?></li>
									</a>
									<div class="border_bottom"></div>
									<a href="<?php //echo $baseUrl;?>/user/listing/trips"
										class="rm_text_deco"><li class="margin_top10 margin_bottom10"><?php// echo Yii::t('app','Your Trips');?></li>
									</a>
									<div class="border_bottom"></div>

									<a href="<?php //echo $baseUrl;?>/user/listing/mywishlists" class="rm_text_deco"><li
										class="margin_top10 margin_bottom10"><?php //echo Yii::t('app','Wish List');?></li> </a>
									<div class="border_bottom"></div -->
									<a href="<?php echo $baseUrl;?>/dashboard" class="rm_text_deco"><li
										class="margin_top10 margin_bottom10"><?php echo Yii::t('app','Dashboard');?></li> </a> 
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
    
        </div><!--container end-->
            
    </nav>

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
			<div class="res-pading0 airfcfx-footer-info col-xs-12 col-sm-3 col-md-4 margin_bottom20">
			
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
			
			<div class="airfcfx-footer-info col-xs-12 col-sm-3 col-md-3 hor-padding">
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


<?php		
		$this->registerJsFile($baseUrl.'/js/jquery.js', array('position' => $this::POS_HEAD), 'jquery');
		$this->registerJsFile($baseUrl.'/js/bootstrap.js', array('position' => $this::POS_HEAD), 'bootstrap');
		$this->registerJsFile($baseUrl.'/js/front.js', array( 'position' => $this::POS_HEAD), 'scripts');
?>


<?php $this->endPage() ?>
<script type="text/javascript" src="<?php echo $baseUrl;?>/js/jquery-ui.min.js"></script>
<script>
	$(document).ready(function(){ 
		
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

 	});
</script>
<style type="text/css">
	ul.home-menu{padding:0 20px!important}ul.home-menu li a.home-menu-text,ul.home-menu li a.home-menu-text:focus{padding:0;background:0 0;color:#484848!important;font-size:15px!important;font-family:Circular,-apple-system,BlinkMacSystemFont,Roboto,Helvetica Neue,sans-serif;font-weight:600;opacity:.9}ul.home-menu li a.home-menu-text:hover{background:0 0!important;color:#484848!important}ul.home-menu li.note-msg a:hover{background:0 0!important;color:#fe5771!important}.note_count{font-size:14px!important}.note_view{font-size:14px!important;font-weight:500!important;float:right}.notify-round{fill:#008489!important;height:6px!important;position:absolute!important;top:50%!important;transform:translate3d(4px,-8px,0)!important;width:6px!important;animation-name:keyframe_p1skye!important;animation-duration:.5s!important;animation-timing-function:ease!important;animation-fill-mode:both!important;opacity:1!important;right:10px!important} 
</style>
</body>
</html>

