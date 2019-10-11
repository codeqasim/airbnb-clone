<?php

/*
 * This page displays the user verification information. User can verify their phone number and email here.
 *
 * @author: Muthumareeswari
 * @package: Views
 * @PHPVersion: 5.4
 */
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;
use frontend\models\Listing;
$this->title = 'Reviews By You';
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
        echo '<li><a href="'.$baseUrl.'/dashboard">'.Yii::t('app','Dashboard').'</a></li>
       <li><a href="'.$baseUrl.'/user/messages/inbox/traveling">'.Yii::t('app','Inbox').'</a></li>
        <li><a href="'.$baseUrl.'/user/listing/mylistings">'.Yii::t('app','Listing').'</a></li>
        <li><a href="'.$baseUrl.'/user/listing/trips">'.Yii::t('app','Trips').'</a></li> 
        <li class="active"><a href="'.$baseUrl.'/editprofile">'.Yii::t('app','Profile').'</a></li>
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


<div class="bg_gray1">
  <div class="container">    
        <div class="col-xs-12 col-sm-3 margin_top20 margin_bottom20">
        	<ul class="profile_left list-unstyled">
			<?php
            echo '<li><a href="'.$baseUrl.'/editprofile" >'.Yii::t('app','Edit Profile').'</a></li>   
            <li><a href="'.$baseUrl.'/paysettings/default" >'.Yii::t('app','Stripe Host Account').'</a></li>         
            <li><a href="'.$baseUrl.'/trust" >'.Yii::t('app','Trust and Verification').'</a></li>
			<li class="active"><a href="'.$baseUrl.'/user/listing/reviewsbyyou" >'.Yii::t('app','Reviews').'</a></li>
';
			?>         
            </ul>
            <a href="<?php echo $baseUrl.'/profile/'.$username;?>"><button class="airfcfx-panel btn-border full-width btn btn_google margin_top20"><?php echo Yii::t('app','View Profile');?></button></a>
        </div> <!--col-sm-3 end -->
        
        <div class="col-xs-12 col-sm-9 margin_top20">
        
           <div class="no_border no-box-shadow airfcfx-panel panel panel-default">
                <div class="airfcfx-xs-heading-tab-cnt no-hor-padding airfcfx-padd-top-20 airfcfx-panel panel-heading profile_menu1 prflreview bg-transparant" style="padding-bottom:0px;">
    
              <!-- Nav tabs -->
			  <?php
              echo '<ul class="airfcfx-noborder nav nav-tabs review_tab" role="tablist">
                <li role="presentation"><a class="airfcfx-tab-heading-btpadding" href="'.$baseUrl.'/user/listing/reviewsaboutyou">'.Yii::t('app','Reviews About You').'</a></li>
                <li role="presentation" class="active"><a class="airfcfx-tab-heading-btpadding" href="'.$baseUrl.'/user/listing/reviewsbyyou">'.Yii::t('app','Reviews By You').'</a></li>            
              </ul>';
			  ?>
            </div>
              <!-- Tab panes -->
              <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="home"> 
                                	
                    <div class="airfcfx-panel-bottom panel-default">

                      
                      <div class="airfcfx-panel-padding panel-body">
                       <div class="row">  

                        <div class="border-box">
                            <div class="box-title"><h4><?= Yii::t('app','Reviews to Write'); ?></h4></div>

                            <div class="box-border-content clearfix">

                                <div class="reviw-write">
                                    <div class="trust">                                                       
									<?php
									if(!empty($reviews))
									{
										foreach($reviews as $review)
										{

											$listid = $review->listid;
											$listdata = $review->getList()->where(['id'=>$listid])->one();
                      $listurl = base64_encode($listdata->id.'_'.rand(1,9999));
											$hostid = $listdata->userid;
											$hostdata = $listdata->getUser()->where(['id'=>$hostid])->one();
											$userimage = $hostdata->profile_image;
											if($userimage=="")
											$userimage = "usrimg.jpg";
											$userimage = Yii::$app->urlManager->createAbsoluteUrl('/albums/images/users/'.$userimage);
											$ressizeduserimage = Yii::$app->urlManager->createAbsoluteUrl ('resized.php?src='.$userimage.'&w=60&h=60');	
											$userurl = base64_encode($hostdata->id."-".rand(0,999));
											$usernameurl = Yii::$app->urlManager->createAbsoluteUrl ( '/profile/' . $userurl );
											echo '<div class="col-sm-12 no-hor-padding">';
											echo '<div class="text-center col-sm-2 margin_top20">';
											echo '<span class="airfcfx-user-icon profile_pict inlinedisplay margin_top20" style="background-image:url('.$ressizeduserimage.');"> </span>
											<a href="'.$usernameurl.'" class=" text_black margin_top10">'.$hostdata->firstname.'</a>';
											echo '</div>';
                      echo '<div class="margin_top20 col-sm-7" id="listname'.$review->reservationid.'">
                    <a href="'.Yii::$app->request->baseUrl.'/user/listing/view/'.$listurl.'" target="_blank" style="text-decoration:underline !important; font-size:16px;">'.$listdata->listingname.'</a>
                    </div>';
											echo '<div class="margin_top20 col-sm-7" id="review'.$review->reservationid.'">'.$review->review.'</div>';

          
											echo '<div class="margin_top20 col-sm-3" >
                      
											<span class="text-warning" id="rating_'.$review->id.'">';
											$rating = $review->rating;
											for($i=1;$i<=5;$i++)
											{	
												if($i<=$rating)
													echo '<i class="fa fa-star static-rating"></i>';
													//echo '<i class="fa fa-star-half-empty static-rating"></i> ';
												else
													echo '<i class="fa fa-star-o static-rating"></i>';
											}
											echo '</span>
											<a id="ur_reviewedit_'.$review->id.'" href="javascript:void(0);" data-toggle="modal" data-target="#reviewpopup"><i class="fa fa-pencil-white" onclick="edit_review('.$review->reservationid.', '.$review->rating.', '.$review->id.')"></i></a>
											</div>';
											echo '</div>';
										}
										echo '<div align="center" class="clear">';
										echo LinkPager::widget([
											'pagination' => $pages,
									   ]);
										
										echo '</div>';										
									}
									else
									{
										echo '<div class="col-sm-12 text-center"><h4>'.Yii::t('app','No reviews yet').'</h4></div>';
									}									
									?>
                                    </div>  
                                </div> <!--col-xs-12 end --> 
                              </div>
                            </div>                           
                          </div> <!--row end --> 
                      </div>
                      
                    </div>   <!--Panel end -->    
                                 
                                    
                </div> <!--#home end -->
                
                <div role="tabpanel" class="tab-pane" id="profile">
                
                	 <div class="panel panel-default margin_top20">
                      <div class="panel-heading profile_menu1">
                        <h3 class="panel-title"><?php echo Yii::t('app','Reviews to Write');?> </h3>
                      </div>
                      
                      <div class="panel-body">
                       <div class="row">                
                                <div class="col-xs-12">
                                    <div class="trust">                                                       
                                    <p><?php echo Yii::t('app','Nobody to review right now. Looks like it’s time for another trip!');?> </p>                                    
                                    </div>  
                                </div> <!--col-xs-12 end -->                            
                             </div> <!--row end -->
                      </div>
                      
                    </div>   <!--Panel end --> 
                    
                   <div class="panel panel-default margin_top20">
                      <div class="panel-heading profile_menu1">
                        <h3 class="panel-title"><?php echo Yii::t('app','Past Reviews You’ve Written');?></h3>
                      </div>
                      
                      <div class="panel-body">
                      
                      </div>
                      
                    </div>   <!--Panel end --> 
                   
                </div> <!--#profile end -->
                	
                </div>
            
            </div>
        
      </div> <!--col-sm-9 end -->
        
        
    </div> <!--container end -->
	</div>
  
