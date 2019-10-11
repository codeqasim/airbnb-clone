 <?php
/*
 * This is for the user to save and edit their information
 *
 * @author: Muthumareeswari
 * @package: Views
 * @PHPVersion: 5.4
 */
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use frontend\models\Listing;
$this->title = 'Edit Profile';
?>
<?php
$baseUrl = Yii::$app->request->baseUrl;
//echo $userdata['firstname'];die;
$firstname = $userdata['firstname'];
$lastname = $userdata['lastname'];
$id = $userdata['id'];
$username = base64_encode($id."-".rand(0,999));
$digits = 4;
//str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
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
<?php $sitesetting = Yii::$app->mycomponent->getLogo(); ?>
        <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 margin_top20">
        	<ul class="profile_left list-unstyled">
			<?php
            echo '<li class="active"><a href="'.$baseUrl.'/editprofile" >'.Yii::t('app','Edit Profile').'</a></li> 
            <li><a href="'.$baseUrl.'/paysettings/default" >'.Yii::t('app','Stripe Host Account').'</a></li>           
            <li><a href="'.$baseUrl.'/trust" >'.Yii::t('app','Trust and Verification').'</a></li>
			<li><a href="'.$baseUrl.'/user/listing/reviewsbyyou" >'.Yii::t('app','Reviews').'</a></li>
            ';
			?>
            </ul>
            <a href="<?php echo $baseUrl.'/profile/'.$username;?>"><button class="airfcfx-panel btn-border full-width btn btn_google margin_top20"><?php echo Yii::t('app','View Profile');?></button></a>
        </div> <!--col-sm-3 end -->
        
        <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9 margin_top20">
			<?php
        	$form = ActiveForm::begin(['id' => 'form-edit','action'=>''.$baseUrl.'/editprofile',
        			//'enableAjaxValidation' => true,
        			//'enableClientValidation'=>true,
        			//'validateOnSubmit'=>true,
        	]);
									   ?>
            <div class="airfcfx-panel panel panel-default">
              <div class="airfcfx-panel airfcfx-panel-padding panel-heading profile_menu1">
                <h3 class="airfcfx-panel-title panel-title"><?php echo Yii::t('app','Required');?></h3>
              </div>
              
              <div class="airfcfx-panel-padding panel-body">
                <div class="row ">
                	<div class="col-xs-12 margin_top10">
                        <div class="col-xs-12 col-sm-3 text-right">
                        
                        <label class="profile_label"><?php echo Yii::t('app','First Name');?></label> 
                        </div>
                        <div class="col-xs-12 col-sm-9 no-hor-padding">
                         <?= $form->field($model, 'firstname')->textInput(['class' => 'form-control','name'=>'SignupForm[firstname]','placeholder'=>'First Name','maxlength'=>'30','value'=>''.$firstname.'','onkeypress'=>'return isAlpha(event)'])->label(false) ?>
                        </div>
                    </div> <!--col-xs-12 end -->
                    
                    <div class="col-xs-12 margin_top10 margin_bottom10">
                        <div class="col-xs-12 col-sm-3 text-right">
                        <label class="profile_label"><?php echo Yii::t('app','Last Name');?></label> 
                        </div>
                        <div class="col-xs-12 col-sm-9 no-hor-padding">
                        <?= $form->field($model, 'lastname')->textInput(['class' => 'form-control','name'=>'SignupForm[lastname]','placeholder'=>'Last Name','maxlength'=>'30','value'=>''.$lastname.'','onkeypress'=>'return isAlpha(event)'])->label(false) ?>
                        <p class="margin_top_5 text_gray1"><?php echo Yii::t('app','This is only shared once you have a confirmed booking with another '.$sitesetting->sitename.' user.');?></p>
                        </div>
                    </div> <!--col-xs-12 end -->
                    
                    <div class="col-xs-12 margin_top10">
                        <div class="col-xs-12 col-sm-3 text-right">
                        <label class="profile_label"><?php echo Yii::t('app','I Am');?><i class="fa fa-lock profile_icon" data-toggle="tooltip" data-placement="top" title="Private"></i> </label> 
                        </div>
                        <div class="col-xs-12 col-sm-9 no-hor-padding">
                        <select class="form-control" style="width:auto;" id="profile-gender" name="SignupForm[gender]">
						<?php
						if($userdata['gender']=='male')
						{
							echo '<option value="">'.Yii::t('app','Gender').'</option>
								  <option value="male" selected>'.Yii::t('app','Male').'</option>
								  <option value="female">'.Yii::t('app','Female').'</option>
								  <option value="other">'.Yii::t('app','Other').'</option>';
						}
						else if($userdata['gender']=='female')
						{
							echo '<option value="">'.Yii::t('app','Gender').'</option>
							      <option value="male">'.Yii::t('app','Male').'</option>
								  <option value="female" selected>'.Yii::t('app','Female').'</option>
								  <option value="other">'.Yii::t('app','Other').'</option>';
						}
						else if($userdata['gender']=='other')
						{
							echo '<option value="">'.Yii::t('app','Gender').'</option>
							      <option value="male">'.Yii::t('app','Male').'</option>
								  <option value="female">'.Yii::t('app','Female').'</option>
								  <option value="other" selected>'.Yii::t('app','Other').'</option>';
						}
						else
						{
							echo '<option value="" >'.Yii::t('app','Gender').'</option>
								  <option value="male">'.Yii::t('app','Male').'</option>
								  <option value="female">'.Yii::t('app','Female').'</option>
								  <option value="other">'.Yii::t('app','Other').'</option>';
						}
						?>
                        </select>
                        <p class="margin_top_5 text_gray1"><?php echo Yii::t('app','We use this data for analysis and never share it with other users.');?></p>
                        <div class="errcls" id="generr" style="clear: both;"></div><br/>
                        </div>
                    </div> <!--col-xs-12 end -->
                    
                    <div class="col-xs-12 margin_top10">
                        <div class="col-xs-12 col-sm-3 text-right">
                        <label class="profile_label"><?php echo Yii::t('app','Birth Date');?> <i class="fa fa-lock profile_icon" data-toggle="tooltip" data-placement="top" title="Private"></i> </label> 
                        </div>
                        <div class="airfcfx-profile-bd col-xs-12 col-sm-9 no-hor-padding">
							<?php
							$birthdate = $userdata['birthday'];

							if(isset($birthdate) && $birthdate!="")
							{
								$birthdate = explode("-",$birthdate);
							}
							else
							{
								$birthdate[0] = '0';
								$birthdate[1] = '0';
								$birthdate[2] = '0';
							}
							?>
                        <select class="form-control col-sm-4" style="width:55px;" name="SignupForm[month]">
						<?php
						if($birthdate[0] == "0")
						{
							echo '<option value="0">Month</option>';
							for($m=1;$m<=12;$m++)
							{
								echo '<option value="'.$m.'">'.$m.'</option>';
							}							
						}
						else
						{
							for($m=1;$m<=12;$m++)
							{	
								if($birthdate[0] == $m)
								{
									echo '<option value="'.$m.'" selected>'.$m.'</option>';
								}
								else
								{
									echo '<option value="'.$m.'">'.$m.'</option>';
								}
							}
						}
						?>
                        </select>
                        <select class="form-control col-sm-4 margin_left10" style="width:50px;" name="SignupForm[day]">
						<?php
						if($birthdate[1] == "0")
						{
							echo '<option value="0">Day</option>';
							for($d=1;$d<=31;$d++)
							{
								echo '<option value="'.$d.'">'.$d.'</option>';
							}
						}
						else
						{
							for($d=1;$d<=31;$d++)
							{
								if($birthdate[1] == $d)
								{
									echo '<option value="'.$d.'" selected>'.$d.'</option>';
								}
								else
								{
									echo '<option value="'.$d.'">'.$d.'</option>';
								}
							}
						}
						?>
                        </select>
                        <select class="form-control col-sm-4 margin_left10" style="width:65px;" name="SignupForm[year]">
						<?php
						if($birthdate[2] == "0")
						{
							echo '<option value="0000">Year</option>';
							for($i=2013;$i>1900;$i--){
								echo '<option value="'.$i.'"  >'.$i.'</option>';
							}
						}
						else
						{
							for($i=date('Y');$i>=1900;$i--){
							if($birthdate[2] == $i){ 
								echo '<option value="'.$i.'"  selected>'.$i.'</option>';
							}else{                 
								echo '<option value="'.$i.'"  >'.$i.'</option>';
								}
							}
						}
						?>
                        </select>
                        <br/><br/>
                        <p class="margin_top_5 text_gray1"><?php echo Yii::t('app','We use this data for analysis and never share it with other users.');?></p>
                        </div>
                    </div> <!--col-xs-12 end -->
                    
                    <div class="col-xs-12 margin_top10">
                        <div class="col-xs-12 col-sm-3 text-right">
                        <label class="profile_label"><?php echo Yii::t('app','Email Address ');?><i class="fa fa-lock profile_icon" data-toggle="tooltip" data-placement="top" title="Private"></i></label> 
                        </div>
                        <div class="col-xs-12 col-sm-9 no-hor-padding">
                        <input type="text" class="form-control " disabled="true" value="<?php echo $userdata['email'];?>" placeholder="" style="" />
                        <p class="margin_top_5 text_gray1"><?php echo Yii::t('app',"We won't share your private email address with other ".$sitesetting->sitename." users.");?> </p>
                        </div>
                    </div> <!--col-xs-12 end -->
                    
                    <!-- div class="col-xs-12 margin_top10">
                        <div class="col-xs-12 col-sm-3 text-right">
                        <label class="profile_label"><?php echo Yii::t('app','Paypal Id');?> <i class="fa fa-lock profile_icon" data-toggle="tooltip" data-placement="top" title="Private"></i></label> 
                        </div>
                        <div class="col-xs-12 col-sm-9 no-hor-padding">
                        <input type="text" class="form-control " name="SignupForm[paypalid]" value="<?php //if(isset($userdata['paypalid'])) echo $userdata['paypalid'];else echo '';?>" placeholder="" style="" id="paypalid" />
                        <div class="errcls" id="payerr" style="clear: both;"></div><br/>      
                        </div>        
                                  
                    </div --> <!--col-xs-12 end -->

                    <!-- Facebook account verification begins -->
                     <div class="col-xs-12 margin_top10">
                    		<div class="col-xs-12 col-sm-3 text-right">
                        <label class="profile_label"><?php echo Yii::t('app','Phone Number');?><i class="fa fa-lock profile_icon" data-toggle="tooltip" data-placement="top" title="Private"></i></label> 
                        </div>
                    		<?php 
                    			$sms_settings = json_decode($site_settings->smssettings, true);
	                    		$fb_appid = $sms_settings['facebook']['appid'];
	                    		$fb_secret = $sms_settings['facebook']['secret'];
	                    	?>
                    		<input type="hidden" name="fb_appid" id="fb_appid" value="<?php echo $fb_appid; ?>" >
								<input type="hidden" name="fb_secret" id="fb_secret" value="<?php echo $fb_secret; ?>">

								<input type="hidden" name="code" id="code">
								<input type="hidden" name="csrf_nonce" id="csrf_nonce">	

                    		<?php if($userdata->mobileverify !='1') { ?>					 
									<div class="change-pwd-btn col-xs-12 col-sm-9 no-hor-padding">										
										<a class="border-radius-5 primary-bg-color text-align-center" href="javascript:;" onclick="phone_btn_onclick();"><?php echo Yii::t('app','Verify via sms'); ?></a>
									</div>
								<?php } else { ?>
									<div class="col-xs-12 col-sm-9 no-hor-padding LRespPadT10">
									<?php echo Yii::t('app','Your mobile has been verified').' '.$userdata->verifyno; ?>
										<a class="border-radius-5 primary-bg-color text-align-center" href="javascript:;" onclick="phone_btn_onclick();"><?php echo Yii::t('app','Change'); ?></a>
									</div>
								<?php } ?>
                   	</div>               
                    
                    <?php /*<div class="col-xs-12 margin_top10">
                        <div class="col-xs-12 col-sm-3 text-right">
                        <label class="profile_label"><?php echo Yii::t('app','Phone Number');?><i class="fa fa-lock profile_icon" data-toggle="tooltip" data-placement="top" title="Private"></i></label> 
                        </div>
						<?php
						if($userdata->mobileverify!=1)
						{
							?>
						<div class="col-xs-12 col-sm-9 no-hor-padding" id="phoneverify">
							<input type="button" class="btn btn-danger" value="Generate Code" onclick="generate_code();">
							<br /><br />
							<?php
								if(isset($userdata->verifyno) && $userdata->verifyno!="")
								{
									echo '<div id="codeblock">
										<div id="codetext">Your generated code is '.$userdata->verifyno.'. Enter this code to verify.</div>
											<input type="text" value="" class="form-control smalltext" id="verifycode">
											<input type="button" value="Verify" class="btn btn_email" onclick="verify_code();">
											<div id="codesuccess" class="successtxt"></div>
											<div id="codeerror" class="errcls"></div>
										</div>';
								}
								else
								{
									echo '<div id="codeblock" class="hiddencls">
										<div id="codetext"></div>
											<input type="text" value="" class="form-control smalltext" id="verifycode">
											<input type="button" value="Verify" class="btn btn_email" onclick="verify_code();">
											<div id="codesuccess" class="successtxt"></div>
											<div id="codeerror" class="errcls"></div>
										</div>';
								}
							?>

						</div>
						<?php
						}
						else
						{
							echo '<div class="col-xs-12 col-sm-9">'.Yii::t('app','Verified').'</div>';
						}
						?>
                        <!--div class="col-xs-12 col-sm-9">
                        	<p class="margin_bottom20 text_gray1">No Phone Number entered</p>
                        	<div class="col-sm-12 show_ph"><i class="fa fa-plus"></i> <a href="javascript:void(0);" class="text-danger"> Add a Phone Number</a></div>
                            
                                <div class="col-sm-8 add_phone form-group  border1 padding10" style="display:none;">  
                                <div class="margin_top20">
                                <label>Choose a Country</label>
                                <select name="country" class="form-control">
								<option value="0">Country</option>
								<?php
								foreach($countries as $key => $country)
								{
									echo '<option value="'.$country['id'].'">'.$country['countryname'].'</option>';
								}
								?>
                                </select>
                                </div>
                                
                                <div class="margin_top10">
                                <label>Add a Phone Number</label>
                                <div class="input-group">
                                <span class="input-group-addon">+91</span>
                                <?= $form->field($model, 'phoneno')->textInput(['class'=>'form-control','value'=>$userdata['phoneno'],'name'=>'SignupForm[phoneno]'])->label(false); ?>
                                </div>
                                </div>
                                
                                <div class="margin_top10">
                                <button class="btn btn_email">Verify via SMS</button>
                                <button class="btn btn_email">Verify via Call</button><br/>
                                <a href="#" class="text-danger pull-right"> Why Verify?</a>                                
                                </div>
                                
                                </div>
                                <br/>
                                <div class="col-sm-12">
                                <p class="margin_top20 text_gray1">This is only shared once you have a confirmed booking with another Airbnb user. This is how we can all get in touch.</p>
                                </div>
                             </div-->
                            
                        </div>  */ ?>
                        
                        <div class="col-xs-12 margin_top10">
                            <div class="col-xs-12 col-sm-3 text-right">
                            <label class="profile_label"><?php echo Yii::t('app','State'); ?></label> 
                            </div>
                            <div class="col-xs-12 col-sm-9 no-hor-padding">
                            <?= $form->field($model, 'state')->textInput(['class'=>'form-control','name'=>'SignupForm[state]','value'=>$userdata['state']])->label(false); ?>
                            <!--p class="margin_top_5 text_gray1"><?php echo Yii::t('app',"We won't share your private email address with other ".$sitesetting->sitename." users.");?></p-->
                            </div>
                    	</div> <!--col-xs-12 end -->
                        
                         <div class="col-xs-12 margin_top10">
                            <div class="col-xs-12 col-sm-3 text-right">
                            <label class="profile_label"><?php echo Yii::t('app','Describe Yourself');?></label> 
                            </div>
                            <div class="col-xs-12 col-sm-9 no-hor-padding">
                            <?= $form->field($model, 'about')->textarea(['rows'=>'5','class'=>'form-control','name'=>'SignupForm[about]','value'=>''.$userdata['about'].''])->label(false); ?>
                            <p class="margin_top_5 text_gray1"><?php echo Yii::t('app',''.$sitesetting->sitename.' is built on relationships. Help other people get to know you.');?></p>
                            <p class=" text_gray1 margin_top10"><?php echo Yii::t('app','Tell them about the things you like: What are 5 things you can\'t live without? Share your favorite travel destinations, books, movies, shows, music, food.');?></p>
                            <p class=" text_gray1 margin_top10"><?php echo Yii::t('app','Tell them what it\'s like to have you as a guest or host: What\'s your style of traveling? Of '.$sitesetting->sitename.' hosting?');?></p>
                            <p class=" text_gray1 margin_top10"><?php echo Yii::t('app','Tell them about you: Do you have a life motto?');?></p>
                            </div>
                    	</div> <!--col-xs-12 end -->
                    
                </div> <!--row end -->
                
              </div>
              
            </div> <!--Panel end -->
            
        	<div class="airfcfx-panel panel panel-default">
              <div class="airfcfx-panel airfcfx-panel-padding panel-heading profile_menu1">
                <h3 class="airfcfx-panel-title panel-title"><?php echo Yii::t('app','Optional');?></h3>
              </div>
              
              <div class="airfcfx-panel-padding panel-body">
                <div class="row">
                	<div class="col-xs-12 margin_top10">
                            <div class="col-xs-12 col-sm-3 text-right">
                            <label class="profile_label"><?php echo Yii::t('app','School');?></label> 
                            </div>
                            <div class="col-xs-12 col-sm-9 no-hor-padding">
                             <?= $form->field($model, 'school')->textInput(['class'=>'form-control','name'=>'SignupForm[school]','value'=>''.$userdata['school'].''])->label(false); ?>
                            </div>
                    </div> <!--col-xs-12 end -->
                    
                    <div class="col-xs-12 margin_top10">
                            <div class="col-xs-12 col-sm-3 text-right">
                            <label class="profile_label"><?php echo Yii::t('app','Work');?></label> 
                            </div>
                            <div class="col-xs-12 col-sm-9 no-hor-padding">
                            <?= $form->field($model, 'work')->textInput(['class'=>'form-control','name'=>'SignupForm[work]','value'=>''.$userdata['work'].''])->label(false); ?>                            
                            </div>
                    </div> <!--col-xs-12 end -->
                    
                    <div class="col-xs-12 margin_top10">
                            <div class="col-xs-12 col-sm-3 text-right">
                            <label class="profile_label"><?php echo Yii::t('app','Time Zone');?></label> 
                            </div>
                            <div class="col-xs-12 col-sm-9 no-hor-padding">
                            <select class="airfcfx-timezone-dd form-control" stye="width:auto;" name="SignupForm[timezone]">
                            <option value="">--</option>
							<?php
							foreach($timezones as $timezone)
							{
								if($userdata->timezone==$timezone->timezone)
								echo '<option value="'.$timezone->timezone.'" selected>'.$timezone->timezone.'</option>';
								else
								echo '<option value="'.$timezone->timezone.'">'.$timezone->timezone.'</option>';
							}
							?>
                        <!--option value="International Date Line West">(GMT-11:00) International Date Line West</option>
                        <option value="Midway Island">(GMT-11:00) Midway Island</option>
                        <option value="Samoa">(GMT-11:00) Samoa</option>
                        <option value="Hawaii">(GMT-10:00) Hawaii</option>
                        <option value="Alaska">(GMT-09:00) Alaska</option>
                        <option value="America/Los_Angeles">(GMT-08:00) America/Los_Angeles</option>
                        <option value="Pacific Time (US &amp; Canada)">(GMT-08:00) Pacific Time (US &amp; Canada)</option>
                        <option value="Tijuana">(GMT-08:00) Tijuana</option>
                        <option value="America/Mazatlan">(GMT-07:00) America/Mazatlan</option>
                        <option value="America/Phoenix">(GMT-07:00) America/Phoenix</option>
                        <option value="Arizona">(GMT-07:00) Arizona</option>
                        <option value="Chihuahua">(GMT-07:00) Chihuahua</option>
                        <option value="Mazatlan">(GMT-07:00) Mazatlan</option>
                        <option value="Mountain Time (US &amp; Canada)">(GMT-07:00) Mountain Time (US &amp; Canada)</option>
                        <option value="America/Chicago">(GMT-06:00) America/Chicago</option>
                        <option value="Central America">(GMT-06:00) Central America</option>
                        <option value="Central Time (US &amp; Canada)">(GMT-06:00) Central Time (US &amp; Canada)</option>
                        <option value="Guadalajara">(GMT-06:00) Guadalajara</option>
                        <option value="Mexico City">(GMT-06:00) Mexico City</option>
                        <option value="Monterrey">(GMT-06:00) Monterrey</option>
                        <option value="Saskatchewan">(GMT-06:00) Saskatchewan</option>
                        <option value="America/Cancun">(GMT-05:00) America/Cancun</option>
                        <option value="America/New_York">(GMT-05:00) America/New_York</option>
                        <option value="America/Toronto">(GMT-05:00) America/Toronto</option>
                        <option value="Bogota">(GMT-05:00) Bogota</option>
                        <option value="Eastern Time (US &amp; Canada)">(GMT-05:00) Eastern Time (US &amp; Canada)</option>
                        <option value="Indiana (East)">(GMT-05:00) Indiana (East)</option>
                        <option value="Lima">(GMT-05:00) Lima</option>
                        <option value="Quito">(GMT-05:00) Quito</option>
                        <option value="Caracas">(GMT-04:30) Caracas</option>
                        <option value="Atlantic Time (Canada)">(GMT-04:00) Atlantic Time (Canada)</option>
                        <option value="Georgetown">(GMT-04:00) Georgetown</option>
                        <option value="La Paz">(GMT-04:00) La Paz</option>
                        <option value="Newfoundland">(GMT-03:30) Newfoundland</option>
                        <option value="America/Cordoba">(GMT-03:00) America/Cordoba</option>
                        <option value="America/Montevideo">(GMT-03:00) America/Montevideo</option>
                        <option value="America/Sao_Paulo">(GMT-03:00) America/Sao_Paulo</option>
                        <option value="Brasilia">(GMT-03:00) Brasilia</option>
                        <option value="Buenos Aires">(GMT-03:00) Buenos Aires</option>
                        <option value="Greenland">(GMT-03:00) Greenland</option>
                        <option value="Santiago">(GMT-03:00) Santiago</option>
                        <option value="Mid-Atlantic">(GMT-02:00) Mid-Atlantic</option>
                        <option value="Azores">(GMT-01:00) Azores</option>
                        <option value="Cape Verde Is.">(GMT-01:00) Cape Verde Is.</option>
                        <option value="Atlantic/Canary">(GMT+00:00) Atlantic/Canary</option>
                        <option value="Casablanca">(GMT+00:00) Casablanca</option>
                        <option value="Dublin">(GMT+00:00) Dublin</option>
                        <option value="Edinburgh">(GMT+00:00) Edinburgh</option>
                        <option value="Europe/Dublin">(GMT+00:00) Europe/Dublin</option>
                        <option value="Europe/London">(GMT+00:00) Europe/London</option>
                        <option value="Lisbon">(GMT+00:00) Lisbon</option>
                        <option value="London">(GMT+00:00) London</option>
                        <option value="Monrovia">(GMT+00:00) Monrovia</option>
                        <option value="UTC">(GMT+00:00) UTC</option>
                        <option value="Amsterdam">(GMT+01:00) Amsterdam</option>
                        <option value="Belgrade">(GMT+01:00) Belgrade</option>
                        <option value="Berlin">(GMT+01:00) Berlin</option>
                        <option value="Bern">(GMT+01:00) Bern</option>
                        <option value="Bratislava">(GMT+01:00) Bratislava</option>
                        <option value="Brussels">(GMT+01:00) Brussels</option>
                        <option value="Budapest">(GMT+01:00) Budapest</option>
                        <option value="Copenhagen">(GMT+01:00) Copenhagen</option>
                        <option value="Europe/Amsterdam">(GMT+01:00) Europe/Amsterdam</option>
                        <option value="Europe/Berlin">(GMT+01:00) Europe/Berlin</option>
                        <option value="Europe/Copenhagen">(GMT+01:00) Europe/Copenhagen</option>
                        <option value="Europe/Madrid">(GMT+01:00) Europe/Madrid</option>
                        <option value="Europe/Paris">(GMT+01:00) Europe/Paris</option>
                        <option value="Europe/Rome">(GMT+01:00) Europe/Rome</option>
                        <option value="Europe/Vienna">(GMT+01:00) Europe/Vienna</option>
                        <option value="Europe/Zagreb">(GMT+01:00) Europe/Zagreb</option>
                        <option value="Europe/Zurich">(GMT+01:00) Europe/Zurich</option>
                        <option value="Ljubljana">(GMT+01:00) Ljubljana</option>
                        <option value="Madrid">(GMT+01:00) Madrid</option>
                        <option value="Paris">(GMT+01:00) Paris</option>
                        <option value="Prague">(GMT+01:00) Prague</option>
                        <option value="Rome">(GMT+01:00) Rome</option>
                        <option value="Sarajevo">(GMT+01:00) Sarajevo</option>
                        <option value="Skopje">(GMT+01:00) Skopje</option>
                        <option value="Stockholm">(GMT+01:00) Stockholm</option>
                        <option value="Vienna">(GMT+01:00) Vienna</option>
                        <option value="Warsaw">(GMT+01:00) Warsaw</option>
                        <option value="West Central Africa">(GMT+01:00) West Central Africa</option>
                        <option value="Zagreb">(GMT+01:00) Zagreb</option>
                        <option value="Asia/Jerusalem">(GMT+02:00) Asia/Jerusalem</option>
                        <option value="Athens">(GMT+02:00) Athens</option>
                        <option value="Bucharest">(GMT+02:00) Bucharest</option>
                        <option value="Cairo">(GMT+02:00) Cairo</option>
                        <option value="Europe/Athens">(GMT+02:00) Europe/Athens</option>
                        <option value="Harare">(GMT+02:00) Harare</option>
                        <option value="Helsinki">(GMT+02:00) Helsinki</option>
                        <option value="Istanbul">(GMT+02:00) Istanbul</option>
                        <option value="Jerusalem">(GMT+02:00) Jerusalem</option>
                        <option value="Kyiv">(GMT+02:00) Kyiv</option>
                        <option value="Pretoria">(GMT+02:00) Pretoria</option>
                        <option value="Riga">(GMT+02:00) Riga</option>
                        <option value="Sofia">(GMT+02:00) Sofia</option>
                        <option value="Tallinn">(GMT+02:00) Tallinn</option>
                        <option value="Vilnius">(GMT+02:00) Vilnius</option>
                        <option value="Baghdad">(GMT+03:00) Baghdad</option>
                        <option value="Europe/Moscow">(GMT+03:00) Europe/Moscow</option>
                        <option value="Kuwait">(GMT+03:00) Kuwait</option>
                        <option value="Minsk">(GMT+03:00) Minsk</option>
                        <option value="Moscow">(GMT+03:00) Moscow</option>
                        <option value="Nairobi">(GMT+03:00) Nairobi</option>
                        <option value="Riyadh">(GMT+03:00) Riyadh</option>
                        <option value="St. Petersburg">(GMT+03:00) St. Petersburg</option>
                        <option value="Volgograd">(GMT+03:00) Volgograd</option>
                        <option value="Tehran">(GMT+03:30) Tehran</option>
                        <option value="Abu Dhabi">(GMT+04:00) Abu Dhabi</option>
                        <option value="Baku">(GMT+04:00) Baku</option>
                        <option value="Muscat">(GMT+04:00) Muscat</option>
                        <option value="Tbilisi">(GMT+04:00) Tbilisi</option>
                        <option value="Yerevan">(GMT+04:00) Yerevan</option>
                        <option value="Kabul">(GMT+04:30) Kabul</option>
                        <option value="Ekaterinburg">(GMT+05:00) Ekaterinburg</option>
                        <option value="Islamabad">(GMT+05:00) Islamabad</option>
                        <option value="Karachi">(GMT+05:00) Karachi</option>
                        <option value="Tashkent">(GMT+05:00) Tashkent</option>
                        <option value="Asia/Calcutta">(GMT+05:30) Asia/Calcutta</option>
                        <option value="Chennai">(GMT+05:30) Chennai</option>
                        <option value="Kolkata">(GMT+05:30) Kolkata</option>
                        <option value="Mumbai">(GMT+05:30) Mumbai</option>
                        <option value="New Delhi">(GMT+05:30) New Delhi</option>
                        <option value="Sri Jayawardenepura">(GMT+05:30) Sri Jayawardenepura</option>
                        <option value="Kathmandu">(GMT+05:45) Kathmandu</option>
                        <option value="Almaty">(GMT+06:00) Almaty</option>
                        <option value="Astana">(GMT+06:00) Astana</option>
                        <option value="Dhaka">(GMT+06:00) Dhaka</option>
                        <option value="Novosibirsk">(GMT+06:00) Novosibirsk</option>
                        <option value="Urumqi">(GMT+06:00) Urumqi</option>
                        <option value="Rangoon">(GMT+06:30) Rangoon</option>
                        <option value="Asia/Bangkok">(GMT+07:00) Asia/Bangkok</option>
                        <option value="Asia/Jakarta">(GMT+07:00) Asia/Jakarta</option>
                        <option value="Asia/Vientiane">(GMT+07:00) Asia/Vientiane</option>
                        <option value="Bangkok">(GMT+07:00) Bangkok</option>
                        <option value="Hanoi">(GMT+07:00) Hanoi</option>
                        <option value="Jakarta">(GMT+07:00) Jakarta</option>
                        <option value="Krasnoyarsk">(GMT+07:00) Krasnoyarsk</option>
                        <option value="Asia/Makassar">(GMT+08:00) Asia/Makassar</option>
                        <option value="Asia/Taipei">(GMT+08:00) Asia/Taipei</option>
                        <option value="Beijing">(GMT+08:00) Beijing</option>
                        <option value="Chongqing">(GMT+08:00) Chongqing</option>
                        <option value="Hong Kong">(GMT+08:00) Hong Kong</option>
                        <option value="Irkutsk">(GMT+08:00) Irkutsk</option>
                        <option value="Kuala Lumpur">(GMT+08:00) Kuala Lumpur</option>
                        <option value="Perth">(GMT+08:00) Perth</option>
                        <option value="Singapore">(GMT+08:00) Singapore</option>
                        <option value="Taipei">(GMT+08:00) Taipei</option>
                        <option value="Ulaan Bataar">(GMT+08:00) Ulaan Bataar</option>
                        <option value="Asia/Seoul">(GMT+09:00) Asia/Seoul</option>
                        <option value="Asia/Tokyo">(GMT+09:00) Asia/Tokyo</option>
                        <option value="Osaka">(GMT+09:00) Osaka</option>
                        <option value="Sapporo">(GMT+09:00) Sapporo</option>
                        <option value="Seoul">(GMT+09:00) Seoul</option>
                        <option value="Tokyo">(GMT+09:00) Tokyo</option>
                        <option value="Yakutsk">(GMT+09:00) Yakutsk</option>
                        <option value="Adelaide">(GMT+09:30) Adelaide</option>
                        <option value="Australia/Darwin">(GMT+09:30) Australia/Darwin</option>
                        <option value="Darwin">(GMT+09:30) Darwin</option>
                        <option value="Australia/Brisbane">(GMT+10:00) Australia/Brisbane</option>
                        <option value="Australia/Hobart">(GMT+10:00) Australia/Hobart</option>
                        <option value="Australia/Sydney">(GMT+10:00) Australia/Sydney</option>
                        <option value="Brisbane">(GMT+10:00) Brisbane</option>
                        <option value="Canberra">(GMT+10:00) Canberra</option>
                        <option value="Guam">(GMT+10:00) Guam</option>
                        <option value="Hobart">(GMT+10:00) Hobart</option>
                        <option value="Magadan">(GMT+10:00) Magadan</option>
                        <option value="Melbourne">(GMT+10:00) Melbourne</option>
                        <option value="Pacific/Guam">(GMT+10:00) Pacific/Guam</option>
                        <option value="Port Moresby">(GMT+10:00) Port Moresby</option>
                        <option value="Solomon Is.">(GMT+10:00) Solomon Is.</option>
                        <option value="Sydney">(GMT+10:00) Sydney</option>
                        <option value="Vladivostok">(GMT+10:00) Vladivostok</option>
                        <option value="New Caledonia">(GMT+11:00) New Caledonia</option>
                        <option value="Auckland">(GMT+12:00) Auckland</option>
                        <option value="Fiji">(GMT+12:00) Fiji</option>
                        <option value="Kamchatka">(GMT+12:00) Kamchatka</option>
                        <option value="Marshall Is.">(GMT+12:00) Marshall Is.</option>
                        <option value="Pacific/Fiji">(GMT+12:00) Pacific/Fiji</option>
                        <option value="Wellington">(GMT+12:00) Wellington</option>
                        <option value="Nuku'alofa">(GMT+13:00) Nuku'alofa</option-->
                        </select>                            
                            </div>
                    </div> <!--col-xs-12 end -->
                    
                    <div class="col-xs-12 margin_top10">
                            <div class="col-xs-12 col-sm-3 text-right">
                            	<label class="padding0 profile_label"><?php echo Yii::t('app',"Language");?></label> 
                            </div>
                            <div class="col-xs-12 col-sm-9 no-hor-padding">    
                            <?php
                            echo '<div class="language-hold">';
                            if(!empty($userdata->language))
                            {
                            	$decode_languages = json_decode($userdata->language);
                            	foreach($decode_languages as $language)
                            	{
                            		echo '<div class="eachlanguage">'.ucwords($language->name).'</div>';
                            	}
                            }
                            echo '</div>';
                            echo '<div style="clear:both;"></div>';
                            ?>
                            <div class="margin_top10">
                            <a href="#" data-toggle="modal" data-target="#myModal" class=""><i class="fa fa-plus-circle "></i> <?php echo Yii::t('app','Add More');?></a>  </div>
                            <p class="text_gray1 margin_bottom10"><?php echo Yii::t('app','Add languages you speak.');?></p>                     
                            </div>
                    </div> <!--col-xs-12 end -->
                    
                    <div class="col-xs-12 margin_top10">
                        <div class="col-xs-12 col-sm-3 text-right">
                        <label class="padding0 profile_label"><?php echo Yii::t('app','Emergency Contact');?> <i class="fa fa-lock profile_icon" data-toggle="tooltip" data-placement="top" title="Private"></i></label> 
                        </div>
                        <div class="col-xs-12 col-sm-9 no-hor-padding">
                        <?php
							if($userdata['emergencyname'] != '')
							{
								echo $userdata['emergencyname'].' ('.$userdata['emergencyrelation'].')';
							} 
						?>
                        <a href="javascript:void(0);" class=" add_cont" > <i class="fa fa-plus-circle "></i> <?php 
                        	if($userdata['emergencyname'] == '')
                        	{
                        		echo Yii::t('app','Add Contact');
                        	}else{
                        		echo Yii::t('app','Edit Contact');
                        	}
                        
                        ?></a>
                        <p class="margin_top_5 text_gray1"><?php echo Yii::t('app','Give our Customer Experience team a trusted contact we can alert in an urgent situation.');?></p>
                        </div>
                        
                    </div> <!--col-xs-12 end -->
                    
                     <div class="row add_contact" style="display:none;">
                        	<div class="col-xs-12 margin_top10">
                                <div class="col-xs-12 col-sm-3 text-right">
                                <label class="profile_label"><?php echo Yii::t('app','Name');?></label> 
                                </div>
                                <div class="col-xs-12 col-sm-9 no-hor-padding">
                                <?= $form->field($model, 'emergencyname')->textInput(['class'=>'form-control','name'=>'SignupForm[emergencyname]','value'=>''.$userdata['emergencyname'].''])->label(false); ?>
                                </div>
                            </div> <!--col-xs-12 end -->
                    
                            <div class="col-xs-12 margin_top10">
                                <div class="col-xs-12 col-sm-3 text-right">
                                <label class="profile_label"><?php echo Yii::t('app','Phone');?></label> 
                                </div>
                                <div class="col-xs-12 col-sm-9 no-hor-padding">
                                <?= $form->field($model, 'emergencyno')->textInput(['class'=>'form-control','name'=>'SignupForm[emergencyno]','value'=>''.$userdata['emergencyno'].'','onkeypress'=>'return isNumber(event)'])->label(false); ?>
                                </div>
                            </div> <!--col-xs-12 end -->
                            
                            <div class="col-xs-12 margin_top10">
                                <div class="col-xs-12 col-sm-3 text-right">
                                <label class="profile_label"><?php echo Yii::t('app','Email');?></label> 
                                </div>
                                <div class="col-xs-12 col-sm-9 no-hor-padding">
                                <?= $form->field($model, 'emergencyemail')->textInput(['class'=>'form-control','name'=>'SignupForm[emergencyemail]','value'=>''.$userdata['emergencyemail'].''])->label(false); ?>
                                </div>
                            </div> <!--col-xs-12 end -->
                    
                            <div class="col-xs-12 margin_top10">
                                <div class="col-xs-12 col-sm-3 text-right">
                                <label class="profile_label"><?php echo Yii::t('app','Relationship');?></label> 

                                </div>
                                <div class="col-xs-12 col-sm-9 no-hor-padding">
                                <?= $form->field($model, 'emergencyrelation')->textInput(['class'=>'form-control','name'=>'SignupForm[emergencyrelation]','value'=>''.$userdata['emergencyrelation'].''])->label(false); ?>
                                </div>
                            </div> <!--col-xs-12 end -->
                        </div> <!--add_contact end -->
                    
                    <div class="col-xs-12 margin_top10">
                            <div class="col-xs-12 col-sm-3 text-right">
                            <label class="padding0 profile_label"><?php echo Yii::t('app','Residence Address');?></label>  
                            </div>
                            <div class="col-xs-12 col-sm-9 no-hor-padding">                               
                            <?php
                            	$residenceAddress = "";
                            	if(trim($shipping['address1'])!="")
                            		$residenceAddress = trim($shipping['address1']);

                            	$residenceAddress = (trim($shipping['city'])!="" && $residenceAddress!="") ? $residenceAddress.", ".trim($shipping['city']) : trim($shipping['city']);

                            	$residenceAddress = (trim($shipping['state'])!="" && $residenceAddress!="") ? $residenceAddress.", ".trim($shipping['state']) : trim($shipping['state']);

                            	$residenceAddress = (trim($shipping['zipcode'])!="" && $residenceAddress!="") ? $residenceAddress.", ".trim($shipping['zipcode']) : trim($shipping['zipcode']);

                            	echo ucwords($residenceAddress);
                            ?>
                            <a href="javascript:void(0);" class="add_ship" > <i class="fa fa-plus-circle"></i> <?php
                            	//echo '<pre>'; print_r($shipping); exit;
                            if(!empty($shipping))
                            {
                            	echo Yii::t('app','Edit');
                            }else{
                            	echo Yii::t('app','Add');
                            }
                            ?></a>
                                <div class="row add_shipping padding10" style="display:none;">


                                <?php
									if(isset($shipping['address1']))
									$addr1 = $shipping['address1'];
									else
									$addr1 = "";
									if(isset($shipping['address2']))
									$addr2 = $shipping['address2'];
									else
									$addr2 = "";
									if(isset($shipping['city']))
									$city = $shipping['city'];
									else
									$city = "";
									if(isset($shipping['state']))
									$state = $shipping['state'];
									else
									$state = "";
									if(isset($shipping['zipcode']))
									$zipcode = $shipping['zipcode'];
									else
									$zipcode = "";
									if(isset($shipping['country']))
									$countryid = $shipping['country'];
									else
									$countryid = "0";
								?>
                                <div class="">
                                <label><?php echo Yii::t('app','Country');?></label>
                                <select name="Shippingaddress[country]" class="airfcfx-timezone-dd form-control">
								<option value="0"><?php echo Yii::t('app','Country');?></option>
								<?php
								foreach($countries as $key => $country)
								{
									if($countryid == $country['id'])
									echo '<option value="'.$country['id'].'" selected>'.$country['countryname'].'</option>';
									else
									echo '<option value="'.$country['id'].'">'.$country['countryname'].'</option>';
								}
								?>
                                </select>
                                </div>								
                                <div class=" margin_top10 ">
                                <div class="col-xs-12 col-sm-6" style="padding:0px;">
                                <label class="profile_label"><?php echo Yii::t('app','Address Line1');?></label>       
                                <?= $form->field($shipping, 'address1')->textInput(['class'=>'form-control margin_bottom10','name'=>'Shippingaddress[address1]','value'=>''.$addr1.''])->label(false); ?>                          
                                </div>
                                <div class="col-xs-12 col-sm-5 margin_left20 address2" style="padding:0px;">
                                <label class="profile_label"><?php echo Yii::t('app','Address Line2');?></label>                                 
                                <?= $form->field($shipping, 'address2')->textInput(['class'=>'form-control margin_bottom10','name'=>'Shippingaddress[address2]','value'=>''.$addr2.''])->label(false); ?>
                                </div>
                                </div>
                                
                                <div class="margin_top10">                                    
                                    <label class="profile_label"><?php echo Yii::t('app','City / Town / District');?></label>
                                    <?= $form->field($shipping, 'city')->textInput(['class'=>'form-control margin_bottom10','name'=>'Shippingaddress[city]','value'=>''.$city.''])->label(false); ?>                                     
                            	</div> <!--col-xs-12 end -->
                                
                                <div class=" margin_top10">                                    
                                    <label class="profile_label"><?php echo Yii::t('app','State / Province / County / Region');?></label>  
                                    <?= $form->field($shipping, 'state')->textInput(['class'=>'form-control margin_bottom10','name'=>'Shippingaddress[state]','value'=>''.$state.''])->label(false); ?>                                   
                            	</div> <!--col-xs-12 end -->
                                
                                <div class=" margin_top10">                                    
                                    <label class="profile_label"><?php echo Yii::t('app','ZIP / Postal Code');?></label>
                                    <?= $form->field($shipping, 'zipcode')->textInput(['class'=>'form-control margin_bottom10','name'=>'Shippingaddress[zipcode]','value'=>''.$zipcode.'','onkeypress'=>'return isNumber(event)'])->label(false); ?>                                     
                            	</div> <!--col-xs-12 end -->
                                
                                <div class="text-center">
                                	<button class="btn btn_email airfcfx-panel pull-right" data-toggle="tooltip" data-placement="bottom" title="Please enter your address to continue"><?php echo Yii::t('app','Save');?></button>
                                </div>
                               
                                </div>
                            </div>
                    </div> <!--col-xs-12 end -->
                    
              </div> <!--row end -->
              </div>
              
            </div> <!--Panel end -->
            
      <?php /* <div class="panel panel-default">
          <div class="panel-heading profile_menu1">
            <h3 class="panel-title">Business Travel</h3>
          </div>
          
          <div class="panel-body">
            <div class="row">
                
                	<div class="col-xs-12 margin_top10">
                        <div class="col-xs-12 col-sm-3 text-right">
                        <label class="profile_label">Work Email Address <i class="fa fa-lock profile_icon" data-toggle="tooltip" data-placement="top" title="Private"></i></label> 
                        </div>
                        <div class="col-xs-12 col-sm-9">
                        <a href="#" class="text-danger add_cont" > <i class="fa fa-plus text-danger"></i> Add Work Email</a>
                        <p class="margin_top_5 text_gray1">We won't share your private email with other Airbnb users.</p>
                        </div>
                        
                    </div> <!--col-xs-12 end -->
                
                 </div> <!--row end -->
          </div>
          
      </div>  <!--Panel end -->   */ ?>   
       
        
        <div class="form-group">
            <?= Html::submitButton(Yii::t('app','Submit'), ['class' => 'pull-right airfcfx-panel btn btn_email margin_bottom20','onclick' => 'return edit_profile();']) ?>
        </div>
    
      </div> <!--col-sm-9 end -->
        
    </div> <!--container end -->
