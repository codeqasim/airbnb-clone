<?php

/*
 * This page displays the user verification information. User can verify their phone number and email here.
 *
 * @author: AK
 * @package: Views
 * @PHPVersion: 5.6
 */
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;
use frontend\models\Listing;
use backend\components\Myclass;

$this->title = 'Your Trips';
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
        <li class="active"><a href="'.$baseUrl.'/user/listing/trips">'.Yii::t('app','Trips').'</a></li>
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
        <div class="col-xs-12 col-sm-3 margin_top20">
        	<ul class="profile_left list-unstyled">
			<?php
			echo '<li class="active"><a href="'.$baseUrl.'/user/listing/trips" class="active">'.Yii::t('app','Your Trips').'</a></li>            
            <li><a href="'.$baseUrl.'/user/listing/previoustrips">'.Yii::t('app','Previous Trips').'</a></li>';
			?>         
            </ul>

        </div> <!--col-sm-3 end -->
        
        <div class="col-xs-12 col-sm-9 margin_top20">        
        
        <div class="airfcfx-panel panel panel-default">
          <div class="airfcfx-panel-padding airfcfx-panel panel-heading profile_menu1">
            <h3 class="panel-title"><?php echo Yii::t('app','Your Trips');?></h3>
          </div>
          
          <div class="panel-body">
            <div class="row">
				<?php
				if(!empty($trips))
				{
					echo '<div class="trips-cnt margin_top10 margin_bottom20 paddingleft table-responsive col-sm-12 col-lg-12">';
						echo '<table class="table table_no_border tripdesign">
                                	<thead>
                                      <tr class="review_tab">
                                        <th>'.Yii::t('app','Dates and Location').'</th>
										<th>'.Yii::t('app','Checkin Out Time').'</th> 
                                        <th>'.Yii::t('app','Options').'</th>
										<th>'.Yii::t('app','Review').'</th>
                                        <th>'.Yii::t('app','Status').'</th>
                                      </tr>
                                    </thead>';					
					foreach($trips as $trip)
					{
						//Check Cancel button or not
						$fromdate = $trip->fromdate;
						$todate = $trip->todate;

						$startdate = date('M,d,Y',$fromdate);
						$enddate = date('M,d,Y',$todate);

						$listdata = $trip->getList()->where(['id'=>$trip->listid])->one();

						$listinghours=explode('*|*',$listdata->pernight_availablity);

						if($listdata->pernight_availablity!="" && $listdata->pernight_availablity!=null)
						{
							$listinghours_start=date("h:i A", strtotime($listinghours[0]));
                     		$listinghours_end=date("h:i A", strtotime($listinghours[1]));
						}

						// Listing Timezone time
						$current_Timezone = Myclass::getTime($trip->timezone); 
						date_default_timezone_set('UTC');  

						$listurl = base64_encode($listdata->id.'_'.rand(1,9999));
						$hostdata = $trip->getHost()->where(['id'=>$trip->hostid])->one();
						$usrimg = $hostdata->profile_image;
						$currency = $listdata->getCurrency0()->where(['id'=>$listdata->currency])->one();
						if(!empty($currency))
							$currencysymbol = $currency->currencysymbol;
						else
							$currencysymbol = "";

						if($usrimg=="")
							$usrimg = "usrimg.jpg";

						$userimage = Yii::$app->urlManager->createAbsoluteUrl ( '/albums/images/users/'.$usrimg);
						$resized_userimage = Yii::$app->urlManager->createAbsoluteUrl ('resized.php?src='.$userimage.'&w=40&h=40');	
                            echo '<tr id="reserve_'.$trip->id.'" class="review_tab">';


						echo '<td class="wesetwidth"><div class="datetd"><label>'.Yii::t('app','Date :').'</label><span>'.$startdate.' - '.$enddate.'</span></div>';
							
						
						echo'<div class="datetd"><label>'.Yii::t('app','Location :').' </label><span>';
							if(isset($listdata->accesscode) && !empty($listdata->accesscode))
								echo $listdata->accesscode.', ';
							echo $listdata->streetaddress.', '.$listdata->city.',</span> <span>'.$listdata->state.','.$listdata->zipcode.'</span></div><div class="datetd"><label>'.Yii::t('app','Host :').' </label><span>'.$hostdata->firstname.' '.$hostdata->lastname.'</span></div>';


							echo '<p class="airfcfx-td-dtnloc-trp"><a class="text-danger" href="'.$baseUrl.'/user/listing/view/'.$listurl.'">'.$listdata->listingname.'</a></p>';

												
							if($trip->checkin!='0000-00-00 00:00:00' && $trip->checkout!='0000-00-00 00:00:00')
							{
								echo '<td>'.date("h:i A", strtotime($trip->checkin)).'<br/>'.date("h:i A", strtotime($trip->checkout)).'</td>'; 
							}
							else
							echo '<td>--</td>';
							echo '</td><td>';
							if($trip->bookstatus=="accepted" || $trip->bookstatus=="requested") {
								if(($trip->booking=="perhour" || $trip->booking=="pernight") && $trip->checkin!='0000-00-00 00:00:00' && $trip->checkout!='0000-00-00 00:00:00' && (strtotime($current_Timezone) < strtotime($trip->checkin))) {   
									
									echo '<input type="button" value="'.Yii::t('app','Cancel').'" id="cancel-btn_'.$trip->id.'" class="btn btn-danger" onclick="change_reserve_status(\'cancel\',\''.$trip->id.'\')"> <br/><img id="loadingimg'.$trip->id.'" src="'.$baseUrl.'/images/load.gif" class="msgLoader margin_top10">'; 

								} else {	 
									echo '--';
								} 
								
							}
							else
							echo '--';
							echo '</td>';
							$reviews = $trip->getReviews()->where(['reservationid'=>$trip->id])->one();
							$reserve_status = array('accepted','claimed');
							if(count($reviews)==0 && (in_array($trip->bookstatus,$reserve_status) || ($trip->bookstatus == "refunded" && strtolower($trip->cancelby) == "admin")))
							{ 
								if(strtotime($trip->checkout) < strtotime($current_Timezone))  
								{
									echo '<td align="center"><div id="reviewbtn'.$trip->id.'"><a href="javascript:void(0);" data-toggle="modal" data-target="#reviewpopup"><input type="button" value="'.Yii::t('app','Review').'" class="btn btn-danger" onclick="review_trip('.$trip->id.')"></a></div></td>'; 
								}
								else
								echo '<td align="center">--</td>'; 
							}
							else if(in_array($trip->bookstatus,$reserve_status) || ($trip->bookstatus == "refunded" && strtolower($trip->cancelby) == "admin")) 
							{
								$reviewurl = Yii::$app->urlManager->createAbsoluteUrl ( '/user/listing/reviewsbyyou' );
								echo '<td><a href="'.$reviewurl.'">View Review</a></td>';							
							} else {
								echo '<td align="center">--</td>'; 
							} 


							echo '<td class="airfcfx-min-width-80px">';
							if($trip->bookstatus!="")
							{
								echo '<p class="successtxt statustxt_'.$trip->id.'"><b>'.Yii::t('app',ucfirst($trip->bookstatus)).'</b></p>';
							}							
							echo '</td>';							
							echo '</tr>';
							$current_Timezone = "";
					}
					echo '</table>';
					echo '</div>';
				}
				else
				{
					echo '<div class="clearfix margin_top10 margin_bottom20">
                        <div class="col-xs-12 col-sm-6 ">
                        <p>'.Yii::t('app','You have no current trips.').'</p>
                        </div>

                        
                    </div> <!--col-xs-12 end -->';
				}
					?>
                          <?php
