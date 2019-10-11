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
$this->title = Yii::t('app','Account');
?>
<?php
$baseUrl = Yii::$app->request->baseUrl;

?>
  <div class="profile_head">
    <div class="container">    
      <ul class="profile_head_menu list-unstyled">
        <?php 
          echo '<li><a href="'.$baseUrl.'/dashboard">'.Yii::t('app','Dashboard').'</a></li>
          <li><a href="'.$baseUrl.'/user/messages/inbox">'.Yii::t('app','Inbox').'</a></li>
          <li><a href="'.$baseUrl.'/user/listing/mylistings">'.Yii::t('app','Listing').'</a></li>
          <li><a href="'.$baseUrl.'/dashboard">'.Yii::t('app','Trips').'</a></li>
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
              echo '<li class="active"><a href="'.$baseUrl.'/user/listing/notifications">'.Yii::t('app','Notifications').'</a></li>
                <li><a href="'.$baseUrl.'/user/listing/usernotifications">'.Yii::t('app','User Notifications').'</a></li>
                <li><a href="'.$baseUrl.'/changepassword">'.Yii::t('app','Security').'</a></li>
                <li><a href="'.$baseUrl.'/user/listing/completedtransaction">'.Yii::t('app','Transaction History').'</a></li>';
            ?>
          </ul>
             
        </div> <!--col-sm-3 end -->
        <form action="<?php $baseUrl.'/user/listings/notifications'; ?>" method="post">
          <div class="col-xs-12 col-sm-9 margin_top20">
          
            <div class="airfcfx-panel panel panel-default">
              <div class="airfcfx-panel airfcfx-panel-padding panel-heading profile_menu1">
                <h3 class="airfcfx-panel-title panel-title"><?php echo Yii::t('app','Mobile Notifications / Text Messages ');?></h3>
              </div>
              
              <div class="airfcfx-panel-padding panel-body ">
                <?php
                  $notifications = json_decode($userdata->notifications,true);
                  $emails = json_decode($userdata->emailsettings,true);

                /*
                <div class="row ">
                  <div class="col-xs-12 col-sm-4 ">
                    <h5 class="margin_top0">
                      <b><?php echo Yii::t('app','Text Messages');?></b>
                    </h5>                       
                    <p>
                      <?php echo Yii::t('app','Receive mobile updates by regular SMS text message.');?>
                    </p>
                  </div>
                  
                  <?php
                    echo '<input type="hidden" value="1" name="hidval">';
                    
                    if(empty($userdata->phoneno))
                    {
                      echo '<div class="col-xs-12 col-sm-8 ">
                              <p>'.Yii::t('app','You can add and verify phone numbers on your account from the').'<a class="text-danger" href="'.$baseUrl.'/editprofile"> '.Yii::t('app','Edit Profile').'</a> section.</p>
                          </div> ';
                    } else {
                      echo '<div class="col-xs-12 col-sm-8 ">';
                      if(isset($notifications['mobilenotify']) && $notifications['mobilenotify']==1)
                      echo '<input type="checkbox" name="mobilenotify" value="1" checked><b><div class="airfcfx-search-checkbox-text">'.Yii::t('app','Enable Text Message Notifications').'</div></b>';
                      else
                      echo '<input type="checkbox" name="mobilenotify" value="1"><b><div class="airfcfx-search-checkbox-text">'.Yii::t('app','Enable Text Message Notifications').'</div></b>';
                      echo '</div>';
                    }
                  ?>
                    
                </div> <!--row end --> 
                <hr/>   */ ?>
                
                <div class="row">
                  <div class="col-xs-12 col-sm-4">
                    <h5 class="margin_top0">
                      <b><?php echo Yii::t('app','Push Notifications');?></b>
                    </h5>                   
                    <p class="margin_bottom15">
                      <?php echo Yii::t('app','Receive Push Notifications to your iPhone, iPod Touch or Android device.');?>
                    </p>
                  </div>  
                  <div class="col-xs-12 col-sm-8">
                    <div class="airfcfx-margin-top checkbox margin_bottom20">
                      <label class="airfcfx-label">
                        <?php
                          if(isset($userdata->pushnotification) && $userdata->pushnotification==1)
                            echo '<input type="checkbox" name="pushnotify" value="1" checked> <div class="airfcfx-search-checkbox-text"><b>'.Yii::t('app','Enable Push Notifications').'</b></div>';
                          else
                            echo '<input type="checkbox" name="pushnotify" value="1"> <div class="airfcfx-search-checkbox-text"><b>'.Yii::t('app','Enable Push Notifications').'</b></div>';
                        ?>
                        <p>
                          <?php echo Yii::t('app','Download the');?> <?php echo $sitesettings->sitename;?> <?php echo Yii::t('app','App for iPhone, iPod Touch, or Android and receive advanced updates through Push Notifications instead of plain text messages.');
                          ?>
                        </p> 
                      </label>
                    </div>
                  </div>
                </div> <!--row end -->
                <hr />
                <div class="row margin_top30">
                  <div class="col-xs-12 col-sm-4">
                    <h5 class="margin_top0">
                      <b><?php echo Yii::t('app','Receive notifications for');?></b>
                    </h5>                   
                    <p>
                      <?php echo Yii::t('app','Applies to both text messages & push notifications.');?>
                    </p>
                  </div>  
                  <div class="col-xs-12 col-sm-8">
                    <div class="airfcfx-margin-top checkbox margin_bottom20">
                      <label class="airfcfx-label">
                        <?php
                          if(isset($notifications['messagenotify']) && $notifications['messagenotify']==1)
                            echo '<input type="checkbox" name="messagenotify" value="1" checked> <div class="airfcfx-search-checkbox-text"><b>'.Yii::t('app','Messages').'</b></div>';
                          else
                            echo '<input type="checkbox" name="messagenotify" value="1"> <div class="airfcfx-search-checkbox-text"><b>'.Yii::t('app','Messages').'</b></div>';
                        ?>
                        <?php echo Yii::t('app','From hosts and guests');?> 
                      </label>
                    </div>
                    <div class="airfcfx-margin-top checkbox margin_bottom20">
                      <label class="airfcfx-label">
                        <?php
                          if(isset($notifications['reservationnotify']) && $notifications['reservationnotify']==1)
                            echo '<input type="checkbox" name="reservationnotify" value="1" checked> <div class="airfcfx-search-checkbox-text"><b>'.Yii::t('app','Reservation Updates').'</b></div>';
                          else
                            echo '<input type="checkbox" name="reservationnotify" value="1"> <div class="airfcfx-search-checkbox-text"><b>'.Yii::t('app','Reservation Updates').'</b></div>';
                        ?>
                  
                        <?php echo Yii::t('app','Confirmations');?>
                      </label>
                    </div>
                              
                  </div>
                </div> <!--row end -->
              </div>
            </div> <!--Panel end -->
            
            <div class="airfcfx-panel panel panel-default">
              <div class="airfcfx-panel airfcfx-panel-padding panel-heading profile_menu1">
                <h3 class="airfcfx-panel-title panel-title">
                  <?php echo Yii::t('app','Email Settings');?> 
                </h3>
              </div>
          
              <div class="airfcfx-panel-padding panel-body">
                <div class="row ">
                  <div class="col-xs-12 col-sm-4">
                    <h4 class="margin_top0">
                      <b><?php echo Yii::t('app','I want to receive:');?></b>
                    </h4>                     
                    <p>
                      <?php echo Yii::t('app','You can disable these at any time.');?>
                    </p>
                  </div>  
                  
                  <div class="col-xs-12 col-sm-8">
                    <div class="checkbox margin_bottom20">
                      <label class="airfcfx-label">
                        <?php
                          if(isset($emails['reservationemail']) && $emails['reservationemail']==1)
                            echo '<input type="checkbox" name="reservationemail" value="1" checked>';
                          else
                            echo '<input type="checkbox" name="reservationemail" value="1">';
                        ?>
                        <div class="airfcfx-search-checkbox-text"><b><?php echo Yii::t('app','Reservations.');?></b></div>   
                      </label>
                    </div>                              
                  </div>
                </div> <!--row end -->
              </div>
              <div class="airfcfx-panel-footer panel-footer">
                <div class="text-right">
                  <button class="airfcfx-panel btn btn_email"><?php echo Yii::t('app','Save');?></button>
                </div>
              </div>
            </div>  <!--Panel end -->       
          </div> <!--col-sm-9 end -->
        </form>
    </div> <!--container end -->
  </div> 