<script>
$(document).ready(function(){    
    $(".show_ph").click(function(){
        $(".add_phone").show();
		$(".show_ph").hide();
    });
	$(".add_cont").click(function(){
        $(".add_contact").toggle();		
    });
	$(".add_ship").click(function(){
        $(".add_shipping").toggle();		
    });
});
</script>

<div class="modal fade" id="reviewpopup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog emergency_width" role="document">
    <div class="modal-content col-sm-12 no-hor-padding">
      <div class="modal-header no_border">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>        
      </div>
      <div class="modal-body">
            <?php $form = ActiveForm::begin(['id' => 'password-form','action' => '',
            ]); ?>
			<input type="hidden" id="tripid" value="">

			<div class="form-group">

          <div class="col-sm-12 no-hor-padding">
            
            <div class="editrating" style="display: none;">
              <div class="form-group">
                 <?php echo Yii::t('app','Ratings :');?>
                 <span class="text-warning margin_right5">
                 <i class="fa fa-star-o static-rating rating one cur" id="rateone" onclick="ratingClick('1');"></i>
                 <i class="fa fa-star-o static-rating rating two cur" id="ratetwo" onclick="ratingClick('2');"></i>
                 <i class="fa fa-star-o static-rating rating three cur" id="ratethree" onclick="ratingClick('3');"></i>
                 <i class="fa fa-star-o static-rating rating four cur" id="ratefour" onclick="ratingClick('4');"></i>
                 <i class="fa fa-star-o static-rating rating five cur" id="ratefive" onclick="ratingClick('5');"></i>
                 </span>
                 &nbsp;<span class="current-rate">0</span><?php echo Yii::t('app','Out of 5');?>
                 <?php echo '<a href="javascript:void(0);" onclick="javascript:cancelrating();">cancel</a>'; ?>
              </div>
            </div>

            <div class="viewrating">
              <div class="form-group">
              <?php
                  echo '<div id="ratingelement" ></div>';
              ?>
            </div>
          </div>

          <div class="col-sm-12 no-hor-padding">Your Review :</div>


          <div class="review description"> 
          <input type="hidden" name="ratings" id="ratings">
          <input type="hidden" name="putreviewid" id="putreviewid" >
            <textarea maxlength="180" class="form-control" id="reviewmsg" rows="3" cols="20" style="vertical-align: middle;"></textarea>
          </div>
			</div>

                <div class="form-group pull-right">
                    <input type="button" class="btn btn_email margin_top10 " id="revieweditbtn" onclick="reviewedit();" value="Save" >
                </div>

            <?php ActiveForm::end(); ?>
            <div id="reviewediterr" class="errcls"></div>
            </div>
           
    </div>
  </div>
</div>
</div>

<script type="text/javascript">
  function editrating()
  {
    $('.editrating').show();
    $('.viewrating').hide();
    return false;
  }

  function cancelrating()
  {
    $('.editrating').hide();
     $('.viewrating').show();
    return false;
  }
</script>