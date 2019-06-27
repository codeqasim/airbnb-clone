<script type="text/javascript">
function initialize(){ 
	var myOptions = {
	scrollwheel: false,
	zoom: <?php echo $zoom; ?>,
	zoomControl:true,
	zoomControlOptions: {
		style:google.maps.ZoomControlStyle.SMALL
	},
	center: new google.maps.LatLng(<?php echo $cLat; ?>,<?php echo $cLong; ?>),
	mapTypeControl: true,
	mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU},
		navigationControl: true,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	}
	map = new google.maps.Map(document.getElementById("map_canvas"),myOptions);
	google.maps.event.addListener(map, 'click', function() {
        infowindow.close();
    });
	google.maps.event.addListener(map, 'dragend', function() { doAjax(); } );
	google.maps.event.addListener(map, 'zoom_changed', function() { doAjax(); });
    downloadUrl();
	$('#header_pagination').html('<?php echo $newpaginationLink; ?>');
	$('#footer_pagination').html('<?php echo $newpaginationLink; ?>');
}
		

//<![CDATA[
      // this variable will collect the html which will eventually be placed in the side_bar 
      var side_bar_html = ""; 
    var img='images/mapIcons/marker_red.png'; 
  var yimg='images/mapIcons/marker_yellow.png';
      // arrays to hold copies of the markers and html used by the side_bar 
      // because the function closure trick doesnt work there 
      var gmarkers = []; 
      var gicons = [];
     // global "map" variable
      var map = null;
gicons["red"] = new google.maps.MarkerImage(img,
      // This marker is 20 pixels wide by 34 pixels tall.
      new google.maps.Size(20, 34),
      // The origin for this image is 0,0.
      new google.maps.Point(0,0),
      // The anchor for this image is at 9,34.
      new google.maps.Point(9, 34));
  // Marker sizes are expressed as a Size of X,Y
  // where the origin of the image (0,0) is located
  // in the top left of the image.
 
  // Origins, anchor positions and coordinates of the marker
  // increase in the X direction to the right and in
  // the Y direction down.

  var iconImage = new google.maps.MarkerImage(img,
      // This marker is 20 pixels wide by 34 pixels tall.
      new google.maps.Size(20, 34),
      // The origin for this image is 0,0.
      new google.maps.Point(0,0),
      // The anchor for this image is at 9,34.
      new google.maps.Point(9, 34));
  var iconShadow = new google.maps.MarkerImage('images/mapIcons/shadow50.png',
      // The shadow image is larger in the horizontal dimension
      // while the position and offset are the same as for the main image.
      new google.maps.Size(37, 34),
      new google.maps.Point(0,0),
      new google.maps.Point(9, 34));
      // Shapes define the clickable region of the icon.
      // The type defines an HTML &lt;area&gt; element 'poly' which
      // traces out a polygon as a series of X,Y points. The final
      // coordinate closes the poly by connecting to the first
      // coordinate.
  var iconShape = {
      coord: [9,0,6,1,4,2,2,4,0,8,0,12,1,14,2,16,5,19,7,23,8,26,9,30,9,34,11,34,11,30,12,26,13,24,14,21,16,18,18,16,20,12,20,8,18,4,16,2,15,1,13,0],
      type: 'poly'
  };

function getMarkerImage(iconColor) {
   if ((typeof(iconColor)=="undefined") || (iconColor==null)) { 
      iconColor = "red"; 
   }
   if (!gicons[iconColor]) {
   
      gicons[iconColor] = new google.maps.MarkerImage("images/mapIcons/marker_"+iconColor+".png",
      // This marker is 20 pixels wide by 34 pixels tall.
      new google.maps.Size(27, 32),
      // The origin for this image is 0,0.
      new google.maps.Point(0,0),
      // The anchor for this image is at 6,20.
      new google.maps.Point(9, 34));
   } 
   return gicons[iconColor];

}

      gicons["blue"] = getMarkerImage("blue");
      gicons["green"] = getMarkerImage("green");
      gicons["yelow"] = getMarkerImage("yellow");
