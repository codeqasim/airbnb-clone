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
use frontend\models\Weekendprice;

$this->title = 'Calendar';
?>
<?php
$baseUrl = Yii::$app->request->baseUrl;

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
        <li><a href="'.$baseUrl.'/user/listing/notifications">'.Yii::t('app','Account').'</a></li>';
        if (!Yii::$app->user->isGuest) {
	        $loguserid = Yii::$app->user->identity->id;
	        $userHostStatus = Yii::$app->user->identity->hoststatus;
	        $userListings = Listing::find()->where(['userid'=>$loguserid])->all();

	        	if($userHostStatus == 1 && count($userListings) > 0) {
	        		echo '<li class="active"><a href="'.$baseUrl.'/user/listing/calendar">'.Yii::t('app','Calender').'</a></li>';
	        	}
	      }
		?>

        </ul>
    </div> <!--container end -->
</div> <!--profile_head end -->
<?php 
	$currency_code = "";
	$currency_symbol = "";
	if(isset($_SESSION['currency_code']) && $_SESSION['currency_code']!="" && isset($_SESSION['currency_symbol']) && $_SESSION['currency_symbol']!="") { 
      $currency_code = $_SESSION['currency_code'];
      $currency_symbol = $_SESSION['currency_symbol'];
   } else {
   	$currency_code = $defaultcurrency->currencycode;
      $currency_symbol = $defaultcurrency->currencysymbol;
   }

   $rate2= Myclass::getcurrencyprice($listingcurrency->currencycode);//listing currency
   $rate= Myclass::getcurrencyprice($currency_code);//user currency

	$durationPrice = ($lastListing->booking == "pernight")? $lastListing->nightlyprice : $lastListing->hourlyprice; 
	//$listingOrginalPrice = round(($rate * ($durationPrice/$rate2)),2);
	$listingOrginalPrice = $durationPrice; 

	$stripe_USD = Myclass::getcurrencyprice('USD'); 
	$list_CUR = $listingcurrency->price;  

	$stripe_money = ceil(($stripe_USD * 10) * ($list_CUR));


	$weekendDiscount = $lastListing->weekendprice;
    if($weekendDiscount == '1'){
        $queryWeekend = Weekendprice::find()->where(['listid'=>$lastListing->id])->one();
        $weekendPrice = $queryWeekend->weekend_price; 
    }else{
        $weekendPrice = '';
    }

	$bookingText = ($lastListing->booking == "pernight")? Yii::t('app','Nightly price') : Yii::t('app','Hourly price'); 
?>
<input type="hidden" class="stripemoney" value="<?php echo $stripe_money; ?>" > 
<input type="hidden" class="durationPrice" value="<?php echo $durationPrice; ?>" >
<input type="hidden" class="userCurrencySymbol" value="<?php echo $currency_symbol; ?>" >
<input type="hidden" class="listingOrginalPrice" value="<?php echo $listingOrginalPrice; ?>" >
<input type="hidden" class="listingCurrencySymbol" value="<?php echo $listingcurrency->currencysymbol; ?>" >
<input type="hidden" class="listingWeekPrice" value="<?php echo $weekendPrice; ?>" >  
 
<!-- Multidate picker.css -->
<link rel="stylesheet" type="text/css" href="<?php echo $baseUrl.'/css/bootstrap-multidatepicker.css'; ?>">
<!-- Bootstrap Multi Date Picker -->
<script type="text/javascript" src="<?php echo $baseUrl.'/js/bootstrap-datepicker.min.js'; ?>"></script> 

