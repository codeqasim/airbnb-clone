<?php

/*
 * Home page contents with the search option
 *
 * @author: AK
 * @package: Views
 * @PHPVersion: 5.6.40 
 */
/* @var $this yii\web\View */
use backend\components\Myclass;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\CurrencyConverter\CurrencyConverter;
use frontend\models\Reviews; 


$this->title = $sitesettings->sitename;
$hour_booking= $sitesettings->hour_booking;
$baseUrl = Yii::$app->request->baseUrl;
$socialSettings = $sitesettings->socialid;
$socialSettingsDetails = json_decode($socialSettings, true);

$googleId = isset($socialSettingsDetails['google']['appid'])?$socialSettingsDetails['google']['appid']:'';
?>

<?php
$bannerimageurl = Yii::$app->urlManager->createAbsoluteUrl ('/albums/images/homepage/'. $homesettings->banner);
?>

  <script src="https://apis.google.com/js/api:client.js"></script>
  <script>
    var googleUser = {};
    var startApp = function() {
      gapi.load('auth2', function(){
        // Retrieve the singleton for the GoogleAuth library and set up the client.
        auth2 = gapi.auth2.init({
          client_id: '<?php echo trim($googleId); ?>',   
          cookiepolicy: 'single_host_origin', 
        });
        attachSignin(document.getElementById('customBtn'));
      });
    };

    function attachSignin(element) {
      console.log(element.id);
      auth2.attachClickHandler(element, {},
          function(googleUser) {
                var profile = googleUser.getBasicProfile();

                var id = profile.getId();
                var full_name=[];
                full_name.push({
                  givenName:profile.getName()
                })
                var last_name = profile.getFamilyName();
                var first_name = profile.getGivenName();
                var image = [];
                image.push({
                  url:profile.getImageUrl()
                })
                var email = profile.getEmail();

                var attributes = [];
                attributes.push({
                  id:id,
                  name:full_name[0],
                  last_name:last_name,
                  image:image[0],
                  email:email,
                  first_name:first_name,
                  type:'google'
                });

                window.location = baseurl+'/social/'+btoa(JSON.stringify(attributes[0]));

          }, function(error) {
              var error = error.error;
              if(error != "popup_closed_by_user"){
                  window.location = baseurl+'/social/error';  
              }  
          });
    }
  </script>

  <script>
    var googleUser = {};
    var startAppLogin = function() {
      gapi.load('auth2', function(){
        // Retrieve the singleton for the GoogleAuth library and set up the client.
        auth2 = gapi.auth2.init({
          client_id: '<?php echo trim($googleId); ?>',   
          cookiepolicy: 'single_host_origin', 
        });
        attachSignin(document.getElementById('customBtnLogin'));
      });
    }; 
  </script>

  <style type="text/css">
    #customBtn,#customBtnLogin{display:inline-block;background:#fff;color:#444;width:100%;border-radius:3px;border:thin solid #888;white-space:nowrap;padding:3px}#customBtn:hover,#customBtnLogin:hover{cursor:pointer}span.label{font-family:serif;font-weight:400}span.icon{background:url(https://google-developers.appspot.com/identity/sign-in/g-normal.png) transparent 5px 50% no-repeat;display:inline-block;vertical-align:middle;width:42px;height:42px}span.buttonText{display:inline-block;vertical-align:middle;padding-left:0;padding-right:0;font-size:18px;font-weight:700;} 
  </style>


<!--Calendar script searchbar -->
<script type="text/javascript" src="<?php echo ($baseUrl.'/js/moment.js');?>"></script>
<script type="text/javascript" src="<?php echo ($baseUrl.'/js/daterangepicker.js');?>"></script>



    <div class="banner-upd" style="/*background-image:url(<?php echo $bannerimageurl; ?>); */">

        <div class="airfcfx-home-cnt-width container">
