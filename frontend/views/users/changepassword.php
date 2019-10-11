<?php
/*
 * This page is for the user to change their password
 *
 * @author: Muthumareeswari
 * @package: Views
 * @PHPVersion: 5.4
 */
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use frontend\models\Listing;
$this->title = Yii::t('app','Change Password');
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
        <li><a href="'.$baseUrl.'/user/listing/mylistings">'.Yii::t('app','Listings').'</a></li>
        <li><a href="'.$baseUrl.'/user/listing/trips">'.Yii::t('app','Trips').'</a></li>
        <li><a href="'.$baseUrl.'/editprofile">'.Yii::t('app','Profile').'</a></li>
        <li class="active"><a href="'.$baseUrl.'/user/listing/notifications">'.Yii::t('app','Account').'</a></li>';
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
            echo '<li><a href="'.$baseUrl.'/user/listing/notifications">'.Yii::t('app','Notifications').'</a></li>
			<li><a href="'.$baseUrl.'/user/listing/usernotifications">'.Yii::t('app','User Notifications').'</a></li>
            <li class="active"><a href="'.$baseUrl.'/changepassword">'.Yii::t('app','Security').'</a></li>
			<li><a href="'.$baseUrl.'/user/listing/completedtransaction">'.Yii::t('app','Transaction History').'</a></li>';
			?>
            </ul>
           
        </div> <!--col-sm-3 end -->
        
        <div class="col-xs-12 col-sm-9 margin_top20">
        	
           
        	
            
       <div class="airfcfx-panel panel panel-default">
		<?php $form = ActiveForm::begin(['id' => 'changepassword-form',
		]); ?>		
          <div class="airfcfx-panel airfcfx-panel-padding panel-heading profile_menu1">
            <h3 class="airfcfx-panel-title panel-title"><?php echo Yii::t('app','Change Your Password');?>  </h3>
          </div>
          
          <div class="airfcfx-panel-padding change-paswrd panel-body">
            	<div class="row">

                        <div class="col-xs-12 margin_bottom10">
                            <label for="" class="col-sm-3 control-label text-right margin_top10"><?php echo Yii::t('app','Old Password'); ?></label>
                            <div class="col-sm-9">
<input type="hidden" value="<?php echo base64_decode($userdata['password']);?>" id="useroldpassword">
								<?= $form->field($model,'oldpassword')->passwordInput(['class'=>'form-control','style'=>'width:50%;','name'=>'oldpassword','id'=>'oldpassword'])->label(false);?>
                            </div>
                            
                          </div>
                          
                          <div class="col-xs-12 margin_bottom10">
                            <label for="" class="col-sm-3 control-label text-right margin_top10"><?php echo Yii::t('app','New Password');?></label>
                            <div class="col-sm-9">
                              <?= $form->field($model,'newpassword')->passwordInput(['class'=>'form-control','style'=>'width:50%;','name'=>'newpassword','id'=>'newpassword'])->label(false);?>
                            </div>
                          </div>
                          
                          <div class="col-xs-12 margin_bottom10">
                            <label for="" class="col-sm-3 control-label text-right margin_top10"><?php echo Yii::t('app','Confirm Password');?></label>
                            <div class="col-sm-9">
                              <?= $form->field($model,'confirmpassword')->passwordInput(['class'=>'form-control','style'=>'width:50%;','name'=>'confirmpassword','id'=>'confirmpassword'])->label(false);?>
                            </div>
                          </div>
  
                		
                        
                    </div> <!--row end -->
          </div>
          <div class="airfcfx-panel-footer panel-footer">
          	<div class="text-right"><button class="airfcfx-panel btn btn_email margin_top10 margin_bottom10"><?php echo Yii::t('app','Update Password');?></button></div>
          </div>
          <?php ActiveForm::end(); ?>
      </div>  <!--Panel end -->       
       

        <!-- div class="airfcfx-panel panel panel-default">

          <div class="airfcfx-panel airfcfx-panel-padding panel-heading profile_menu1">
            <h3 class="airfcfx-panel-title panel-title">Login History</h3>
          </div>

          <div class="airfcfx-panel-padding change-paswrd panel-body">
              <div class="table-responsive">
              <table id="login_history-table" class="table login_history-table">
                  <thead>
                    <tr>
                      <th>Browser/Device</th>
                      <th>Location</th>
                      <th>Recent Activity</th>
                      <th>&nbsp;</th>
                    </tr>
                  </thead>
                  <tbody>
                          <tr>
                            <td>
                              <ul class="list-unstyled">
                                <li>Firefox</li>
                                <li><span class="text-muted">Windows 10</span></li>
                              </ul>
                            </td>
                            <td> Madurai, TN, India</td>
                            <td>about 19 hours ago</td>
                            <td class="text-right">
                                <!-- Logout of Session >
                                <form id="logout-form" method="POST" action="/logout">
                                  <a href="#" class="submit-logout" title="Log Out"> Log Out</a>
                                </form> 
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <ul class="list-unstyled">
                                <li>Firefox</li>
                                <li><span class="text-muted">Windows 10</span></li>
                              </ul>
                            </td>
                            <td> Madurai, TN, India</td>
                            <td>6 months ago</td>
                            <td class="text-right">
                                <!-- Logout of Session >
                                <form id="logout-form" method="POST" action="/logout">
                                  <a href="#" class="submit-logout" title="Log Out"> Log Out</a>
                                </form> 
                            </td>
                          </tr>
                  </tbody>
                </table>
              </div>
          </div>

          <div class="chang-paswrd-if">
              <p class="">If you see something unfamiliar, <a href="#"> change your password</a>. </p>    
          </div>

        </div -->
       
      <!--div class="panel panel-default">
          <div class="panel-heading profile_menu1">
            <h3 class="panel-title">Login Notifications  </h3>
          </div>
          
          <div class="panel-body">
            	<div class="row margin_top10">
                		<div class="col-xs-12">                        
                        <div class="checkbox margin_bottom20">
                                <label>
                                  <input type="checkbox">   Turn on login notifications  
                                </label>
                              </div>
                        
                        <p>Login notifications are an extra security feature. When you turn them on, we’ll let you know when anyone logs into your Airbnb account from a new browser. This helps keep your account safe. </p>
                        </div>
                    </div> 
          </div>
          <div class="panel-footer">
          	<div class="text-right"><button class="btn btn_email  ">Save</button></div>
          </div>
          
      </div-->  <!--Panel end -->  
        
       
       
        
      </div> <!--col-sm-9 end -->
        
    </div> <!--container end -->


  
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