<script>

	var datepicker = $.fn.datepicker.noConflict();
	$.fn.bootstrapDP = datepicker;
	var listingPrice = "<?php echo $listingOrginalPrice; ?>";
	var listCurrency = "<?php echo $listingcurrency->currencysymbol; ?>"; 
	var listingWeekPrice = "<?php echo $weekendPrice; ?>";  
	//var blockedDates; 
	//var availableDates;

	function calendarCall(active_dates, block_dates, avail_rates) { 
		//blockedDates = block_dates;
		//availableDates = active_dates;
		calendarInput();

		$input = $("#dater");
		$input.bootstrapDP({
			format: "mm/dd/yyyy",
			startDate: "-",
			clearBtn: false,
			multidate: true,
			todayHighlight: false,
			beforeShowDay: function (date) {
				var d = date;
				var curr_date = d.getDate();
				var curr_month = d.getMonth() + 1; //Months are zero based
				var curr_year = d.getFullYear();
				var curr_day = d.getDay(); 

				var formattedDate = curr_date + "/" + curr_month + "/" + curr_year;		

				var d = new Date();
				var todayCode = (d.getMonth() + 1) +"/"+ d.getDate() + "/" + d.getFullYear();
				todayCode = (new Date(todayCode).getTime() / 1000).toFixed(0);

				var formattedCode = curr_month + "/" + curr_date + "/" + curr_year;
				formattedCode = (new Date(formattedCode).getTime() / 1000).toFixed(0);

				if ($.inArray(formattedDate, block_dates) != -1) {
					return {
						classes: 'block',
						content: '<dat class="calPrice"></dat>',
					};
				} else if ($.inArray(formattedDate, active_dates) != -1) {
					var dateIndex = active_dates.indexOf(formattedDate);
					return {
						classes: 'avail',
						content: '<dat class="calPrice"><dat class="calPriceSym">'+listCurrency+'</dat><dat class="calPriceValue">'+avail_rates[dateIndex]+'</dat><dat class="calPriceFlag"></dat></dat>', 
					};
				} else {
					if(todayCode<=formattedCode) {
						if((curr_day == 5 || curr_day == 6) && $.trim(listingWeekPrice)!="") { 
							return {
								content: '<dat class="calPrice"><dat class="calPriceSym">'+listCurrency+'</dat><dat class="calPriceValue">'+listingWeekPrice+'</dat></dat>',   
							};
						} else {  
							return {
								content: '<dat class="calPrice"><dat class="calPriceSym">'+listCurrency+'</dat><dat class="calPriceValue">'+listingPrice+'</dat></dat>',
							};
						}
					} else {
						return {
							content: '<dat class="calPrice"></dat>',
						};
					}
				}
				return;
			}
		});
	}

	function calendarInput() { 
		$('#dater').on('changeDate', function () {
			$('#my_hidden_input').val(
				$('#dater').bootstrapDP('getFormattedDate')
			);

			var hiddenValue = $('#my_hidden_input').val();
			if($.trim(hiddenValue) == "") {
				$(".target").hide("slide", { direction: "right" }, 500); 
				$('.clearCalendar').css('display','none'); 
				$('.editCalendar').css('display','none');
			} else {
				$('.clearCalendar').css('display','block'); 
				$('.editCalendar').css('display','block');   
			}
		});

		$("#showr").click(function () {
			console.log('in'); 
			var listId = $(".displayflex.active > .hiddenId").val();  
			var dateRangeValue = $('#my_hidden_input').val();
		   var dateRangeValue = dateRangeValue.split(',');
		   var dateRangeValue = dateRangeValue.filter(function (el) {
			  return ($.trim(el) != "");
			});
			dateRangeValue = dateRangeValue+","; 

			$.ajax({
            type : 'POST',
            url : baseurl + '/user/listing/calendar',
            async: true,
            beforeSend: function() {  
            	$(".calendarLoadMain").show(); 
            	$(".target").show("slide", { direction: "right" }, 500);
            },
            data : {
                listid : listId,
                listingFlag : "check",
                dateRangeValue : dateRangeValue,
            },
            success : function(data) {
            	var datas = atob(data).split("***~#~***");
            	if ($.trim(data)!="" && datas.length == 3) { 
            		
            		if($.trim(datas[0]) == 0) {  
         				$("#liststatus").val('blocked');
         				$(".pricebar").hide();
            		} else {
            			$("#liststatus").val('available'); 
            			$(".pricebar").show();  
            		} 

            		$("#note").val($.trim(datas[1]));
            		$("#specialprice").val($.trim(datas[2])); 

               	$(".calendarLoadMain").hide(); 
					}
            }
 			});
		});

		$("#hider").click(function () {
			$(".target").hide("slide", { direction: "right" }, 500);
		});

		$(".clearCalendar").click(function () {
			$('#dater').val("").bootstrapDP("update"); 
			$('#my_hidden_input').val(""); 
			$(".target").hide("slide", { direction: "right" }, 500); 
			$('.clearCalendar').css('display','none');
			$('.editCalendar').css('display','none');
		}); 

	}

	$(document).ready(function () {
		$(".pricetip").click(function () {
			$("#specialprice").val($.trim($(".durationPrice").val()));
		}); 

		$('#specialprice').keydown(function (e) {
        if ($.inArray(e.keyCode, [46, 8, 13]) !== -1 ||
             // Allow: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) ||
             // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
		});	

		$('#liststatus').change(function(){

			if($('#liststatus option:selected').val() == 'available')
			{
				$('.pricebar').show('slow');
			}else if($('#liststatus option:selected').val() == 'blocked') {
				$('.pricebar').hide('slow');
			} else {
				$('.pricebar').hide('slow'); 
			}
		});

	});

</script>

<div class="container bg_gray1">
	<div class="mrgnset">
	<?php if(count($listings) > 0) { ?>
		<div class="col-xs-12 col-sm-3 margin_top20 margin_bottom20"> 
			<nav class="navbar navbar-inverse mang-list">
				<div class="navbar-header listingnav">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand res-disp" href="#">Listing details</a>
				</div>
				<div class="collapse navbar-collapse no-hor-padding" id="myNavbar">
					<!-- div class="listing-details-d">Listing details</div -->

					<div class="listingboxes">
						<?php foreach ($listings as $key => $list) { 
							$photos = $list->getPhotos()->where(['listid'=>$list->id])->orderBy('id asc')->one();
							$listurl = base64_encode($list->id.'_'.rand(1,9999));
							if(isset($photos->image_name) && $photos->image_name!="") {
								$listimagename = Yii::$app->urlManager->createAbsoluteUrl ('/albums/images/listings/'.$photos->image_name);
								$header_response = get_headers($listimagename, 1);
								if ( strpos( $header_response[0], "404" ) !== false )
								{
									$listimagename = Yii::$app->urlManager->createAbsoluteUrl ('/images/room_default.png');
								} 
								else 
								{
									$listimagename = Yii::$app->urlManager->createAbsoluteUrl ('/albums/images/listings/'.$photos->image_name);
								}							
							} else {
								$listimagename = Yii::$app->urlManager->createAbsoluteUrl ('/images/room_default.png');
							}

							$activeClass = ($list->id == $lastListing->id) ? "active" : "";
						?>
							<div id="listing_<?= $list->id ?>" class="padding_top15 padding_bottom15 displayflex <?= $activeClass ?>"> 
								<input type="hidden" class="hiddenId" value="<?= $list->id ?>"> 
								<div class="alignself-center"> 
									<!-- <img src="<?php //echo $listimagename ?>" class="listerimg"> -->
								</div>
								<div class="margin_left15 flexfill"> 
									<a href="<?= $baseUrl.'/user/listing/view/'.$listurl ?>"><?php echo ucfirst($list->listingname); ?></a>
									<div class="statusflex justifycontent-spacebet">
										<?php if($list->liststatus == 1) { ?>
											<div><?php echo Yii::t('app','Listed'); ?></div>
											<div class="list-indicate"></div>
										<?php } else { ?>
											<div><?php echo Yii::t('app','Unlisted'); ?></div>
											<div class="unlist-indicate"></div>
										<?php } ?>
									</div>
								</div>
							</div>
						<?php } ?>									
					</div>

				</div>
			</nav>
		</div>
		<!--col-sm-3 end -->
		
		<input type="hidden" name="hour_booking" id="hour_booking" value="yes" />
		<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9 margin_top20">
				
				<div class="panel-body padding0">
					<div class="row">

						<div class="col-xs-12 margin_bottom20 commcls" >

							<div class="calendarLoad col-xs-12 col-md-12 text-center" style="display: none; margin:250px 0px 50px;"> 
								<img src="<?= $baseUrl.'/images/load.gif' ?>">  
							</div>
							<div id="calendardiv" class="col-xs-12 col-md-12 padding0" class="clear"> 
								<input type="hidden" id="my_hidden_input" value="">  
								<div id="calendarUpdate" class="clear">
									<div id="dater"></div>
									<?php 
										$availDates = "";
										$blockDates = "";
										$availRate = "";

										$todaydate = date('m/d/Y');
										$today = strtotime($todaydate);
										if(trim($lastListing->splpricestatus) == 1) {
										   if(trim($lastListing->specialprice) !="") {
										      $specialpricedata = json_decode($lastListing->specialprice);

										      if(count($specialpricedata) > 0 ) {
										         foreach ($specialpricedata as $key => $special) {
										            if(strtotime($special->specialendDate) >= $today) {
										               $c_sdate = strtotime(trim($special->specialstartDate));
										               $c_edate = strtotime(trim($special->specialendDate));
										               $c_price = trim($special->specialprice);
										               //$c_price = round(($rate * (trim($special->specialprice)/$rate2)),2);

										               if ($c_edate >= $c_sdate) {
										                  for ($pDates=$c_sdate; $pDates <= $c_edate; $pDates+=86400) {
										                  	if($pDates >= $today) {
											                     $pDate = date('j/n/Y', $pDates);
											                     $availDates.= (trim($availDates=="")) ? "'".$pDate."'" : ",'".$pDate."'"; 
											                     $availRate.= (trim($availRate=="")) ? "'".$c_price."'" : ",'".$c_price."'"; 
											                  }
										                  }
										               }
										            }
										         }
										      }
										   }

										   if(trim($lastListing->blockedspecialprice) !="") {
										      $specialpricedata = json_decode($lastListing->blockedspecialprice);

										      if(count($specialpricedata) > 0 ) {
										         foreach ($specialpricedata as $key => $special) {
										            if(strtotime($special->specialendDate) >= $today) {
										               $c_sdate = strtotime(trim($special->specialstartDate));
										               $c_edate = strtotime(trim($special->specialendDate));

										               if ($c_edate >= $c_sdate) {
										                  for ($pDates=$c_sdate; $pDates <= $c_edate; $pDates+=86400) {
										                  	if($pDates >= $today) {
											                     $pDate = date('j/n/Y', $pDates);
											                     $blockDates.= (trim($blockDates=="")) ? "'".$pDate."'" : ",'".$pDate."'"; 
											                  } 
										                  }
										               }
										            }
										         }
										      }
										   }
										}
									?> 
									<script>

										$(document).ready(function () {

											var active_dates = [<?php echo $availDates; ?>];
	   									var block_dates = [<?php echo $blockDates; ?>]; 
	   									var avail_rates = [<?php echo $availRate; ?>]; 
	   									calendarCall(active_dates, block_dates, avail_rates);

										});
									</script>
									<a href="javascript:void(0);" class="clearCalendar float-left"><?=Yii::t('app','Clear')?></a>
									<a href="javascript:void(0);" id="showr" class="editCalendar btn float-right"><i class="fa fa-edit"></i> <?=Yii::t('app','Edit')?></a>
								</div>

								<div id="rightCalLoad" class="target rightcal"> 
									<div class="calendarLoadMain col-xs-12 col-md-12 text-center" style="display: none;"> 
											<img src="<?= $baseUrl.'/images/load.gif' ?>">  
									</div>
									<div class="col-sm-12 col-md-12 col-xs-12">
										<button type="button" id="hider" class="close">
											<svg viewBox="0 0 24 24" role="img" aria-label="Close" focusable="false" style="height: 16px; width: 16px; display: block; fill: rgb(118, 118, 118);">
												<path d="m23.25 24c-.19 0-.38-.07-.53-.22l-10.72-10.72-10.72 10.72c-.29.29-.77.29-1.06 0s-.29-.77 0-1.06l10.72-10.72-10.72-10.72c-.29-.29-.29-.77 0-1.06s.77-.29 1.06 0l10.72 10.72 10.72-10.72c.29-.29.77-.29 1.06 0s .29.77 0 1.06l-10.72 10.72 10.72 10.72c.29.29.29.77 0 1.06-.15.15-.34.22-.53.22" fill-rule="evenodd"></path>
											</svg>
										</button>
									</div>  
									<div class="rightcal-child col-sm-12 col-md-12 col-xs-12">
										<div class="coldiv no-hor-padding margin_bottom24">
											<div class="no-hor-padding labeldiv">
												<label>
													<?php echo Yii::t('app','Availability'); ?>
												</label>
											</div>
											<select id="liststatus" name="liststatus" class="form-control liststatus listselect selectsze">
												<option value="available"><?php echo Yii::t('app','Available'); ?></option>
												<option value="blocked"><?php echo Yii::t('app','Blocked'); ?></option>
												<!-- option value="default">Default</option -->
											</select>
										</div>

										<div class="coldiv no-hor-padding pricebar margin_bottom24 border_bottom_pad">
											<div class="no-hor-padding labeldiv">
												<label class="bookingText">
													<?= $bookingText ?>
												</label>
											</div>
											
											<div class="pricepanel">
												<div class="symbolcls">
													<span id="currencysymbol" class="symboltxt currencysymbol"><?= $listingcurrency->currencysymbol; ?></span> 
												</div>

												<input type="text" maxlength="5" name="specialprice" value="" class="form-control smalltext flexfill"
												 id="specialprice">
											</div>

											<div class="coldiv pricetip">
											 	<?php echo Yii::t('app','Use base price').": <span id='currencysymboltip'>".$listingcurrency->currencysymbol."</span><span id='currencypricetip'>".$stripe_money."</span>"; ?> 
											</div> 

											<div class="coldiv" class="margin_bottom24">
											<?php echo Yii::t('app','You’re responsible for choosing the listing price').'.'; ?>
											</div>
										</div>

										<div class="coldiv no-hor-padding specialnote margin_bottom24">
											<div class="no-hor-padding labeldiv">
												<label>
													<?php echo Yii::t('app','Private note'); ?>
												</label>
												<span class="addnote">
													<a href="javascript:void(0);" class="addnoteslideup"><?php echo Yii::t('app','Add'); ?> <i class="fa fa-angle-down"></i></a>
												</span>
											</div>
											
											<div class=" coldiv no-hor-padding addnotes">
												<div class="no-hor-padding" style="margin-bottom: 8px;">
													<?php echo '<i class="fa fa-lock margin_right5"></i>'.Yii::t('app', 'This is not shown to guests').'.'; ?> 
												</div>
												<textarea name="note" id="note"></textarea>
											</div>
										</div>
										
									</div>
									<div class="actionpanel col-sm-12 col-md-12 col-xs-12">
										<p class="calendarLoadToggle col-xs-12 col-md-12 text-center" style="display: none;"> 
											<img src="<?= $baseUrl.'/images/load.gif' ?>">  
										</p>
										<a href="javascript:void(0);" id="show" class="btn float-left">Save</a>
										<p class="help-block help-block-error" style="display: none;"></p>
									</div>
								</div>
								
								<script>
									$(document).ready(function () {
										$(".addnoteslideup").click(function () {
											$(".addnotes").slideToggle();
										});
									});
								</script>

								<!--a href="javascript:void(0);" class="clearCalendar float-left" style="line-height:35px; margin-top:15px;font-size:16px !important; display: none;">Clear</a>
								<a href="#data" id="showr" class="editCalendar btn float-right" style="margin-top:15px;font-size:16px !important; display: none;"><i class="fa fa-edit"></i> Edit</a !--> 
							
							</div> 
						</div>
					</div>
					<!--row end -->
				</div>
				<!--Panel end -->
		</div>
	<!-- container end -->
	<?php } else { ?>
		<div class="text-center" style="font-size:24px;margin:50px auto;">No Listings found.</div>
	<?php } ?>


	</div>
</div>

<script>

$(document).on("click",".displayflex",function(){
    var listId = $(this).find(".hiddenId").val();

   if ($('.listingboxes >.displayflex').hasClass('active')) {
	   $('.listingboxes >.displayflex').removeClass('active');
	   $(this).addClass('active');  
	}

	$.ajax({
            type : 'POST',
            url : baseurl + '/user/listing/calendar',
            async: true,
            beforeSend: function() {
            	$(".target").hide("slide", { direction: "right" }, 500);   
            	$("#calendardiv").hide();
               $(".calendarLoad").show();
            },
            data : {
                listid : listId,
                listingFlag : "fetch",
            },
            success : function(data) {
            	$(".calendarLoad").hide();

					if ($.trim(data)!="" && $.trim(data)!="failed") {
						// calendar Progress
						var data = data.split("###~#~###");
						var datas = atob(data[0]).split("***~#~***");
	               if (datas.length == 8) {
	               	$("#calendarUpdate").html($.trim(datas[7]));

	               	var strArr = datas[0].split(',');
							var active_dates = [];
							for(i=0; i < strArr.length; i++)
							   active_dates.push(strArr[i]);

	               	var block_dates = [];
	               	var strArr = datas[1].split(',');
							for(i=0; i < strArr.length; i++)
							   block_dates.push(strArr[i]); 

							var avail_rates = [];
							var strArr = datas[2].split(',');
							for(i=0; i < strArr.length; i++)
							   avail_rates.push(strArr[i]);

							listingPrice = $.trim(datas[3]);
							listCurrency = $.trim(data[1]);
							listingWeekPrice = $.trim(data[2]);  

							$('#currencysymboltip, #currencysymbol').html($.trim(data[1]));  
							$('#currencypricetip').html($.trim(data[3])); 
							$('.stripemoney').val($.trim(data[3]));   
							$('.durationPrice').val($.trim(datas[4]));
							$('.bookingText').html($.trim(datas[5])); 
							$('#specialprice').val(""); 
							$('#my_hidden_input').val(""); 

	               	calendarCall(active_dates, block_dates, avail_rates);	               	 
							$("#calendardiv").show();
						} else {
						 window.location.reload();
						}
					}
            }
 			});    
});

$(document).on("click","#show",function(){
	var dateRange = $('#my_hidden_input').val();
   var listingStatus = $('#liststatus').val();
   var specialPrice = $('#specialprice').val();
   var stripeMoney = parseInt($('.stripemoney').val()); 
   var listingNotes = $('#note').val();
   var errorFlag = 0;
   var cFlag = 0; 
   var dateRange = dateRange.split(',');
   var dateRange = dateRange.filter(function (el) {
	  return ($.trim(el) != "");
	});
	dateRange = dateRange+","; 

   if($.trim(dateRange)=="") {
   	$(".actionpanel > p.help-block-error").html("Select date").css('display','block');
   	errorFlag = 1;
   }

   if(listingStatus!="available" && listingStatus!="blocked" && errorFlag == 0) { 
   	$(".actionpanel > p.help-block-error").html("Select availability").css('display','block');
   	errorFlag = 1;
   }

   if(listingStatus=="available" && $.trim(specialPrice)=="" && errorFlag == 0) {
   	$(".actionpanel > p.help-block-error").html("Enter Price").css('display','block');
   	errorFlag = 1;
   } else if(listingStatus=="available" && $.trim(specialPrice) < stripeMoney && errorFlag == 0) {
   	$(".actionpanel > p.help-block-error").html("Price should be more than base value").css('display','block');
   	errorFlag = 1; 
   }

   if($.trim(dateRange)!="" && dateRange.length > 0 && (listingStatus=="available" || listingStatus=="blocked") && errorFlag==0) { 
   	if(listingStatus=="available" && specialPrice > 0) {
   		cFlag = 1;
   	} else if(listingStatus=="blocked") { 
   		cFlag = 1; 
   	}
   	
   }

   if(errorFlag == 1) {
   	setTimeout(function() {
         $(".actionpanel>p.help-block-error").hide('slow');
         $('.actionpanel>p.help-block-error').html(''); 
   	}, 3000);
   	return false;
   }

   if(errorFlag == 0 && cFlag == 1) {
   	var listId = $(".displayflex.active > .hiddenId").val(); 

   	$.ajax({ 
         type : 'POST',
         url : baseurl + '/user/listing/calendar',
         async: true,
         beforeSend: function() {   
         	$("#show").hide();
            $(".calendarLoadToggle").show();
         },
         data : {
            listingDateRange : dateRange,
            listingStatus : listingStatus,
            listingSpecialPrice : specialPrice,
            listingNotes : listingNotes,
            listingFlag : "update", 
            listid : listId, 
         },
         success : function(data) {
         	$(".calendarLoadToggle").hide();

				if ($.trim(data)!="" && $.trim(data)!="failed") {					
					// calendar Progress
					var data = data.split("###~#~###");
					var datas = atob(data[0]).split("***~#~***");
               if (datas.length == 8) {
               	$("#calendarUpdate").html($.trim(datas[7]));   

               	var strArr = datas[0].split(',');
						var active_dates = [];
						for(i=0; i < strArr.length; i++)
						   active_dates.push(strArr[i]);

               	var block_dates = [];
               	var strArr = datas[1].split(',');
						for(i=0; i < strArr.length; i++)
						   block_dates.push(strArr[i]); 

						var avail_rates = [];
						var strArr = datas[2].split(',');
						for(i=0; i < strArr.length; i++)
						   avail_rates.push(strArr[i]);

						listingPrice = $.trim(datas[3]);
						listCurrency = $.trim(data[1]);   

						$('#currencysymboltip, #currencysymbol').html($.trim(data[1])); 
						$('#currencypricetip').html($.trim(data[3]));
						$('.stripemoney').val($.trim(data[3]));    
						$('.durationPrice').val($.trim(datas[4]));
						$('.bookingText').html($.trim(datas[5])); 
						$('#specialprice').val(""); 

               	calendarCall(active_dates, block_dates, avail_rates);	
               	$("#show").show();               	 
               	$("#specialprice").val("");               	 
               	$("#note").val("");  
               	$("#my_hidden_input").val("");  
               	$("#liststatus").val("available"); 
               	$(".pricebar").show(); 
               	$(".target").hide("slide", { direction: "right" }, 500);  
               	$('.clearCalendar').css('display','none'); 
						$('.editCalendar').css('display','none');
						
						$("#calendardiv").show();
					} else {
					 	window.location.reload();
					}
				}
         }
		});  
   }  
   
});

</script>

<style>
/*New*/

#hider.close {
	opacity: 1 !important; 
	margin: 24px 5px !important; 
	width:100%;

}
.managelist-modal {
	max-width: 300px
}
.labeldiv {
	margin-bottom: 8px !important;
}

