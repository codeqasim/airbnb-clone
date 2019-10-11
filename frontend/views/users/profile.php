<?php
   /*
    * This page is for displaying the information about the user. It is the profile page of the user.
    *
    * @author: Muthumareeswari
    * @package: Views
    * @PHPVersion: 5.4
    */
   /* @var $this yii\web\View */
   use yii\helpers\Html;
   use yii\bootstrap\ActiveForm;
   use frontend\models\Roomtype;
   use yii\widgets\LinkPager;
   use yii\CurrencyConverter\CurrencyConverter;
   use frontend\models\Reviews;
   use backend\components\Myclass; 
   use frontend\models\Listing;
   $this->title = 'Profile';
   ?>
<?php
   $baseUrl = Yii::$app->request->baseUrl;
   //echo $userdata['firstname'];die;
   $firstname = $userdata['firstname'];
   $lastname = $userdata['lastname'];
   ?>
<div class="profile-page">
   <div class="container">
      <div class="row">
         <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3 margin_top20 margin_bottom20">
            <?php
               if(isset($userdata->profile_image) && $userdata->profile_image!="")
               {
               	$profile_image = $userdata->profile_image;
               	$profile_image = Yii::$app->urlManager->createAbsoluteUrl ( '/albums/images/users/'.$profile_image);
               	$resized_profile_image = Yii::$app->urlManager->createAbsoluteUrl ('resized.php?src='.$profile_image.'&w=350&h=225');	
               	echo '<div class="profile_img" style="background-image:url('.$resized_profile_image.');" ></div>';
               }
               else
               {
               	$profile_image = "usrimg.jpg";
               	$profile_image = Yii::$app->urlManager->createAbsoluteUrl ( '/albums/images/users/'.$profile_image);
               	$resized_profile_image = Yii::$app->urlManager->createAbsoluteUrl ('resized.php?src='.$profile_image.'&w=350&h=225');	
               	echo '<div class="profile_img" style="background-image:url('.$resized_profile_image.');" ></div>';
               }
               ?>
            <div class="border1 margin_top20 margin_bottom20">
               <h4 class="profile_menu1 margin_top0" style="padding:0px;margin-bottom:0px;">
                  <?php echo Yii::t('app','Verified Info');?>	
                  <i class="fa fa-question-circle hover_tool pos_rel pull-right">
                     <div class="tooltip_text">
                        <p class="font_size12"><?php echo Yii::t('app','Verifications help build trust between guests and hosts and can make booking easier. ');?></p>
                     </div>
                     <!--tooltip_text end-->
                  </i>
               </h4>
               <div class="bg_white margin_top20 margin_bottom10">
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
                  <p><?php echo Yii::t('app','Email');?></p>
                  <!--<p class="text_gray1"><?php echo Yii::t('app','Not Verified');?> </p>	-->									
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
               <p><?php echo Yii::t('app','Mobile');?> </p>
               <!--<p class="text_gray1"><?php echo Yii::t('app','Verified');?> </p>-->
               <?php
                  }
                  elseif($loguserid == $userdata->id && $userdata['mobileverify'] != '1')
                  {
                  	?>
               <i class="close-circle fa-1x text-danger"></i>
            </div>
            <p><?php echo Yii::t('app','Mobile');?></p>
            <!--<p class="text_gray1"><?php echo Yii::t('app','Not q');?></p>	-->									
            <?php
               }else{
               	?>
            
            <i class="close-circle fa-1x text-danger"></i>

         </div>
          <?= '<p>'.Yii::t('app','Mobile').'</p>'; ?>
         <?php
            }
            ?>
      </div>
      <?php
         if($loguserid==$userdata->id && ($userdata['mobileverify']!="1" || $userdata['emailverify']!="1"))
         {
         	?>
      <a href="<?php echo $baseUrl.'/trust';?>" class="text-danger margin_left20"><?php echo Yii::t('app','Verify more info ');?> </a>
      <?php
         }elseif($loguserid!=$userdata->id)
         {
         	?>
      <a href="<?php echo $baseUrl.'/user/help/view/1';?>" class="text-danger margin_left20" target="_blank"><?php echo Yii::t('app','Learn more ');?> </a> 
      <?php
         }
         ?>
   </div>
   <!--row end -->
