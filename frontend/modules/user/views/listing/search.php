<?php
use backend\components\Myclass;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\LinkPager;
use yii\CurrencyConverter\CurrencyConverter;
use frontend\models\Listing;
use frontend\models\Reviews;

/* @var $this yii\web\View */
/* @var $model frontend\models\Listing */

$baseUrl = Yii::$app->request->baseUrl;
$hour_booking= $sitesettings->hour_booking;
//echo base64_encode("2_".rand(1,9999));

$this->title = 'Search Listing';

if( isset($_GET['roomtype']) && $_GET['roomtype'] != '' )
{
	$roomtype = $_GET['roomtype'];
}else{
	$roomtype = '';
}
?>

<script type="text/javascript" src="<?php echo ($baseUrl.'/js/moment.js');?>"></script>
<script type="text/javascript" src="<?php echo ($baseUrl.'/js/daterangepicker.js');?>"></script>
<script type="text/javascript">
	$("document").ready(function() {

		$('.dropdown-menu').on('click', function(e) {
		   if($(this).hasClass('dropdown-menu-form')) {
		       e.stopPropagation();
		   }
		});

		$('body').on('click', function(event){ 
         if($(event.target).is('.search-filter-listing .btn-group .btn')) {
            var boolValue = $(event.target).attr('aria-expanded');
            var boolValueSpl = $(event.target).attr('id');
             if(boolValueSpl == "daterange") {
                 if($('#hideFace').hasClass('showen')) {
                     //$('#hideFace').removeClass("showen");
                     $('.split_cell_1').css('z-index','8'); 
                     $('.bottom_filter').css('z-index','1');   
                 } else {
                     $('#hideFace').addClass("showen");
                     $('.split_cell_1').css('z-index','8'); 
                     $('.bottom_filter').css('z-index','1'); 
                 }
             } else if(boolValueSpl == "moreFilter") {
                 if($('.filter_menu2').hasClass('filter_menu3')) {
                     $('#hideFace').addClass("showen");
                     $('.split_cell_1').css('z-index','12');
                     $('.bottom_filter').css('z-index','12');
                 } else {
                     $('#hideFace').removeClass("showen");
                     $('.split_cell_1').css('z-index','8');
                     $('.bottom_filter').css('z-index','1'); 
                 }
             } else if(boolValue == "false") {
                 $('#hideFace').addClass("showen");
                 $('.split_cell_1').css('z-index','8');
                 $('.bottom_filter').css('z-index','1'); 
             } else {
                 $('#hideFace').removeClass("showen");
                 if($('.filter_menu2').hasClass('filter_menu3')) {
                    $('.bottom_filter').css('z-index','12');
                 } else {
                 	$('.bottom_filter').css('z-index','1');
                 }
             }
         } else {
                if($('.filter_menu2').hasClass('filter_menu3')) {
             		$('#hideFace').addClass("showen");
             		$('.split_cell_1').css('z-index','12');
                    $('.bottom_filter').css('z-index','12');
                } else { 
                 	$('.bottom_filter').css('z-index','1');
                 	if($('#hideFace').hasClass('showen')) {
                 		$('#hideFace').removeClass("showen");
             		}
                }
         }
         
      });

	});
</script>

<div id="spinmodal" style="display: none">
   <div class="center">
        <i class="fa fa-spinner fa-spin" style="font-size:48px;color: #EC1E79"></i>
   </div>
</div>


<div class="search-filter-listing topMargin clearfix">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="btn-group">
		   <?php
				$checkIndate = (isset($_GET['checkin']) && $_GET['checkin'] != '') ? $_GET['checkin'] : "";
				$checkOutdate = (isset($_GET['checkout']) && $_GET['checkout'] != '') ? $_GET['checkout'] : ""; 

				if( (isset($_GET['checkin']) && $_GET['checkin'] != '') && 
					(isset($_GET['checkout']) && $_GET['checkout'] != '') )
				{
					$hiddendateValues = $_GET['checkin'].' - '.$_GET['checkout'];
					$momentCheckIndate = $_GET['checkin'];
					$momentCheckOutdate = $_GET['checkout']; 
				}else{
					$hiddendateValues = '';
					/*$momentCheckIndate = date('m/d/Y');
					$momentCheckOutdate = date('m/d/Y', strtotime("+1 day"));  */ 
					$momentCheckIndate = date('m/d/Y');
					$momentCheckOutdate = date('m/d/Y');  
				}

			?>
			<input type="button" name="daterange" id="daterange" class="btn btn-primary white-bg-border dropdown-toggle" value="Dates" readonly/ >
			<input type="hidden" id="daterangepick_value" value="<?= $hiddendateValues; ?>" />
		</div>

		<div class="cls-duration btn-group">
		  	<button type="button" class="btn btn-primary white-bg-border dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo Yii::t('app','Duration'); ?></button>
 
		<div class="dropdown-menu dropdown-menu-form">
			    <div class="popup-body clearfix">
			    	<div class="checkboxatrb">
			    		<label>
			    			<span class="check-cover">
			    				<input class="form-control" value="pernight" id="pernight" onchange="updateSearchList('pernight', 'duration_type');" name="duration[]" type="checkbox" checked="checked">
			    				<div class="airfcfx-search-checkbox-text"></div> 
			    			</span>
			    			<span class="check-cover">Per Night</span>
			    		</label>
			    		<label>
			    			<span class="check-cover">
			    				<input class="form-control" value="perhour" id="perhour" onchange="updateSearchList('perhour', 'duration_type');" name="duration[]" type="checkbox" checked="checked">  
			    				<div class="airfcfx-search-checkbox-text"></div> 
			    			</span>
			    			<span class="check-cover">Per Hour</span>
			    		</label>
					</div>
		     	</div>
		  	</div> 
		</div>

		<div class="cls-rmtype btn-group">
		  	<button type="button" class="btn btn-primary white-bg-border dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo Yii::t('app','Room Type'); ?></button>
			  
		  	<div class="dropdown-menu dropdown-menu-form">
			    <div class="popup-body clearfix">
			    	<div class="checkboxatrb">
			    	<?php
			    		
			    		foreach($roomData as $room_data)
			    		{
			    			echo '<label>
						    			<span class="check-cover">';
					?>
						<input type="checkbox" id="<?= $room_data['roomtypeid']; ?>" name="roomdata[]" 
						value="<?= $room_data['roomtypeid']; ?>"
						onclick="updateSearchList('<?= $room_data['roomtypeid']; ?>','roomtype-checkbox');"
						 class="form-control" <?= (isset($_GET['roomtype']) && $_GET['roomtype'] == $room_data['roomtypeid']) ? 'checked="checked"' : ''; ?>> 
					<?php
						    echo '<div class="airfcfx-search-checkbox-text"></div> 
						    			</span>
						    			<span class="check-cover">'.$room_data['roomtype'].'<br><small>'.$room_data['description'].'</small></span>
						    		</label>';
			    		}
			    	?>
			    	
					</div>
		     	</div>
		  	</div>
		</div>

		<div class="cls-price-filter btn-group"> 
		  	<button type="button" class="btn btn-primary white-bg-border dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo Yii::t('app','Price Range'); ?></button>
			  
		  	<div class="dropdown-menu dropdown-menu-form no-padding">
			    <div class="popup-body price-rang clearfix">
			    	
			    	<div class="range-slider">
						<input id="price_range" type="text" name="price_range" value="<?= $priceRangeValue ?>">
					</div>
		     	</div>
		  	</div>
		</div>

		<div class="cls-morefileter btn-group">

		  	<button type="button" id="moreFilter" class="btn btn-primary white-bg-border filter_menu_btn"><?php echo Yii::t('app','More Filter');?></button>
			  
		</div>
	</div>
