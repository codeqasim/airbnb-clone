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
use frontend\models\Listing; 
$this->title = 'Trust';
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
        <div class="col-xs-12 col-sm-3 margin_top20">
        	<ul class="profile_left list-unstyled">
			<?php
            echo '<li><a href="'.$baseUrl.'/editprofile" >'.Yii::t('app','Edit Profile').'</a></li> 
            <li><a href="'.$baseUrl.'/paysettings/default" >'.Yii::t('app','Stripe Host Account').'</a></li>           
            <li class="active"><a href="'.$baseUrl.'/trust" >'.Yii::t('app','Trust and Verification').'</a></li>
			<li><a href="'.$baseUrl.'/user/listing/reviewsbyyou" >'.Yii::t('app','Reviews').'</a></li>
';
			?>         
            </ul>
            <a href="<?php echo $baseUrl.'/profile/'.$username;?>"><button class="airfcfx-panel btn-border full-width btn btn_google margin_top20"><?php echo Yii::t('app','View Profile');?></button></a>
        </div> <!--col-sm-3 end -->
        
        <div class="col-xs-12 col-sm-9 margin_top20">        
        
        <div class="airfcfx-panel panel panel-default">
          <div class="airfcfx-panel airfcfx-panel-padding panel-heading profile_menu1">
            <h3 class="airfcfx-panel-title panel-title"><?php echo Yii::t('app','Add More Verifications');?></h3>
          </div>
          
          <div class="airfcfx-panel-padding panel-body">
            <div class="row">                
                	<div class="">
                    
                        <div class="col-xs-12 trust">
                        <h4 class="bold-font"><?php echo Yii::t('app','Email Address');?></h4>
						<?php
						if($userdata->emailverify==1)
						{
							 echo Yii::t('app','Your email address has been verified successfully.');
						}
						else
						{
						?>
                        <p class=""><?php echo Yii::t('app','Please verify your email address by clicking the link in the message we just sent to:');?> <?php echo $userdata->email; ?> <?php echo Yii::t('app','Can’t find our message? Check your spam folder or ');?>
                        <a href="#" onclick="sendtrustmail();" class="text-danger"><?php echo Yii::t('app','resend the confirmation email.');?></a> <?php
								echo '<img id="loadingimg" style="display:none;" class="loadingtrustmail" src="'.$baseUrl.'/images/load.gif" class="loading">';
								?>	</p>
                        <input type="hidden" value="<?php echo $userdata['email']; ?>" id="loguseridemail" />
						<?php
						}
						?>						
                        </div>	
                        <div id="succmsg"></div>

                        <div class="col-xs-12 trust margin_top20">
                        <h4 class="bold-font"><?php echo Yii::t('app','Phone Number');?></h4>                        
                        <p class=""><?php echo Yii::t('app','Make it easier to communicate with a verified phone number. We’ll send you a code by SMS or read it to you over the phone. Enter the code below to confirm that you’re the person on the other end.');?> </p> 
                        <br/>
                        </div>
						<?php
						if($userdata->mobileverify==1)
						{
							echo '<div class="col-xs-12 trust"><p>'. Yii::t('app','Number verified successfully.').'</p></div>';
						}
						else
						{
							$profileurl = Yii::$app->urlManager->createAbsoluteUrl ( '/editprofile#phoneverify');
							echo '<div class="col-xs-12 trust"><p><a href="'.$profileurl.'" class="airfcfx-red-icon">Verify your number</a></p></div>';
						}
						?>
                        
                        
                        <!--div class="col-xs-12 margin_top20">
                        	<p class="margin_bottom20 font_size13">No Phone Number entered</p>
                        	<div class="col-sm-12 show_ph" style="padding:0px;"><i class="fa fa-plus"></i> <a href="javascript:void(0);" class="font_size13"> Add a Phone Number</a></div>
                            
                                <div class="col-xs-12 col-sm-8 add_phone form-group  border1 padding10" style="display:none;">  
                                
                                <label>Choose a Country</label>
                                <select name="country" class="form-control countrydropdown" style="width:auto">
								<option value="0">Country</option>
								<?php
								foreach($countries as $key => $country)
								{
									echo '<option value="'.$country['id'].'">'.$country['countryname'].'</option>';
								}
								?>
                                </select>
                                
                                
                                <div class="margin_top10">
                                <label>Add a Phone Number</label>
                                <div class="input-group">
                                <span class="input-group-addon">+91</span>
                                <input type="text" class="form-control phonefldalgn" name="SignupForm[phoneno]" value="<?php echo $userdata['phoneno'];?>" placeholder="" style="width:auto;" />
                                </div>
                                </div>
                                
                                <div class="margin_top10">
                                <button class="btn btn_email">Verify via SMS</button>
                                <button class="btn btn_email">Verify via Call</button><br/>
                                <a href="#" class="text-danger pull-right"> Why Verify?</a>                                
                                </div>
                                
                                </div>
                                <br/>
                                
                             </div--> <!--col-xs-12 end -->
                    </div> <!--col-xs-12 end -->
                
                 </div> <!--row end -->

          </div>
          
        </div> <!--Panel end -->
        
         
        
        
        
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