<?php
if(isset($_SESSION['welcomepop']) && $_SESSION['welcomepop']=="1")
{


echo '<div class="modal fade in" style="display:block;top:100px;" id="welcomepopup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog login_width" role="document">
    <div class="modal-content">
      <div class="modal-header no_border">
        <button type="button" onclick="close_model_popup()" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>        
      </div>
      <div class="modal-body text-center">
      <h3>Welcome</h3>
Hosts and guests on site are real people with real homes. That’s why you’ll have to confirm a few, quick details to activate your account.';
echo '<a href="'.$baseUrl.'/dashboard"><button name="login-button" class="btn btn_email margin_top10 width100" type="button">Get Started</button></a>';
            echo '</div>
           
    </div>
  </div>
</div>';
}
$_SESSION['welcomepop'] = '0';
?>
            <div class="pos_rel banner_text text_white"> 
                <!--<h1 class="site-name"><span>Airfinch</span></h1>-->        
                <h1 style="/*color:<?= $homesettings->bannertextcolor; ?> !important; */"><?php echo Yii::t('app',$homesettings->bannertitle);?></h1>
                <h4 style="/* color:<?= $homesettings->bannertextcolor; ?> !important; */"><?php echo Yii::t('app',$homesettings->bannerdesc);?> </h4>

                <!-- Validation Message for Search bars.-->
                  
                <!-- End Vaildation Message -->

                <div class="home-search-option airfcfx-home-website-search banner_form margin_bottom30 margin_top40">  

                    <div class="form-searchwhole clearfix">      	
                      <div class="banner_form_left">    
                          <div class="error-search" style="color:red !important; margin-left: 45px;"></div>
                          <div class="search-svg-icon">
                              <svg viewBox="0 0 24 24" role="presentation" aria-hidden="true" focusable="false" style="height: 24px; width: 24px; display: block; fill: rgb(118, 118, 118);"><path d="m10.4 18.2c-4.2-.6-7.2-4.5-6.6-8.8.6-4.2 4.5-7.2 8.8-6.6 4.2.6 7.2 4.5 6.6 8.8-.6 4.2-4.6 7.2-8.8 6.6m12.6 3.8-5-5c1.4-1.4 2.3-3.1 2.6-5.2.7-5.1-2.8-9.7-7.8-10.5-5-.7-9.7 2.8-10.5 7.9-.7 5.1 2.8 9.7 7.8 10.5 2.5.4 4.9-.3 6.7-1.7v.1l5 5c .3.3.8.3 1.1 0s .4-.8.1-1.1" fill-rule="evenodd"></path></svg>
                          </div>

                          	<input id="where-to-go-main" type="text" value="" onclick="myFunction()" placeholder="<?php echo Yii::t('app','Where do you want to go').'?';?>" class="form-control form_text1 where-to-go" /> 
                              <input type="hidden" id="latitude" value="">
                              <input type="hidden" id="longitude" value="">
                      </div>
                      <div class="banner_form_right">
                        <button class="airfcfx-btn_search btn btn_search width100" type="button" onclick="searchlistmain();">
                          <!--<div class="airfcfx-search-icon"></div>--><div class="airfcfx-mobile-search-txt"><?php echo Yii::t('app',' Search');?></div>
                        </button>
                        
                      </div>
                    </div>

                    <div id="checking-inputs" class="checking-inputs clearfix" style="display: none;">
                            <div class="form-text2 clshome">
                              <input type="button" id="daterangepick" name="daterange" class="form-control" value="<?=Yii::t('app','Dates')?>" />
                            </div>
                            
                             <?php
                                foreach($roomtypes as $roomtype)
                                {
                            ?>
                                <div class="form-text2 form-control clshome"><a href="javascript:void(0);" onclick="searchlistroomtype(<?= $roomtype->id; ?>);"><?=Yii::t('app',$roomtype->roomtype); ?></a></div>
                            <?php } ?>
                            <input type="hidden" id="daterangepick_value" value="" />
                                                                       
                    </div>
                    
                    
            	</div> <!--banner_form end-->
				
				<div class="airfcfx-home-mobile-cal col-xs-12 no-hor-padding">
					<a href="" class="airfcfx-input-model" data-toggle="modal" data-target="#airfcfx-mobile-cal">Where to ?</a>
					<a href="" class="airfcfx-mobile-cal-search" data-toggle="modal" data-target="#airfcfx-mobile-cal"><div class="airfcfx-search-icon"></div></a>
				</div>
				
				<!--mobile calendar popup-->
				
			<div class="modal fade" id="airfcfx-mobile-cal" role="dialog"> 
				<div class="modal-dialog mobile-cal-cnt">
					<div class="mobile-cal-header d-flex">
            <button class="close airfcfx-mobile-cal-close align-self-center" type="button" data-dismiss="modal">×</button>
            <div class="align-self-center font-size20 bold">
						<?php echo Yii::t('app','Search');?></div>
					</div>
					<div class="mobile-cal-body">
						<input id="where-to-go-mobile" type="text" value="" placeholder="<?php echo Yii::t('app','Where do u want to go?');?>" class="mobile-cal-input-100 form-control form_text1 where-to-go" /> 
						<input type="hidden" id="latitudemobile" value="">
						<input type="hidden" id="longitudemobile" value="">


                        <input type="text" name="daterange" id="daterange" class="respance-range mobile-cal-input-50 airfcfx-right-border form_text2 form-control" placeholder="Select Date"/>
                            <?php
                                foreach($roomtypes as $roomtype)
                                {
                            ?>
                                <div class="form-text2 form-control clshome"><a href="#" onclick="searchlistroomtype(<?= $roomtype->id; ?>);"><?= $roomtype->roomtype; ?></a></div> 
                            <?php } ?>
                            
						<div class="error-searchmobile" style="float:right;"></div>
						<button class="airfcfx-mobile-cal-btn airfcfx-slider-btn btn btn_search" onclick="searchlistmobile();"><?php echo Yii::t('app','Search');?></button> 
            
					</div>
				</div>
			</div>
				
                
            </div>  <!--banner_text end-->

        </div>
        <!--container end-->

    </div>
    <!--banner end-->
    


    
	 <?php
	 if(!empty($recentview))
	 {
    echo '
    <div class="airfcfx-home-cnt-width container pos_rel">
<div class="margin_top50 margin_bottom30  margin_left10 margin_right10">
            <h1 class="airfcfx-txt-home">'.Yii::t('app','Recently Viewed').'</h1>
			<h4>'.Yii::t('app','Find the most recent listings you discovered').'</h4>
    	</div>	
        <div id="owl-demos" class="owl-carousel owl-theme">
            <div class="owl-wrapper-outer">
                <div class="owl-wrapper" style="left: 0px; display: block; transition: all 1000ms ease 0s; transform: translate3d(0px, 0px, 0px);">';	

               $r_list = 0; 
    

		foreach(array_filter($recentview) as $recentlist)
		{
            

			//foreach($recent as $recentlist)
			//{
                    $listcurrency = $recentlist->getCurrency0()->where(['id'=>$recentlist->currency])->one();
                    if(isset($listcurrency->currencysymbol) && $listcurrency->currencysymbol!="")
                    $currencysymbol = $listcurrency->currencysymbol;
                    else
                    $currencysymbol = "";
					
					//$converter = new CurrencyConverter();
					if(isset($_SESSION['currency_code']) && $_SESSION['currency_code']!="")
					{
						$currency_code = $_SESSION['currency_code'];
						$currency_symbol = $_SESSION['currency_symbol'];
						if(!empty($listcurrency)){
						      //$rate =  $converter->convert($listcurrency->currencycode, $currency_code);
                  $rate2= Myclass::getcurrencyprice($listcurrency->currencycode);//listing currency
                  $rate= Myclass::getcurrencyprice($currency_code);//user currency
						}
                        else
                        {
                            $rate2= 1;//listing currency
                            $rate= 1;//user currency
                        }
						

					}
					else
					{
						if(!empty($listcurrency))
						$currency_symbol = $listcurrency->currencysymbol;
						else
						$currency_symbol = "";

                      if(!empty($currency))
                            {
                                $rate= Myclass::getcurrencyprice($currency_symbol);//user currency
                                $rate2= Myclass::getcurrencyprice($currency_symbol);//listing currency
                            }
                            else
                            {
                               $rate = "1";//listing currency
                               $rate2 = "1";//user currency
                            }
						
					}					
					
                    $roomtype = $recentlist->getRoomtype0()->where(['id'=>$recentlist->roomtype])->one(); 


                    $photos = $recentlist->getPhotos()->where(['listid'=>$recentlist->id])->all();
                    if(isset($photos[0]->image_name) && $photos[0]['image_name']!="")
                    $listphoto = Yii::$app->urlManager->createAbsoluteUrl ( '/albums/images/listings/'.$photos[0]->image_name);
                    else
                    $listphoto = Yii::$app->urlManager->createAbsoluteUrl ( '/albums/images/users/usrimg.jpg');
                    $listimageurl = Yii::$app->urlManager->createAbsoluteUrl ('resized.php?src='.$listphoto.'&w=465&h=330'); 
                    $listuserdata = $recentlist->getUser()->where(['id'=>$recentlist->userid])->one();
                    if(isset($listuserdata->profile_image) && $listuserdata->profile_image!="")
                    $userphoto = Yii::$app->urlManager->createAbsoluteUrl ( '/albums/images/users/'.$listuserdata->profile_image);
                    else
                    $userphoto = Yii::$app->urlManager->createAbsoluteUrl ( '/albums/images/users/usrimg.jpg');
                    $listuserimageurl = Yii::$app->urlManager->createAbsoluteUrl ('resized.php?src='.$userphoto.'&w=56&h=56');
                    $listingurl = base64_encode($recentlist->id.'_'.rand(1,9999));
                    $listingurl = Yii::$app->urlManager->createAbsoluteUrl ( '/user/listing/view/' . $listingurl );				
                    echo '<div class="airfcfx-homerecent-pad-10 col-xs-12 col-sm-3"><a class="rm_text_deco" href="'.$listingurl.'">
                        <div class="item">
                            <div class="bg_img borderradius5" style="background-image:url('.$listphoto.');">';?>
                                <?php if(isset($loguserid) && $loguserid!="")
                                {
                                echo '<div class="favorite" onclick="show_list_popup(event,'.$recentlist->id.');" data-target="#myModal2" data-toggle="modal">
                                <i class="fa fa-heart-o"></i><i class="fa fa-heart fav_bg"></i>
                                </div>';
                                }
                            echo '</div>
                            <p class="siml-text1 margin_left5 small text_gray1 margin_right60"><b>  '.$roomtype->roomtype.' . <span>'; 
                            echo ($recentlist->beds > 1) ? $recentlist->beds.' Beds' : $recentlist->beds.' Bed';
                            echo '</span></b></p>
                            <p class="siml-text2 margin_left5 fa-1x">'.$recentlist->listingname.' </p>';?>

                            <div class="margin_left5 similar-prices">
                             <?php if($recentlist->booking=='perhour') 
                                {?>
                                <div class="hrs-price"><span>  <?php echo $currency_symbol."".round(($rate * ($recentlist->hourlyprice/$rate2)),2)." ".Yii::t('app','per hour'); ?></span></div>
                                <?php
                                }
                                else{?>
                                <div class="full-price"><span>  <?php echo $currency_symbol." ".round(($rate * ($recentlist->nightlyprice/$rate2)),2)." ".Yii::t('app','per night'); ?></span></div>
                                <?php }?>
                            </div>
                                <div class="margin_left5 similar-ratings">
                                  <div class="country-details">
                                    <?php
                            $ratings = Reviews::getRatingbylisting($recentlist->id);
                            echo '<p class="place-star-rating">';
                            
                              for($x=1; $x<=$ratings['rating']; $x++) {
                                echo '<span class="full-star-span">
                                    <svg viewBox="0 0 1000 1000" role="presentation" aria-hidden="true" focusable="false" style="height: 1em; width: 1em; display: block; fill: currentcolor;"><path d="M971.5 379.5c9 28 2 50-20 67L725.4 618.6l87 280.1c11 39-18 75-54 75-12 0-23-4-33-12l-226.1-172-226.1 172.1c-25 17-59 12-78-12-12-16-15-33-8-51l86-278.1L46.1 446.5c-21-17-28-39-19-67 8-24 29-40 52-40h280.1l87-278.1c7-23 28-39 52-39 25 0 47 17 54 41l87 276.1h280.1c23.2 0 44.2 16 52.2 40z"></path></svg>
                                </span>';
                            }
                            if (strpos($ratings['rating'],'.')) {
                                echo '<span class="half-star-span">
                                    <span class="no-cover-star">
                                      <svg viewBox="0 0 1000 1000" role="presentation" aria-hidden="true" focusable="false" style="height: 1em; width: 1em; display: block; fill: currentcolor;"><path d="M971.5 379.5c9 28 2 50-20 67L725.4 618.6l87 280.1c11 39-18 75-54 75-12 0-23-4-33-12l-226.1-172-226.1 172.1c-25 17-59 12-78-12-12-16-15-33-8-51l86-278.1L46.1 446.5c-21-17-28-39-19-67 8-24 29-40 52-40h280.1l87-278.1c7-23 28-39 52-39 25 0 47 17 54 41l87 276.1h280.1c23.2 0 44.2 16 52.2 40z"></path></svg>
                                    </span>
                                    <span class="off-cover-star">
                                      <svg viewBox="0 0 1000 1000" role="presentation" aria-hidden="true" focusable="false" style="height: 1em; width: 1em; display: block; fill: currentcolor;"><path d="M510.2 23.3l1 767.3-226.1 172.2c-25 17-59 12-78-12-12-16-15-33-8-51l86-278.1L58 447.5c-21-17-28-39-19-67 8-24 29-40 52-40h280.1l87-278.1c7.1-23.1 28.1-39.1 52.1-39.1z"></path></svg>
                                    </span>
                                </span>';
                                $x++;
                            }
                            while ($x<=5) {
                                echo '<span class="half-star-span">
                                    <span class="no-cover-star">
                                      <svg viewBox="0 0 1000 1000" role="presentation" aria-hidden="true" focusable="false" style="height: 1em; width: 1em; display: block; fill: currentcolor;"><path d="M971.5 379.5c9 28 2 50-20 67L725.4 618.6l87 280.1c11 39-18 75-54 75-12 0-23-4-33-12l-226.1-172-226.1 172.1c-25 17-59 12-78-12-12-16-15-33-8-51l86-278.1L46.1 446.5c-21-17-28-39-19-67 8-24 29-40 52-40h280.1l87-278.1c7-23 28-39 52-39 25 0 47 17 54 41l87 276.1h280.1c23.2 0 44.2 16 52.2 40z"></path></svg>
                                    </span>
                                </span>';
                                $x++;
                            }
                            echo '<span class="place-reviews"> '.$ratings['n_rating'].' </span>';    
                    ?>
                                  </div>
                              </div>
                       <?php echo '</div></a>
                    </div>';				
			//}
                    $r_list++;
		}
                echo '</div>
            </div>
        </div>
    </div><!--pos_rel end-->';		
	 }
	 ?>
      <?php
      if(count($traverselistings) > 0)
      {
        echo '<div class="airfcfx-home-cnt-width container">
              <div class="margin_top50 margin_bottom15 margin_left10 margin_right10">
                <h1 class="airfcfx-txt-home">'.Yii::t('app','Traverse the world').'</h1>
                <h4>'.Yii::t('app','See the best destinations people are travelling around the world.').'</h4>
              </div>
              <div class="airfcfx-country-cnt col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">';
                $t=0;
                foreach($traverselistings as $traverlist)
                {
                  if($t>7)
                    continue; 

                  if(isset($traverlist['currencysymbol']) && $traverlist['currencysymbol']!="")
                    $currencysymbol = $traverlist['currencysymbol'];
                  else
                    $currencysymbol = "";
                    
                  //$converter = new CurrencyConverter();

                  if(isset($_SESSION['currency_code']) && $_SESSION['currency_code']!="")
                  {
                    $currency_code = $_SESSION['currency_code'];
                    $currency_symbol = $_SESSION['currency_symbol'];

                    if(!empty($traverlist['currency'])) {
                        $rate2= Myclass::getcurrencyidprice($traverlist['currency']);//listing currency 
                        $rate= Myclass::getcurrencyprice($currency_code);//user currency
                    } else { 
                        $rate2= 1;//listing currency
                        $rate= 1;//user currency
                    }
                  } else {
                    if(!empty($traverlist['currencysymbol']))
                        $currency_symbol = $traverlist['currencysymbol'];
                    else
                        $currency_symbol = "";
                     
                    if(!empty($currency_symbol)) {
                      $rate= Myclass::getcurrencyprice($currency_symbol);//user currency
                      $rate2= Myclass::getcurrencyprice($currency_symbol);//listing currency
                    } else {
                      $rate = "1";//listing currency
                      $rate2 = "1";//user currency
                    }
                  }

                  if(isset($traverlist['image_name']) && $traverlist['image_name']!="")
                    $listimg = Yii::$app->urlManager->createAbsoluteUrl ( '/albums/images/listings/'.$traverlist['image_name']);
                  else
                    $listimg = Yii::$app->urlManager->createAbsoluteUrl ( '/albums/images/users/usrimg.jpg');

                    $listimageurl = Yii::$app->urlManager->createAbsoluteUrl ('resized.php?src='.$listimg.'&w=465&h=330'); 

          
                  $listingurl = base64_encode($traverlist['listid'].'_'.rand(1,9999));
                  $listingurl = Yii::$app->urlManager->createAbsoluteUrl ( '/user/listing/view/' . $listingurl ); 
                  echo '<div class="airfcfx-country place-image">
                          <a href="'.$listingurl.'" class="airfcfx-country-img-show col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
                            <div class="images-display-padding"> 
                               <div class="airfcfx-country-img" style="background-image:url('.$listimg.') !important;"></div>
                            </div>
                            <div class="country-details similar-prices">
                              <p class="place margin_left5">'.$traverlist['roomtypename'].' . ';
                                echo ($traverlist['beds'] > 1) ? $traverlist['beds'].' Beds' : $traverlist['beds'].' Bed';
                              echo '</p>
                              <p class="siml-text2 margin_left5 fa-1x">'.$traverlist['listingname'].'</p>';

                              if( $traverlist['booking']=='perhour' )
                              {
                                  echo '<p class="full-price margin_left5">'.$currency_symbol."".round(($rate * ($traverlist['hourlyprice']/$rate2)),2)." ".Yii::t('app','per hour').'</p>'; 
                              }
                              else{
                                 echo '<p class="full-price margin_left5">'.$currency_symbol."".round(($rate * ($traverlist['nightlyprice']/$rate2)),2)." ".Yii::t('app','per night').'</p>'; 
                              }
                    
                              echo '<p class="place-star-rating margin_left5 coldiv">';

                                for($x=1; $x<=$traverlist['ratings']; $x++) {
                                  echo '<span class="full-star-span">
                                      <svg viewBox="0 0 1000 1000" role="presentation" aria-hidden="true" focusable="false" style="height: 1em; width: 1em; display: block; fill: currentcolor;"><path d="M971.5 379.5c9 28 2 50-20 67L725.4 618.6l87 280.1c11 39-18 75-54 75-12 0-23-4-33-12l-226.1-172-226.1 172.1c-25 17-59 12-78-12-12-16-15-33-8-51l86-278.1L46.1 446.5c-21-17-28-39-19-67 8-24 29-40 52-40h280.1l87-278.1c7-23 28-39 52-39 25 0 47 17 54 41l87 276.1h280.1c23.2 0 44.2 16 52.2 40z"></path></svg>
                                  </span>';
                                }
                                if (strpos($traverlist['ratings'],'.')) {
                                    echo '<span class="half-star-span">
                                        <span class="no-cover-star">
                                          <svg viewBox="0 0 1000 1000" role="presentation" aria-hidden="true" focusable="false" style="height: 1em; width: 1em; display: block; fill: currentcolor;"><path d="M971.5 379.5c9 28 2 50-20 67L725.4 618.6l87 280.1c11 39-18 75-54 75-12 0-23-4-33-12l-226.1-172-226.1 172.1c-25 17-59 12-78-12-12-16-15-33-8-51l86-278.1L46.1 446.5c-21-17-28-39-19-67 8-24 29-40 52-40h280.1l87-278.1c7-23 28-39 52-39 25 0 47 17 54 41l87 276.1h280.1c23.2 0 44.2 16 52.2 40z"></path></svg>
                                        </span>
                                        <span class="off-cover-star">
                                          <svg viewBox="0 0 1000 1000" role="presentation" aria-hidden="true" focusable="false" style="height: 1em; width: 1em; display: block; fill: currentcolor;"><path d="M510.2 23.3l1 767.3-226.1 172.2c-25 17-59 12-78-12-12-16-15-33-8-51l86-278.1L58 447.5c-21-17-28-39-19-67 8-24 29-40 52-40h280.1l87-278.1c7.1-23.1 28.1-39.1 52.1-39.1z"></path></svg>
                                        </span>
                                    </span>';
                                    $x++;
                                }
                                while ($x<=5) {
                                    echo '<span class="half-star-span">
                                        <span class="no-cover-star">
                                          <svg viewBox="0 0 1000 1000" role="presentation" aria-hidden="true" focusable="false" style="height: 1em; width: 1em; display: block; fill: currentcolor;"><path d="M971.5 379.5c9 28 2 50-20 67L725.4 618.6l87 280.1c11 39-18 75-54 75-12 0-23-4-33-12l-226.1-172-226.1 172.1c-25 17-59 12-78-12-12-16-15-33-8-51l86-278.1L46.1 446.5c-21-17-28-39-19-67 8-24 29-40 52-40h280.1l87-278.1c7-23 28-39 52-39 25 0 47 17 54 41l87 276.1h280.1c23.2 0 44.2 16 52.2 40z"></path></svg>
                                        </span>
                                    </span>';
                                    $x++;
                                }
              
                                echo '<span class="place-reviews"> '.$traverlist['n_rating'].' </span>
                              </p>
                            </div>
                          </a>
                        </div>';
                  $t++;
                }
              echo '</div>';
              if(count($traverselistings)>5) {
                echo '<div class="show-all margin_left10 margin_right10">
                  <button type="button" onclick="javascript:searchtraverseworld();" class="show-more-btn">
                  <span class="load-more-image">'.Yii::t('app','Show all').'('.count($traverselistings).') </span> <div class="right-arrow"><svg viewBox="0 0 18 18" role="presentation" aria-hidden="true" focusable="false" style="height: 10px; width: 10px; fill: currentcolor;"><path d="m4.29 1.71a1 1 0 1 1 1.42-1.41l8 8a1 1 0 0 1 0 1.41l-8 8a1 1 0 1 1 -1.42-1.41l7.29-7.29z" fill-rule="evenodd"></path></svg></div></button>
                </div>';
              }
        echo '</div>';
      } ?>

      <?php
            //Featured
            if(count($featuredlist) > 0)
            {
            echo '<div class="airfcfx-home-cnt-width container">
    
        <div class="margin_top50 padding10">
            <h1 class="airfcfx-txt-home">'.Yii::t('app','Featured Homes').'</h1>'; 
           // <h4>'.Yii::t('app','See the best destinations people are travelling around the world.').' </h4>
        echo '</div><div class="airfcfx-country-cnt col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">';
    $feature_list = 0;           
    foreach($featuredlist as $recentlist)
     {
            if($feature_list > 7)
              break;
      //foreach($recent as $recentlist)
      //{
                    $listcurrency = $recentlist->getCurrency0()->where(['id'=>$recentlist->currency])->one();
                    if(isset($listcurrency->currencysymbol) && $listcurrency->currencysymbol!="")
                    $currencysymbol = $listcurrency->currencysymbol;
                    else
                    $currencysymbol = "";
          
          //$converter = new CurrencyConverter();
          if(isset($_SESSION['currency_code']) && $_SESSION['currency_code']!="")
          {
            $currency_code = $_SESSION['currency_code'];
            $currency_symbol = $_SESSION['currency_symbol'];
            if(!empty($listcurrency))
            {
                $rate2= Myclass::getcurrencyprice($listcurrency->currencycode);//listing currency
                $rate= Myclass::getcurrencyprice($currency_code);//user currency
            }
                        else
                        {
                            $rate2= 1;//listing currency
                            $rate= 1;//user currency
                        }
            

          }
          else
          {
            if(!empty($listcurrency))
            $currency_symbol = $listcurrency->currencysymbol;
            else
            $currency_symbol = "";

                      if(!empty($currency))
                            {
                                $rate= Myclass::getcurrencyprice($currency_symbol);//user currency
                                $rate2= Myclass::getcurrencyprice($currency_symbol);//listing currency
                            }
                            else
                            {
                               $rate = "1";//listing currency
                               $rate2 = "1";//user currency
                            }
            
          }         
          
                    $roomtype = $recentlist->getRoomtype0()->where(['id'=>$recentlist->roomtype])->one(); 


                    $photos = $recentlist->getPhotos()->where(['listid'=>$recentlist->id])->all();
                    if(isset($photos[0]->image_name) && $photos[0]['image_name']!="")
                    $listphoto = Yii::$app->urlManager->createAbsoluteUrl ( '/albums/images/listings/'.$photos[0]->image_name);
                    else
                    $listphoto = Yii::$app->urlManager->createAbsoluteUrl ( '/albums/images/users/usrimg.jpg');
                    $listimageurl = Yii::$app->urlManager->createAbsoluteUrl ('resized.php?src='.$listphoto.'&w=465&h=330');
                    $listuserdata = $recentlist->getUser()->where(['id'=>$recentlist->userid])->one();
                    if(isset($listuserdata->profile_image) && $listuserdata->profile_image!="")
                    $userphoto = Yii::$app->urlManager->createAbsoluteUrl ( '/albums/images/users/'.$listuserdata->profile_image);
                    else
                    $userphoto = Yii::$app->urlManager->createAbsoluteUrl ( '/albums/images/users/usrimg.jpg');
                    $listuserimageurl = Yii::$app->urlManager->createAbsoluteUrl ('resized.php?src='.$userphoto.'&w=56&h=56');
                    $listingurl = base64_encode($recentlist->id.'_'.rand(1,9999));
                    $listingurl = Yii::$app->urlManager->createAbsoluteUrl ( '/user/listing/view/' . $listingurl );

                    $listName  = ($recentlist->listingname != '') ? $recentlist->listingname : '(No Name)';
                    echo '<div class="airfcfx-homerecent-pad-10 col-xs-12 col-sm-3"><a class="rm_text_deco" href="'.$listingurl.'">
                        <div class="item">
                            <div class="bg_img borderradius5" style="background-image:url('.$listphoto.');">';?>
                                <?php if(isset($loguserid) && $loguserid!="")
                                {
                                echo '<div class="favorite" onclick="show_list_popup(event,'.$recentlist->id.');" data-target="#myModal2" data-toggle="modal">
                                <i class="fa fa-heart-o"></i><i class="fa fa-heart fav_bg"></i>
                                </div>';
                                }
                            echo '</div>
                            <p class="siml-text1 margin_left5 small text_gray1 margin_right60"><b>  '.$roomtype->roomtype.' . <span>'; 
                            echo ($recentlist->beds > 1) ? $recentlist->beds.' Beds' : $recentlist->beds.' Bed';
                            echo '</span></b></p>
                            <p class="siml-text2 margin_left5 fa-1x">'.$listName.' </p>'; ?>

                            <div class="margin_left5 similar-prices">
                             <?php if($recentlist->booking=='perhour') 
                                {?>
                                <div class="hrs-price"><span>  <?php echo $currency_symbol." ".round(($rate * ($recentlist->hourlyprice/$rate2)),2)." ".Yii::t('app','per hour'); ?></span></div>
                                <?php
                                }
                                else{?>
                                <div class="full-price"><span>  <?php echo $currency_symbol." ".round(($rate * ($recentlist->nightlyprice/$rate2)),2)." ".Yii::t('app','per night'); ?></span></div> 
                                <?php }?>
                            </div>
                                <div class="margin_left5 similar-ratings">
                                  <div class="country-details">
                                    <?php
                            $ratings = Reviews::getRatingbylisting($recentlist->id);
                            echo '<p class="place-star-rating">';
                            
                              for($x=1; $x<=$ratings['rating']; $x++) {
                                echo '<span class="full-star-span">
                                    <svg viewBox="0 0 1000 1000" role="presentation" aria-hidden="true" focusable="false" style="height: 1em; width: 1em; display: block; fill: currentcolor;"><path d="M971.5 379.5c9 28 2 50-20 67L725.4 618.6l87 280.1c11 39-18 75-54 75-12 0-23-4-33-12l-226.1-172-226.1 172.1c-25 17-59 12-78-12-12-16-15-33-8-51l86-278.1L46.1 446.5c-21-17-28-39-19-67 8-24 29-40 52-40h280.1l87-278.1c7-23 28-39 52-39 25 0 47 17 54 41l87 276.1h280.1c23.2 0 44.2 16 52.2 40z"></path></svg>
                                </span>';
                            }
                            if (strpos($ratings['rating'],'.')) {
                                echo '<span class="half-star-span">
                                    <span class="no-cover-star">
                                      <svg viewBox="0 0 1000 1000" role="presentation" aria-hidden="true" focusable="false" style="height: 1em; width: 1em; display: block; fill: currentcolor;"><path d="M971.5 379.5c9 28 2 50-20 67L725.4 618.6l87 280.1c11 39-18 75-54 75-12 0-23-4-33-12l-226.1-172-226.1 172.1c-25 17-59 12-78-12-12-16-15-33-8-51l86-278.1L46.1 446.5c-21-17-28-39-19-67 8-24 29-40 52-40h280.1l87-278.1c7-23 28-39 52-39 25 0 47 17 54 41l87 276.1h280.1c23.2 0 44.2 16 52.2 40z"></path></svg>
                                    </span>
                                    <span class="off-cover-star">
                                      <svg viewBox="0 0 1000 1000" role="presentation" aria-hidden="true" focusable="false" style="height: 1em; width: 1em; display: block; fill: currentcolor;"><path d="M510.2 23.3l1 767.3-226.1 172.2c-25 17-59 12-78-12-12-16-15-33-8-51l86-278.1L58 447.5c-21-17-28-39-19-67 8-24 29-40 52-40h280.1l87-278.1c7.1-23.1 28.1-39.1 52.1-39.1z"></path></svg>
                                    </span>
                                </span>';
                                $x++;
                            }
                            while ($x<=5) {
                                echo '<span class="half-star-span">
                                    <span class="no-cover-star">
                                      <svg viewBox="0 0 1000 1000" role="presentation" aria-hidden="true" focusable="false" style="height: 1em; width: 1em; display: block; fill: currentcolor;"><path d="M971.5 379.5c9 28 2 50-20 67L725.4 618.6l87 280.1c11 39-18 75-54 75-12 0-23-4-33-12l-226.1-172-226.1 172.1c-25 17-59 12-78-12-12-16-15-33-8-51l86-278.1L46.1 446.5c-21-17-28-39-19-67 8-24 29-40 52-40h280.1l87-278.1c7-23 28-39 52-39 25 0 47 17 54 41l87 276.1h280.1c23.2 0 44.2 16 52.2 40z"></path></svg>
                                    </span>
                                </span>';
                                $x++;
                            }
                            echo '<span class="place-reviews"> '.$ratings['n_rating'].' </span>';    
                    ?>
                                  </div>
                              </div>
                       <?php echo '</div></a>
                    </div>';        
      //}
                    $feature_list++;
    }
                echo '</div>';
                if(count($featuredlist) > 8)
                {
                    echo '<div class="show-all margin_left10 margin_right10"><button type="button" class="show-more-btn" onclick="javascript:searchfeatured();"><span class="load-more-image">'.Yii::t('app','Show all').'('.count($featuredlist).') </span> <div class="right-arrow"><svg viewBox="0 0 18 18" role="presentation" aria-hidden="true" focusable="false" style="height: 10px; width: 10px; fill: currentcolor;"><path d="m4.29 1.71a1 1 0 1 1 1.42-1.41l8 8a1 1 0 0 1 0 1.41l-8 8a1 1 0 1 1 -1.42-1.41l7.29-7.29z" fill-rule="evenodd"></path></svg></div></button></div>';
                }
                echo '</div>';
            
       // echo '</div> </div><!--pos_rel end-->';
    }
     ?>


     <?php
            //Homes around the world
            if(count($listings) > 0)  
            {
            echo '<div class="airfcfx-home-cnt-width container">
    
        <div class="margin_top50 padding10">
            <h1 class="airfcfx-txt-home">'.Yii::t('app','Homes around the world').'</h1>';
            //<h4>'.Yii::t('app','See the best homes around the world.').' </h4>
        echo '</div><div class="airfcfx-country-cnt col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">';
    $around_list = 0;           
    foreach($listings as $recentlist)
     {
            if($around_list > 3)
              break;
      //foreach($recent as $recentlist)
      //{
                    $listcurrency = $recentlist->getCurrency0()->where(['id'=>$recentlist->currency])->one();
                    if(isset($listcurrency->currencysymbol) && $listcurrency->currencysymbol!="")
                    $currencysymbol = $listcurrency->currencysymbol;
                    else
                    $currencysymbol = "";
          
          //$converter = new CurrencyConverter();
          if(isset($_SESSION['currency_code']) && $_SESSION['currency_code']!="")
          {
            $currency_code = $_SESSION['currency_code'];
            $currency_symbol = $_SESSION['currency_symbol'];
            if(!empty($listcurrency))
            {
                $rate2= Myclass::getcurrencyprice($listcurrency->currencycode);//listing currency
                $rate= Myclass::getcurrencyprice($currency_code);//user currency
            }
                        else
                        {
                            $rate2= 1;//listing currency
                            $rate= 1;//user currency
                        }
            

          }
          else
          {
            if(!empty($listcurrency))
            $currency_symbol = $listcurrency->currencysymbol;
            else
            $currency_symbol = "";

                      if(!empty($currency))
                            {
                                $rate= Myclass::getcurrencyprice($currency_symbol);//user currency
                                $rate2= Myclass::getcurrencyprice($currency_symbol);//listing currency
                            }
                            else
                            {
                               $rate = "1";//listing currency
                               $rate2 = "1";//user currency
                            }
            
          }         
          
                    $roomtype = $recentlist->getRoomtype0()->where(['id'=>$recentlist->roomtype])->one(); 


                    $photos = $recentlist->getPhotos()->where(['listid'=>$recentlist->id])->all();
                    if(isset($photos[0]->image_name) && $photos[0]['image_name']!="")
                    $listphoto = Yii::$app->urlManager->createAbsoluteUrl ( '/albums/images/listings/'.$photos[0]->image_name);
                    else
                    $listphoto = Yii::$app->urlManager->createAbsoluteUrl ( '/albums/images/users/usrimg.jpg');
                    $listimageurl = Yii::$app->urlManager->createAbsoluteUrl ('resized.php?src='.$listphoto.'&w=465&h=330');
                    $listuserdata = $recentlist->getUser()->where(['id'=>$recentlist->userid])->one();
                    if(isset($listuserdata->profile_image) && $listuserdata->profile_image!="")
                    $userphoto = Yii::$app->urlManager->createAbsoluteUrl ( '/albums/images/users/'.$listuserdata->profile_image);
                    else
                    $userphoto = Yii::$app->urlManager->createAbsoluteUrl ( '/albums/images/users/usrimg.jpg');
                    $listuserimageurl = Yii::$app->urlManager->createAbsoluteUrl ('resized.php?src='.$userphoto.'&w=56&h=56');
                    $listingurl = base64_encode($recentlist->id.'_'.rand(1,9999));
                    $listingurl = Yii::$app->urlManager->createAbsoluteUrl ( '/user/listing/view/' . $listingurl );

                    $listName  = ($recentlist->listingname != '') ? $recentlist->listingname : '(No Name)';
                    echo '<div class="airfcfx-homerecent-pad-10 col-xs-12 col-sm-3"><a class="rm_text_deco" href="'.$listingurl.'">
                        <div class="item">
                            <div class="bg_img borderradius5" style="background-image:url('.$listphoto.');">';?>
                                <?php if(isset($loguserid) && $loguserid!="")
                                {
                                echo '<div class="favorite" onclick="show_list_popup(event,'.$recentlist->id.');" data-target="#myModal2" data-toggle="modal">
                                <i class="fa fa-heart-o"></i><i class="fa fa-heart fav_bg"></i>
                                </div>';
                                }
                            echo '</div>
                            <p class="siml-text1 margin_left5 small text_gray1 margin_right60"><b>  '.$roomtype->roomtype.' . <span>'; 
                            echo ($recentlist->beds > 1) ? $recentlist->beds.' Beds' : $recentlist->beds.' Bed';
                            echo '</span></b></p>
                            <p class="siml-text2 margin_left5 fa-1x">'.$listName.' </p>'; ?>

                            <div class="margin_left5 similar-prices">
                             <?php if($recentlist->booking=='perhour') 
                                {?>
                                <div class="hrs-price"><span>  <?php echo $currency_symbol." ".round(($rate * ($recentlist->hourlyprice/$rate2)),2)." ".Yii::t('app','per hour'); ?></span></div>
                                <?php
                                }
                                else{?>
                                <div class="full-price"><span>  <?php echo $currency_symbol." ".round(($rate * ($recentlist->nightlyprice/$rate2)),2)." ".Yii::t('app','per night'); ?></span></div> 
                                <?php }?>
                            </div>
                                <div class="margin_left5 similar-ratings">
                                  <div class="country-details">
                                    <?php
                            $ratings = Reviews::getRatingbylisting($recentlist->id);
                            echo '<p class="place-star-rating">';
                            
                              for($x=1; $x<=$ratings['rating']; $x++) {
                                echo '<span class="full-star-span">
                                    <svg viewBox="0 0 1000 1000" role="presentation" aria-hidden="true" focusable="false" style="height: 1em; width: 1em; display: block; fill: currentcolor;"><path d="M971.5 379.5c9 28 2 50-20 67L725.4 618.6l87 280.1c11 39-18 75-54 75-12 0-23-4-33-12l-226.1-172-226.1 172.1c-25 17-59 12-78-12-12-16-15-33-8-51l86-278.1L46.1 446.5c-21-17-28-39-19-67 8-24 29-40 52-40h280.1l87-278.1c7-23 28-39 52-39 25 0 47 17 54 41l87 276.1h280.1c23.2 0 44.2 16 52.2 40z"></path></svg>
                                </span>';
                            }
                            if (strpos($ratings['rating'],'.')) {
                                echo '<span class="half-star-span">
                                    <span class="no-cover-star">
                                      <svg viewBox="0 0 1000 1000" role="presentation" aria-hidden="true" focusable="false" style="height: 1em; width: 1em; display: block; fill: currentcolor;"><path d="M971.5 379.5c9 28 2 50-20 67L725.4 618.6l87 280.1c11 39-18 75-54 75-12 0-23-4-33-12l-226.1-172-226.1 172.1c-25 17-59 12-78-12-12-16-15-33-8-51l86-278.1L46.1 446.5c-21-17-28-39-19-67 8-24 29-40 52-40h280.1l87-278.1c7-23 28-39 52-39 25 0 47 17 54 41l87 276.1h280.1c23.2 0 44.2 16 52.2 40z"></path></svg>
                                    </span>
                                    <span class="off-cover-star">
                                      <svg viewBox="0 0 1000 1000" role="presentation" aria-hidden="true" focusable="false" style="height: 1em; width: 1em; display: block; fill: currentcolor;"><path d="M510.2 23.3l1 767.3-226.1 172.2c-25 17-59 12-78-12-12-16-15-33-8-51l86-278.1L58 447.5c-21-17-28-39-19-67 8-24 29-40 52-40h280.1l87-278.1c7.1-23.1 28.1-39.1 52.1-39.1z"></path></svg>
                                    </span>
                                </span>';
                                $x++;
                            }
                            while ($x<=5) {
                                echo '<span class="half-star-span">
                                    <span class="no-cover-star">
                                      <svg viewBox="0 0 1000 1000" role="presentation" aria-hidden="true" focusable="false" style="height: 1em; width: 1em; display: block; fill: currentcolor;"><path d="M971.5 379.5c9 28 2 50-20 67L725.4 618.6l87 280.1c11 39-18 75-54 75-12 0-23-4-33-12l-226.1-172-226.1 172.1c-25 17-59 12-78-12-12-16-15-33-8-51l86-278.1L46.1 446.5c-21-17-28-39-19-67 8-24 29-40 52-40h280.1l87-278.1c7-23 28-39 52-39 25 0 47 17 54 41l87 276.1h280.1c23.2 0 44.2 16 52.2 40z"></path></svg>
                                    </span>
                                </span>';
                                $x++;
                            }
                            echo '<span class="place-reviews"> '.$ratings['n_rating'].' </span>';    
                    ?>
                                  </div>
                              </div>
                       <?php echo '</div></a>
                    </div>';        
                    $around_list++;
    }
                echo '</div>';
                if(count($listings) > 4) 
                {
                    echo '<div class="show-all margin_left10 margin_right10"><button type="button" class="show-more-btn" onclick="javascript:searcharound();"><span class="load-more-image">'.Yii::t('app','Show all').'('.count($listings).') </span> <div class="right-arrow"><svg viewBox="0 0 18 18" role="presentation" aria-hidden="true" focusable="false" style="height: 10px; width: 10px; fill: currentcolor;"><path d="m4.29 1.71a1 1 0 1 1 1.42-1.41l8 8a1 1 0 0 1 0 1.41l-8 8a1 1 0 1 1 -1.42-1.41l7.29-7.29z" fill-rule="evenodd"></path></svg></div></button></div>';
                }
                echo '</div>'; 
            
       // echo '</div> </div><!--pos_rel end-->';
    }
     ?>

       

       <!--  Featured Destinations  -->   

       <div class="destination-slider">
            <div class="airfcfx-home-cnt-width container"> 
              <div class="margin_left10 margin_right10">
                <h1 class="bold-font margin_top20 home-title"><?= Yii::t('app','Explore Destinations'); ?></h1>
                <h4><?= Yii::t('app','Browse beautiful homes with all the comforts of home'); ?></h4>
                <div class="row">
                    <div class="MultiCarousel" data-items="1,3,5,6" data-slide="1" id="MultiCarousel"  data-interval="1000">
                        <div class="MultiCarousel-inner">
                        <?php
                            foreach($homecountries as $eachcountry)
                            {
                                $country_link = Yii::$app->urlManager->createAbsoluteUrl ( '/search/'.$eachcountry['countryname']);

                                $countryimg = Yii::$app->urlManager->createAbsoluteUrl ( '/albums/images/country/'.$eachcountry['imagename']);

                                $countryimgurl = Yii::$app->urlManager->createAbsoluteUrl ('resized.php?src='.$countryimg.'&w=190&h=220');  

                                echo ' <div class="item">
                                <div class="pad15">
                                    <a href="'.$country_link.'"><img class="desintn-lsider-imag" src="'.$countryimgurl.'" alt="london"></a> 
                                </div>
                                <div class="country-name">
                                  <span class="airfcfx-country-txt">'.$eachcountry['countryname'].'</span>
                                  </div>
                                </div>';
                            } 
                        ?>
                        </div>
                        <button class="btn btn-primary leftLst">
                            <svg viewBox="0 0 18 18" role="img" aria-label="Previous" focusable="false" style="height: 1em; width: 1em; display: block; fill: currentcolor;"><path d="m13.7 16.29a1 1 0 1 1 -1.42 1.41l-8-8a1 1 0 0 1 0-1.41l8-8a1 1 0 1 1 1.42 1.41l-7.29 7.29z" fill-rule="evenodd"></path></svg>
                        </button>
                        <button class="btn btn-primary rightLst">
                            <svg viewBox="0 0 18 18" role="img" aria-label="Next" focusable="false" style="height: 1em; width: 1em; display: block; fill: currentcolor;"><path d="m4.29 1.71a1 1 0 1 1 1.42-1.41l8 8a1 1 0 0 1 0 1.41l-8 8a1 1 0 1 1 -1.42-1.41l7.29-7.29z" fill-rule="evenodd"></path></svg>
                        </button>
                    </div>
                </div>
              </div>
            </div>
        </div>



    
  <div id="myCarousel" class="airfcfx-margin-55 carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <!--ol class="carousel-indicators">
		<?php
		$k = 0;
		foreach($textsliders as $textslider)
		{
			if($k==0)
			echo '<li data-target="#myCarousel" data-slide-to="0" class="active"></li>';
			else
			echo '<li data-target="#myCarousel" data-slide-to="1"></li>';
			
		}
		?>
      
      
    </ol-->

    <!-- Wrapper for slides -->
  <!--<div class="carousel-inner" role="listbox">
  <?php
  $j = 0;
  foreach($textsliders as $textslider)
  {
  	$textsliderimage = $baseUrl.'/admin/images/textsliders/'.$textslider->sliderimage;
  	if($j==0)
  		echo '<div class="item active">';
  	else
  		echo '<div class="item">';
  	echo '<div class="slide_one" style="background-image:url('.$textsliderimage.');"></div>
      <div class="carousel-caption slide_caption">
        '.$textslider->slidertext.'
      </div>
    </div>';
  	$j++;
  } 
  ?>
  </div>

    <!-- Left and right controls -->
    <!--<a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
      <span class="fa fa-angle-left" aria-hidden="true"></span>
      <span class="sr-only"><?php echo Yii::t('app','Previous');?></span>
    </a>
    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
      <span class="fa fa-angle-right" aria-hidden="true"></span>
      <span class="sr-only"><?php echo Yii::t('app','Next');?></span>
    </a>
  </div>-->



  <div class="border_top border_bottom1 airfcfx-home-cnt-width container"> 
    <div id="carousel-example-generic" class="airfcfx-carousel carousel slide margin_top30 margin_bottom30" data-ride="carousel">
          <!-- Wrapper for slides -->
          <div class="carousel-inner" role="listbox">
          <?php
          $i = 0;
          foreach($buttonsliders as $slider)
          {
            if($i==0)
              echo '<div class="item active">';
            else 
              echo '<div class="item">';
            $sliderimage = $baseUrl.'/admin/images/buttonsliders/'.$slider->sliderimage;
              echo '<div class="airfcfx-slide_one slide_one" style="background-image:url('.$sliderimage.');"></div>
              <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 no-hor-padding">
                  <div class="airfcfx-carousel-caption carousel-caption slide_caption1">
                   <h1>'.Yii::t('app',$slider->title).'</h1>
                  <h4>'.Yii::t('app',$slider->description).'</h4>
                  <a target="_blank" href="'.$slider->buttonlink.'">
                  <button class="slider-btn airfcfx-slider-btn btn btn_search">'.Yii::t('app',$slider->buttonname).'</button>
                  </a> 
                  </div> 
              </div>   <!-- col-sm-4 end --> 
            </div>';
            $i++;
          } 
          ?>
            
          </div>
  </div> <!-- slide end -->
        