</div>
	
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content profile_popup">
      <div class="modal-header profile_menu1">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?php echo Yii::t('app','Spoken Languages');?></h4>
      </div>
      <div class="modal-body">
        <p class="text_gray1"><?php echo Yii::t('app','What languages can you speak fluently? We have many international travelers who appreciate hosts who can speak their language.');?></p>
        <div class="row">
        
            <div class="col-xs-12 col-sm-6"> 
                       <?php
					   foreach($languages as $language)
					   {
					   		if(isset($userdata->language) && !empty($userdata->language))
					   		{
					   			$userlanguages = json_decode($userdata->language,true);
						   		$user_languages = [];
						   		foreach ($userlanguages as $key => $value) {
						   			$user_languages[] = $value['name'];
						   		}
					   		}

							echo '<div class="checkbox padd_5_10">
		                      <label class="text_gray1">';
		                      if(!empty($userlanguages))
		                      {
		                      	if(in_array($language->languagename, $user_languages))
		                      	{
		                        	echo '<input type="checkbox" id="myLanguages" checked value="'.$language->languagename.'" name="SignupForm[userlanguages][]">';
		                        }
		                    	else
		                    	{
		                    		echo '<input type="checkbox" id="myLanguages" value="'.$language->languagename.'" name="SignupForm[userlanguages][]">';
		                    	}
		                      }
		                      else
		                      {
		                      	echo '<input type="checkbox" value="'.$language->languagename.'" name="SignupForm[userlanguages][]">';
		                      }
		                        echo '<div class="airfcfx-search-checkbox-text">'.$language->languagename.'</div>
		                      </label>
		                    </div> <!-- Checkbox end -->';
					   }
					   ?>


                    
            </div> <!-- col-sm-6 end -->
            
            <div class="col-xs-12 col-sm-6 join-text-mobile"> 

                     <!-- Checkbox end -->
                    
            </div> <!-- col-sm-6 end -->
            
        </div> <!-- row end -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-border btn_google" data-dismiss="modal"><?php echo Yii::t('app','Cancel');?></button>
        <button type="button" class="btn btn_email" onclick="saveLanuges();" data-dismiss="modal"><?php echo Yii::t('app','Save');?></button>
      </div>
    </div>
  </div>
