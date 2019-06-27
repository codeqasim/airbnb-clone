<?php
//var_dump($city_lat_lng->row()); 
//var_dump($productList->result());die;
//echo '<pre>'; print_r($city_lat_lng->result_array());
$this->load->view('site/templates/header');
if($productList->num_rows() > 0){

  if($PriceMaxMin->row()->MaxPrice==$PriceMaxMin->row()->MinPrice){
  $MinPrice='0.00';
  }else{
  $MinPrice=$PriceMaxMin->row()->MinPrice;
  }

  if($_GET['minPrice']=='' && $_GET['maxPrice']==''){
    if($SearchPriceMaxMin->row()->SMaxPrice==$SearchPriceMaxMin->row()->SMinPrice){
      $SMinPrice='0.00';
    }else{
      $SMinPrice=$SearchPriceMaxMin->row()->SMinPrice;
    }
    $SMaxPrice=$SearchPriceMaxMin->row()->SMaxPrice;
  }else{
    $SMinPrice=$_GET['minPrice']/$this->session->userdata('currency_r');
    $SMaxPrice=$_GET['maxPrice']/$this->session->userdata('currency_r');
  }

?>

<input type="hidden" value="<?php echo intval($PriceMaxMin->row()->MaxPrice); ?>" id="GMaxPrice" />
<input type="hidden" value="<?php echo intval($MinPrice); ?>" id="GMinPrice" />

<input type="hidden" value="<?php echo intval($SMaxPrice); ?>" id="SMaxPrice" />
<input type="hidden" value="<?php echo intval($SMinPrice); ?>" id="SMinPrice" />

<?php }else{?>
<input type="hidden" value="50000" id="GMaxPrice" />
<input type="hidden" value="0" id="GMinPrice" />

<input type="hidden" value="50000" id="SMaxPrice" />
<input type="hidden" value="0" id="SMinPrice" />

<?php } ?>
<input type="hidden" value="<?php echo $currencySymbol; ?>" id="currencysym" />
<input type="hidden" value="<?php echo $this->session->userdata('currency_r'); ?>" id="currencyrate" />

<script type="text/javascript" src="js/site/list_page.js"></script>
<!-- show View more-->
<script type="text/javascript">
function showView(val){

  if($('.showlist'+val).css('display')=='block'){
    $('.showlist'+val).hide('');  
  }else{
    $('.showlist'+val).show('');
  } 
}
</script>
<script type="text/javascript">
function showView1(val){
  if($('.showlist'+val).css('display')=='list-item'){
    $('.showlist'+val).hide('');  
  }else{
    $('.showlist'+val).show('');
  } 
}
</script>
<!-- End show View more-->

<!-- price range-->
 <link rel="stylesheet" href="css/site/themes-smoothness-jquery-ui.css"  type="text/css"/>
<script src="js/site/1.10.2-jquery-ui.js" type="text/javascript"></script>
 <script>
    var currencyrate=$('#currencyrate').val(); 
    var GMaxPrice=$('#GMaxPrice').val() * currencyrate;
    var GMinPrice=$('#GMinPrice').val() * currencyrate;
    
    var SMaxPrice=$('#SMaxPrice').val() * currencyrate;
    var SMinPrice=$('#SMinPrice').val() * currencyrate;
    
    var currencysym=$('#currencysym').val();
    
    
    $(function() {
    
    $( "#slider-range" ).slider({
    range: true,
    min: GMinPrice,
    max: GMaxPrice,
    values: [ SMinPrice, SMaxPrice ],
    slide: function( event, ui ) {
    $( "#amount" ).val( currencysym + ui.values[ 0 ] + " - "+ currencysym + ui.values[ 1 ] );
    }
    });
    $( "#amount" ).val( currencysym + $( "#slider-range" ).slider( "values", 0 ) +
    " - "+ currencysym + $( "#slider-range" ).slider( "values", 1 ) );
    });
    
    $(function() {
    $( "#slider-price" ).slider({
    range: true,
    min: GMinPrice,
    max: GMaxPrice,
    values: [ SMinPrice, SMaxPrice ],
    slide: function( event, ui ) {
    $( "#amount" ).val( currencysym + ui.values[ 0 ] + " - "+ currencysym + ui.values[ 1 ] );
    }
    });
    $( "#amount" ).val( currencysym + $( "#slider-price" ).slider( "values", 0 ) +
    " - "+ currencysym + $( "#slider-price" ).slider( "values", 1 ) );
    });
    
    $(function() {
    $( "#slider-price" ).slider({
    range: true,
    min: GMinPrice,
    max: GMaxPrice,
    values: [ SMinPrice, SMaxPrice ],
    slide: function( event, ui ) {
    
    
    $( "#price" ).val( currencysym + ui.values[ 0 ] + " - "+ currencysym + ui.values[ 1 ] );
    
    $('#minPrice').val(Math.round(ui.values[ 0 ]));
    $('#maxPrice').val(Math.round(ui.values[ 1 ]));
    
    
    }
    });
    $( "#price" ).val( currencysym + $( "#slider-price" ).slider( "values", 0 ) +
    " - "+ currencysym + $( "#slider-price" ).slider( "values", 1 ) );
    });
    
    
    
</script>
<!-- End price range-->

<script type="text/javascript">

/*** 
    Simple jQuery Slideshow Script
    Released by Jon Raasch (jonraasch.com) under FreeBSD license: free to use or modify, not responsible for anything, etc.  Please link out to me if you like it :)
***/