.labeldiv label {
	/*display: flex!important;*/
	justify-content: left!important;
	font-size: 17px;
	font-weight: 500 !important; 
	margin: 0px !important; 
}

div.pricepanel {
	display: flex!important;
	justify-content: left!important;
	font-size: 15px;
	font-weight: 500 !important; 
}

div.pricepanel .symbolcls {
	background: transparent !important;
	line-height: 50px !important;
	padding: 0px !important;
	border-top-left-radius: 5px !important; 
	border-bottom-left-radius: 5px !important; 
	width: 10% !important;
	text-align: right !important;
	float: none !important;
}

.mrgnset select.form-control {
	padding-left: 5px !important; 
	border-radius: 5px !important; 
}

.mrgnset .form-control {
	padding: 11px 40px 11px 5px !important; 
	font-size: 16px;
}

.mrgnset .form-control.flexfill:focus {
	border-left-color: #ffffff !important;
}

.cal-sidepopup {
	position: absolute;
	bottom: 5px;
	right: 5px;
	background: #fff;
	text-align: center;
	border: 1px solid #e4e4e4;
	z-index: 999;
	padding: 10px;
	min-height: 200px;
	max-width: 320px
}

.listingboxes {
	max-height: 485px;  
	overflow-y: auto;
	overflow-x: auto;
	max-width: 300px;
	min-width: 100px;
	border-radius:3px !important; 
}