</div>

<input type="hidden" name="roomtypedata" id="roomtypedata" value="<?= $roomtype; ?>">
<input type="hidden"  id="methodtype" value="<?= $methodType; ?>"> 
<input type="hidden" name="duration" id="duration">

<?php
	if( isset($_GET['roomtype']) && $_GET['roomtype']!= '' )
	{
		$searchtype = 'home';
	}else{
		$searchtype = 'search';
	}
?>
<input type="hidden" name="searchtype" id="searchtype" value="<?= $searchtype; ?>" />

<div id="hideFace"></div>

<div class="split_cell_1 bg_white pos_rel">
<input type="hidden" name="hour_booking" id="hour_booking" value="<?php echo $hour_booking;?>"/>
<div class="filter_menu2">

<div class="padd_lf_rg_20" >

<?php
if($countryDetails > 0 && !empty($countryDetails))
	echo '<input type="hidden" id="countryid" value="'.$countryDetails.'">';
else
	echo '<input type="hidden" id="countryid" value="">';
?>

<div class="filter_menu">  

	<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="luxury-details">
            <h5 class="luxiry-title"><?php echo Yii::t('app','Rooms and Beds');?></h5>

            <div class="col-md-12 col-sm-12 col-xs-12 no-hor-padding">
            	<div id="page-wrap" class="seting-serve">
				    <form method="post" action="">

				      	<div class="clearfix">
					        <div class="col-md-4 col-sm-4 col-xs-6 no-hor-padding">
					        	<label for="name"><?php echo Yii::t('app','Beds'); ?></label>
					        </div>
					        <div class="size-rem col-md-8 col-sm-8 col-xs-6">
					        	<div class="right-postn">
					        		<input type="text" class="sizecount" name="beds-count" id="beds-count" value="1"> 		        		
					        	</div>
					        </div>
				      	</div>

					    <div class="clearfix">
					        <div class="col-md-4 col-sm-4 col-xs-6 no-hor-padding">
					        	<label for="name"><?php echo Yii::t('app','Bedrooms'); ?></label>
					        </div>
					        <div class="size-rem col-md-8 col-sm-8 col-xs-6">
					        	<div class="right-postn">
					        		<input type="text" class="sizecount" name="bedroom-count" id="bedroom-count" value="1">
					        	</div>
					        </div>
					    </div>

					    <div class="clearfix">
					        <div class="col-md-4 col-sm-4 col-xs-6 no-hor-padding">
					        	<label for="name"><?php echo Yii::t('app','Bathrooms');?></label>
					        </div>
					        <div class="size-rem col-md-8 col-sm-8 col-xs-6">
					        	<div class="right-postn">
					        		<input type="text" class="sizecount" name="bathroom-count" id="bathroom-count" value="1">
					        	</div>
					        </div>
					    </div>

				    </form>

				</div>
	        </div>
        </div>
    </div>
</div>

<div class="border_bottom2 margin_top20"></div>

<div class="panel-group accor_adj" id="accordion" role="tablist" aria-multiselectable="true">

<?php 
$aminityCount = count($aminityDetails);
if($aminityCount != 0){ ?>
  <div class="panel panel-default banel-user">
    <div class="panel-heading" role="tab" id="headingTwo">
      <div class="row">
<div class="col-xs-12 col-sm-12 margin_bottom10">
	<h5 class="luxiry-title"><?php echo Yii::t('app','Amenities');?>
	<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" class="searchcollapse toggle1 acor_nav"><i class="fa fa-angle-down"></i> </a> </h5> 
</div><!--col-sm-3 end-->
<div class="amenit-check">
<?php 
$i = 0;
While($i < 3){
?>
<div class="col-xs-12 col-sm-4 margin_bottom10">
<div class="pos_rel">
<label class="font_norm">  <input type="checkbox"  class="" onchange="updateAminity('<?php echo $aminityDetails[$i]->id; ?>')"><div class="airfcfx-search-checkbox-text"> <?php echo $aminityDetails[$i]->name; ?></div> </label>
<?php if($i == 2) 
		//echo '<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseThree" class="acor_nav"><i class="fa fa-angle-down"></i> </a>';
?>
</div>
</div><!--col-sm-3 end-->
<?php 
$i++;
} ?>
</div>
</div>
    </div>
<?php 
if($i < $aminityCount){
?>
    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
      <div class="panel-body">

<?php while ($i < $aminityCount){ 
	$aminityPosition = $i % 3;
	$aminityltPosition = ($i + 1) % 3;
if ($aminityPosition == 0){
?>
<div class="row">

<?php } ?>
<div class="amenit-check"><div class="col-xs-12 col-sm-4 border_top padd_top15">
<label class="font_norm">  <input  type="checkbox"  class="" onchange="updateAminity('<?php echo $aminityDetails[$i]->id; ?>')"><div class="airfcfx-search-checkbox-text"> <?php echo $aminityDetails[$i]->name; ?> </div> </label>
</div></div><!--col-sm-3 end-->
<?php if ($i == ($aminityCount - 0) || $aminityltPosition == 0){ ?>
</div><!--row end-->

<?php } $i++; } ?>

      </div>
<?php } ?>
    </div>
  </div>
  
  <div class="border_bottom2 margin_top10"></div>
<?php } ?>


