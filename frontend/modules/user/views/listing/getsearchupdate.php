<?php
use backend\components\Myclass;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\LinkPager;
//use yii\CurrencyConverter\CurrencyConverter; 
use frontend\models\Reviews; 

/* @var $this yii\web\View */
/* @var $model frontend\models\Listing */

$baseUrl = Yii::$app->request->baseUrl;
$hour_booking= $sitesettings->hour_booking;
//echo base64_encode("2_".rand(1,9999));
if(!empty($listDetails))
{
	$i = 0;
foreach ($listDetails as $listKey => $listDetail){
	$mapArray[$listKey]['lat'] = $listDetail->latitude;
	$mapArray[$listKey]['lng'] = $listDetail->longitude;
	$evenCheck = $listKey % 2;
	if($evenCheck == 0){
		?>
<div class="row">
			<?php }
			echo '<div class="col-xs-12 col-sm-6 margin_top10">';
?>


<div id="carousel-example-generic<?php echo $listKey; ?>" class="carousel slide" data-ride="carousel">
<?php $photos = $listDetail->getPhotos()->where(['listid'=>$listDetail->id])->all();
		$propertyType = $listDetail->getRoomtype0()->one(); //echo "<pre>";print_r($photos);
		$userDetails = $listDetail->getUser()->one(); 
		$currencyDetails = $listDetail->getCurrency0()->one();
		if(!empty($currencyDetails))
		$currency = $currencyDetails->currencysymbol;
		$usrimg = $userDetails->profile_image;
					
					if(isset($_SESSION['currency_code']) && $_SESSION['currency_code']!="")
					{
						$currency_code = $_SESSION['currency_code'];
						$currency_symbol = $_SESSION['currency_symbol'];
						
					/* new currency process */
						if(!empty($currencyDetails))
           					 {
               					 $rate2= Myclass::getcurrencyprice($currencyDetails->currencycode);//listing currency
                				 $rate= Myclass::getcurrencyprice($currency_code);//user currency
            				}
                        else
                        	{
                            $rate2= 1;//listing currency
                            $rate= 1;//user currency
                        	}
                        	/* new currency process */
					}
					else
					{
						if(!empty($currencyDetails))
						$currency_symbol = $currencyDetails->currencysymbol;
						else
						$currency_symbol = "";
						//$rate = "1";
					 /* new currency process */

                         if(!empty($currency_symbol))
                            {
                                $rate= Myclass::getcurrencyprice($currency_symbol);//user currency
                                $rate2= Myclass::getcurrencyprice($currency_symbol);//listing currency
                            }
                            else
                            {
                               $rate = "1";//listing currency
                               $rate2 = "1";//user currency
                            }
                                /* new currency process */
					}
					$listurl = base64_encode($listDetail->id.'_'.rand(1,9999));
					$listurl = Yii::$app->urlManager->createAbsoluteUrl ( '/user/listing/view/' . $listurl );

					if($listDetail->booking=="perhour")
						$mapPrice = "<h6><b>".$currency_symbol.round(($rate * ($listDetail->hourlyprice/$rate2)),2)."</b> <span>".Yii::t('app','per hour')."</span></h6>";
					else
						$mapPrice = "<h6><b>".$currency_symbol.round(($rate * ($listDetail->nightlyprice/$rate2)),2)."</b> <span>".Yii::t('app','per night')."</span></h6>";

					$mapArray[$listKey]['price'] = "<li><h5><a href=".$listurl.">".ucfirst($listDetail->listingname)."</a></h5><h6>".ucfirst($propertyType->roomtype)."</h6>".$mapPrice."</li>";  

		if($usrimg=="")
			$usrimg = "usrimg.jpg";
		$userimage = Yii::$app->urlManager->createAbsoluteUrl ('/albums/images/users/'.$usrimg);
		$userimage = Yii::$app->urlManager->createAbsoluteUrl ('resized.php?src='.$userimage.'&w=56&h=56');
		$userurl = base64_encode($userDetails->id."-".rand(0,999));
		$usernameurl = Yii::$app->urlManager->createAbsoluteUrl ( '/profile/' . $userurl );
		$userName = $userDetails->firstname;
		$userName .= $userDetails->lastname != "" ? " ".$userDetails->lastname : "";
		
?>
  <!-- Wrapper for slides -->
  <?php
  echo '<div class="carousel-inner" role="listbox" onmouseover="showme('.$i.')" onmouseout="hideme('.$i.')">';
  $i++;
  ?>
  <?php
  if(count($photos)!=0)
  {
  foreach ($photos as $photoKey => $photo){
			if(isset($photo->image_name) && $photo->image_name!="")
			{
				$image1 = $photo->image_name;
				$listimage = Yii::$app->urlManager->createAbsoluteUrl ('/albums/images/listings/'.$image1);
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
			}
			else
			$listimage = Yii::$app->urlManager->createAbsoluteUrl('/albums/images/users/usrimg.jpg');
			
			$listresizeurl = Yii::$app->urlManager->createAbsoluteUrl ('resized.php?src='.$listimage.'&w=370&h=340');
  			if ($photoKey == 0){
  ?>
  <a href="<?php echo $listurl; ?>" target="_blank" title="<?php echo $listDetail->listingname; ?>" class="item bg_img active" style="background-image:url(<?php echo $listresizeurl; ?>);">
  </a>
  <?php 
				  	$mapimage = Yii::$app->urlManager->createAbsoluteUrl ('resized.php?src='.$listimage.'&w=80&h=80');
				  	$mapArray[$listKey]['image'] = '<li><img src="'.$mapimage.'"></li>'; 
			  	?>
   <?php }else { ?>
  <a href="<?php echo $listurl; ?>" target="_blank" title="<?php echo $listDetail->listingname; ?>" class="item bg_img" style="background-image:url(<?php echo $listresizeurl; ?>);">
  </a>
    <?php } }}
	else
	{
			$listimage = Yii::$app->urlManager->createAbsoluteUrl('/albums/images/users/usrimg.jpg');
			
			$listresizeurl = Yii::$app->urlManager->createAbsoluteUrl ('resized.php?src='.$listimage.'&w=370&h=340');		
	?>
<a href="<?php echo $listurl; ?>" target="_blank" title="<?php echo $listDetail->listingname; ?>" class="item bg_img active" style="background-image:url(<?php echo $listresizeurl; ?>);">
  </a>
  <?php
	}
	?>
  </div>

  <!-- Controls -->
  <?php if(count($photos) > 1) { ?>
  <a class="left carousel-control" href="#carousel-example-generic<?php echo $listKey; ?>" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#carousel-example-generic<?php echo $listKey; ?>" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
  <?php } ?>
  
  
<a href="<?php echo $usernameurl; ?>" target="_blank" title="<?php echo $userName; ?>">
	<div class="bg_img1" style="background-image:url(<?php echo $userimage; ?>);"></div>
</a>

<!-- <div class="favorite"><i class="fa fa-heart-o"></i><i class="fa fa-heart fav_bg"></i></div> -->

  
</div><!--carousel-example-generic end-->

<a href="<?php echo $listurl; ?>" target="_blank" title="<?php echo $listDetail->listingname; ?>">
	<p class="siml-text1 small text_gray1 margin_right60"><b>  <?php echo $propertyType->roomtype; ?> </b><!-- <span class="text-warning">
	<i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star-o"></i>. 
	</span> 1 review  </b> --></p>
</a>

<a href="<?php echo $listurl; ?>" target="_blank" title="<?php echo $listDetail->listingname; ?>">
	<p class="siml-text2 fa-1x"><?php echo $listDetail->listingname; ?> </p>
</a>


<div class="similar-prices">


	<?php 
	$durationTitle = ($listDetail->booking=='perhour') ? "per hour" : "per night";  
	if($listDetail->booking=='perhour') 
	{?>
	<div class="hrs-price"><span>  <?php echo $currency_symbol.round(($rate * ($listDetail->hourlyprice/$rate2)),2); ?></span><span><?php echo " ".$durationTitle ?></div>
	<?php
	}
	else{?>
	<div class="full-price"><span>  <?php echo $currency_symbol.round(($rate * ($listDetail->nightlyprice/$rate2)),2); ?></span><span><?php echo " ".$durationTitle ?></div>
	<?php }?>

	<?php
	if(isset($userid) && $userid!="") 
	{
		if(in_array($listDetail->id,$wishArray)) {
			$redhrt = "redhrt";
		} else {
			$redhrt = "";  
		}
	?> 
	<div class="favorite wishicon<?php echo $listDetail->id;?>" data-toggle="modal" data-target="#myModal" onclick="show_list_popup(event,<?php echo $listDetail->id;?>);"><i class="fa fa-heart-o <?php echo $redhrt; ?>"></i><i class="fa fa-heart fav_bg"></i></div> 
	<?php }
	else 
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
				<div class ="zeroresultDesc"><?php echo Yii::t('app',"To get more results, try adjusting your search by changing your dates or removing your filters"); ?>.</div>   
				</div>
				  
				</div> 
			</div>
		</div>
<?php }
?>

<input type="hidden" value="<?php echo $totalCount; ?>" class="total-count-value" />
<input type="hidden" value="<?php echo $currencyCode." (".$currencySymbol.")"; ?>" class="hiddenFilterCurrency" /> 
<div style="text-align: center;">
<?php 

//echo $totalCount; exit;
$totalPage = ($totalCount / $limit);
$totalPage = ceil($totalPage);
if($totalPage > 1)
{
	if($currentPage == 1){
?>
<p class="margin_top50"><b><?php echo "1 – ".$limit." of ". $totalCount; ?> Rentals </b></p>
<?php }elseif ($currentPage == $totalPage){
	if($totalCount >= (($offset) + $limit))
	{
		?>
		<p class="margin_top50"><b><?php echo ($offset + 1)." – ".(($offset) + $limit)." of ". $totalCount; ?> Rentals </b></p>
	<?php
	}else
	{
		?>
		<p class="margin_top50"><b><?php echo ($offset + 1)." – ".$totalCount." of ". $totalCount; ?> Rentals </b></p>
		<?php
	}
	?>


<?php }else{ ?>
<p class="margin_top50"><b><?php echo ($offset + 1)." – ".(($offset) + $limit)." of ". $totalCount; ?> Rentals </b></p>
<?php } ?>
<ul class="pagination">
<?php
	if($currentPage != 1){
		echo "<li><a href='javascript:void(0);' onclick='updateSearchList(\"pagination\", \"".($currentPage - 1)."\");'><i class='fa fa-caret-left'></i></a></li>";
	} 
	if($totalPage > 4 && $currentPage > 2){
		$i = $currentPage - 2;
		while($i <= $totalPage && $i <= ($currentPage + 2)){
			if($i == $currentPage){
				echo "<li class='active'><a href='javascript:void(0);' onclick='updateSearchList(\"pagination\", \"$i\");'>$i</a></li>";
			}else{
				echo "<li><a href='javascript:void(0);' onclick='updateSearchList(\"pagination\", \"$i\");'>$i</a></li>";
			}
			$i++;
		}
	}else{
		$i = 1;
		while($i <= $totalPage && $i <= 4){
			if($i == $currentPage){
				echo "<li class='active'><a href='javascript:void(0);' onclick='updateSearchList(\"pagination\", \"$i\");'>$i</a></li>";
			}else{
				echo "<li><a href='javascript:void(0);' onclick='updateSearchList(\"pagination\", \"$i\");'>$i</a></li>";
			}
			$i++;
		}
	}
	
	if($totalPage > 3 && $totalPage > ($i + 4)){
		$i = $totalPage - 4;
		echo '<li class="non_btn"><a href="#">...</a></li>';
		while($i <= $totalPage){
			if($i == $currentPage){
				echo "<li class='active'><a href='javascript:void(0);' onclick='updateSearchList(\"pagination\", \"$i\");'>$i</a></li>";
			}else{
				echo "<li><a href='javascript:void(0);' onclick='updateSearchList(\"pagination\", \"$i\");'>$i</a></li>";
			}
			$i++;
		}
	}elseif ($i < $totalPage && $currentPage > 3 && $totalPage > ($i + 4)){
		$i = $totalPage - 4;
		while($i <= $totalPage){
			if($i == $currentPage){
				echo "<li class='active'><a href='javascript:void(0);' onclick='updateSearchList(\"pagination\", \"$i\");'>$i</a></li>";
			}else{
				echo "<li><a href='javascript:void(0);' onclick='updateSearchList(\"pagination\", \"$i\");'>$i</a></li>";
			}
			$i++;
		}
	}
	if($currentPage != $totalPage){
		echo "<li><a href='javascript:void(0);' onclick='updateSearchList(\"pagination\", \"".($currentPage + 1)."\");'><i class='fa fa-caret-right'></i></a></li>";
	}
?>
</ul> 

<!--<p class="padding_bottm50 listpagecount"><b><?php echo "1 – ".$offset." of ". $totalCount; ?> <?php echo Yii::t('app','Rentals ');?></b></p>-->


<?php } else { 
	if($totalCount > 1) {
?>

	<p class="padding_show"><b><?php echo "Showing 1 – ". $totalCount; ?> <?php echo Yii::t('app','Rentals ');?></b></p>
<?php } elseif($totalCount == 1) { ?>

	<p class="padding_show"><b><?php echo "Showing ". $totalCount; ?> <?php echo Yii::t('app','Rental ');?></b></p>

<?php }
 } ?>
<input type="hidden" value="<?php echo $currentPage; ?>" class="current-page">
<input type="hidden" value="<?php echo $offset; ?>" class="offset">
<input type="hidden" value="<?php echo $limit; ?>" class="limit">
<input type="hidden" id="duration" name="duration">
</div>
<!--div class="border_bottom"></div -->
<?php /* ?>

<p class="margin_top20">More places to stay in Paris: <a href="#" class="text_gray1"> Apartments </a>·  <a href="#" class="text_gray1">Houses</a>·  <a href="#" class="text_gray1">Bed & Breakfasts</a> ·  <a href="#" class="text_gray1">Lofts</a> · <a href="#" class="text_gray1"> Villas</a></p>

<p class="margin_top10">People also stay in  <a href="#" class="text_gray1">Pantin</a> ·  <a href="#" class="text_gray1">Montrouge</a> ·  <a href="#" class="text_gray1">Saint-Ouen</a> ·  <a  href="#" class="text_gray1">Ivry-sur-Seine</a> ·  <a href="#"  class="text_gray1">Levallois-Perret</a></p>

<p class="margin_top10"><a href="#" class="text_gray1">France   ></a> <a href="#" class="text_gray1"> Île-de-France  > </a> <a href="#" class="text_gray1">Paris</a> </p>
<?php */ ?>
<script async defer type="text/javascript">
	deleteMarkers();
	var markerPoints = new Array();
	var infoMarker = new Array();
    <?php 
    if(isset($mapArray) && count($mapArray) > 0){
	    foreach($mapArray as $key => $val){ ?>
    	var locations = {lat: <?php echo $val['lat']; ?>, lng: <?php echo $val['lng']; ?>};
    	//infoMarker.push('<?php //echo $val['price']; ?>');
    	addMarker(locations, '<?php echo '<ul class="mapInfoContent">'.$val['image'].$val['price'].'</ul>'; ?>');	 
    	//markerPoints.push(locations);
        //pausecontent.push('<?php //echo $val['lat']; ?>');
	    <?php }
	} ?>
    showMarkers(); 
</script>

<style type="text/css">
	.defaultsearchlist{
		display: none !important;
	}
	.padding_show {
		padding-top: 30px !important;
		padding-bottom: 30px !important;
	}
</style>