</div>
<!--border1 end -->
<?php

if($userdata->language != '')
{
   $json_decode = json_decode($userdata->language);
   foreach($json_decode as $eachlang)
   {
   $langArray[] = $eachlang->name;
   }
   $language_list = Yii::t('app','Languages').': <p class="language-view">'.implode(', ',$langArray).'</p>'; 
}else{
   //$language_list = '<div class="airfcfx-verified-symbol-width tab_cel text-center "><i class="close-circle fa-1x text-danger"></i></div><p>Languages:&nbsp;&nbsp;&nbsp;&nbsp; </p>';
   $language_list = '';  
}


   ?>
<div class="border1 margin_top20 margin_bottom20">
   <h4 class="profile_menu1 margin_top0" style="padding:0px;margin-bottom:0px;"><?= Yii::t('app','About Me'); ?></h4>
   <div class="bg_white margin_top20 margin_bottom10">

      <div class="airfcfx-verifications-row table1">
        <p style="word-break: break-all;"> 
         <?php
            if(empty($userdata->school))
            {
               echo Yii::t('app','Work').': <br>'.ucfirst($userdata->work); 
            }else{
               echo Yii::t('app','School').': <br>'.ucfirst($userdata->school).'<br><br>';
               echo Yii::t('app','Work').': <br>'.ucfirst($userdata->work); 
            } 
               
         ?>
         </p>  
      </div>

      <div class="airfcfx-verifications-row table1">
         <p><?= $language_list; ?></p>
            
      </div>
   </div>
</div>
<!-- div class="border1 margin_top20 margin_bottom20">
   <h4 class="profile_menu1 margin_top0" style="padding:0px;margin-bottom:0px;"><?= Yii::t('app','Connected accounts'); ?></h4>
   <div class="bg_white margin_top20 margin_bottom10">
      <div class="airfcfx-verifications-row table1">
         <div class="airfcfx-verified-symbol-width tab_cel text-center ">
            <i class="tick-circle fa-1x text-success"></i>
         </div>
         <p><?= Yii::t('app','Facebook'); ?></p>
      </div>
   </div>