.rightcal {
	border: 1px solid #e4e7e7;
	height: 100vh;
	min-width: 340px; 
	max-width: 340px;   
	background: #fff;
	position: fixed;
	right: 0;
	top: 0;
	z-index: 99;
	display: none;
	box-shadow: -5px 0 10px -7px #aaa
}

.rightcal-child {
	display: flex;
	flex-direction: column;
	justify-content: center;
	align-items: center;
	/*	height: 100vh;*/
	padding: 0px 20px !important; 
}

.unlist-indicate {
	height: 7px;
	width: 7px;
	border-radius: 100%;
	background: #f32e2e;
	margin-right: 10px
}

.list-indicate {
	height: 7px;
	width: 7px;
	border-radius: 100%;
	background: green;
	margin-right: 10px
}

.padding10 {
	padding: 10px;
}

.statusflex {
	display: flex;
}

.displayflex {
	display: flex;
	cursor: pointer;
	padding-left: 5px; 
}

.displayflex:hover {
	background: #fafafa none repeat scroll 0% 0%; 
	border-top-left-radius: 5px;
	border-bottom-left-radius: 5px;
}

.displayflex.active { 
	background: #eeeeee none repeat scroll 0% 0%; 
	border-left: 3px solid rgb(0, 132, 137);
	border-top-left-radius: 5px;
	border-bottom-left-radius: 5px;
	
}