</div> <!-- container end -->




 <div class="airfcfx-home-cnt-width explore-content container">
    
    	<div class="text-center margin_top40 margin_bottom40">
    		<h1 class="airfcfx-txt-home"><?php echo Yii::t('app','Explore the world');?></h1>
            <h4><?php echo Yii::t('app','See where people are traveling, all around the world.');?></h4>
    	</div>    

        <?php
          $placeimg = Yii::$app->urlManager->createAbsoluteUrl ('/images/places.png');
          $teamimg = Yii::$app->urlManager->createAbsoluteUrl ('/images/team.png');
          $customerimg = Yii::$app->urlManager->createAbsoluteUrl ('/images/customer-service.png');
        ?>
        
        <div class="airfcfx-reason_one-cnt col-xs-12 col-sm-4">
        	<div class="airfcfx-places airfcfx-reason_one reason_one">
              <div class="reason-icon-left">
                <img class="reason-plce-img" src="<?php echo $placeimg;?>">
              </div>
            	<div class="reason-right-txt">
                  <h1 class="text_black reason-content-title"><?php echo $homesettings->placescount;?>+ <?php echo Yii::t('app',' Places'); ?></h1>
                  <p class="reason_text"><?php echo Yii::t('app',$homesettings->placesdesc);?></p>
					        <!--<div class="airfcfx-support-block-line"></div>-->
              </div>
            </div>  <!-- reason_one end -->
        </div> <!-- col-sm-4 end -->
        
        <div class="airfcfx-reason_one-cnt col-xs-12 col-sm-4">
        	<div class="airfcfx-customers airfcfx-reason_one reason_one">
              <div class="reason-icon-left">
                <img class="reason-plce-img" src="<?php echo $teamimg;?>">
              </div>
            	<div class="reason-right-txt">
                  <h1 class="text_black reason-content-title"><?php echo $homesettings->customerscount;?>+ <?= Yii::t('app','Customers'); ?></h1>
                  <p class="reason_text"><?php echo Yii::t('app',$homesettings->customersdesc);?></p>
					        <!--<div class="airfcfx-support-block-line"></div>-->
              </div>
            </div>  <!-- reason_one end -->
        </div> <!-- col-sm-4 end -->
        
        <div class="airfcfx-reason_one-cnt col-xs-12 col-sm-4">
        	<div class="airfcfx-support  airfcfx-reason_one reason_one">
              <div class="reason-icon-left">
                <img class="reason-plce-img" src="<?php echo $customerimg;?>">
              </div>
            	<div class="reason-right-txt">
                  <h1 class="text_black reason-content-title"><?php echo $homesettings->supporttime;?> <?= Yii::t('app','Support'); ?></h1>
                  <p class="reason_text"><?php echo Yii::t('app',$homesettings->supportdesc);?></p>
					        <!--<div class="airfcfx-support-block-line"></div>-->
              </div>
            </div>  <!-- reason_one end -->
        </div> <!-- col-sm-4 end -->
        
 </div> <!-- Container end -->
 