</div -->
</div>
<div class="profile-nam-tag col-xs-12 col-sm-8 col-md-9 col-lg-9 margin_top20 margin_bottom20">
   <h1 class="profile-name"><?php echo Yii::t('app','Hey, I’m ');?><?php echo $firstname;?>!</h1>
   <?php
      $created = $userdata['created_at'];
      $month = date('F',$created);
      $year = date('Y',$created);
      echo '<h4 class="member-since">'.Yii::t('app','IN · Member since').' '.$month.' '.$year.'</h4>';


      if(isset($loguserid) && $loguserid != '' && $loguserid != $userdata->id)
      {
         if(count($reportcount) != 0)
         {
      ?>
      <div class="margin_bottom10 report-flag"><i class="fa fa-flag-o"></i> <span><?php echo Yii::t('app','You have reported this user'); ?>.<a href="#" onclick="undoreport(<?= $reportcount->id; ?>);" style="text-decoration: underline !important;"><?php echo Yii::t('app','Undo'); ?>.</a></span></div> 
      <?php }else{ ?>
         <div class="margin_bottom10 report-flag"><i class="fa fa-flag-o"></i> <span><a href="#" data-toggle="modal" data-target="#report-user"><?php echo Yii::t('app','Report this user'); ?></a></span></div> 
   <?php
      }
   }
  
    if( $loguserid==$userdata->id ) {
    ?>
      <a class="edit-prof" href="<?php echo $baseUrl.'/editprofile';?>"><?php echo Yii::t('app','Edit Profile');?></a>
    <?php
    }
     
    echo '<div class="margin_bottom10 margin_top10">'.$userdata->about.'</div>';
    echo '<div class="help-block.help-block-error"></div>';
    
    if(!empty($reviews))
    { ?>
        <div id="profile_reviews" class="bg_white margin_top30"> 
          <div class="mylist-profile" id="myList">
            <?php echo '<div class="luxury-details">
              <h5 class="luxiry-title margin_bottom20">'.count($reviews).' Reviews <span id="review"></span></h5>
            </div>';
      
            foreach($reviews as $review) {
              $reviewuserid = $review->userid;
              $reviewuserdata = $review->getUser()->where(['id'=>$reviewuserid])->one();

              $userurl = base64_encode($review->userid."-".rand(0,999));
              $usernameurl = Yii::$app->urlManager->createAbsoluteUrl ( '/profile/' . $userurl );

              $reviewusername = $reviewuserdata->firstname;
              $reviewdate = date('F Y', strtotime($review->cdate));
              if(isset($reviewuserdata->profile_image) && $reviewuserdata->profile_image!="")
              {
                $reviewuserimage = $reviewuserdata->profile_image;
              }
              else
                 $reviewuserimage = "usrimg.jpg";
              
              $reviewuserimg = Yii::$app->urlManager->createAbsoluteUrl('/albums/images/users/'.$reviewuserimage);
              echo '<div class="eachrow">
                <div class="col-xs-12 col-sm-12">
                  <div class="row">
                    <div class="col-xs-12 col-sm-3 col-md-2 text-center padd_bottom30">
                      <div class="profile center-block" style="background-image:url('.$reviewuserimg.');width:65px;height:65px;"> </div>
                        <a class="text_gray1 margin_top10 center-block" href="'.$usernameurl.'">'.$reviewusername.'</a>
                    </div><!--col-sm-4 end-->
            
                    <div class="col-xs-12 col-sm-9 col-md-10">
                      <p>'.$review->review.'</p>
                      <div class="row margin_top0">
                        <div class="col-xs-12 col-sm-6">
                          <p class="text-muted margin_top10">'.$reviewdate.'.</p>
                        </div><!--col-sm-6 end-->
                      </div><!--row end-->
                    </div><!--col-sm-9 end-->

                  </div><!--row end-->
                </div><!--col-sm-9 end-->
              </div><!--row end-->';
            } ?>
            <?php if(count($reviews) > 3) { ?>
              <div class="view-options border_bottom1">
                <div id="loadMore" class="views-list pull-right">Load more <i class="fa fa-angle-double-down"></i>
                </div>
                <div id="showLess" class="views-list pull-right">Show less <i class="fa fa-angle-double-up"></i>
                </div> 
              </div>
            <?php } ?> 
          </div>
          <div align="center" class="clear">
            <?php
              $id = $userdata->id;
              $username = base64_encode($id."-".rand(0,999));
              $listuserurl = Yii::$app->urlManager->createAbsoluteUrl('/profile/'.$username);
        
              /*echo LinkPager::widget([
                'pagination' => $pages,
              ]);*/ 
            ?>
          </div>
      </div><!--bg_white-->
  <?php } ?>

      
  <div id="profile_listing" class="luxury-details">
    <h5 class="luxiry-title margin_bottom30">Listings (<?= count($listdatas); ?>)</h5>
  </div>

  <?php

    $i=0;
    echo '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-hor-padding">';
    echo '<div class="pos_rel mylistings">';

    foreach($listdatas as $eachOne)
    {
      $roomTypeDetails = $eachOne->getRoomtype0()->where(['id'=>$eachOne->roomtype])->one();
      $getPhotos = $eachOne->getPhotos()->where(['listid'=>$eachOne->id])->all();
      $listurl = Yii::$app->urlManager->createAbsoluteUrl('/user/listing/view/'.base64_encode($eachOne->id.'_'.rand(1,9999)));

      if(isset($getPhotos[0]->image_name) && $getPhotos[0]->image_name!="")
      {
         $listimagename = Yii::$app->urlManager->createAbsoluteUrl ('/albums/images/listings/'.$getPhotos[0]->image_name);
         $header_response = get_headers($listimagename, 1);
         if ( strpos( $header_response[0], "404" ) !== false )
         {
               $listimagename = Yii::$app->urlManager->createAbsoluteUrl ('/images/room_default.png');
               $listresizeurl = $listimagename;
         }else{
               $listimagename = Yii::$app->urlManager->createAbsoluteUrl ('/albums/images/listings/'.$getPhotos[0]->image_name);
               $listresizeurl = Yii::$app->urlManager->createAbsoluteUrl ('resized.php?src='.$listimagename.'&w=215&h=75');
         }                    
      } else {
        $listimagename = Yii::$app->urlManager->createAbsoluteUrl ('/images/room_default.png');
        $listresizeurl = $listimagename;
      }
    ?>
    
      <div class="owl-item margin_bottom30 eachlisting">
        <a class="rm_text_deco" href="<?= $listurl; ?>">
        
        <div class="item">
          <div class="bg_img" style="background-image:url(<?= $listresizeurl; ?>);"></div>
           
          <p class="siml-text1 small text_gray1">
            <b>  <?= $roomTypeDetails->roomtype; ?>
              <span data-original-title="" title=""> . <?= $eachOne->bedrooms; ?> Bedroom<?php 
                if( $eachOne->bedrooms > 1 ) {
                  echo 's';
                } ?>
              </span>
            </b>
          </p>
          <?php
            if(isset($eachOne->currency) && $eachOne->currency!="" && $eachOne->currency > 0)
              $listingcurrencyprice = Myclass::getcurrencyidprice($eachOne->currency);  
            else
              $listingcurrencyprice = Myclass::getcurrencydefaultprice();  
             

            if(isset($_SESSION['currency_code']) && $_SESSION['currency_code']!="")
            {
              $currency_code = $_SESSION['currency_code'];
              $currency_symbol = $_SESSION['currency_symbol'];
              $currencycode = "";

              $rate2= $listingcurrencyprice; //listing currency
              $rate= Myclass::getcurrencyprice($currency_code);//user currency

            } else {
              $rate2 = $listingcurrencyprice;
              $rate = Myclass::getcurrencydefaultprice();
            } 
          ?>
                     
          <p class="siml-text2 fa-1x"><?= $eachOne->listingname; ?></p>
          <div class="similar-prices">
            <?php
              if($eachOne->booking == 'perhour') {
            ?>
                <div class="hrs-price">
                  <span data-original-title="" title="">
                    <?php echo $currency_symbol.round((($eachOne->hourlyprice/$rate2) * $rate),2);?>  
                  </span>
                </div>
            <?php } elseif($eachOne->booking == 'pernight') { ?>
                <div class="full-price">
                  <span data-original-title="" title="">
                    <?php echo $currency_symbol.round((($eachOne->nightlyprice/$rate2) * $rate),2);?> 
                  </span>
                </div>
            <?php  } ?>
          </div>

          <div class="similar-ratings">
            <?php $listreviews = Reviews::getRatingbylisting($eachOne->id); ?>
            <div class="country-details">
              <p class="margin_top5 place-star-rating">
                  <?php for($x=1; $x<=$listreviews['rating']; $x++) {
                     echo '<span class="full-star-span">
                      <svg viewBox="0 0 1000 1000" role="presentation" aria-hidden="true" focusable="false" style="height: 1em; width: 1em; display: block; fill: currentcolor;"><path d="M971.5 379.5c9 28 2 50-20 67L725.4 618.6l87 280.1c11 39-18 75-54 75-12 0-23-4-33-12l-226.1-172-226.1 172.1c-25 17-59 12-78-12-12-16-15-33-8-51l86-278.1L46.1 446.5c-21-17-28-39-19-67 8-24 29-40 52-40h280.1l87-278.1c7-23 28-39 52-39 25 0 47 17 54 41l87 276.1h280.1c23.2 0 44.2 16 52.2 40z"></path></svg>
                  </span>';
                  } 
                  if (strpos($listreviews['rating'],'.')) {
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

                  echo '<span class="place-reviews"> '.$listreviews['n_rating'].' </span>';

                   ?>
                  
              </p>
            </div>
          </div>
        </div>
      </a>
    </div>
    <?php 
      $i++;
    }
    echo '</div>';
    echo '</div>';

    echo '<div class="view-options">
      <div id="loadMoreList" class="views-list pull-right">Load more <i class="fa fa-angle-double-down"></i>
      </div>
      <div id="showLessList" class="views-list pull-right">Show less <i class="fa fa-angle-double-up"></i></div>
    </div>'; 
   ?>
      
</div>


</div> <!-- row end -->
</div> <!-- container end -->
</div>
<script type="text/javascript">
   $( document ).ready(function() {
      $("#w0-success-0").css("display","block");
      $("#w0-success-0").css("right","0");
   });
   setTimeout(function() {
   	$("#w0-success-0").css("right","-845px");
   }, 4000);

/*Show more/less for profile Reviews.*/
$(document).ready(function () {
   let reviewLength, size_li_review;
   var xcnt=3;
   reviewLength = $('div.eachrow:lt('+xcnt+')').css('display', 'block');
   size_li_review = $("div.eachrow").size();
    

      if( size_li_review < xcnt || size_li_review == xcnt)
      {
         $('#showLess').hide();
         $('#loadMore').hide();
      }
      if(reviewLength <= xcnt || size_li_review > xcnt)  
      {
         $('#showLess').hide();
      } 

    $('#loadMore').click(function () {
        xcnt= (xcnt+5 <= size_li_review) ? xcnt+5 : size_li_review;
        $('div.eachrow:lt('+xcnt+')').show();
         $('#showLess').show();
        if(xcnt >= size_li_review){
            $('#loadMore').hide();
        }
    });
    $('#showLess').click(function () {
         //xcnt=(xcnt-5<0) ? 3 : xcnt-5;
         xcnt=3;  
         if(xcnt <= 3 || xcnt <=5) { 
            $('#showLess').hide();
            $('html, body').animate({
                scrollTop: $("#profile_reviews").offset().top
            }, 800); 
            setTimeout(function() {
               $('#myList div.eachrow').not(':lt('+xcnt+')').hide();
               $('#loadMore').show();
             }, 1000); 
          } 

    });
});


/*Show more/less for profile listings.*/
$(document).ready(function () {
   let eachlistLength, size_li;
    var x=3;
    eachlistLength = $('div.eachlisting:lt('+x+')').css('display', 'inline-block');
    size_li = $("div.eachlisting").size();

    if( size_li < x || size_li == x)
    {
      $('#loadMoreList').hide();
      $('#showLessList').hide();
    } else if(eachlistLength.length <= x)
    {
      $('#showLessList').hide(); 
    }

    $('#loadMoreList').click(function () {
        x= (x+3 <= size_li) ? x+3 : size_li;
        $('div.eachlisting:lt('+x+')').css('display', 'inline-block');
        $('#showLessList').show();

        if(x >= size_li){  
            $('#loadMoreList').hide();
        }
    });
    $('#showLessList').click(function () {
         //x=(x-3<0) ? 3 : x-3;
         x=3;
         if(x <= 3 || xcnt <=5) { 
            $('#showLessList').hide();
            $('html, body').animate({
                scrollTop: $("#profile_listing").offset().top
            }, 800); 
            setTimeout(function() {
              $('div.eachlisting').not(':lt('+x+')').hide(); 
              $('#loadMoreList').show();
             }, 1000); 
          } 
         
        
    });
});
</script>
<style type="text/css">
div.eachrow{ display:none;
}
div.eachlisting{ display:none;
}
#loadMore {
    color:#ccc;
    cursor:pointer;
}
#loadMore:hover {
    color:black;
}
#showLess {
    color:red;
    cursor:pointer;
}
#showLess:hover {
    color:black;
}