function slideSwitch() {
    var $active = $('#slidebanner IMG.active');

    if ( $active.length == 0 ) $active = $('#slidebanner IMG:last');

    // use this to pull the images in the order they appear in the markup
    var $next =  $active.next().length ? $active.next()
        : $('#slidebanner IMG:first');

    // uncomment the 3 lines below to pull the images in random order
    
  $active.addClass('last-active');

    $next.css({opacity: 0.0})
        .addClass('active')
        .animate({opacity: 1.0}, 1000, function() {
            $active.removeClass('active last-active');
        });
}

$(function() {
    setInterval( "slideSwitch()", 5000 );
});

</script>




<script type="text/javascript">
// When the DOM is ready, run this function
$(document).ready(function() {
  //Set the carousel options
  $('#quote-carousel').carousel({
    pause: true,
    interval: 4000,
    auto:false,
  });
});
</script>





<style >
.ui-datepicker {  
    width: 216px;  
    height: auto;  
    margin: 5px auto 0;  
    font: 9pt Arial, sans-serif;  
    -webkit-box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, .5);  
    -moz-box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, .5);  
    box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, .5);  
} 

.dark-caret-right-top{display:none !important;}
    .ui-datepicker-header {  
        background: url('images/dark_leather.png') repeat 0 0 #000;  
        color: #e0e0e0;  
        font-weight: bold;  
        -webkit-box-shadow: inset 0px 1px 1px 0px rgba(250, 250, 250, 2);  
        -moz-box-shadow: inset 0px 1px 1px 0px rgba(250, 250, 250, .2);  
        box-shadow: inset 0px 1px 1px 0px rgba(250, 250, 250, .2);  
        text-shadow: 1px -1px 0px #000;  
        filter: dropshadow(color=#000, offx=1, offy=-1);  
        line-height: 30px;  
        border-width: 1px 0 0 0;  
        border-style: solid;  
        border-color: #111;  
    }  
  .ui-datepicker thead {  
    background-color: #f7f7f7;  
    background-image: -moz-linear-gradient(top,  #f7f7f7 0%, #f1f1f1 100%);  
    background-image: -webkit-gradient(linear, left top, left bottombottom, color-stop(0%,#f7f7f7), color-stop(100%,#f1f1f1));  
    background-image: -webkit-linear-gradient(top,  #f7f7f7 0%,#f1f1f1 100%);  
    background-image: -o-linear-gradient(top,  #f7f7f7 0%,#f1f1f1 100%);  
    background-image: -ms-linear-gradient(top,  #f7f7f7 0%,#f1f1f1 100%);  
    background-image: linear-gradient(top,  #f7f7f7 0%,#f1f1f1 100%);  
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f7f7f7', endColorstr='#f1f1f1',GradientType=0 );  
    border-bottom: 1px solid #bbb;  
}
.ui-datepicker-prev {  
    float: left;  
    background-position: center -30px; 
}  
.ui-datepicker-next {  
    float: right;  
    background-position: center 0px;  
} 
    
  
  .ui-datepicker-prev, .ui-datepicker-next {  
        display: inline-block;  
        width: 30px;  
        height: 30px;  
        text-align: center;  
        cursor: pointer;  
        background-image: url('images/panel-next.png');  
        background-repeat: no-repeat;  
        line-height: 600%;  
        overflow: hidden;  
    } 
  .ui-state-disabled{
   opacity: 1 !important;
  }
  .ui-icon-circle-triangle-w {
  background-position: 0 0 !important;
  }
  .ui-datepicker .ui-datepicker-prev span{
    display: inline-block;  
        width: 30px;  
        height: 30px;  
        text-align: center;  
        cursor: pointer;  
        background-image: url('images/panel-prev.png');  
        background-repeat: no-repeat;  
        line-height: 600%;  
        overflow: hidden;
  }
  
    
      .ui-datepicker th {  
        text-transform: uppercase;  
        font-size: 6pt;  
        padding: 5px 0;  
        color: #666666;  
        text-shadow: 1px 0px 0px #fff;  
        filter: dropshadow(color=#fff, offx=1, offy=0);  
    }  
      .ui-datepicker thead {  
        background-color: #f7f7f7;  
        background-image: -moz-linear-gradient(top,  #f7f7f7 0%, #f1f1f1 100%);  
        background-image: -webkit-gradient(linear, left top, left bottombottom, color-stop(0%,#f7f7f7), color-stop(100%,#f1f1f1));  
        background-image: -webkit-linear-gradient(top,  #f7f7f7 0%,#f1f1f1 100%);  
        background-image: -o-linear-gradient(top,  #f7f7f7 0%,#f1f1f1 100%);  
        background-image: -ms-linear-gradient(top,  #f7f7f7 0%,#f1f1f1 100%);  
        background-image: linear-gradient(top,  #f7f7f7 0%,#f1f1f1 100%);  
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f7f7f7', endColorstr='#f1f1f1',GradientType=0 );  
        border-bottom: 1px solid #bbb;  
    }  
  .ui-datepicker tbody td {  
    padding: 0;  
    border-right: 1px solid #bbb;  
} 
    .ui-datepicker tbody td:last-child {  
        border-right: 0px;  
    }  
      .ui-datepicker tbody tr {  
        border-bottom: 1px solid #bbb;  
    }  
    .ui-datepicker tbody tr:last-child {  
        border-bottom: 0px;  
    }  
  #ui-datepicker-div .ui-state-default{
   background:none;
  }
  #ui-datepicker-div .ui-state-focus ,#ui-datepicker-div .ui-state-highlight ,a .ui-state-hover{
   background:none;
  }
  
.infoBox:before {
    border-color: #FFFFFF transparent transparent;
    border-style: solid;
    border-width: 15px;
   
    position: absolute;
}
.infoBox .listing-img img{
position: inherit;

}
.gm-style-iw{
height: 100% !important;
width: auto !important;
}

.gm-style img { max-width: none; }
.gm-style label { width: auto; display: inline; }
</style>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script> 
<script type="text/javascript" src="js/site/downloadxml.js"></script>
 
<style type="text/css">
html, body { height: 100%; } 
</style>
<script type="text/javascript"> 
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
        zIndex: Math.round(latlng.lat()*-100000)<<5
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
        });
        google.maps.event.addListener(marker, "mouseout", function() {
          marker.setIcon(gicons["blue"]);
        });
    gmarkers.push(marker);
    // add a line to the side_bar html
    var marker_num = gmarkers.length-1;
   //side_bar_html='<div class="map-areas"><ul class="similar-listing">'+side_bar_html;
   //side_bar_html=side_bar_html+'</ul></div>';
    side_bar_html += '<a href="rental/'+rid+'" onmouseover="gmarkers['+marker_num+'].setIcon(gicons.yellow)" onmouseout="gmarkers['+marker_num+'].setIcon(gicons.blue)">'+details+'</a>';
}
 
 
// This function picks up the click and opens the corresponding info window
function myclick(i) {
  google.maps.event.trigger(gmarkers[i], "click");
}

function initialize() {
// create the map

  var myOptions = {
    zoom: 10,
   zoomControl:true,
zoomControlOptions: {
  style:google.maps.ZoomControlStyle.SMALL
},
    center: new google.maps.LatLng(<?php if($city_lat_lng->row()->latitude!=''){ echo $city_lat_lng->row()->latitude;}else{ echo '25.761680';} ?>,<?php if($city_lat_lng->row()->longitude!=''){ echo $city_lat_lng->row()->longitude;}else{ echo '-80.191790';} ?>),
    mapTypeControl: true,
    mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU},
    navigationControl: true,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  }
  map = new google.maps.Map(document.getElementById("map_canvas"),
                                myOptions);
 
  google.maps.event.addListener(map, 'click', function() {
        infowindow.close();
        });

      downloadUrl();
    
    
    }
 
 
function downloadUrl() {  

    //var xmlDoc = xmlParse(doc);
        //var xml = doc.responseXML;
    //var markers = xml.documentElement.getElementsByTagName("marker");
    var totalResults= '<?php echo count($productList->result()); ?>';
    
    if(totalResults > 0) {
    
    $("#side_bar").html("<img id='validationEr1r' align='middle' style='margin-left:200px; margin-top:20px;' src='images/ajax-loader.gif' />");
    <?php 
    
    if(count($productList->result()) > 0){$hoverlist='1';
      foreach($productList->result() as $Row_Rental){
        
        if($Row_Rental->userid!='' && $Row_Rental->userid!='0' ){
          $useId=base_url().'users/show/'.$Row_Rental->userid;
        }else{
          $useId='javascript:void(0);';
        }
        
        if($Row_Rental->userphoto!='' && $Row_Rental->userphoto!='0' ){
          $useImg=base_url().'images/users/'.$Row_Rental->userphoto;
        }else{
          $useImg=base_url().'images/users/user_thumb.png';
        }
      
      ?>
      
      var lat ='<?php echo $Row_Rental->latitude; ?>'; 
      var lng ='<?php echo $Row_Rental->longitude; ?>';
         
          var point = new google.maps.LatLng(lat,lng);
         // var html = markers[i].getAttribute("html");
      var html = '<div class="infoBox similar-listing" ><li><div class="img-top"><div class="figures-cobnt"><img src="<?php if($Row_Rental->product_image !=''){echo PRODUCTPATH.$Row_Rental->product_image;}else {echo PRODUCTPATH.'dummyProductImage.jpg';}  ?>"></div><div class="posi-abs"><a class="heart" href="rental/<?php echo $Row_Rental->id; ?>"></a><label class="pric-tag"><?php echo $currencySymbol; ?><?php echo $Row_Rental->price * $this->session->userdata('currency_r'); ?></label><a class="aurtors" href="<?php echo $useId; ?>"><img style="border-radius: 50%;height: 70px;width: 100px;" src="<?php echo $useImg; ?>"></a></div></div><div class="img-bottom"><span class="headlined"><a  href="rental/<?php echo $Row_Rental->id; ?>"><?php echo $Row_Rental->product_title; ?></a></span><p class="describ"><?php echo ucfirst($Row_Rental->room_type); ?>- <?php echo ucfirst($Row_Rental->city_name); ?></p></div></li></div>';
    
    var details='<li data-price="<?php echo $Row_Rental->price * $this->session->userdata('currency_r'); ?>"><div class="img-top"><div class="figures-cobnt"><img src="<?php if($Row_Rental->product_image !=''){echo PRODUCTPATH.$Row_Rental->product_image;}else {echo PRODUCTPATH.'dummyProductImage.jpg';} ?>"></div><div class="posi-abs"><a class="ajax cboxElement heart" href="site/rentals/AddWishListForm/<?php echo $Row_Rental->id;?>"></a><label class="pric-tag"><?php echo $currencySymbol; ?><?php echo $Row_Rental->price * $this->session->userdata('currency_r'); ?></label><a class="aurtors" href="<?php echo $useId; ?>"><img style="border-radius: 50%;height: 70px;width: 100px;" src="<?php echo $useImg; ?>"></a></div></div><div class="img-bottom"><span class="headlined"><a  href="rental/<?php echo $Row_Rental->id; ?>"><?php echo $Row_Rental->product_title; ?></a></span><p class="describ"><?php echo ucfirst($Row_Rental->room_type); ?>- <?php echo ucfirst($Row_Rental->city_name); ?></p></div></li>';
    
      var label ='<?php echo trim(substr($Row_Rental->street_name,0,6)); ?>';
          // create the marker
          var marker = createMarker(point,label,html,"blue",details,'<?php echo $Row_Rental->id; ?>');
      <?php $hoverlist=$hoverlist+1;}
    } ?>
        
        // put the assembled side_bar_html contents into the side_bar div
        side_bar_html='<div class="map-areas"><ul class="similar-listing">'+side_bar_html;
        side_bar_html=side_bar_html+'</ul></div>';
        document.getElementById("side_bar").innerHTML = side_bar_html;
    
    }else{
    $("#side_bar").html("No rentals found..");
    }
} 
var infowindow = new google.maps.InfoWindow(
  { 
    size: new google.maps.Size(150,50)
  });
    

    // This Javascript is based on code provided by the
    // Community Church Javascript Team
    // http://www.bisphamchurch.org.uk/   
    // http://econym.org.uk/gmap/
    // from the v2 tutorial page at:
    // http://econym.org.uk/gmap/basic3.htm 
//]]>
</script>


<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js" type="text/javascript"></script>
<!-- slidebox styling via external css -->
<link rel="stylesheet" href="css/site/<?php echo SITE_COMMON_DEFINE ?>jquery.mSimpleSlidebox.css">
<script src="js/site/<?php echo SITE_COMMON_DEFINE ?>jquery.mSimpleSlidebox.js"></script>
<!-- slidebox function call -->
<script type="text/javascript">
$(document).ready(function(){
  $(".mSlidebox").mSlidebox({
    autoPlayTime:4000,
    controlsPosition:{
      buttonsPosition:"outside"
    }
  });
  $("#mSlidebox_3").mSlidebox({
    easeType:"easeInOutCirc",
    numberedThumbnails:true,
    pauseOnHover:false
  });
});
</script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
  
  <!--<link rel="stylesheet" href="/resources/demos/style.css">-->
  <script>
  $(function() {
   
   $( "#datepicker" ).datepicker({ minDate: 0});
   
  $( "#datepicker1" ).datepicker();
  
  });
  </script>
<div class="map-search">
<div>
  <div class="sidebar">
    <div class="filters filters-collapse">
        <ul class="filter-list unstyled">
 <form class="form-horizontal trip-form">

    <li data-tooltip-position="left" rel="tooltip" class="intro-filter clearfix" title="Trip">

      <h6 class="span2 filter-label">Dates</h6>

       
          <div class="control-group">
            <input type="text" placeholder="<?php if($this->lang->line('check_in') != '') { echo stripslashes($this->lang->line('check_in')); } else echo "Check in";?>" value="<?php echo $_GET['datefrom']; ?>" id="datepicker" name="checkin">
             <input type="hidden" value="<?php echo $_GET['minPrice']; ?>"  onchange="myfunction(this)" id="minPrice" /><input type="hidden" value="<?php echo $_GET['maxPrice']; ?>" id="maxPrice" />
            <!--<i class="icon-arrow-right"></i>-->
            <input type="text" placeholder="<?php if($this->lang->line('check_out') != '') { echo stripslashes($this->lang->line('check_out')); } else echo "Check out";?>"  id="datepicker1" value="<?php echo $_GET['dateto']; ?>" name="checkout">
<select data-prefill="" class="guest-select input-medium" name="guests" id="guests">
<option value="1"<?php if($_GET['guests']==1){?>selected="selected"<?php }?> >1 <?php if($this->lang->line('guest_s') != '') { echo stripslashes($this->lang->line('guest_s')); } else echo "Guest";?></option>
<option value="2" <?php if($_GET['guests']==2){?>selected="selected"<?php }?>>2 <?php if($this->lang->line('guest') != '') { echo stripslashes($this->lang->line('guest')); } else echo "Guests";?></option>
<option value="3" <?php if($_GET['guests']==3){?>selected="selected"<?php }?>>3 <?php if($this->lang->line('guest') != '') { echo stripslashes($this->lang->line('guest')); } else echo "Guests";?></option>
<option value="4" <?php if($_GET['guests']==4){?>selected="selected"<?php }?>>4 <?php if($this->lang->line('guest') != '') { echo stripslashes($this->lang->line('guest')); } else echo "Guests";?></option>
<option value="5" <?php if($_GET['guests']==5){?>selected="selected"<?php }?>>5 <?php if($this->lang->line('guest') != '') { echo stripslashes($this->lang->line('guest')); } else echo "Guests";?></option>
<option value="6" <?php if($_GET['guests']==6){?>selected="selected"<?php }?>>6 <?php if($this->lang->line('guest') != '') { echo stripslashes($this->lang->line('guest')); } else echo "Guests";?></option>
<option value="7" <?php if($_GET['guests']==7){?>selected="selected"<?php }?>>7 <?php if($this->lang->line('guest') != '') { echo stripslashes($this->lang->line('guest')); } else echo "Guests";?></option>
<option value="8" <?php if($_GET['guests']==8){?>selected="selected"<?php }?>>8 <?php if($this->lang->line('guest') != '') { echo stripslashes($this->lang->line('guest')); } else echo "Guests";?></option>
<option value="9" <?php if($_GET['guests']==9){?>selected="selected"<?php }?>>9 <?php if($this->lang->line('guest') != '') { echo stripslashes($this->lang->line('guest')); } else echo "Guests";?></option>
<option value="10" <?php if($_GET['guests']==10){?>selected="selected"<?php }?>>10 <?php if($this->lang->line('guest') != '') { echo stripslashes($this->lang->line('guest')); } else echo "Guests";?></option>
<option value="11" <?php if($_GET['guests']==11){?>selected="selected"<?php }?>>11 <?php if($this->lang->line('guest') != '') { echo stripslashes($this->lang->line('guest')); } else echo "Guests";?></option>
<option value="12" <?php if($_GET['guests']==12){?>selected="selected"<?php }?>>12 <?php if($this->lang->line('guest') != '') { echo stripslashes($this->lang->line('guest')); } else echo "Guests";?></option>
<option value="13" <?php if($_GET['guests']==13){?>selected="selected"<?php }?>>13 <?php if($this->lang->line('guest') != '') { echo stripslashes($this->lang->line('guest')); } else echo "Guests";?></option>
<option value="14" <?php if($_GET['guests']==14){?>selected="selected"<?php }?>>14 <?php if($this->lang->line('guest') != '') { echo stripslashes($this->lang->line('guest')); } else echo "Guests";?></option>
<option value="15" <?php if($_GET['guests']==15){?>selected="selected"<?php }?>>15 <?php if($this->lang->line('guest') != '') { echo stripslashes($this->lang->line('guest')); } else echo "Guests";?></option>
<option value="16" <?php if($_GET['guests']==16){?>selected="selected"<?php }?>>16+ <?php if($this->lang->line('guest') != '') { echo stripslashes($this->lang->line('guest')); } else echo "Guests";?></option>
            </select>
          </div>
       

    </li>
  
    
    
    <li data-tooltip-position="left" rel="tooltip" class="clearfix room-type-group intro-filter" title="Room Type">
    
      <h6 class="span2 filter-label linedpads2"><?php if($this->lang->line('room_type') != '') { echo stripslashes($this->lang->line('room_type')); } else echo "Room Type";?></h6>
      <div for="home" data-name="Entire home/apt" class="filter-primary-item span2">
      <input type="checkbox" id="room_type1" name="room_type" value="homec" <?php if($_GET['type1']=='homec') echo 'checked="checked"';?> />
        <i class="icon icon-entire-place"></i>
        <h5><?php if($this->lang->line('entire_place') != '') { echo stripslashes($this->lang->line('entire_place')); } else echo "Entire Place";?></h5>
      </div>

      <div for="private" data-name="Private room" class="filter-primary-item span2">
      <input type="checkbox" id="room_type2" name="room_type" value="private" <?php if($_GET['type2']=='private') echo 'checked="checked"';?> />
        <i class="icon-private-room"></i>
        <h5><?php if($this->lang->line('private_room') != '') { echo stripslashes($this->lang->line('private_room')); } else echo "Private Room";?></h5>
      </div>

      <div for="shared" data-name="Shared room" class="filter-primary-item span2">
      <input type="checkbox" id="room_type3" name="room_type" value="shared" <?php if($_GET['type3']=='shared') echo 'checked="checked"';?>/>
        <i class="icon-shared-room"></i>
        <h5><?php if($this->lang->line('shared_room') != '') { echo stripslashes($this->lang->line('shared_room')); } else echo "Shared Room";?></h5>
      </div>
      <a href="javascript:void(0);" style="background-position: -120px -120px;width:20px;height:20px;background-image: url('./img/glyphicons-halflings.png');" class="icon icon-question-sign" title="
        Entire Place
          Listings where you have the whole place to yourself.
      Private Room
          Listings where you have your own room but share some common spaces.
        Shared Room
          Listings where you'll share your room or your room may be a common space.
    "></a>

      
    </li>

    <li data-tooltip-position="left" rel="tooltip" class="clearfix intro-filter pricefil" title="Price">
      <h6 class="span2 filter-label linedpad3"><!--<?php if($this->lang->line('giftcard_price') != '') { echo stripslashes($this->lang->line('giftcard_price')); } else echo "Price";?>-->Price Range</h6>
    <!--<div class="price_slider">
              <div class="price_text"><input type="text" id="price" value="100"  class="rating_input" /></div>
              <div class="rating_slider">
               
                  <div id="slider-price"></div>
                
              </div>
        </div>-->
    <div class="price_slider">
      <div id="slider-range"></div></div>
      <input type="text" value="<?php echo $currencySymbol.$SMinPrice;?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $currencySymbol.$SMaxPrice;?>" style="color: rgb(94, 85, 90); font-weight: normal; font-family: OpenSansSemibold; border: medium none; box-shadow: none; margin: -26px 0px 0px 0px;position: relative;top: 20px;width: 70%;" id="amount_pricefilter">
     
    </li>
  
   <div class="filter-reald">
      <a href="javascript:showView1('5');" class="filter-btn" style="margin:10px 0 0 20px;">More Filters</a>
      
      </div>

 
    <li title="Size" data-tooltip-position="left" rel="tooltip" class="clearfix showlist5">
      <h6 class="span2 filter-label linedpads4"><?php if($this->lang->line('size') != '') { echo stripslashes($this->lang->line('size')); } else echo "Size";?></h6>
      <div class="control-group span6">
        <div class="row">

          <select name="min_bedrooms" id="bedrooms" class="span2">
            <option value="" <?php if($_GET['bedrooms']==''){echo 'selected="selected"';} ?>><?php if($this->lang->line('bedrooms') != '') { echo stripslashes($this->lang->line('bedrooms')); } else echo "Bedrooms";?></option>
            <option value="1" <?php if($_GET['bedrooms']=='1'){echo 'selected="selected"';} ?>>1 <?php if($this->lang->line('bedrooms') != '') { echo stripslashes($this->lang->line('bedrooms')); } else echo "Bedrooms";?></option>
<option value="2" <?php if($_GET['bedrooms']=='2'){echo 'selected="selected"';} ?>>2 <?php if($this->lang->line('bedrooms') != '') { echo stripslashes($this->lang->line('bedrooms')); } else echo "Bedrooms";?></option>
<option value="3" <?php if($_GET['bedrooms']=='3'){echo 'selected="selected"';} ?>>3 <?php if($this->lang->line('bedrooms') != '') { echo stripslashes($this->lang->line('bedrooms')); } else echo "Bedrooms";?></option>
<option value="4" <?php if($_GET['bedrooms']=='4'){echo 'selected="selected"';} ?>>4 <?php if($this->lang->line('bedrooms') != '') { echo stripslashes($this->lang->line('bedrooms')); } else echo "Bedrooms";?></option>
<option value="5" <?php if($_GET['bedrooms']=='5'){echo 'selected="selected"';} ?>>5 <?php if($this->lang->line('bedrooms') != '') { echo stripslashes($this->lang->line('bedrooms')); } else echo "Bedrooms";?></option>
<option value="6" <?php if($_GET['bedrooms']=='6'){echo 'selected="selected"';} ?>>6 <?php if($this->lang->line('bedrooms') != '') { echo stripslashes($this->lang->line('bedrooms')); } else echo "Bedrooms";?></option>
<option value="7" <?php if($_GET['bedrooms']=='7'){echo 'selected="selected"';} ?>>7 <?php if($this->lang->line('bedrooms') != '') { echo stripslashes($this->lang->line('bedrooms')); } else echo "Bedrooms";?></option>
<option value="8" <?php if($_GET['bedrooms']=='8'){echo 'selected="selected"';} ?>>8 <?php if($this->lang->line('bedrooms') != '') { echo stripslashes($this->lang->line('bedrooms')); } else echo "Bedrooms";?></option>
<option value="9" <?php if($_GET['bedrooms']=='9'){echo 'selected="selected"';} ?>>9 <?php if($this->lang->line('bedrooms') != '') { echo stripslashes($this->lang->line('bedrooms')); } else echo "Bedrooms";?></option>
<option value="10" <?php if($_GET['bedrooms']=='10'){echo 'selected="selected"';} ?>>10 <?php if($this->lang->line('bedrooms') != '') { echo stripslashes($this->lang->line('bedrooms')); } else echo "Bedrooms";?></option>
          </select>

          <select name="min_bathrooms" id="bathrooms" class="span2">
        <option value="" <?php if($_GET['bathrooms']==''){echo 'selected="selected"';} ?>><?php if($this->lang->line('bathrooms') != '') { echo stripslashes($this->lang->line('bathrooms')); } else echo "Bathrooms";?></option>
    <?php for($i=1;$i<=8;$i++){?>
    <option value="<?php echo $i?>" <?php if($_GET['bathrooms']==$i) echo 'selected="selected"'; ?>><?php echo $i; if($this->lang->line('bathrooms') != '') { echo stripslashes($this->lang->line('bathrooms')); } else echo "Bathrooms";?></option>
    <?php }?>
          </select>

          <select name="min_beds" id="beds" class="span2">
            <option value="" <?php if($_GET['beds']==''){echo 'selected="selected"';} ?>><?php if($this->lang->line('beds') != '') { echo stripslashes($this->lang->line('beds')); } else echo "Beds";?></option>
            <option value="1" <?php if($_GET['beds']=='1'){echo 'selected="selected"';} ?>>1 <?php if($this->lang->line('beds') != '') { echo stripslashes($this->lang->line('beds')); } else echo "Beds";?></option>
<option value="2" <?php if($_GET['beds']=='2'){echo 'selected="selected"';} ?>>2 <?php if($this->lang->line('beds') != '') { echo stripslashes($this->lang->line('beds')); } else echo "Beds";?></option>
<option value="3" <?php if($_GET['beds']=='3'){echo 'selected="selected"';} ?>>3 <?php if($this->lang->line('beds') != '') { echo stripslashes($this->lang->line('beds')); } else echo "Beds";?></option>
<option value="4" <?php if($_GET['beds']=='4'){echo 'selected="selected"';} ?>>4 <?php if($this->lang->line('beds') != '') { echo stripslashes($this->lang->line('beds')); } else echo "Beds";?></option>
<option value="5" <?php if($_GET['beds']=='5'){echo 'selected="selected"';} ?>>5 <?php if($this->lang->line('beds') != '') { echo stripslashes($this->lang->line('beds')); } else echo "Beds";?></option>
<option value="6" <?php if($_GET['beds']=='6'){echo 'selected="selected"';} ?>>6 <?php if($this->lang->line('beds') != '') { echo stripslashes($this->lang->line('beds')); } else echo "Beds";?></option>
<option value="7" <?php if($_GET['beds']=='7'){echo 'selected="selected"';} ?>>7 <?php if($this->lang->line('beds') != '') { echo stripslashes($this->lang->line('beds')); } else echo "Beds";?></option>
<option value="8" <?php if($_GET['beds']=='8'){echo 'selected="selected"';} ?>>8 <?php if($this->lang->line('beds') != '') { echo stripslashes($this->lang->line('beds')); } else echo "Beds";?></option>
<option value="9" <?php if($_GET['beds']=='9'){echo 'selected="selected"';} ?>>9 <?php if($this->lang->line('beds') != '') { echo stripslashes($this->lang->line('beds')); } else echo "Beds";?></option>
<option value="10" <?php if($_GET['beds']=='10'){echo 'selected="selected"';} ?>>10 <?php if($this->lang->line('beds') != '') { echo stripslashes($this->lang->line('beds')); } else echo "Beds";?></option>
<option value="11" <?php if($_GET['beds']=='11'){echo 'selected="selected"';} ?>>11 <?php if($this->lang->line('beds') != '') { echo stripslashes($this->lang->line('beds')); } else echo "Beds";?></option>
<option value="12" <?php if($_GET['beds']=='12'){echo 'selected="selected"';} ?>>12 <?php if($this->lang->line('beds') != '') { echo stripslashes($this->lang->line('beds')); } else echo "Beds";?></option>
<option value="13" <?php if($_GET['beds']=='13'){echo 'selected="selected"';} ?>>13 <?php if($this->lang->line('beds') != '') { echo stripslashes($this->lang->line('beds')); } else echo "Beds";?></option>
<option value="14" <?php if($_GET['beds']=='14'){echo 'selected="selected"';} ?>>14 <?php if($this->lang->line('beds') != '') { echo stripslashes($this->lang->line('beds')); } else echo "Beds";?></option>
<option value="15" <?php if($_GET['beds']=='15'){echo 'selected="selected"';} ?>>15 <?php if($this->lang->line('beds') != '') { echo stripslashes($this->lang->line('beds')); } else echo "Beds";?></option>
<option value="16" <?php if($_GET['beds']=='16'){echo 'selected="selected"';} ?>>16+ <?php if($this->lang->line('beds') != '') { echo stripslashes($this->lang->line('beds')); } else echo "Beds";?></option>
          </select>

        </div>
      </div>
    </li>

       <?php
       $list_value_loop=1;
     foreach($main_cat as $category) {?>
  <li title="<?php echo $category->attribute_name;?>" data-tooltip-position="left" rel="tooltip" class="clearfix showlist5">
      <h6 class="span2 filter-label  left-widt"><?php echo $category->attribute_name;?></h6>



    



<?php
$sec_categ_loop_count=count($sec_category[$category->id]);
//var_dump($sec_category[$category->id]);die;
for($i=0;$i<3;$i++)
{
if($i==0)
{
echo '<div class="right-arel onclk-hide">';
} ?>
<label><input type="checkbox"  value="<?php echo $sec_category[$category->id][$i]['id'];?>" id="<?php echo 'list_value'.$list_value_loop;?>" <?php if($_GET['list_value'.$list_value_loop]==$sec_category[$category->id][$i]['id']){ ?> checked="checked" <?php }?>><span> <?php echo $sec_category[$category->id][$i]['list_value'];?></span></label>
<?php 
$list_value_loop++;
if($i==2)
{
echo '</div><div class="drop4btn"><i class="caret"></i></div>';
}

}
for($j=3;$j<$sec_categ_loop_count;$j++)
{
if($j==3)
{
echo '<div class="right-arel">';
}
?>
<label><input type="checkbox"  value="<?php echo $sec_category[$category->id][$j]['id'];?>" id="<?php echo 'list_value'.$list_value_loop;?>" <?php if($_GET['list_value'.$list_value_loop]==$sec_category[$category->id][$j]['id']){ ?> checked="checked" <?php }?>><span> <?php echo $sec_category[$category->id][$j]['list_value'];?></span></label>
<?php
$list_value_loop++;
 if($j==$sec_categ_loop_count)
{
echo '</div>';
}
 
}
?>
</li>
  <?php }?> 

    <li title="Keywords" data-tooltip-position="left" rel="tooltip" class="clearfix showlist5">
      <h6 class="span2 filter-label"><?php if($this->lang->line('keywords') != '') { echo stripslashes($this->lang->line('keywords')); } else echo "Keywords";?></h6>
      <input type="text" placeholder="ocean side, transit, relaxing..." value="<?php echo $_GET['keywords']; ?>" name="keywords" id="keywords" class="span6">
    </li>
    


      <div class="showlisting">
        <a class="show-btn23">Show Listing</a>
      </div>
     </form>

  </ul>

     
    </div>
     

      
   <div class="sidebar-header-placeholder"></div>
    <?php echo $paginationLink; ?>
    <div class="search-results">
<div class="listings-loading clearfix">
      <div id="side_bar">
      </div>
 </div>
      
    </div>
  </div>

  <div class="map" >
    <div id="map_canvas" style="width: 560px; height: 100%;"></div>
   
    
  </div>
  

</div>

<input type="hidden" id="GetCity" value="<?php echo str_replace(' ','+',$_GET['city']); ?>"  />

<style>
.filter-primary-item input[type="checkbox"] {
    display: none;
}

input[type="checkbox"]:checked + i {
    border: 1px solid red;
}
</style>
<script type="text/javascript">
$(function() { 
$( "#datepicker" ).datepicker({
defaultDate: "+1w",
changeMonth: true,
numberOfMonths: 1,
minDate:0,
onClose: function( selectedDate ) {
  if($( "#datepicker1" ).val()==''){
    $( "#datepicker1" ).datepicker( "option", "maxDate", selectedDate ).focus();
  }else{
    $( "#datepicker1" ).datepicker( "option", "maxDate", selectedDate );
  }
}
});
$( "#datepicker1" ).datepicker({
defaultDate: "+1w",
changeMonth: true,
numberOfMonths: 1,
minDate:0,
onClose: function( selectedDate ) {

if($( "#datepicker" ).val()==''){
$( "#datepicker" ).datepicker( "option", "maxDate", selectedDate ).focus();
}else{
$( "#datepicker" ).datepicker( "option", "maxDate", selectedDate );
}
}
});

});





$(".filter-primary-item i").click(function(){
     $(this).prev().attr('checked',true);
   
});
 
 


$('form').change(function() {






/*$.ajax(
    {
      type: 'POST',
      url: baseURL+'site/rentals/RentalListDateSearch',
      data:{'datefrom':$( "#datefrom" ).val(),'dateto':$( "#dateto" ).val(),'guests':$('#guests').val(),'room-type':$("input[name=room_type]").val(),'bedrooms':$( "#bedrooms" ).val(),'bathrooms':$( "#bathrooms" ).val(),'beds':$( "#beds" ).val(),'keywords':$( "#keywords" ).val()},
      success: function(data) 
      {*/ 
      
      
        /* if ($('#room_type1').is(':checked')) {
          var roomtype1='home';
        }
        if ($('#room_type2').is(':checked')) {
          var roomtype2='privateroom';
        }
        if ($('#room_type3').is(':checked')) {
          var roomtype3='sharedroom';
        }
        pageurl = $(location).attr('href');  
        var city=$('#GetCity').val();
        var pushUrl=baseURL+'property/?city='+city+'&location=&datefrom='+$( "#datepicker" ).val()+'&dateto='+$( "#datepicker1" ).val()+'&guests='+$( "#guests" ).val()+'&type1='+roomtype1+'&type2='+roomtype2+'&type3='+roomtype3+'&bedrooms='+$("#bedrooms").val()+'&bathrooms='+$("#bathrooms").val()+'&beds='+$("#beds").val()+'&keywords='+$("#keywords").val()+'&minPrice='+$("#minPrice").val()+'&maxPrice='+$("#maxPrice").val();
        if(pageurl!=''){
          window.history.pushState({path:pageurl},'',pushUrl);  
        } */
      /*}
      
    });*/
});
function SubmitSearchButton(){
var roomtype1='';var roomtype2='';var roomtype3='';
        if ($('#room_type1').is(':checked')) {
          roomtype1='home';
        }
        if ($('#room_type2').is(':checked')) {
          roomtype2='privateroom';
        }
        if ($('#room_type3').is(':checked')) {
          roomtype3='sharedroom';
        }
        pageurl = $(location).attr('href');  
        var city=$('#GetCity').val();
        var pushUrl=baseURL+'property/?city='+city+'&location=&datefrom='+$( "#datepicker" ).val()+'&dateto='+$( "#datepicker1" ).val()+'&guests='+$( "#guests" ).val()+'&type1='+roomtype1+'&type2='+roomtype2+'&type3='+roomtype3+'&bedrooms='+$("#bedrooms").val()+'&bathrooms='+$("#bathrooms").val()+'&beds='+$("#beds").val()+'&keywords='+$("#keywords").val()+'&minPrice='+$("#minPrice").val()+'&maxPrice='+$("#maxPrice").val();
        if(pageurl!=''){
          window.history.pushState({path:pageurl},'',pushUrl);  
          window.location.reload();
        }
}

$(function()
{
$('.drop4btn').click(function()
{
$(this).next().slideToggle();
});

$('.drop4btn').each(function()
{
$(this).next().css('display','none');
});

});




//gangatahran

function showProducts(minPrice, maxPrice) {
    $(".similar-listing li").hide().filter(function() {
        var price = parseInt($(this).data("price"), 10);
        return price >= minPrice && price <= maxPrice;
    }).show();
}
<?php 
if(isset($PriceMaxMin)){
?>
$(function() {
    var options = {
        range: true,
        min: 0,
        max: '<?php echo $PriceMaxMin->row()->MaxPrice*$this->session->userdata('currency_r');?>',
        values: [0, '<?php echo $PriceMaxMin->row()->MaxPrice*$this->session->userdata('currency_r');?>'],
        slide: function(event, ui) {
            var min = ui.values[0],
                max = ui.values[1];

            $("#amount_pricefilter").val("<?php echo $this->session->userdata('currency_s');?>" + min + "                                                                                                                             <?php echo $this->session->userdata('currency_s');?>" + max);
            showProducts(min, max);
        }
    }, min, max;

    $("#slider-range").slider(options);

    min = $("#slider-range").slider("values", 0);
    max = $("#slider-range").slider("values", 1);

    $("#amount").val("<?php echo $this->session->userdata('currency_s');?>" + min + " - <?php echo $this->session->userdata('currency_s');?>" + max);

    showProducts(min, max);
  
  
  $('#autocomplete').val('<?php echo $_GET['city'];?>');
});
<?php }?>
</script>

<style>
.drop4btn{
    float: left;
    position: absolute;
    right: 30px;
    top: 30px;
  cursor:pointer;
}
.form-horizontal.trip-form .showlist5{position:relative}
</style>

<?php 
//$this->load->view('site/templates/footer');
?>