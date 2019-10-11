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
use frontend\models\Currency;
use backend\components\Myclass;

$this->title = 'Your Future Reservations';
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
			<li class="active"><a href="'.$baseUrl.'/user/listing/futurereservations" class="active">'.Yii::t('app','Unapproved Reservations').'</a></li>
			<li><a href="'.$baseUrl.'/user/listing/requirements" class="active">'.Yii::t('app','Reservation Requirements').'</a></li>';
            //echo '<li><a href="reservation_requirement.html">Reservation Requirements</a></li>';
			?>         
            </ul>
			<a href="<?php echo $baseUrl.'/user/listing/listcreate';?>">
            <button class="btn btn_dashboard margin_top20"><?php echo Yii::t('app','Add New Listings');?></button>
			</a>
        </div> <!--col-sm-3 end -->
        
        <div class="col-xs-12 col-sm-9 margin_top20">        
        
        <div class="airfcfx-panel panel panel-default">
          <div class="airfcfx-panel airfcfx-panel-padding panel-heading profile_menu1">
            <h3 class="panel-title"><?php echo Yii::t('app','Your Future Reservations');?></h3>
          </div>
          
          <div class="airfcfx-panel-padding panel-body">
            <div class="airfcfx-full-width-div">
				<?php
				if(!empty($reservations))
				{
					echo '<div class="reservations-cnt airfcfx-full-width-div table-responsive">';
						echo '<table class="futuretable table table_no_border reservationtable">
                                	<thead>
                                      <tr class="review_tab">
                                         <th>'.Yii::t('app','Dates and Location').'</th>
                                        <th>'.Yii::t('app','Guest').'</th>                                        
                                        <th>'.Yii::t('app','Details').'</th>                                      
                                       <th>'.Yii::t('app','Status').'</th>
                                      </tr>
                                    </thead>';					
					foreach($reservations as $reservation)
					{
						$fromdate = $reservation->checkin;
						$todate = $reservation->checkout;
						$startdate = date('M,d,Y',strtotime($fromdate));
						$enddate = date('M,d,Y',strtotime($todate)); 
						$listdata = $reservation->getList()->where(['id'=>$reservation->listid])->one();

						$listinghours=explode('*|*',$listdata->pernight_availablity);
						if($listdata->pernight_availablity!="" && $listdata->pernight_availablity!=null)
						{
								$listinghours_start=date("h:i A", strtotime($listinghours[0]));
                        $listinghours_end=date("h:i A", strtotime($listinghours[1]));
						}
						$listurl = base64_encode($listdata->id.'_'.rand(1,9999));
						$userdata = $reservation->getUser()->where(['id'=>$reservation->userid])->one();
						$usrimg = $userdata->profile_image;

						$currency_code = $reservation->currencycode;
                  if($reservation->convertedcurrencycode!="")
                  {
                    if($reservation->currencycode!=$reservation->convertedcurrencycode)           
                      $rate =  $reservation->convertedprice;
                    else
                      $rate = "1";
                  } else {
                    $rate = "1";
                  }

                  $currency = $reservation->getCurrencydetail($currency_code);
                  if(!empty($currency))
                    $currencysymbol = $currency->currencysymbol;
                  else
                    $currencysymbol = "";

            		$reserveTotal = round(($rate * $reservation->total),2);   


						if($usrimg=="")
							$usrimg = "usrimg.jpg";
						$userimage = Yii::$app->urlManager->createAbsoluteUrl ( '/albums/images/users/'.$usrimg);
						$resized_userimage = Yii::$app->urlManager->createAbsoluteUrl ('resized.php?src='.$userimage.'&w=40&h=40');	
                            echo '<tr id="reserve_'.$reservation->id.'" class="review_tab">';

							echo '<td class="wesetwidth"><div class="datetd"><label>'.Yii::t('app','Date').' :</label><span>'.$startdate.' - '.$enddate.'</span></div>';
							if($reservation->booking=='perhour'){
								$hours=explode('*|*',$reservation->hourly_booked);
								$bookedhours=date("h:i A", strtotime($hours[0])).' - '.date("h:i A", strtotime($hours[1]));
								echo '<div class="datetd"><label>'.Yii::t('app','Hours').' :</label><span>'.$bookedhours.'</span></div>';
							}

							if($reservation->booking=='pernight' && $listdata->pernight_availablity!="" && $listdata->pernight_availablity!=null)
							{
								echo'<div class="datetd"><label>'.Yii::t('app','Checkin').' :</label><span>'.$listinghours_start.'</span></div>';
								echo'<div class="datetd"><label>'.Yii::t('app','Checkout').' :</label><span>'.$listinghours_end.'</span></div>';
							}

							echo'<div class="datetd"><label>'.Yii::t('app','Location').' : </label><span>'.$listdata->streetaddress.', '.$listdata->city.'</span> <span>'.$listdata->state.', '.$listdata->zipcode.'</span></div>

								<p class="airfcfx-td-dtnloc"><a class="text-danger" href="'.$baseUrl.'/user/listing/view/'.$listurl.'">'.$listdata->listingname.'</a></p>
							</td>

							<td class="airfcfx-td-dtnloc">
							<div class="table-img-prof">
								<span class="airfcfx-prof profile_pict inlinedisplay" style="background-image:url('.$resized_userimage.');"> </span>
							<div class="spanusrname inlinedisplay airfcfx-td-guest">'.$userdata->firstname.' '.$userdata->lastname.'</div>
							<div class="spanusrname inlinedisplay airfcfx-td-guest">('.$reservation->guests.' '.Yii::t('app','guests').')</div></div></td>
							<td class="airfcfx-total-cell" ><p>'.$currencysymbol.$reserveTotal.'</p></td>'; 

							// Listing Timezone time
							$current_Timezone = Myclass::getTime($reservation->timezone); 
							date_default_timezone_set('UTC');  

							if(strtotime($current_Timezone) < strtotime($reservation->checkin)) { 
								echo '<td class=""><div class="future-trrab-btn"><input type="button" value="'.Yii::t('app','Accept').'" class="btn btn-danger airfcfx-panel" onclick="change_reserve_status(\'accept\',\''.$reservation->id.'\')">
								<input type="button" class="btn btn-danger airfcfx-panel" value="'.Yii::t('app','Decline').'" onclick="change_reserve_status(\'decline\',\''.$reservation->id.'\')"></div>
									<div calss="col-xs-12"> 
									<img id="loadingimg'.$reservation->id.'" src="'.$baseUrl.'/images/load.gif" class="msgLoader"> 
									</div>
									</td>';
							} else {
								echo '<td>--</td>'; 
							}
							echo '</tr>';    
					}
					echo '</table>';
					echo '</div>';
				}
				else
				{
					echo '<div class="margin_top10 margin_bottom20">
                        <div class="col-xs-12 col-sm-6 ">
                        <p>'.Yii::t('app','You have no upcoming reservations.').'</p><br />
                        ';
						echo '
                        </div>

                        
                    </div> <!--col-xs-12 end -->';
				}
					?>
					<br /><br /><br />
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
			.msgLoader { display: none;  margin:20px 30% 0;}
	</style>
  