<?php 
$homeTypeCount = count($homeTypeDetails);
if($homeTypeCount != 0){ ?>
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingTwo">
      <div class="row">
<div class="col-xs-12 col-sm-12 margin_bottom10">
<h5 class="luxiry-title"><?php echo Yii::t('app','Property Type');?>
<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree" class="acor_nav searchcollapse toggle2"><i class="fa fa-angle-down"></i> </a></h5> 
</div><!--col-sm-3 end-->
<div class="amenit-check">
<?php 
$i = 0;
While($i < 3){
?>
<div class="col-xs-12 col-sm-4 margin_bottom10">
<div class="pos_rel">
<label class="font_norm">  <input type="checkbox"  class="" onchange="updateHomeType('<?php echo $homeTypeDetails[$i]->id; ?>')">
<div class="airfcfx-search-checkbox-text"><?php echo $homeTypeDetails[$i]->hometype; ?> </div></label>
<?php if($i == 2) 
		//echo '<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree" class="acor_nav"><i class="fa fa-angle-down"></i> </a>';
?>
</div>
</div><!--col-sm-3 end-->
<?php 
$i++;
} ?>
</div>
</div>
    </div>
<?php 
if($i < $homeTypeCount){
?>
    <div id="collapseThree" class="panel-collapse collapse lastrowshow" role="tabpanel" aria-labelledby="headingTwo">
      <div class="panel-body">

<?php while ($i < $homeTypeCount){ 
	$homeTypePosition = $i % 3;
	$homeTypeltPosition = ($i + 1) % 3;
if ($homeTypePosition == 0){
?>
<div class="row">
<!--<div class="col-xs-12 col-sm-4">
</div>-->
<?php } ?>
<div class="amenit-check"><div class="col-xs-12 col-sm-4 border_top padd_top15">
<label class="font_norm">  <input  type="checkbox"  class="" onchange="updateHomeType('<?php echo $homeTypeDetails[$i]->id; ?>')"> <div class="airfcfx-search-checkbox-text"><?php echo $homeTypeDetails[$i]->hometype; ?></div>  </label>
</div></div><!--col-sm-3 end-->
<?php if ($i == ($homeTypeCount - 0) || $homeTypeltPosition == 0){ ?>
</div><!--row end-->

<?php } $i++; } ?>

      </div>
<?php } ?>
    </div>
  </div>
  
<?php } ?>
 
</div><!--panel-group end-->



  

</div><!--padd_lf_rg_20 end-->

  </div><!--filter_menu end-->

</div>

<div id="search-data" class="bg_gray1 padd_lf_rg_15 padd_bottom30"> 
<?php
	if($zeroresult == "zeroresult") { ?>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 margin_top20">
				<div class="zeroresult">
				<div class ="zeroresultText "><?php echo Yii::t('app','No results'); ?></div>
				<div class ="zeroresultDesc"><?php echo Yii::t('app',"Unable to find anything matching your search. Try searching other keywords"); ?>.</div>
				</div>
				<div class ="zeroresultShow margin_top40"><?php echo Yii::t('app',"Homes around the world"); ?>    
				</div> 
			</div>
		</div>

<?php } ?>


<?php