<div class="modal fade" id="signupModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog login_width" role="document">
    <div class="modal-content">
      <div class="modal-header no_border clearfix">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">
            <svg viewBox="0 0 24 24" role="img" aria-label="Close" focusable="false" style="display: block; fill: rgb(0, 0, 0); height: 16px; width: 16px;">
<path fill-rule="evenodd" d="M23.25 24a.744.744 0 0 1-.53-.22L12 13.062 1.28 23.782a.75.75 0 0 1-1.06-1.06L10.94 12 .22 1.28A.75.75 0 1 1 1.28.22L12 10.94 22.72.22a.749.749 0 1 1 1.06 1.06L13.062 12l10.72 10.72a.749.749 0 0 1-.53 1.28">
</svg>
          </span>
        </button>        
      </div>
      <div class="modal-body text-center">

            <?= yii\authclient\widgets\AuthChoice::widget([
                'baseAuthUrl' => ['auth']
              ]); ?>

            <div id="gSignInWrapper"> 
              <div id="customBtn" class="customGPlusSignIn">
                <span class="icon"></span>
                <span class="buttonText">Signup with Google</span>
              </div>
            </div>  

            <script>startApp();</script>

               <div class="login_or border_bottom "><span><?php echo Yii::t('app','or');?></span></div>
      <?php 
      if(isset($socialSettingsDetails['socialstatus']) && $socialSettingsDetails['socialstatus'] == "1") { ?>

        <!--<h2 class="login-popup-title">join in to continue</h2>
      	<div class="login-tiltl"><?php echo Yii::t('app','Signup with');?> </div>--><a href="#" class="text-danger">
      	      	
      	</a>

        <?php } else { 
        		echo  Yii::t('app','Sign Up');
        } ?>
            <?php $form = ActiveForm::begin(['id' => 'form-signup','action'=>'signup',
            		//'onSubmit'=>'return validatedata();'
            		//'enableAjaxValidation' => true,
            		//'enableClientValidation'=>true,
            		//'validateOnSubmit'=>true,
            ]); ?>

                <?= $form->field($model, 'firstname')->textInput(['id'=>'firstname','class' => 'form-control margin_top30 margin_bottom10','placeholder' => ''.Yii::t('app','First Name').'','onkeypress'=>'return isAlpha(event)','maxlength'=>'30'])->label(false); ?>
                <?= $form->field($model, 'lastname')->textInput(['id'=>'lastname','class' => 'form-control margin_bottom10','placeholder' => ''.Yii::t('app','Last Name').'','onkeypress'=>'return isAlpha(event)','maxlength'=>'30'])->label(false); ?>

                <?= $form->field($model, 'email')->textInput(['id' => 'email', 'class' => 'form-control margin_bottom10','placeholder' => ''.Yii::t('app','Email Address').''])->label(false); ?>
                <!--?= $form->errorSummary($model); ?-->
                <?= $form->field($model, 'password')->passwordInput(['id'=>'password','class' => 'form-control margin_bottom10','placeholder' => ''.Yii::t('app','Password').''])->label(false); ?>
                <p class="text-right text-danger margin_bottom10 show-paswrd">
                    <a href="#" onclick="javascript:ToggleSignup();">Show password</a>
                </p>
                 <div class="bdaycls"> <label><?php echo Yii::t('app','Birthday ?');?></label>
                    <p>To sign up, you must be 18 or older. Other people won’t see your birthday.</p>
                    <br />
                    <select name="SignupForm[year]" class="bdayselcls slctFix" id="byear">
                      <option value="0000"><?php echo Yii::t('app','Year');?></option>

                      <?php
                        $Year = date('Y') - 18; 
                        for($i=$Year;$i>=1900;$i--)
                        {
                            echo '<option value="'.$i.'">'.$i.'</option>';
                        }
                      ?>
                    </select>
                    <select name="SignupForm[month]" class="bdayselcls slctFix" id="bmonth" >
                      <option value="0"><?php echo Yii::t('app','Month');?></option>
                      <option value="1"><?php echo Yii::t('app','January');?></option>
                      <option value="2"><?php echo Yii::t('app','February');?></option>
                      <option value="3"><?php echo Yii::t('app','March');?></option>
                      <option value="4"><?php echo Yii::t('app','April');?></option>
                      <option value="5"><?php echo Yii::t('app','May');?></option>
                      <option value="6"><?php echo Yii::t('app','June');?></option>
                      <option value="7"><?php echo Yii::t('app','July');?></option>
                      <option value="8"><?php echo Yii::t('app','August');?></option>
                      <option value="9"><?php echo Yii::t('app','September');?></option>
                      <option value="10"><?php echo Yii::t('app','October');?></option>
                      <option value="11"><?php echo Yii::t('app','November');?></option>
                      <option value="12"><?php echo Yii::t('app','December');?></option>
                    </select>
                    <select name="SignupForm[day]" class="bdayselcls slctFix" id="bday"> 
                      <option value="0"><?php echo Yii::t('app','Day');?> 
                    </select>
        
				 </div>
				 <div class="has-error"><p id="bdayerr" class="help-block help-block-error"></p></div>