</div>	
	<?php ActiveForm::end(); ?>
<script>
$(document).ready(function(){   
$('#form-edit').on('keyup keypress', function(e) {
  var keyCode = e.keyCode || e.which;
  if (keyCode === 13) { 
    e.preventDefault();
    return false;
  }
});

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

function saveLanuges()
{
	var checkboxes = document.getElementsByName('SignupForm[userlanguages][]');
	var vals = "";
	for (var i=0, n=checkboxes.length;i<n;i++) 
	{
		if (checkboxes[i].checked) 
		{
		    vals += '<div class="eachlanguage">'+checkboxes[i].value+'</div>';
		}
	}

	//if (vals) vals = vals.substring(1);
	//var languages = vals.split(',');
	$('.language-hold').html(vals);
}
</script>


<script src="https://sdk.accountkit.com/en_EN/sdk.js"></script>

<script type="text/javascript">

  // initialize Account Kit with CSRF protection
  AccountKit_OnInteractive = function(){
   var appid = document.getElementById("fb_appid").value;
          //alert(secret);
   AccountKit.init({       
     appId:appid,         
     state:"91", 
     version:"v1.0"
   });
  };

  // login callback
  function loginCallback(response) {
    console.log(response);
    if (response.status === "PARTIALLY_AUTHENTICATED") {
      var codes = document.getElementById("code").value = response.code;
      var nonce =  document.getElementById("csrf_nonce").value = response.state;
      
      $.ajax({
        type : 'POST',
        url : baseurl + '/mobileverificationstatus',
        data : {'code': codes, 'csrf_nonce': nonce},
        success : function(data) {
            //alert(data);
            location.reload();
        }
      });
      //document.getElementById("my_form").submit();
    }
    else if (response.status === "NOT_AUTHENTICATED") {
      // handle authentication failure
      console.log("Authentication failure");
    }
    else if (response.status === "BAD_PARAMS") {
      // handle bad parameters
      console.log("Bad parameters");
    }
  }
  	// phone form submission handler
  	function phone_btn_onclick() {
		// you can add countryCode and phoneNumber to set values
		var secret = document.getElementById("fb_secret").value;
		var appid = document.getElementById("fb_appid").value;
      
      if(secret != '' && appid != '' ) {

        AccountKit.login('PHONE', {},loginCallback);
		}
		else
		{
		  $('.mobile-error').css('display','inline-block');
		  $('.mobile-error').html(Yii.t('app','Please provide the correct app id and secret id'));
		  return false;
		}    
  }
  
</script>




<style type="text/css">
.field-profile-phoneno
{
	display:inline;
}
.help-block-error{
	clear: both;
}
.eachlanguage{
	padding: 5px;
	float: left;
}
</style>