if(!empty($listDetails))
{
	$i = 0;
foreach ($listDetails as $listKey => $listDetail){

			if($listDetail->listingname == '')
				continue;  

			$mapArray[$listKey]['lat'] = $listDetail->latitude;
			$mapArray[$listKey]['lng'] = $listDetail->longitude;
			$evenCheck = $listKey % 2;
			if($evenCheck == 0){
?>
<div class="row">
			<?php 
				}
			?>
<div class="col-xs-12 col-sm-6 margin_top10">


<div id="carousel-example-generic<?php echo $listKey; ?>" class="carousel slide" data-ride="carousel">
	<?php $photos = $listDetail->getPhotos()->where(['listid'=>$listDetail->id])->all();
			$propertyType = $listDetail->getRoomtype0()->one(); //echo "<pre>";print_r($photos);
			$userDetails = $listDetail->getUser()->one(); 
			$currencyDetails = $listDetail->getCurrency0()->one();
			$currency = "";
			if(!empty($currencyDetails))
				$currency = $currencyDetails->currencysymbol;
			
			$usrimg = $userDetails->profile_image;
			$converter = new CurrencyConverter();
			if(isset($_SESSION['currency_code']) && $_SESSION['currency_code']!="")
			{
				$currency_code = $_SESSION['currency_code'];
				$currency_symbol = $_SESSION['currency_symbol'];
				
				if(!empty($currencyDetails))
				{
   				 $rate2= Myclass::getcurrencyprice($currencyDetails->currencycode);//listing currency
    				 $rate= Myclass::getcurrencyprice($currency_code);//user currency
				} else {
                $rate2= 1;//listing currency
                $rate= 1;//user currency
            }
                  	
			} else {
				if(!empty($currencyDetails))
				$currency_symbol = $currencyDetails->currencysymbol;
				else
				$currency_symbol = "";

				if(!empty($currency_symbol)) {
				     $rate= Myclass::getcurrencyprice($currency_symbol);//user currency
				     $rate2= Myclass::getcurrencyprice($currency_symbol);//listing currency
				} else {
				    $rate = "1";//listing currency
				    $rate2 = "1";//user currency
				}
                                
			}
		
			if($usrimg=="")
				$usrimg = "usrimg.jpg";
			$userimage = Yii::$app->urlManager->createAbsoluteUrl ('/albums/images/users/'.$usrimg);
			$userimage = Yii::$app->urlManager->createAbsoluteUrl ('resized.php?src='.$userimage.'&w=56&h=56');
			$userurl = base64_encode($userDetails->id."-".rand(0,999));
			$usernameurl = Yii::$app->urlManager->createAbsoluteUrl ( '/profile/' . $userurl );
			$userName = $userDetails->firstname;
			$userName .= $userDetails->lastname != "" ? " ".$userDetails->lastname : "";
			$listurl = base64_encode($listDetail->id.'_'.rand(1,9999));
			$listurl = Yii::$app->urlManager->createAbsoluteUrl ( '/user/listing/view/' . $listurl );

			if($listDetail->booking=="perhour")
				$mapPrice = "<h6><b>".$currency_symbol.round(($rate * ($listDetail->hourlyprice/$rate2)),2)."</b> <span>".Yii::t('app','per hour')."</span></h6>";
			else
				$mapPrice = "<h6><b>".$currency_symbol.round(($rate * ($listDetail->nightlyprice/$rate2)),2)."</b> <span>".Yii::t('app','per night')."</span></h6>";

			$mapListingname = str_replace("'", "\'", $listDetail->listingname);
			$mapListingname = str_replace('"', '\"', $mapListingname); 

			$mapArray[$listKey]['price'] = '<li><h5><a href="'.$listurl.'">'.ucfirst($mapListingname).'</a></h5><h6>'.ucfirst($propertyType->roomtype).'</h6>'.$mapPrice.'</li>';   
			//$mapArray[$listKey]['price'] = "<a href=".$listurl."><p>".ucfirst($listDetail->listingname)."</p></a>";
			//$mapArray[$listKey]['images'] = $photos;  
?>
<!-- Wrapper for slides -->
  <?php
  echo '<div class="carousel-inner" role="listbox" onmouseover="showme('.$i.')" onmouseout="hideme('.$i.')">';
  $i++;
  ?>
  <?php foreach ($photos as $photoKey => $photo){

			if(isset($photo->image_name))
			{
				$image1 = $photo->image_name;
				$listimage = Yii::$app->urlManager->createAbsoluteUrl ('/albums/images/listings/'.$image1);
			}
			else{
				$listimage = Yii::$app->urlManager->createAbsoluteUrl('/albums/images/users/usrimg.jpg');
			}
			$header_response = get_headers($listimage, 1);


			if ( strpos( $header_response[0], "404" ) !== false )
			{
				$listimage = Yii::$app->urlManager->createAbsoluteUrl('/albums/images/users/usrimg.jpg');
			}
			else
			{
				$image1 = $photo->image_name;
				$listimage = Yii::$app->urlManager->createAbsoluteUrl ('/albums/images/listings/'.$image1);
			}


			$listresizeurl = Yii::$app->urlManager->createAbsoluteUrl ('resized.php?src='.$listimage.'&w=370&h=340');
  			if ($photoKey == 0){ ?>
				<a href="<?php echo $listurl; ?>" target="_blank" title="<?php echo $listDetail->listingname; ?>"
					 class="item bg_img active" style="background-image:url(<?php echo $listresizeurl; ?>);">
				</a>
			  	<?php 
				  	$mapimage = Yii::$app->urlManager->createAbsoluteUrl ('resized.php?src='.$listimage.'&w=80&h=80');
				  	$mapArray[$listKey]['image'] = '<li><img src="'.$mapimage.'"></li>'; 
			  	?>
   		<?php } else { ?>
			   <a href="<?php echo $listurl; ?>" target="_blank" title="<?php echo $listDetail->listingname; ?>"
			   	 class="item bg_img" style="background-image:url(<?php echo $listresizeurl; ?>);">
			  </a>
    		<?php } } ?>
  </div>
  
  <?php if(count($photos) > 1) { ?>
  <a class="left carousel-control" href="#carousel-example-generic<?php echo $listKey; ?>" role="button" data-slide="prev">
    <span class="svgarrow left" aria-hidden="true"><svg viewBox="0 0 18 18" role="img" aria-label="Previous" focusable="false" style="height: 24px; width: 24px; display: block; fill: rgb(255, 255, 255);"><path d="m13.7 16.29a1 1 0 1 1 -1.42 1.41l-8-8a1 1 0 0 1 0-1.41l8-8a1 1 0 1 1 1.42 1.41l-7.29 7.29z" fill-rule="evenodd"></path></svg></span>
    <span class="sr-only"><?php echo Yii::t('app','Previous');?></span>
  </a>
  <a class="right carousel-control" href="#carousel-example-generic<?php echo $listKey; ?>" role="button" data-slide="next">
    <span class="svgarrow right" aria-hidden="true"><svg viewBox="0 0 18 18" role="img" aria-label="Next" focusable="false" style="height: 24px; width: 24px; display: block; fill: rgb(255, 255, 255);"><path d="m4.29 1.71a1 1 0 1 1 1.42-1.41l8 8a1 1 0 0 1 0 1.41l-8 8a1 1 0 1 1 -1.42-1.41l7.29-7.29z" fill-rule="evenodd"></path></svg></span>
    <span class="sr-only"><?php echo Yii::t('app','Next');?></span>
  </a>
  <?php } ?>
  
<a href="<?php echo $usernameurl; ?>" target="_blank" title="<?php echo $userName; ?>">
	<div class="bg_img1" style="background-image:url(<?php echo $userimage; ?>);"></div>
</a>
  
</div><!--carousel-example-generic end-->

<a href="<?php echo $listurl; ?>" target="_blank" title="<?php echo $listDetail->listingname; ?>">
	<p class="siml-text1 small text_gray1 margin_right60"><b><?php echo $propertyType->roomtype; ?></b></p>
</a>


<a href="<?php echo $listurl; ?>" target="_blank" title="<?php echo $listDetail->listingname; ?>">
	<p class="siml-text2 fa-1x"><?php echo $listDetail->listingname; ?></p>
</a>
	
<div class="similar-prices">

	<?php 
	$durationTitle = ($listDetail->booking=='perhour') ? "per hour" : "per night";  		
	if($listDetail->booking=='perhour') 
	{?>
		<div class="hrs-price"><span>  <?php echo $currency_symbol.round(($rate * ($listDetail->hourlyprice/$rate2)),2); ?></span><span><?php echo " ".$durationTitle ?></div>
	<?php
	}elseif( $listDetail->booking=='pernight' ){?>
		<div class="full-price"><span>  <?php echo $currency_symbol.round(($rate * ($listDetail->nightlyprice/$rate2)),2); ?></span><span><?php echo " ".$durationTitle ?></div>
	<?php }?>

	<?php
	if(isset($userid) && $userid!="" && $userid!=$listDetail->userid)  
	{
		if(in_array($listDetail->id,$wishArray)) { 
			$redhrt = "redhrt";
		} else {
			$redhrt = "";  
		}
	?>
		<div class="favorite wishicon<?php echo $listDetail->id;?>" data-toggle="modal" data-target="#myModal" onclick="show_list_popup(event,<?php echo $listDetail->id;?>);"><i class="fa fa-heart-o <?php echo $redhrt; ?>"></i><i class="fa fa-heart fav_bg"></i></div> 
	<?php }
	else if($userid == "")
	{
		$loginurl = Yii::$app->urlManager->createAbsoluteUrl ( 'signin');
	?> 
		<a href="<?php echo $loginurl;?>"><div class="favorite"><i class="fa fa-heart-o"></i><i class="fa fa-heart fav_bg"></i></div></a>
	<?php }?>

</div>


<div class="similar-ratings">
                                <div class="country-details">
                                    <?php
                            $ratings = Reviews::getRatingbylisting($listDetail->id);
                            echo '<p class="place-star-rating">';
                            
                              for($x=1; $x<=$ratings['rating']; $x++) {
                                echo '<span class="full-star-span">
                                    <svg viewBox="0 0 1000 1000" role="presentation" aria-hidden="true" focusable="false" style="height: 1em; width: 1em; display: block; fill: currentcolor;"><path d="M971.5 379.5c9 28 2 50-20 67L725.4 618.6l87 280.1c11 39-18 75-54 75-12 0-23-4-33-12l-226.1-172-226.1 172.1c-25 17-59 12-78-12-12-16-15-33-8-51l86-278.1L46.1 446.5c-21-17-28-39-19-67 8-24 29-40 52-40h280.1l87-278.1c7-23 28-39 52-39 25 0 47 17 54 41l87 276.1h280.1c23.2 0 44.2 16 52.2 40z"></path></svg>
                                </span>';
                            }
                            if (strpos($ratings['rating'],'.')) {
                                echo '<span class="half-star-span">
                                    <span class="no-cover-star">
                                      <svg viewBox="0 0 1000 1000" role="presentation" aria-hidden="true" focusable="false" style="height: 1em; width: 1em; display: block; fill: currentcolor;"><path d="M971.5 379.5c9 28 2 50-20 67L725.4 618.6l87 280.1c11 39-18 75-54 75-12 0-23-4-33-12l-226.1-172-226.1 172.1c-25 17-59 12-78-12-12-16-15-33-8-51l86-278.1L46.1 446.5c-21-17-28-39-19-67 8-24 29-40 52-40h280.1l87-278.1c7-23 28-39 52-39 25 0 47 17 54 41l87 276.1h280.1c23.2 0 44.2 16 52.2 40z"></path></svg>
                                    </span>
                                    <span class="off-cover-star">
                                      <svg viewBox="0 0 1000 1000" role="presentation" aria-hidden="true" focusable="false" style="height: 1em; width: 1em; display: block; fill: currentcolor;"><path d="M510.2 23.3l1 767.3-226.1 172.2c-25 17-59 12-78-12-12-16-15-33-8-51l86-278.1L58 447.5c-21-17-28-39-19-67 8-24 29-40 52-40h280.1l87-278.1c7.1-23.1 28.1-39.1 52.1-39.1z"></path></svg>
                                    </span>
                                </span>';
                                $x++;
                            }
                            while ($x<=5) {
                                echo '<span class="half-star-span">
                                    <span class="no-cover-star">
                                      <svg viewBox="0 0 1000 1000" role="presentation" aria-hidden="true" focusable="false" style="height: 1em; width: 1em; display: block; fill: currentcolor;"><path d="M971.5 379.5c9 28 2 50-20 67L725.4 618.6l87 280.1c11 39-18 75-54 75-12 0-23-4-33-12l-226.1-172-226.1 172.1c-25 17-59 12-78-12-12-16-15-33-8-51l86-278.1L46.1 446.5c-21-17-28-39-19-67 8-24 29-40 52-40h280.1l87-278.1c7-23 28-39 52-39 25 0 47 17 54 41l87 276.1h280.1c23.2 0 44.2 16 52.2 40z"></path></svg>
                                    </span>
                                </span>';
                                $x++;
                            }
                            echo '<span class="place-reviews"> '.$ratings['n_rating'].' </span>';    
                    ?>
                                </div>
                            </div>



</div><!--col-sm-6 end-->
<?php if($evenCheck != 0 || count($listDetails) == ($listKey + 1)){
?>
</div><!--row end-->
<?php }
}}
else
{ ?>
	<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 margin_top20">
				<div class="zeroresult">
				<div class ="zeroresultText "><?php echo Yii::t('app','No results'); ?></div>
				<div class ="zeroresultDesc"><?php echo Yii::t('app',"Unable to find anything matching your search. Try searching other keywords"); ?>.</div>
				</div>
				<div class ="zeroresultShow margin_top40"><?php echo Yii::t('app',"Homes around the world"); ?>   
				</div> 
			</div>
		</div>
<?php }
?>
</div>