<?php
$termsurl = Yii::$app->urlManager->createAbsoluteUrl("/user/help/terms");;
?>
        <div class="margin_top10 text-left font_size12 margin_bottom10"><p><?php echo Yii::t('app','By signing up, I agree to ');?><?php echo $sitesettings->sitename;?>'s <a href="<?php echo $termsurl;?>" target="_blank" class="text-danger"><?php echo Yii::t('app','Terms and Conditions.');?></a> </p></div>  
                <div class="form-group">
                    <?= Html::submitButton(''.Yii::t('app','Sign up').'', ['id'=>'signup_btn', 'class' => 'btn btn_email margin_top10 width100', 'name' => 'signup-button']) ?>  
                </div>
				<?php
				$loadimgurl = Yii::$app->urlManager->createAbsoluteUrl ('/images/load.gif');
echo '<img alt="loading" id="signuploadimg" src="'.$loadimgurl.'" class="loading" style="margin-top:-1px;">';
?>
            <?php ActiveForm::end(); ?>  

            <!--<p class="changeover">Already have an Airbnb account? <a data-dismiss="modal" data-toggle="modal" href="#loginModal">Log in</a></p>-->
          
      </div>  

    </div>
  </div>
</div>



<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog login_width" role="document">
    <div class="modal-content">
      <div class="modal-header no_border clearfix">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">
            <svg viewBox="0 0 24 24" role="img" aria-label="Close" focusable="false" style="display: block; fill: rgb(0, 0, 0); height: 16px; width: 16px;">