/*
Load More And Show More Lists.
*/

#loadMoreList {
    color:#000;
    cursor:pointer;
}
#loadMoreList:hover {
    color:black;
}
#showLessList {
    color:#000;
    cursor:pointer;
}
#showLessList:hover {
    color:black;
}
</style>
<div class="modal fade" id="report-user" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      
      <div class="modal-header clearfix">
         <span class="modal-title">Do you want to anonymously report this user?</span>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">
            <svg viewBox="0 0 24 24" role="img" aria-label="Close" focusable="false" style="display: block; fill: rgb(0, 0, 0); height: 16px; width: 16px;">
               <path fill-rule="evenodd" d="M23.25 24a.744.744 0 0 1-.53-.22L12 13.062 1.28 23.782a.75.75 0 0 1-1.06-1.06L10.94 12 .22 1.28A.75.75 0 1 1 1.28.22L12 10.94 22.72.22a.749.749 0 1 1 1.06 1.06L13.062 12l10.72 10.72a.749.749 0 0 1-.53 1.28">
            </svg>
          </span>
        </button>        
      </div>

      <div class="modal-body report-user-pop">
         <p><?php echo Yii::t('app','If so, please choose one of the following reasons').'.'; ?></p> 

         <div class="body-report">
            <?php
               foreach($getReports as $eachReport)
               {
            ?>
               <div class="button-report margin_bottom15 margin_top15" id="reportbug">
                  <input type="hidden" name="reportid" id="reportid" value="<?= $eachReport->id; ?>">
                  <button class="btn-default reason-btn" onclick="sendvalue(<?= $eachReport->id; ?>,<?= $userdata->id; ?>);"><?= $eachReport->report; ?></button>
                  <span>
                     <a href="#" data-toggle="popover" data-placement="left" data-content="<?= $eachReport->shortdesc; ?>">
                        <svg viewBox="0 0 24 24" role="img" aria-label="<?= $eachReport->shortdesc; ?>" focusable="false" style="height: 20px; width: 20px; display: block; fill: rgb(72, 72, 72);"><path d="m12 0c-6.63 0-12 5.37-12 12s5.37 12 12 12 12-5.37 12-12-5.37-12-12-12zm0 23c-6.07 0-11-4.92-11-11s4.93-11 11-11 11 4.93 11 11-4.93 11-11 11zm4.75-14c0 1.8-.82 2.93-2.35 3.89-.23.14-1 .59-1.14.67-.4.25-.51.38-.51.44v2a .75.75 0 0 1 -1.5 0v-2c0-.74.42-1.22 1.22-1.72.17-.11.94-.55 1.14-.67 1.13-.71 1.64-1.41 1.64-2.61a3.25 3.25 0 0 0 -6.5 0 .75.75 0 0 1 -1.5 0 4.75 4.75 0 0 1 9.5 0zm-3.75 10a1 1 0 1 1 -2 0 1 1 0 0 1 2 0z" fill-rule="evenodd"></path></svg>
                     </a>
                  </span>
               </div>
            <?php 
            } 
            ?>
         </div>
      </div>
          
    </div>
  </div>