<div class="filter_menu4 margin_bottom30">
<div class="bg_gray1 ">
<!--filter mobile popup-->
<div class="modal fade" id="airfcfx-mobile-filt" role="dialog"> 
				<div class="modal-dialog mobile-cal-cnt">
					<div class="mobile-cal-header">
						Filters
					</div>
					<div class="mobile-cal-body">
						<div class="mobile-cal-divider"></div>
						<div class="mobile-cal-size-cnt">
            <select id="bedroom-count-mobile" class="form-control" >
            <option value=""><?php echo Yii::t('app','Bedrooms');?></option>
            <?php for ($i = 1; $i <= $listingProperties->bedrooms; $i++){
                echo "<option value='$i'>$i Bedrooms</option>";
            }?>
            </select>
            <select id="bathroom-count-mobile" class="form-control">
            <option value=""><?php echo Yii::t('app','Bathrooms');?></option>
            <?php for ($i = 1; $i <= $listingProperties->bathrooms; $i++){
                echo "<option value='$i'>$i Bathrooms</option>";
            }?>
            </select>
            <select id="beds-count-mobile" class="form-control">
            <option value=""><?php echo Yii::t('app','Beds');?></option>
            <?php for ($i = 1; $i <= $listingProperties->beds; $i++){
                echo "<option value='$i'>$i Beds</option>";
            }?>
            </select>
						</div>
						<div class="mobile-cal-divider"></div>
						<div class="mobile-cal-section-heading txt-left-align">Amenities</div>
						<div class="mobile-cal-check-cnt">
              <?php 
              $i = 0;
              While($i < 3){
              ?>
							<div class="pos_rel">
								<label class="font_norm">
								<input type="checkbox"  class="" onchange="updateAminity('<?php echo $aminityDetails[$i]->id; ?>')">
								<div class="airfcfx-search-checkbox-text"><?php echo $aminityDetails[$i]->name; ?></div>
								</label>
							</div>
              <?php if($i == 2) 
              {
                echo '<div class="airfcfx-more-div">
                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwomobile" aria-expanded="false" 
                aria-controls="collapseThree" onclick="hide_more_txt(this)" id="amenitymore">+ More </a></div>';
              } 
                  
              ?>                
              <?php 
              $i++;
              } ?>  
						</div>
            <?php 
            if($i < $aminityCount){
            ?>
            <div id="collapseTwomobile" class="panel-collapse collapse clear" role="tabpanel" aria-labelledby="headingTwo">
              <div class="panel-body">
                <?php while ($i < $aminityCount){ 
                  $aminityPosition = $i % 3;
                  $aminityltPosition = ($i + 1) % 3;
                if ($aminityPosition == 0){
                ?>
                <div class="row">

                <?php } ?>
                <div class="pos_rel">
                <label class="font_norm">  
                  <input  type="checkbox"  class="" onchange="updateAminity('<?php echo $aminityDetails[$i]->id; ?>')">
                  <div class="airfcfx-search-checkbox-text"> <?php echo $aminityDetails[$i]->name; ?> </div> 
                </label>
                </div><!--col-sm-3 end-->
                <?php if ($i == ($aminityCount - 0) || $aminityltPosition == 0){ ?>
                </div><!--row end-->

            <?php } $i++; } ?>

              </div>
            <?php } 
                echo '<div class="airfcfx-less-div">
                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwomobile" aria-expanded="false" 
                aria-controls="collapseThree" onclick="show_more_txt()">- Less </a></div>';  
                ?>          
          </div>
  </div>
  
  <div class="border_bottom2 margin_top10"></div>
						<div class="mobile-cal-divider"></div>
						<div class="mobile-cal-section-heading txt-left-align">Property Type</div>
						<div class="mobile-cal-check-cnt">
              <?php 
              $i = 0;
              While($i < 3){
              ?>
							<div class="pos_rel">
								<label class="font_norm">
								<input type="checkbox"  class="" onchange="updateHomeType('<?php echo $homeTypeDetails[$i]->id; ?>')">
								<div class="airfcfx-search-checkbox-text"><?php echo $homeTypeDetails[$i]->hometype; ?></div>
								</label>
							</div>
              <?php if($i == 2) 
              {
                  echo '<div class="airfcfx-more-div">
                  <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThreemobile" aria-expanded="false" 
                  aria-controls="collapseThree" onclick="hide_more_txt(this)" id="propertymore">+ More </a></div>';
              }
              ?>               
              <?php 
              $i++;
              } ?>              
						</div>
            <?php 
            if($i < $homeTypeCount){
            ?>
            <div id="collapseThreemobile" class="panel-collapse collapse clear" role="tabpanel" aria-labelledby="headingTwo">
                  <div class="panel-body">

            <?php while ($i < $homeTypeCount){ 
              $homeTypePosition = $i % 3;
              $homeTypeltPosition = ($i + 1) % 3;
            if ($homeTypePosition == 0){
            ?>
            <div class="row">

            <?php } ?>
            <div class="pos_rel">
            <label class="font_norm">  
              <input  type="checkbox"  class="" onchange="updateHomeType('<?php echo $homeTypeDetails[$i]->id; ?>')"> 
              <div class="airfcfx-search-checkbox-text"><?php echo $homeTypeDetails[$i]->hometype; ?></div>  </label>
            </div><!--col-sm-3 end-->
            <?php if ($i == ($homeTypeCount - 0) || $homeTypeltPosition == 0){ ?>
            </div><!--row end-->

            <?php } $i++; } ?>

                  </div>
            <?php } 
                  echo '<div class="airfcfx-less-div">
                  <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThreemobile" aria-expanded="false" 
                  aria-controls="collapseThree" onclick="show_more_txt1()">- Less </a></div>';            
            ?>
                </div>
              </div>
              
						<div class="mobile-cal-divider"></div>
						<button class="airfcfx-white-btn airfcfx-mobile-cal-2btn airfcfx-slider-btn btn btn_search"  data-dismiss="modal" type="button"><?php echo Yii::t('app','Cancel');?></button>
						<button class="airfcfx-mobile-cal-2btn airfcfx-slider-btn btn btn_search pull-right" onclick="updateSearchListmobile('home1', 'more');"><?php echo Yii::t('app','Apply Filters');?></button>
					</div>
				</div>
			</div>