<path fill-rule="evenodd" d="M23.25 24a.744.744 0 0 1-.53-.22L12 13.062 1.28 23.782a.75.75 0 0 1-1.06-1.06L10.94 12 .22 1.28A.75.75 0 1 1 1.28.22L12 10.94 22.72.22a.749.749 0 1 1 1.06 1.06L13.062 12l10.72 10.72a.749.749 0 0 1-.53 1.28">
</svg>
          </span>
        </button>        
      </div>
      <div class="modal-body text-center">

          <?= yii\authclient\widgets\AuthChoice::widget([
                   'baseAuthUrl' => ['auth']
              ]); ?>

          <div id="gSignInWrapper"> 
              <div id="customBtnLogin" class="customGPlusSignIn">
                <span class="icon"></span>
                <span class="buttonText">Signup with Google</span>
              </div>
          </div>    

          <script>startAppLogin();</script> 

              <div class="login_or border_bottom"><span><?php echo Yii::t('app','or');?></span></div>  

      <?php 
      if(isset($socialSettingsDetails['socialstatus']) && $socialSettingsDetails['socialstatus'] == "1") { ?>
      <!--<h2 class="login-popup-title">Log in to continue</h2>-->
      
        <a href="#" class="text-danger"></a>

        <?php } else {
        		echo  Yii::t('app','Login');
        }?>    
            <?php $form = ActiveForm::begin(['id' => 'login-form','action' => 'login',
            ]); ?>

                <?= $form->field($model, 'email')->textInput(['id'=>'login-email', 'class' => 'form-control margin_top30 margin_bottom10','placeholder' => ''.Yii::t('app','Email').'', 'value'=>''])->label(false) ?>

                <?= $form->field($model, 'password')->passwordInput(['id'=>'login-password','class' => 'form-control margin_bottom10','placeholder' => ''.Yii::t('app','Password').'',  'value'=>''])->label(false) ?> 

                <div class="checkboxatrb">
                <label>
                <span class="check-cover">
                  <input class="form-control" id="login-rememberMe" name="SignupForm[rememberMe]" type="checkbox">
                  <div class="airfcfx-search-checkbox-text"></div> 
                </span>
                <span class="check-cover bold-font">&nbsp;&nbsp;Remember me</span>
              </label>
              </div>

				<p class="text-right text-danger margin_bottom10 show-paswrd">
    				<a href="#" onclick="javascript:Toggle();">Show password</a>
				</p>

                <div class="form-group">
                    <?= Html::submitButton(''.Yii::t('app','Login').'', ['class' => 'btn btn_email margin_top10 width100', 'name' => 'login-button']) ?>
                </div>
				<?php
				$loadimgurl = Yii::$app->urlManager->createAbsoluteUrl ('/images/load.gif');