echo '<div align="center">';
 echo LinkPager::widget([
     'pagination' => $pages,
]);
 echo '</div>'
 ?>                 
                 </div> <!--row end -->

          </div>
          
        </div> <!--Panel end -->
        
         
        
        
        
    </div> <!--container end -->
	</div>
  
<style type="text/css">
	
</style>
<div class="modal fade" id="reviewpopup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog emergency_width" role="document">
    <div class="modal-content">
      <div class="modal-header no_border">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>        
      </div>
      <div class="modal-body">
            <?php $form = ActiveForm::begin(['id' => 'password-form','action' => '',
            ]); ?>
           
			<input type="hidden" id="tripid" value="">
			<div class="form-group margin_top15">
			<?php echo Yii::t('app','Your Ratings :');?>
			<span class="text-warning">
				<i class="fa fa-star-o static-rating rating one cur" id="rateone" onclick="ratingClick('1');"></i>
				<i class="fa fa-star-o static-rating rating two cur" id="ratetwo" onclick="ratingClick('2');"></i>
				<i class="fa fa-star-o static-rating rating three cur" id="ratethree" onclick="ratingClick('3');"></i>
				<i class="fa fa-star-o static-rating rating four cur" id="ratefour" onclick="ratingClick('4');"></i>
				<i class="fa fa-star-o static-rating rating five cur" id="ratefive" onclick="ratingClick('5');"></i>
			</span>
				&nbsp;<span class="current-rate">0</span> <?php echo Yii::t('app','Out of 5');?>
			 <div class="error_fun" id="errorBox"></div>
				</div>
				
			<div class="form-group">
				<?php echo Yii::t('app','Your Review :');?> <textarea class="form-control" maxlength="180" id="reviewmsg" rows="3" style="vertical-align: middle;"></textarea>
			 <div class="error_fun" id="errorBoxr"></div>
			</div>
                <div class="form-group text-center">
                    <input type="button" class="btn btn_email margin_top10" id="reviewsave" value="<?php echo Yii::t('app','Save');?>" onclick="savereview();">
                </div>
                

            <?php ActiveForm::end(); ?>
            </div>
           
    </div>
  </div>
</div>

<style type="text/css">
	.msgLoader { display: none;  }
</style>