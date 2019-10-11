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

$this->title = 'Your Reservations';
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
        <div class="col-xs-12 col-sm-3 margin_top20">
        	<ul class="profile_left list-unstyled">
			<?php
			echo '<li><a href="'.$baseUrl.'/user/listing/mylistings">'.Yii::t('app','Active Listing').'</a></li>            
			<li><a href="'.$baseUrl.'/user/listing/pendinglistings">'.Yii::t('app','Pending Listing').'</a></li>
            <li class="active"><a href="'.$baseUrl.'/user/listing/reservations" class="active">'.Yii::t('app','Your Reservations').'</a></li>
			<li><a href="'.$baseUrl.'/user/listing/futurereservations">'.Yii::t('app','Unapproved Reservations').'</a></li>
			<li><a href="'.$baseUrl.'/user/listing/requirements" class="active">'.Yii::t('app','Reservation Requirements').'</a></li>';
            //echo '<li><a href="reservation_requirement.html">Reservation Requirements</a></li>  ';
			?>         
            </ul>
			<a href="<?php echo $baseUrl.'/user/listing/listcreate';?>">
            <button class="btn btn_dashboard margin_top20"><?php echo Yii::t('app','Add New Listings');?></button>
			</a>
        </div> <!--col-sm-3 end -->
        
        <div class="col-xs-12 col-sm-9 margin_top20">        
        
        <div class="airfcfx-panel panel panel-default">
          <div class="airfcfx-panel airfcfx-panel-padding panel-heading profile_menu1">
            <h3 class="panel-title"><?php echo Yii::t('app','Your Reservations');?></h3>

          </div>
          
          <div class="panel-body">
            <div class="row">
						
				<?php
				if(!empty($reservations))
				{
					echo '<div class="reservations-cnt margin_top10 margin_bottom20 table-responsive col-sm-12 col-lg-12">';
						echo '<table class="table table_no_border reservationtable">
                                	<thead>
                                      <tr class="review_tab">
                                        <th>'.Yii::t('app','Dates and Location').'</th>
                                        <th>'.Yii::t('app','Guest').'</th>                                        
                                        <th>'.Yii::t('app','Details').'</th>
										<th>'.Yii::t('app','Check In').'</th>
										<th>'.Yii::t('app','Check Out').'</th>
										<th>'.Yii::t('app','Status').'</th>
                                      </tr>
                                    </thead>';					
					foreach($reservations as $reservation)
					{
						$fromdate = $reservation->fromdate;
						$todate = $reservation->todate;
						$startdate = date('M,d,Y',$fromdate);
						$enddate = date('M,d,Y',$todate);
						$listdata = $reservation->getList()->where(['id'=>$reservation->listid])->one();

						$listinghours=explode('*|*',$reservation->hourly_booked); 

						if($reservation->hourly_booked!="" && $reservation->hourly_booked!=null)
						{
							$listinghours_start = date("h:i A", strtotime($listinghours[0]));
                     $listinghours_end = date("h:i A", strtotime($listinghours[1]));
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

							echo '<td class="wesetwidth"><div class="datetd"><label>'.Yii::t('app','Date').':</label><span>'.$startdate.' - '.$enddate.'</span></div>';
							if($reservation->booking=='perhour' ){
								$hours=explode('*|*',$reservation->hourly_booked);
								$bookedhours=date("h:i A", strtotime($hours[0])).' - '.date("h:i A", strtotime($hours[1]));
								echo '<div class="datetd"><label>'.Yii::t('app','Hours').' :</label><span>'.$bookedhours.'</span></div>';
							}

							if($reservation->booking=='pernight' && $listdata->pernight_availablity!="" && $listdata->pernight_availablity!=null)
							{
								echo'<div class="datetd"><label>'.Yii::t('app','Check in').' :</label><span>'.$listinghours_start.'</span></div>';
								echo'<div class="datetd"><label>'.Yii::t('app','Check Out').' :</label><span>'.$listinghours_end.'</span></div>';
							}

							echo'<div class="datetd"><label>'.Yii::t('app','Location').' : </label><span>'.$listdata->streetaddress.', '.$listdata->city.'</span> <span>'.$listdata->state.', '.$listdata->zipcode.'</span></div>

								<p class="airfcfx-td-dtnloc"><a class="text-danger" href="'.$baseUrl.'/user/listing/view/'.$listurl.'">'.$listdata->listingname.'</a></p>

							</td>

							<td><div class="table-img-prof"><span class="airfcfx-prof profile_pict inlinedisplay" style="background-image:url('.$resized_userimage.');"></span>
							<div class="spanusrname inlinedisplay airfcfx-td-guest">'.$userdata->firstname.' '.$userdata->lastname.'</div>
							<div class="spanusrname inlinedisplay airfcfx-td-guest">('.$reservation->guests.' '.Yii::t('app','guests').') </div></div></td>
							';
							$todaydate = date('m/d/Y');
							$sdate = date('m/d/Y',$fromdate);
							$today = strtotime($todaydate);
							$fdate = strtotime($sdate);
							$reserveid = $reservation->id;

							echo '<td class="airfcfx-total-cell"><p>'.$currencysymbol.$reserveTotal.'</p>'; 
							/*if($todate<$today && $reservation->bookstatus!="declined" && $reservation->bookstatus!="cancelled" && isset($reservation->securityfees) && $reservation->securityfees!="")
							{
								$reservationurl = base64_encode($reservation->id.'_'.rand(1,9999));
								echo '<p class="airfcfx-claim-bottomfx"><a href="'.$baseUrl.'/user/listing/claim/'.$reservationurl.'"><input type="button" value="'.Yii::t('app','Claim').'" class="airfcfx-claim airfcfx-width-100 btn btn_dashboard"></a></p>';
							}*/
							if($fdate<=$today && $reservation->bookstatus!="declined" && $reservation->bookstatus!="cancelled" && $reservation->bookstatus!="refunded")
							{ 
									
								if($reservation->checkin=='0000-00-00 00:00:00')
								{
								
									echo '<td class="airfcfx-checkin-cell"><input type="button" id="checkinbtn'.$reserveid.'" value="'.Yii::t('app','Check In').'" class="airfcfx-checkin airfcfx-min-width-50 btn btn-danger" onclick="show_checkin('.$reserveid.')">
									<div id="checkindate'.$reserveid.'" class="airfcfx-checkin-div hiddencls">
									<input type="text" class="form-control datepicker" style="width:144px;" id="checkin'.$reserveid.'" placeholder="DD/MM/YYYY"><br />
									<select class="form-control" style="width:45px; padding:6px 3px;" id="inhr'.$reserveid.'">';
									echo '<option value="">HH</option>';
									for($i=1;$i<=24;$i++)
									{ 
										echo '<option>'.str_pad($i, 2, '0', STR_PAD_LEFT).'</option>';
									}
									echo '</select>
									<select class="form-control" style="width:45px; padding:6px 3px;" id="inmin'.$reserveid.'">';
									echo '<option value="">MM</option>';
									for($i=0;$i<=59;$i++)
									{
										echo '<option>'.str_pad($i, 2, '0', STR_PAD_LEFT).'</option>';
									}
									echo '</select>
									<select class="form-control" style="width:45px; padding:6px 3px;" id="insec'.$reserveid.'">';
									echo '<option value="">SS</option>';
									for($i=0;$i<=59;$i++)
									{
										echo '<option>'.str_pad($i, 2, '0', STR_PAD_LEFT).'</option>';
									}
									echo '</select>
									<div class="errcheckindate"></div>
									<button class="airfcfx-save-btn airfcfx-min-width-50 btn btn-primary" onclick="save_checkin('.$reserveid.');">'.Yii::t('app','Save').'</button>
									</div>
									</td>';
									
								}
								else
								{
									echo '<td>'.$reservation->checkin.'</td>';	
								}
								
								if($reservation->checkout=='0000-00-00 00:00:00')
								{
									if($reservation->checkin=='0000-00-00 00:00:00')
									{
										echo '<td>';
										echo '<span  id="checkout_'.$reserveid.'">---</span>';
										echo '<div id="checkoutdate'.$reserveid.'" class="airfcfx-checkin-div hiddencls" style="display:none;">
										<input type="text" class="form-control datepicker" style="width:144px;" id="checkout'.$reserveid.'" placeholder="DD/MM/YYYY"><br />
										<select class="form-control" style="width:45px; padding:6px 3px;" id="outhr'.$reserveid.'">';
										echo '<option>HH</option>';
										for($i=1;$i<=24;$i++)
										{
											echo '<option>'.$i.'</option>';
										}
										echo '</select>
										<select class="form-control" style="width:45px; padding:6px 3px;" id="outmin'.$reserveid.'">';
										echo '<option>MM</option>';
										for($i=0;$i<=59;$i++)
										{
											echo '<option>'.str_pad($i, 2, '0', STR_PAD_LEFT).'</option>';
										}
										echo '</select>
										<select class="form-control" style="width:45px; padding:6px 3px;" id="outsec'.$reserveid.'">';
										echo '<option>SS</option>';
										for($i=0;$i<=59;$i++)
										{
											echo '<option>'.str_pad($i, 2, '0', STR_PAD_LEFT).'</option>';
										}
										echo '</select>
										<button class="btn btn-primary" onclick="save_checkout('.$reserveid.');">'.Yii::t('app','Save').'</button>
										</div>';
										echo '</td>';
									}
									else
									{
										echo '<td class="airfcfx-checkout-cell"><input type="button" id="checkoutbtn'.$reserveid.'" value="Check Out" class="airfcfx-checkout airfcfx-min-width-50 btn btn-danger" onclick="show_checkout('.$reserveid.')">
										<div id="checkoutdate'.$reserveid.'" class="airfcfx-checkin-div hiddencls">
										<input type="text" class="form-control datepicker" style="width:144px;" id="checkout'.$reserveid.'" placeholder="DD/MM/YYYY"><br />
										<select class="form-control" style="width:45px; padding:6px 3px;" id="outhr'.$reserveid.'">';
										echo '<option>HH</option>';
										for($i=1;$i<=24;$i++)
										{
											echo '<option>'.$i.'</option>';
										}
										echo '</select>
										<select class="form-control" style="width:45px; padding:6px 3px;" id="outmin'.$reserveid.'">';
										echo '<option>MM</option>';
										for($i=0;$i<=59;$i++)
										{
											echo '<option>'.str_pad($i, 2, '0', STR_PAD_LEFT).'</option>';
										}
										echo '</select>
										<select class="form-control" style="width:45px; padding:6px 3px;" id="outsec'.$reserveid.'">';
										echo '<option>SS</option>';
										for($i=0;$i<=59;$i++)
										{
											echo '<option>'.str_pad($i, 2, '0', STR_PAD_LEFT).'</option>';
										}
										echo '</select>
										<button class="airfcfx-save-btn btn btn-primary" onclick="save_checkout('.$reserveid.');">'.Yii::t('app','Save').'</button>
										</div>
										</td>';
										//echo '<td align="center">---</td>';							
									}
								}
								else
								{
									echo '<td>'.$reservation->checkout.'</td>';
								}
							}	else
							{
								echo '<td>--</td>
								<td>--</td>
								';
							} 
							echo '<td class="airfcfx-min-width-80px">';
							if($reservation->bookstatus!="")
							{
								echo '<p class="successtxt"><b>'.ucfirst(Yii::t('app',$reservation->bookstatus)).'</b></p>';
							}							
							echo '</td>';
							echo '</tr>';    
					}
					echo '</table>';
					echo '</div>';
				}
				else
				{
					echo '<div class="margin_top10 margin_bottom20">
                        <div class="col-xs-12 col-sm-12 ">
                        <p>'. Yii::t('app','You have no upcoming reservations.').'</p><br />
						
                        </div>

                        
                    </div>';
				}
					?>

					<?php
					echo '<div class="col-md-12 col-sm-12 col-xs-12"><a href="'.$baseUrl.'/user/listing/pastreservations" class="mine-blue-txt">'.Yii::t('app','View past reservation history').'</a></div>';
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
  
<script type="text/javascript">
	$(document).ready(function(){
		/*$(".datepicker").datepicker({
			 minDate: new Date(1999, 10 - 1, 25)
		}); */
		
		$(".datepicker").datepicker({ minDate: 0});
		
	});

</script>