<div class="airfcfx-mobile-float-icon-cnt"><button type="button" class="airfcfx-mobile-morefilter-btn btn btn-default margin_top10" data-toggle="modal" data-target="#airfcfx-mobile-filt"><b><?php echo Yii::t('app','More Filter');?></b></button></div>




<input type="hidden" value="<?php echo $totalCount; ?>" class="total-count-value" />
<?php 
$totalPage = ($totalCount / $pagesContent);
$totalPage = ceil($totalPage);
if($totalPage > 1){ $i = 1; ?>
<div class="margin_bottom50 text-center margin_top50">
<p class="listpagecount defaultsearchlist 1"><b><?php echo "1 – ".$pagesContent." of ". $totalCount; ?> <?php echo Yii::t('app','Rentals ');?></b></p>
<ul class="pagination main-pagination padding_bottm30"> 
<?php while($i < $totalPage && $i < 4){
		if($i == 1){
			echo "<li class='active'><a href='javascript:void(0);' onclick='updateSearchList(\"pagination\", \"$i\");'>$i</a></li>";
		}else{
			echo "<li><a href='javascript:void(0);' onclick='updateSearchList(\"pagination\", \"$i\");'>$i</a></li>";
		}
		$i++;
	}
	if($totalPage > 3 && $totalPage > ($i + 4)){
		echo '<li class="non_btn"><a href="javascript:void(0);">...</a></li>';
		while($i <= $totalPage){
			echo "<li><a href='javascript:void(0);' onclick='updateSearchList(\"pagination\", \"$i\");'>$i</a></li>";
			$i++;
		}
	}elseif ($i <= $totalPage){
		while($i <= $totalPage){
			echo "<li><a href='javascript:void(0);' onclick='updateSearchList(\"pagination\", \"$i\");'>$i</a></li>";
			$i++;
		}
	}
	echo "<li class='step-ahead'><a href='javascript:void(0);' onclick='updateSearchList(\"pagination\", \"2\");'><i class='fa fa-angle-right'></i></a></li>";
?>
</ul> 

</div>
<?php } else { ?>

<div style="text-align: center;"?>

<?php	if($totalCount > 1) {
	?>

	<p class="padding_bottm50 listpagecount defaultsearchlist"><b><?php echo "Showing 1 – ". $totalCount; ?> <?php echo Yii::t('app','Rentals ');?></b></p>
	<?php } elseif($totalCount == 1) { ?>

	<p class="padding_bottm50 listpagecount defaultsearchlist"><b><?php echo "Showing ". $totalCount; ?> <?php echo Yii::t('app','Rental ');?></b></p>

<?php } ?>

	</div> 
<?php } ?>
<input type="hidden" value="1" class="current-page">
<input type="hidden" value="<?php echo $pagesContent; ?>" class="offset">
<input type="hidden" value="<?php echo $pagesContent; ?>" class="limit">
<input id="place-latitude" type="hidden" value="<?php echo (isset($lat) && trim($lat)!="") ? $lat:""; ?>">
<input id="place-longitude" type="hidden" value="<?php echo (isset($lng) && trim($lng)!="") ? $lng:""; ?>">	
 
</div><!--padd_lf_rg_20 end-->
</div> <!--bg_gray1 end-->
</div><!--filter_menu4 end-->


<div class="bottom_filter">
<button type="button" class="btn min-blue-bg btn-default filter_menu_btn"><?php echo Yii::t('app','Close');?></button>
<button type="button" class="btn min-blue-bg btn-default  filter_menu_btn margin_left10" onclick="updateSearchList('home1', 'more');"><?php echo Yii::t('app','Apply Filters');?></button>
</div><!--bottom_filter end-->

</div>  <!--cell_1 end-->
</div>
<div class="split_cell_2">

<div class="airfcfx-map-check-div">	
	<label>
			<input type="checkbox" id="searchmove" name="searchmove">
			<div class="airfcfx-search-checkbox-text" for="commonamenities1" style="display:block">Search as I move the map</div>
	</label>
