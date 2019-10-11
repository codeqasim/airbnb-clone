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
$this->title = 'Reservation Requirements';
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
        <li class="active"><a href="'.$baseUrl.'/user/listing/mylistings">'.Yii::t('app','Listing').'</a></li>
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

<div class="bg_gray1">
  <div class="container">    
        <div class="col-xs-12 col-sm-3 margin_top20 margin_bottom20">
        	<ul class="profile_left list-unstyled">
			<?php
			echo '<li><a href="'.$baseUrl.'/user/listing/mylistings">'.Yii::t('app','Active Listing').'</a></li>            
			<li><a href="'.$baseUrl.'/user/listing/pendinglistings">'.Yii::t('app','Pending Listing').'</a></li>
            <li><a href="'.$baseUrl.'/user/listing/reservations">'.Yii::t('app','Your Reservations').'</a></li>
			<li><a href="'.$baseUrl.'/user/listing/futurereservations">'.Yii::t('app','Unapproved Reservations').'</a></li>
			<li class="active"><a href="'.$baseUrl.'/user/listing/requirements" class="active">'.Yii::t('app','Reservation Requirements').'</a></li>';
           // echo '<li><a href="reservation_requirement.html">Reservation Requirements</a></li>  ';
			?>         
            </ul>
			<a href="<?php echo $baseUrl.'/user/listing/listcreate';?>">
            <button class="airfcfx-panel btn btn_dashboard margin_top20"><?php echo Yii::t('app','Add New Listings');?></button>
			</a>
        </div> <!--col-sm-3 end -->
        
        <div class="col-xs-12 col-sm-9 margin_top20">        
        
        <div class="panel panel-default">
          <div class="panel-heading airfcfx-panel-padding profile_menu1">
            <h3 class="panel-title"><?php echo Yii::t('app','Your Listings');?></h3>
          </div>

          <div class="airfcfx-panel-padding panel-body">
            <div class="">
				<?php

					$profileurl = Yii::$app->urlManager->createAbsoluteUrl ( '/editprofile#phoneverify');
					$trusturl = Yii::$app->urlManager->createAbsoluteUrl ( '/trust');
					echo '<div class="">
                        <div class="col-xs-12 col-sm-12 no-hor-padding">
                        <p>'.Yii::t('app','Your guests will need to verify their ID before booking with you.').'</p><br />

<p>'.Yii::t('app','Before you can require guests to verify their ID, you\'ll need to verify yours!').'</p><br />';
if($userdata->emailverify!="1" && $userdata->mobileverify!="1")
echo '<p>Verify your <a href="'.$profileurl.'" class="text-danger">Mobile Number</a> and <a href="'.$trusturl.'" class="text-danger">Email Id</a> to enable this requirement.</p>';
else if($userdata->mobileverify!="1")
echo '<p>Verify your <a href="'.$profileurl.'" class="text-danger">Mobile Number</a> to enable this requirement.</p>';
else if($userdata->emailverify!="1")
echo '<p>Verify your <a href="'.$trusturl.'" class="text-danger">Email Id</a> to enable this requirement.</p>';
                        echo '</div>

                        
                    </div> <!--col-xs-12 end -->';
					?>
					
					<br /><br /><br />

                 </div> <!--row end -->

          </div>
          
        </div> <!--Panel end -->
        
         
        
        
        
    </div> <!--container end -->
	</div>
  