.alignself-center {
	align-self: center;
}

.padders {
	padding-right: 0px!important;
	padding-left: 0!important;
}

.justifycontent-spacebet {
	justify-content: space-between;
}

.flexfill {
	flex: 1 1 auto!important;
	border-left-color: #ffffff !important;
	border-top-right-radius: 5px !important; 
	border-bottom-right-radius: 5px !important; 
	border-top-left-radius: 0px !important; 
	border-bottom-left-radius: 0px !important; 
}

.listing-details-d {
	font-size: 16px;
	font-weight: 700;
	padding: 10px;
}

.listingnav {
	width: 100%!important;
}

@media (max-width:767px) {
	.listingboxes {
		border: 1px solid #e4e7e7;
		max-height: 300px;
		overflow-y: auto;
		overflow-x: auto;
	}
	.padders {
		padding-right: 15px!important;
		padding-left: 15px!important;
	}
	.listingboxes {
		max-width: 100%;
		min-width: 100%;
		margin-top: 30px
	}
	.listing-details-d {
		display: none
	} 
}

@media(min-width:630px) and (max-width:767px) {
	.listingnav {
		border-bottom: 0px!important;
	}
}

#dater .datepicker.datepicker-inline{
	padding:0px !important;
}

.listerimg{
    height:40px;
    width:40px; 
    border-radius: 100%;
}
.padding_bottom15 {
	padding-bottom: 15px;
}
#dater .datepicker table tr td.old.day.block, #dater .datepicker table tr td.old.day.avail {
	border: 1px solid #e4e7e7 !important; 
}
.margin_bottom24 {
	margin-bottom: 24px;
}
.pricepanel {
	margin-bottom: 8px;
}
.pricetip {
	color: #008489 !important;
}
.pricetip:hover {
	text-decoration: underline !important;  
}
.border_bottom_pad {  
	border-bottom: 1px solid #e4e4e4;
	padding-bottom: 24px;
}

.addnote {
	font-size: 16px;
	font-weight: 500;
	float: right;
}
.addnote > a:focus, .addnote > a:active, .addnote > a:hover  {
	color: #008489 !important;
}

textarea#note {
  resize: vertical; 
  min-height: 90px !important; 
  max-height: 120px !important;
  padding: 10px;   
  font-size: 16px !important;
  font-weight: 400; 
  border-radius: 5px !important; 
}

.actionpanel {
	position: absolute;
	left: 0px;
	bottom: 0px;
	right: 0px;
	background-color: #ffffff;
	border-top: 1px solid #e4e4e4;
	display: flex;
}

.actionpanel > p {
	padding: 0px;
	width: 100%;
	line-height: 35px; 
	margin: 15px 0px !important; 
}

a#show {
	margin: 15px 10px 15px 0px;
	font-size: 16px !important;
}
.calendarLoadMain { 
	position: absolute;
	height: 100%;
	background: rgb(255,255,255,0.85);
	z-index: 9;
	padding: 65% 0%;
}
.clearCalendar {
	line-height:35px; 
	margin-top:15px;
	font-size:16px !important; 
	display: none;
}

.editCalendar{
	margin-top:15px;
	font-size:16px !important; 
	display: none;
}
</style>