echo '<img alt="loading" id="loginloadimg" src="'.$loadimgurl.'" class="loading" style="margin-top:-1px;">';
?>
            <?php ActiveForm::end(); ?>

                <p class="text-center text-danger margin_bottom10">
                    <a href="#" data-toggle="modal" data-target="#myModalpass" id="forgotpass">
                        <?php echo Yii::t('app','Forgot Password?');?>
                    </a>
                </p>

            <!-- <p class="changeover">Don’t have an account? <a data-dismiss="modal" data-toggle="modal" href="#signupModal">Sign up</a></p>-->

            </div>
          
    </div>
  </div>
</div>

<div class="modal fade" id="myModalpass" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog login_width" role="document">
    <div class="modal-content">
      <div class="modal-header no_border clearfix">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">
              <svg viewBox="0 0 24 24" role="img" aria-label="Close" focusable="false" style="display: block; fill: rgb(0, 0, 0); height: 16px; width: 16px;">
<path fill-rule="evenodd" d="M23.25 24a.744.744 0 0 1-.53-.22L12 13.062 1.28 23.782a.75.75 0 0 1-1.06-1.06L10.94 12 .22 1.28A.75.75 0 1 1 1.28.22L12 10.94 22.72.22a.749.749 0 1 1 1.06 1.06L13.062 12l10.72 10.72a.749.749 0 0 1-.53 1.28">
</svg>
          </span>
        </button>        
      </div>
      <div class="modal-body text-center">