</div>	
<div id="map" style="border:0; height:84.5vh; width:100%;">

</div>


</div>  <!--cell_2 end-->

<script>

//slideer stop
$('.carousel').carousel({
  interval: false
})
//Range slider
  jQuery(document).ready(function($) {
  	//https://egorkhmelev.github.io/jslider/
	  var priceto = $.trim('<?php echo $priceRangeValue; ?>');
    priceto = priceto.split(';');
	  // Price Range Input
	  $("#price_range").rangeslider({
		  from: 0,
		  to: 10010,  
		  limits: false,
		  //scale: ['0', '5K', '10K'],
		  step: 10,
		  smooth: true,
		  dimension: '<em id="filterCurrency"><?php echo $currencyCode." (".$currencySymbol.")"; ?></em>', 
		  onstatechange: function( value ){
    		pricerange = value.split(";");
		    if (pricerange[0]>=10000) { 
		       $(".jslider-value.jslider-value-to > span").html('10000+');
		    } else if (pricerange[1]>10000) { 
		       $(".jslider-value.jslider-value-to > span").html(pricerange[0] +' - 10000+');
		    } else {
		        $(".jslider-value.jslider-value-to > span").html(pricerange[0] +' - '+ pricerange[1]);
		    }
  		}
	  });

	  if(priceto[1] > 10000) {
	  		$(".jslider-value.jslider-value-to > span").html(priceto[0] +' - 10000+'); 
	  }
  });

//Range slider  
$(document).ready(function(){
    $(".toggle_foot, .close_x").click(function(){
        $(".toggle_foot1").toggleClass("foot_ads");
    });
});


//Range slider  
$(document).ready(function(){
    $(".filter_menu_btn").click(function(){
        $(".filter_menu").toggleClass("filter_menu1");
		$(".filter_menu2").toggleClass("filter_menu3");
		$(".filter_menu4").toggleClass("filter_menu5");
		$(".bottom_filter").toggleClass("filter_menu1");		
    });
});

</script>
<script async defer type="text/javascript" src="<?php echo $baseUrl;?>/js/map_actions.js"></script>

<script async defer type="text/javascript">

	var markerPoints = new Array();
	var infoMarker = new Array();
	var baseLat = <?php $lat = (trim($lat==""))?"0": $lat; echo $lat; ?>; 
	var baselng = <?php $lng = (trim($lng==""))?"0": $lng; echo $lng; ?>;  
  
   <?php 
    if(isset($mapArray) && count($mapArray) > 0){
	    foreach($mapArray as $key => $val){ ?>
	    	var locations = {lat: <?php echo $val['lat']; ?>, lng: <?php echo $val['lng']; ?>};
	    	markerPoints.push(locations);
	    	infoMarker.push('<?php echo '<ul class="mapInfoContent">'.$val['image'].$val['price'].'</ul>'; ?>'); 
	    <?php }
	} ?>
  	var latLng = new google.maps.LatLng(baseLat, baselng);
   var geocoder= new google.maps.Geocoder();
   var searchval = $("#where-to-go").val();
   var zoomval;
   
   geocoder.geocode( {'latLng': latLng},
      function(results, status) {
        	if(status == google.maps.GeocoderStatus.OK) {
          	if(results[0]) {
					var add= results[0].formatted_address ;
					var  value=add.split(",");

					count=value.length;
					country=value[count-1];
					state=value[count-2];

					if (typeof results[0]['address_components'][4] != 'undefined') {
						city=results[0]['address_components'][4].long_name;
					} else
                	city = "";
                    
               cityexist = searchval.indexOf(city);
                    
               if(cityexist>=0)
                  zoomvalue = "10";
               else
                  zoomvalue = "6";
               
               zoomval = <?php if($countryDetails > 0){ echo "4";} else { ?>parseInt(zoomvalue)<?php } ?>; 
          	}
         }  
      }
    );
    google.maps.event.addListener(map,'click',function(event) { alert("dfsd");

});
</script>
	
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog listpopupwidth" role="document">
    <div class="modal-content">

      <div class="modal-body padding0">
      	<div class="toplistdiv" style="display:none;">
	      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	      	<span aria-hidden="true">&times;</span>
	      </button>   
	      <h3>Save to Wish List</h3>          
	      <hr />
	</div>
      	  <div class="airfcfx-leftlistdiv leftlistdiv">
				<div class="banner2 banner2hgt" id="listimage" ></div>
      	  </div>
		  <input type="hidden" value="" id="listingid">
	<div class="airfcfx-rightlistdiv-cnt">
	 <div class="airfcfx-rightlistdiv rightlistdiv padding20 wishlisthgt">
	 
	 <div class="airfcfx-topfullviewdiv topfullviewdiv">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="float:right !important; "><span aria-hidden="true">&times;</span></button>   
	      <h3>Save to Wish List</h3><hr />
         </div>
		 
	 <div class="airfcfx-wishlist-contianer" id="listsdiv"> 
<div id="listnames"></div>
          </div>
		  </div>
		  <div class="airfcfx-wish-createlist-cnt">
			  <input type="text" id="newlistname" class="airfcfx-listtxt listtxt" value="" placeholder="Create New List" maxlength="20">
			  <input type="button" value="Create" class="airfcfx-createbtn btn btn-danger createbtn" onclick="create_new_list();">
		  </div> 
          <div class="airfcfx-wishlist-btn-cnt">
        	<input type="button" value="Cancel" class="airfcfx-cancelsze btn btn_email cancelsze cancelbtn " data-dismiss="modal">
			<input type="button" value="Save" data-dismiss="modal" class="airfcfx-savebtn btn btn-primary savebtn pull-right" onclick="save_lists();">
			<div class="errcls listerr"></div>
         </div>
		</div> 
    		  
	  </div>
      <div class="clear">

      </div>            
  </div>
</div>
</div>	

<script>
	$(document).ready(function(){ 
		$("body").css("overflow","hidden");
		$(".alert-success").addClass("flashcss");

		$("#closebutton").click(function(){
			$(".alert-success").removeClass("flashcss");
		});
	});

	var clickCount = 0;
	
	$('.toggle1').click(function(){ 
		var foo = $(this).attr('aria-expanded');
		if(foo == "false") {
			$('.toggle1>i').removeClass('fa-angle-down');
			$('.toggle1>i').addClass('fa-angle-up'); 
		} else {
			$('.toggle1>i').removeClass('fa-angle-up');
			$('.toggle1>i').addClass('fa-angle-down');  
		} 
		$('.toggle2>i').removeClass('fa-angle-up');
		$('.toggle2>i').addClass('fa-angle-down');    
	});

	$('.toggle2').click(function(){ 
		var foo1 = $(this).attr('aria-expanded');
		if(foo1 == "false") {
			$('.toggle2>i').removeClass('fa-angle-down');
			$('.toggle2>i').addClass('fa-angle-up'); 
		} else {
			$('.toggle2>i').removeClass('fa-angle-up');
			$('.toggle2>i').addClass('fa-angle-down');   
		} 
		$('.toggle1>i').removeClass('fa-angle-up');
		$('.toggle1>i').addClass('fa-angle-down');  
	});

