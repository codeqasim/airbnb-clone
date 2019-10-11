<?php
/*
 * This page is for displaying the information about the user. It is the profile page of the user.
 *
 * @author: Muthumareeswari
 * @package: Views
 * @PHPVersion: 5.4
 */
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
$this->title = 'Create Listing';
?>
<?php
$baseUrl = Yii::$app->request->baseUrl;
//echo $userdata['firstname'];die;
$firstname = $userdata['firstname'];
$lastname = $userdata['lastname'];
$hour_booking= $sitesettings->hour_booking;

?>

<div class="bg_gray1">
<div class="container">
	<div class="row">
        
		<div class="listing-create col-xs-12">
		
        <div class="col-xs-12 col-sm-12 col-md-6">

                <div class="col-xs-12 margin_top30 margin_bottom30">
                    <h1><?php echo Yii::t('app','List Your Space');?></h1>
                    <p><?php echo $sitesettings->sitename;?><?php echo ' '.Yii::t('app','lets you make money renting out your place.');?>  </p>
                </div>


        	<div class="col-xs-12 airfcfx-createlist no-hor-padding">
            	<div class="col-md-12 col-sm-12 col-xs-12">
                        <label><?php echo Yii::t('app','Home Type');?></label>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                        <select class="select_list select_list-comman  home" id="homeother" style="width:100%;position:relative;">
                        <?php 
            			foreach($hometype as $homes)
            			{
            				{
            					echo '<option value="'.$homes->id.'">'.$homes->hometype.'</option>';
            				}
            			}
            			?>
                        </select>
                

                <div id="homeerr" class="errcls"></div>
                </div>
            </div> <!-- col-sm-12 end -->
            
            <div class="col-xs-12 no-hor-padding">

                 <div class="col-md-12 col-sm-12 col-xs-12">
                        <label><?php echo Yii::t('app','Room Type');?></label>
                </div>

                <div class="col-md-12 col-sm-12 col-xs-12">
                        <select class="select_list-comman roomtype">
                            <!--<option value="0">Others</option>-->
                            <option value="<?php echo $roomtype[0]->id;?>"><?php echo $roomtype[0]->roomtype;?></option>
                            <option value="<?php echo $roomtype[1]->id;?>"><?php echo $roomtype[1]->roomtype;?></option>
                            <option value="<?php echo $roomtype[2]->id;?>"><?php echo $roomtype[2]->roomtype;?></option>
                        </select>
                        <div id="roomerr" class="errcls"></div>
                </div>
            </div> <!-- col-sm-12 end -->
                     <input type="hidden" id="hour_booking" value="<?php echo $hour_booking;?>" />
            <?php if($hour_booking=='yes'){ ?>

                <div class="col-md-6 col-sm-6 col-xs-12 no-hor-padding">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <label><?php echo Yii::t('app','Duration');?></label>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                            <select class="select_list select_list-comman" id="booking">
                            <option value=""><?=Yii::t('app','Select Duration')?></option>
                            <option value="<?php echo 'perhour';?>">Hourly based</option>
                            <option value="<?php echo 'pernight';?>">Per Night</option>
                            
                            </select>
                            <div id="bookerr" class="errcls"></div>
                    </div>
                   
                </div> 
            <?php } else { ?>
                <div class="col-md-6 col-sm-6 col-xs-12 no-hor-padding">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <label><?php echo Yii::t('app','Duration');?></label>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                            <select class="select_list select_list-comman" id="booking">
                            <option value="">Select Duration</option>
                            <option value="<?php echo 'pernight';?>">Per Night</option> 
                            
                            </select>
                            <div id="bookerr" class="errcls"></div>
                    </div>
                   
                </div>
            <?php } ?>
            
            <div class="col-md-6 col-sm-6 col-xs-12 no-hor-padding margin_bottom20">
                <div class="col-md-12 col-sm-12 col-xs-12">
                        <label><?php echo Yii::t('app','Accomodates');?></label>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                        <select class="select_list select_list-comman" id="accommodate">
            			<?php
            			for($i=1;$i<=$listingproperties->accommodates;$i++)
            			{
            				echo '<option value="'.$i.'">'.$i.'</option>';
            			}
            			?> 
                        </select>
                

                 </div>
            </div> <!-- col-sm-12 end -->
            
            <div class="col-md-12 col-sm-12 col-xs-12 no-hor-padding">
                <div class="col-md-12 col-sm-12 col-xs-12">
                        <label><?php echo Yii::t('app','City');?></label>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="input-group" style="width: 100%">
                        <input type="text" class="location-list" id="citynew" placeholder="<?php echo Yii::t('app','Enter a Location');?>" />
                        <input type="hidden" id="city" name="city">
                        <input type="hidden" id="state" name="state">
                        <input type="hidden" id="country" name="country">
                        <input type="hidden" id="latitude" name="latitude">
                        <input type="hidden" id="longitude" name="longitude"> 
                    </div>
                
                <div id="cityerr" class="errcls"></div>
                </div>
            </div> <!-- col-sm-12 end -->
            
            <div class="col-md-12 col-sm-12 col-xs-12 no-hor-padding margin_top20">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  
                </div>
                 <div class="col-md-12 col-sm-12 col-xs-12">
                    <button class="btn btn_email padding10" type="button" onclick="savelist()"><?php echo Yii::t('app','Continue');?></button>
        			<div id="emailverifyerr" class="errcls"></div>
                </div>
            </div>
            
        </div> <!-- col-sm-6 end -->

        <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="listing-right-img">
                <img class="img-responsive" src="<?php echo $baseUrl.'/images/listing-img.svg'; ?>" alt="image" />
            </div>
        </div>
		
		</div>
    </div> <!-- row end -->

</div> <!-- container end -->

	
</div>

    <!-- script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?v=3&sensor=false&libraries=places"></script-->
    <script type="text/javascript">
        google.maps.event.addDomListener(window, 'load', function () {
            var places = new google.maps.places.Autocomplete(document.getElementById('citynew'));
            google.maps.event.addListener(places, 'place_changed', function () {
                var place = places.getPlace();
                var latitude = place.geometry.location.lat();
                var longitude = place.geometry.location.lng();

                document.getElementById("latitude").value = latitude;
                document.getElementById("longitude").value = longitude;   

                var city = "";
                for (var i = 0; i < place.address_components.length; i++) {
                    var addressType = place.address_components[i].types[0];
                    //if (componentForm[addressType]) {
                          
                    if(addressType=="locality") {
                    	document.getElementById("city").value = place.address_components[i].long_name;
                        city = place.address_components[i].long_name;
                    } /*else if (addressType == "sublocality_level_1"){ 
                        document.getElementById("city").value = place.address_components[i].long_name;
                        city = place.address_components[i].long_name;    
                    }*/ else if(addressType=="administrative_area_level_1") 
                    	document.getElementById("state").value = place.address_components[i].long_name;
                    else if(addressType=="country")
                    	document.getElementById("country").value = place.address_components[i].long_name;

                    if(city == "") {
                        document.getElementById("city").value = "";
                    } 
                      //var val = place.address_components[i].long_name;alert(val);
                     // document.getElementById(addressType).value = val;
                    //}
                  }                
                //document.getElementById("citynew").value = place.address_components[0].long_name;
                //document.getElementById("state").value = place.address_components[1].long_name;
                //document.getElementById("country").value = place.address_components[2].long_name;
                //alert(mesg);
            });
        });
    </script>