<?php echo Yii::t('app',"Enter the email address associated with your account, and we'll email you a link to reset your password. ");?>  
            <?php $form = ActiveForm::begin(['validateOnSubmit' => false,'enableClientValidation'=>false,'id' => 'password-form','action' => 'forgotpassword','enableAjaxValidation'=>false,
            ]); ?>

                <?= $form->field($models, 'email')->textInput(['class' => 'form-control margin_top30','placeholder' => ''.Yii::t('app','Email').''])->label(false) ?>

			<div class="login_or border_bottom"></div>      
                <div class="form-group">
                    <?= Html::submitButton(''.Yii::t('app','Send Reset Link').'', ['class' => 'btn btn_email margin_top10 width100', 'name' => 'reset-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
            </div>
           
    </div>
  </div>
</div>

</div>
<script>
	$('.carousel').carousel({
    interval: 4000
});
	$(document).ready(function() {
        var hourbased='<?php echo $hour_booking; ?>';
    		$("#where-to-go-main").val("");
    		$("#check-in-main").val("");
    		$("#check-out-main").val("");
        $('#forgotpass').click(function () {
    	  $("#forgotpass").attr('data-dismiss','modal');
    	 /*document.cookie = "dismiss=true";
    	  // Load up a new modal...
    	  $('#loginModal').hide();
    	  $("#loginModal").removeClass("in");
    	  $(".modal-backdrop").remove();*/
    	     $("body").css("padding-right","0px");
    	   });

        //$(document).on('keyup',"", function (event) {
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
       $(function () {
            $("#check-in-main").datepicker({
            	minDate:new Date(),
                    onSelect: function (selected) {
                        var dt = new Date(selected);
                        if(hourbased=='no')
                        {
                          dt.setDate(dt.getDate() + 1);
                          $("#check-out-main").datepicker("option", "minDate", dt);
                        }
                        //
            			     //$("#check-out").datepicker('show');
                        //
                    },
            		onClose: function (selectedDate) {
            			$("#check-out-main").datepicker('show');
            		}
                });
                edate = new Date();
                 if(hourbased=='no'){ edate.setDate(edate.getDate()+1); }
                    $("#check-out-main").datepicker({
                		minDate:edate,
                        onSelect: function (selected) {
                            var dt = new Date(selected);
                            if(hourbased=='no'){dt.setDate(dt.getDate() - 1);}
                            $("#check-in-main").datepicker("option", "maxDate", dt);
                        }
                    });

         });

        $("#check-in-mobile").keydown(function(event){
            if (event.which == 13) {
            $("#check-in-mobile").readonlyDatepicker(true);
            }
        });
        $("#check-out-mobile").keydown(function(event){
            if (event.which == 13) {
            $("#check-out-mobile").readonlyDatepicker(true);
            }
        });
        $(function () {
            $("#check-in-mobile").datepicker({
              minDate:new Date(),
                    onSelect: function (selected) {
                        var dt = new Date(selected);
                        if(hourbased=='no')
                        {
                          dt.setDate(dt.getDate() + 1);
                           //$("#check-out").datepicker('show');
                          $("#check-out-mobile").datepicker("option", "minDate", dt);
                        }
                    },
                onClose: function (selectedDate) {
                  $("#check-out-mobile").datepicker('show');
                }
                });
              edate = new Date();
              if(hourbased=='no'){ edate.setDate(edate.getDate()+1);}
                  $("#check-out-mobile").datepicker({
                  minDate:edate,
                      onSelect: function (selected) {
                          var dt = new Date(selected);
                           if(hourbased=='no'){dt.setDate(dt.getDate() - 1)};
                          $("#check-in-mobile").datepicker("option", "maxDate", dt);
                      }
                  });

          });
});




function close_model_popup()
{
	$("#welcomepopup").removeClass("in");
	$("#welcomepopup").css("display","none");
}

function initMapmain() {
	autocomplete = new google.maps.places.Autocomplete((document
			.getElementById('where-to-go-main')), {
		types : [ 'geocode' ],
    change: function(event, ui) {
      if (ui.item == null) {
          $("#where-to-go-main").val("");
          $("#where-to-go-main").focus();
      }
    },
	});
}  

function initMapmobile() {
  autocomplete = new google.maps.places.Autocomplete((document
      .getElementById('where-to-go-mobile')), {
    types : [ 'geocode' ]
  });
}

google.maps.event.addDomListener(window, 'load', initMapmain);
google.maps.event.addDomListener(window, 'load', initMapmobile);
</script>
<script>
$( document ).ready(function() {

$(".modal").on("hidden.bs.modal", function(){
    $(".help-block").html("");
    $(".form-group").removeClass("has-error");
});

   $("#w2-success-0").css("display","block");
   $("#w2-success-0").css("right","0");
});
setTimeout(function() {
	$("#w2-success-0").css("right","-845px");
}, 4000);
</script>

<script>
  function myFunction() {
     var element = document.getElementById("checking-inputs");
     element.classList.toggle("checking-inputs-mystyle");
  }
</script>

<script type="text/javascript">

$(function() {
    $('input[name="daterange"]').daterangepicker({
      //startDate: moment(), 
      //endDate: moment().add(1, "days"),
      autoUpdateInput: false, 
      locale: {
          cancelLabel: 'Clear'
      }
    });

    $('input[name="daterange"]').on('apply.daterangepicker', function(ev, picker) {
      var pStartDate = picker.startDate.format('MM/DD/YYYY');
      var pEndDate = picker.endDate.format('MM/DD/YYYY');

      if(pStartDate == pEndDate){
        var pStartDates = picker.startDate;
        //var pEndDates = picker.endDate.add(1, "days");
        var pEndDates = picker.endDate;
        $('#daterangepick_value').val(pStartDates.format('MM/DD/YYYY') + ' - ' +pEndDates.format('MM/DD/YYYY'));
         //$(this).val(pStartDates.format('DD MMM') + ' - ' + pEndDates.format('DD MMM'));  
         $(this).val(pStartDates.format('DD MMM'));   
      } else {
        $('#daterangepick_value').val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
        $(this).val(picker.startDate.format('DD MMM') + ' - ' + picker.endDate.format('DD MMM')); 
      }
    });

    $('input[name="daterange"]').on('cancel.daterangepicker', function(ev, picker) {
        $('#daterangepick').data('daterangepicker').setStartDate(moment());
        $('#daterangepick').data('daterangepicker').setEndDate(moment());   
        $(this).val('Dates'); 
        $('#daterangepick_value').val('');
    });

});
</script>

<script type="text/javascript">
    $(document).ready(function () {
    var itemsMainDiv = ('.MultiCarousel');
    var itemsDiv = ('.MultiCarousel-inner');
    var itemWidth = "";

    $('.leftLst, .rightLst').click(function () {
        var condition = $(this).hasClass("leftLst");
        if (condition)
            click(0, this);
        else
            click(1, this)
    });

    ResCarouselSize();

    $(window).resize(function () {
        ResCarouselSize();
    });

    //this function define the size of the items
    function ResCarouselSize() {
        var incno = 0;
        var dataItems = ("data-items");
        var itemClass = ('.item');
        var id = 0;
        var btnParentSb = '';
        var itemsSplit = '';
        var sampwidth = $(itemsMainDiv).width();
        var bodyWidth = $('body').width();
        $(itemsDiv).each(function () {
            id = id + 1;
            var itemNumbers = $(this).find(itemClass).length;
            btnParentSb = $(this).parent().attr(dataItems);
            itemsSplit = btnParentSb.split(',');
            $(this).parent().attr("id", "MultiCarousel" + id);


            if (bodyWidth >= 1200) {
                incno = itemsSplit[3];
                itemWidth = sampwidth / incno;
            }
            else if (bodyWidth >= 992) {
                incno = itemsSplit[2];
                itemWidth = sampwidth / incno;
            }
            else if (bodyWidth >= 768) {
                incno = itemsSplit[1];
                itemWidth = sampwidth / incno;
            }
            else if (bodyWidth >= 550) {
                incno = itemsSplit[1];
                itemWidth = sampwidth / incno;
            }
            else {
                incno = itemsSplit[0];
                itemWidth = sampwidth / incno;
            }
            $(this).css({ 'transform': 'translateX(0px)', 'width': itemWidth * itemNumbers });
            $(this).find(itemClass).each(function () {
                $(this).outerWidth(itemWidth);
            });

            $(".leftLst").addClass("over");
            $(".rightLst").removeClass("over");

        });
    }
    //this function used to move the items
    function ResCarousel(e, el, s) {
        var leftBtn = ('.leftLst');
        var rightBtn = ('.rightLst');
        var translateXval = '';
        var divStyle = $(el + ' ' + itemsDiv).css('transform');
        var values = divStyle.match(/-?[\d\.]+/g);
        var xds = Math.abs(values[4]);
        if (e == 0) {
            translateXval = parseInt(xds) - parseInt(itemWidth * s);
            $(el + ' ' + rightBtn).removeClass("over");

            if (translateXval <= itemWidth / 2) {
                translateXval = 0;
                $(el + ' ' + leftBtn).addClass("over");
            }
        }
        else if (e == 1) {
            var itemsCondition = $(el).find(itemsDiv).width() - $(el).width();
            translateXval = parseInt(xds) + parseInt(itemWidth * s);
            $(el + ' ' + leftBtn).removeClass("over");

            if (translateXval >= itemsCondition - itemWidth / 2) {
                translateXval = itemsCondition;
                $(el + ' ' + rightBtn).addClass("over");
            }
        }
        $(el + ' ' + itemsDiv).css('transform', 'translateX(' + -translateXval + 'px)');
    }

    //It is used to get some elements from btn
    function click(ell, ee) {
        var Parent = "#" + $(ee).parent().attr("id");
        var slide = $(Parent).attr("data-slide");
        ResCarousel(ell, Parent, slide);
    }

});


    function searchfeatured()
    {
        window.location.href = "<?= Yii::$app->urlManager->createAbsoluteUrl ( '/search/type/featured' ); ?>";
        return false;
    }


    function searcharound()
    {
        window.location.href = "<?= Yii::$app->urlManager->createAbsoluteUrl ( '/search/type/anywhere' ); ?>";
        return false;
    }

    function searchtraverseworld()
    {
        window.location.href = "<?= Yii::$app->urlManager->createAbsoluteUrl ( '/search/type/traverse' ); ?>"; 
        return false;
    }


    function Toggle() { 
            var temp = document.getElementById("login-password"); 
            if (temp.type === "password") { 
                temp.type = "text"; 
            } 
            else { 
                temp.type = "password"; 
            } 
        } 

    function ToggleSignup() { 
            var temp = document.getElementById("password"); 
            if (temp.type === "password") { 
                temp.type = "text"; 
            } 
            else { 
                temp.type = "password"; 
            } 
        } 
</script>

<script>
  $(document).on('change', '#bmonth, #byear', function(e){
      var year = $('#byear').val();
      var month = $('#bmonth').val(); 
      if(month>0 && month<=12 && year > 0) {
        var getDaysInMonth = function(month,year) {
         return new Date(year, month, 0).getDate(); 
        };
        var totalDays = getDaysInMonth(month, year); 
        var count;
        var totalText = "";  
        for(count = 1; count<=totalDays; count++) {
          totalText+="<option value='"+count+"'>"+count+"</option>"; 
        }
        $('#bday').html(totalText);
      }
  });
</script>

<style type="text/css">.footer{margin-top: 0;}#daterangepick{margin: 10px 10px;border-radius: 3px !important;height: 45px;float: left !important;width: auto !important;padding: 10px 20px;}</style> 