</script>

<script type="text/javascript">
$(function() {

  $(".right-postn").append('<span class="editiveplus">+</span> <div class="dec inc-dec">-</div><div class="inc inc-dec">+</div>');

  $(".inc-dec").on("click", function() {

    var $button = $(this);
    var oldValue = $button.parent().find("input").val();

    if ($button.text() == "+") {
  	  var newVal = parseFloat(oldValue) + 1;
  	} else {
	   // Don't allow decrementing below zero
      if (oldValue > 1) {
        var newVal = parseFloat(oldValue) - 1;
	    } else {
        newVal = 1; 
      }
	}

    $button.parent().find("input").val(newVal);

  });

});
</script>


<script type="text/javascript">

$(function() {
	var startDates = '<?php echo $checkIndate; ?>';
	var endDates = '<?php echo $checkOutdate; ?>';
	var autoTitle = ($.trim(startDates)==$.trim(endDates)) ? false : true; 
	if($.trim(startDates)==$.trim(endDates) && $.trim(startDates) !="" && $.trim(endDates) !="") { 
		$('#daterange').val("<?php echo date('d M',strtotime($momentCheckIndate)); ?>");    
	} 
    $('input[name="daterange"]').daterangepicker({
    	startDate: moment(new Date('<?php echo $momentCheckIndate; ?>')),
    	endDate: moment(new Date('<?php echo $momentCheckOutdate; ?>')), 
    	autoUpdateInput: autoTitle, 
        locale: {
            format: 'DD MMM',
            cancelLabel: 'Clear'
        }
    });

    $('input[name="daterange"]').on('apply.daterangepicker', function(ev, picker) {
    	var pStartDate = picker.startDate.format('MM/DD/YYYY');
    	var pEndDate = picker.endDate.format('MM/DD/YYYY');

    	if(pStartDate == pEndDate){
    		var pStartDates = picker.startDate;
    		//var pEndDates = picker.endDate.add(1, "days");
    		var pEndDates = picker.endDate;
    		$('#daterangepick_value').val(pStartDates.format('MM/DD/YYYY') + ' - ' +pEndDates.format('MM/DD/YYYY'));
         //$(this).val(pStartDates.format('DD MMM') + ' - ' + pEndDates.format('DD MMM'));  
         $(this).val(pStartDates.format('DD MMM'));   
    	} else {
        $('#daterangepick_value').val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
        $(this).val(picker.startDate.format('DD MMM') + ' - ' + picker.endDate.format('DD MMM')); 
      }
      updateSearchList('#daterangepick_value','daterange');  
    });

    $('input[name="daterange"]').on('cancel.daterangepicker', function(ev, picker) {   
        $('#daterange').data('daterangepicker').setStartDate(moment());
        //$('#daterange').data('daterangepicker').setEndDate(moment().add(1, "days")); 
        $('#daterange').data('daterangepicker').setEndDate(moment()); 
        $(this).val('Dates'); 
        $('#daterangepick_value').val('');
        updateSearchList('#daterangepick_value','daterange'); 
    });

    
});

</script>

<style type="text/css">
	.padd_lf_rg_15 {
		padding:0px 15px !important; 
	}
	.pac-container {
	    z-index: 99999;
    }

	#spinmodal
    {
        position: fixed;
        z-index: 999;
        height: 100%;
        width: 100%;
        top: 0;
        left: 0;
        background-color: Black;
        filter: alpha(opacity=60);
        opacity: 0.6;
        -moz-opacity: 0.8;
    }
    .center
    {
        z-index: 1000;
        margin: 300px auto;
        padding: 10px;
        width: 67px;
        background-color: White;
        border-radius: 10px;
        filter: alpha(opacity=100);
        opacity: 1;
        -moz-opacity: 1;
    }
	#infoWindow {
	    width: 250px !important; 
	    overflow: hidden;
	}
	#txt {
		width: 250px !important;
	    overflow: hidden;
	    font-weight: bold;
	    font-size: 15px;
	    word-wrap: break-word;
	}
    .navbar.navbar-default.norm_nav {
    	z-index: 99999;
	}
	.search-filter-listing {
	    position: relative;
	    z-index: 1041;
	    background: #fff;
	    border-bottom: 1px solid #eeeeee;
	}
		.jslider .jslider-value {
	    display: none !important;
	    visibility: hidden !important; 
  	}
  	.jslider .jslider-scale ins{
  		color: #000 !important;
  	}
  	.jslider-scale {
  		top:-40px !important;
  		left:18px !important;
  	}
  	.jslider-value.jslider-value-to {
  		width: 100% !important;
  		display: block !important;
  		visibility: visible !important;
  		left: 0% !important;
  		margin: 0px !important;
  		padding: 0px !important;
		font-weight: bold;  
		font-size: 12px;
		color: #006C70 !important; 
	}
	.jslider-value.jslider-value-to #filterCurrency {
		font-style: normal !important;
		line-height: 14px;
		display: block;  
	}
	ul.mapInfoContent{
		list-style: none;
		padding: 0px;
		display: flex; 
	}
	ul.mapInfoContent > li:first-child {
		margin-right: 10px !important;
	}

	ul.mapInfoContent > li:first-child > img{
		border-radius: 5px !important;
	}

	#map .gm-style-mtc div {
		height: 25px !important;
		font-size: 12px !important;
		padding: 0px 10px !important;
	}
	#map .gm-style-mtc > div div{
		padding: 0px !important;
	}
	#map .gm-style-mtc > div div label{
		margin:5px 0px 0px !important;
		font-size: 12px !important;
	}

	.airfcfx-map-check-div .airfcfx-search-checkbox-text {
		font-size: 12px !important; 
		line-height: initial !important;   
	}


	.zeroresultText { 
		font-weight: 700;
		font-size: 28px;
		letter-spacing: -0.6px;
		text-align: left;
		color: #fe5771; 
		
		
	}

	.zeroresultDesc {
		font-size: 14px;
		font-weight: 500;
	} 

	.zeroresultShow {
		font-weight: 700;
		font-size: 28px;
		letter-spacing: -0.6px;
		text-align: left;
		/*color: #007D8C;*/
		color: #484848 ! important;
		margin-bottom: 10px;
	} 

	.searchcollapse {
		margin-right:15px; 
		float: right;
	}

</style> 