// A function to create the marker and set up the event window function 
function createMarker(latlng,name,html,color,details,rid) {
    var contentString = html;
    var marker = new google.maps.Marker({
        position: latlng,
        icon: gicons[color],
        shadow: iconShadow,
        map: map,
        title: name,
    animation: google.maps.Animation.DROP,
        zIndex: 1
        });
  
  google.maps.event.addListener(map, 'idle', function(event) {
  
    //alert('asdasd'); return false;
    //updMap(0);
    
  });
  

    google.maps.event.addListener(marker, 'click', function() {
        infowindow.setContent(contentString); 
        infowindow.open(map,marker);
        });
        // Switch icon on marker mouseover and mouseout
        google.maps.event.addListener(marker, "mouseover", function() {
          marker.setIcon(gicons["yellow"]);
		  marker.setZIndex(100);
        });
        google.maps.event.addListener(marker, "mouseout", function() {
          marker.setIcon(gicons["blue"]);
        });
    gmarkers.push(marker);
    // add a line to the side_bar html
    var marker_num = gmarkers.length-1;
   //side_bar_html='<div class="map-areas"><ul class="similar-listing">'+side_bar_html;
   //side_bar_html=side_bar_html+'</ul></div>';
    side_bar_html += '<div onmouseover="gmarkers['+marker_num+'].setIcon(gicons.yellow)" onmouseout="gmarkers['+marker_num+'].setIcon(gicons.blue)">'+details+'</div>';
}
 
 
// This function picks up the click and opens the corresponding info window
function myclick(i) {
  google.maps.event.trigger(gmarkers[i], "click");
}


 
 
 
function downloadUrl() {  
    var totalResults= '<?php echo count($productList->result()); ?>';
    if(totalResults > 0) {
    $("#side_bar").html("<img id='validationEr1r' align='middle' style='margin-left:200px; margin-top:20px;' src='images/ajax-loader.gif' />");
    <?php 
    if(count($productList->result()) > 0){$hoverlist='1';
      foreach($productList->result() as $Row_Rental){
        
        if($Row_Rental->userid !='' && $Row_Rental->userid !='0' ){
          $useId=base_url().'users/show/'.$Row_Rental->userid;
        }else{
          $useId='javascript:void(0);';
        }
        
        if($Row_Rental->userphoto!='' && $Row_Rental->userphoto!='0' ){
          $useImg=base_url().'images/users/'.$Row_Rental->userphoto;
        }else{
          $useImg=base_url().'images/site/profile.png';
        }
      
      ?>
      
      var lat ='<?php echo $Row_Rental->latitude; ?>'; 
      var lng ='<?php echo $Row_Rental->longitude; ?>';
         
          var point = new google.maps.LatLng(lat,lng);
         // var html = markers[i].getAttribute("html"); 
		 <?php //echo $Row_Rental->product_image; die;?>
      var html = '<div class="infoBox similar-listing" ><li><div class="img-top"><div class="figures-cobnt"><img src="<?php if($Row_Rental->product_image !=''){echo PRODUCTPATH.$Row_Rental->product_image;}else {echo PRODUCTPATH.'dummyProductImage.jpg';}  ?>"></div><div class="posi-abs"><a class="heart" href="rental/<?php echo $Row_Rental->id; ?>" target="_blank"></a><label class="pric-tag"><span class="rm-rate"><?php echo $currencySymbol; ?></span><?php echo $Row_Rental->price * $this->session->userdata('currency_r'); ?></label><a class="aurtors" href="<?php echo $useId; ?>"><img style="border-radius: 50%;height: 70px;width: 100px;" src="<?php echo $useImg; ?>"></a></div></div><div class="img-bottom"><span class="headlined"><a  href="rental/<?php echo $Row_Rental->id; ?>"><?php echo addslashes($Row_Rental->product_title); ?></a></span><p class="describ"><?php echo ucfirst($Row_Rental->room_type); ?>- <?php echo addslashes(ucfirst($Row_Rental->city_name)); ?></p></div></li></div>';
    
    var details='<li data-price="<?php echo $Row_Rental->price * $this->session->userdata('currency_r'); ?>"><div class="img-top">';
	<?php if($loginCheck==''){?>
	var details1='<a class="ajax cboxElement heart reg-popup1" href="site/rentals/AddWishListForm/<?php echo $Row_Rental->id;?>"></a>';
	<?php }else{ ?>
	var details1='<a class="ajax cboxElement <?php if(in_array($Row_Rental->id,$newArr))echo 'heart-exist'; else echo 'heart';?>" href="site/rentals/AddWishListForm/<?php echo $Row_Rental->id;?>"></a>';
	<?php } ?>
	
	var details2='<div class="figures-cobnt"><a href="rental/<?php echo $Row_Rental->id;?>" target="_blank"><img src="<?php if($Row_Rental->product_image !=''){echo PRODUCTPATH.$Row_Rental->product_image;}else {echo PRODUCTPATH.'dummyProductImage.jpg';} ?>"></a></div><div class="posi-abs"><label class="pric-tag"><span class="curSymbol"><?php echo $currencySymbol; ?></span><?php echo $Row_Rental->price * $this->session->userdata('currency_r'); ?></label><a class="aurtors" href="<?php echo $useId; ?>"><img style="border-radius: 50%;height: 70px;width: 100px;" src="<?php echo $useImg; ?>"></a></div></div><div class="img-bottom"><span class="headlined"><a  href="rental/<?php echo $Row_Rental->id; ?>"><?php echo addslashes($Row_Rental->product_title); ?></a></span><p class="describ"><?php echo ucfirst($Row_Rental->home_type); ?>- <?php echo addslashes(ucfirst($Row_Rental->city_name)); ?></p></div></li>';
    
      var label ='<?php echo trim(addslashes($Row_Rental->product_title));?>';
          // create the marker
          var marker = createMarker(point,label,html,"blue",details+details1+details2,'<?php echo $Row_Rental->id; ?>');
      <?php $hoverlist=$hoverlist+1;}
    } ?>
        
        // put the assembled side_bar_html contents into the side_bar div
        side_bar_html='<div class="map-areas"><ul class="similar-listing">'+side_bar_html;
        side_bar_html=side_bar_html+'</ul></div>';
		$("#side_bar").html(side_bar_html);
		side_bar_html = "";
    
    }else{
    $("#side_bar").html("No rentals found..");
    }
} 
var infowindow = new google.maps.InfoWindow(
  { 
    size: new google.maps.Size(150,150)
  });
    

    // This Javascript is based on code provided by the
    // Community Church Javascript Team
    // http://www.bisphamchurch.org.uk/   
    // http://econym.org.uk/gmap/
    // from the v2 tutorial page at:
    // http://econym.org.uk/gmap/basic3.htm 
//]]>
</script>