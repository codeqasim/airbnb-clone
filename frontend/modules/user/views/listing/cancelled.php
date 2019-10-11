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
$this->title = Yii::t('app','cancelled');
?>
<?php
$baseUrl = Yii::$app->request->baseUrl;

?>
<div class="profile_head">
	<div class="container">    
    	<ul class="profile_head_menu list-unstyled">
		<?php 
        echo '<li><a href="'.$baseUrl.'/dashboard">'.Yii::t('app','Dashboard').'</a></li>
        <li><a href="'.$baseUrl.'/user/messages/inbox/traveling">Inbox</a></li>
        <li><a href="'.$baseUrl.'/user/listing/mylistings">'.Yii::t('app','Listing').'</a></li>
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
	<div class="row">
    	
        <div class="col-xs-12 margin_top20 margin_bottom20">
        	<div class="col-sm-12">
                <div class="panel panel-default margin_top30">

                  <div class="panel-body padding10">



          		<?php echo "<center class='payment-success'><p>	Something went worng!</p>";
					echo "<p><span style='color:#B53A4A;'>Your payment was Cancelled, please try again.</span>.</p>";
					//echo "<p style='font-size:13px;'>You will receive a Email shortly from ".$setngs->noreplyname."</p>";	
					echo "</center>"
          
        				?>
     				   </div>  <!--Panel end -->       
       
    
        
      </div> <!--col-sm-9 end -->
        
    </div> <!--container end -->
</div>
</div>
</div>
</div>