</div>



<div class="modal fade" id="report-success" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      
      <div class="modal-header clearfix">
         <span class="modal-title">Thank You</span>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">
            <svg viewBox="0 0 24 24" role="img" aria-label="Close" focusable="false" style="display: block; fill: rgb(0, 0, 0); height: 16px; width: 16px;">
               <path fill-rule="evenodd" d="M23.25 24a.744.744 0 0 1-.53-.22L12 13.062 1.28 23.782a.75.75 0 0 1-1.06-1.06L10.94 12 .22 1.28A.75.75 0 1 1 1.28.22L12 10.94 22.72.22a.749.749 0 1 1 1.06 1.06L13.062 12l10.72 10.72a.749.749 0 0 1-.53 1.28">
            </svg>
          </span>
        </button>        
      </div>
      <div class="modal-body report-user-pop">
         <div class="body-report">
               <p>Thanks for taking the time to report this user. These reports help make Airbnb better for everyone, so we take them seriously. We’ll reach out if we have questions about your report.</p>
         </div>
      </div>
          
    </div>
  </div>
</div>


<div class="modal fade" id="delete-report" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      
      <div class="modal-header clearfix">
         <span class="modal-title">Thank You</span>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">
            <svg viewBox="0 0 24 24" role="img" aria-label="Close" focusable="false" style="display: block; fill: rgb(0, 0, 0); height: 16px; width: 16px;">
               <path fill-rule="evenodd" d="M23.25 24a.744.744 0 0 1-.53-.22L12 13.062 1.28 23.782a.75.75 0 0 1-1.06-1.06L10.94 12 .22 1.28A.75.75 0 1 1 1.28.22L12 10.94 22.72.22a.749.749 0 1 1 1.06 1.06L13.062 12l10.72 10.72a.749.749 0 0 1-.53 1.28">
            </svg>
          </span>
        </button>        
      </div>
      <div class="modal-body report-user-pop">
         <div class="body-report">
               <p>Your report was deleted.</p>
         </div>
      </div>
          
    </div>
  </div>
</div>
<script>
$(document).ready(function(){
    $('[data-toggle="popover"]').popover();   
});
</script>