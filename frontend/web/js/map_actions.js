/**
 * To handle the map functions
 * in the search page of listing
 */
var markers = [];
var map;
function initMap() {
	autocomplete = new google.maps.places.Autocomplete((document.getElementById('where-to-go')), {
	  types : [ 'geocode' ]
  });

  google.maps.event.addListener(autocomplete, 'place_changed', function() {
	  fillInAddress();
  });

  if(baseLat == 0 && baselng ==0){
    baseLat = 0.00;
    baselng = 0.00;
    zoomval = 2;
  }

  map = new google.maps.Map(document.getElementById('map'), {
    center: {lat: baseLat, lng: baselng},
    zoom: zoomval,
    mapTypeId: 'roadmap',
    styles: [{
      featureType: 'poi',
      stylers: [{ visibility: 'off' }]  // Turn off points of interest.
    }, {
      featureType: 'transit.station',
      stylers: [{ visibility: 'off' }]  // Turn off bus stations, train stations, etc.
    }],
    disableDoubleClickZoom: true
  });

  google.maps.event.addListener(map,'mousedown',function(event) { 
    searchmove = $('input[name="searchmove"]:checked').val();
    if(searchmove=="on")
    {
      var place = event.latLng;
      lat = place.lat();
      lng = place.lng();
      var geocoder;
      geocoder = new google.maps.Geocoder();
      var latlng = new google.maps.LatLng(lat, lng);

      geocoder.geocode(
        {'latLng': latlng}, 
        function(results, status) {
          if (status == google.maps.GeocoderStatus.OK) {
            if (results[0]) {
                var add= results[0].formatted_address ;
                var  value=add.split(",");

                count=value.length;
                country=value[count-1];
                state=value[count-2];
                city=value[count-3];
                var methodCall = $.trim($("#searchTypeText").val()).toLowerCase();
                if(methodCall == "anywhere")
                  methodCall = "Anywhere · ";
                else if(methodCall == "featured")
                  methodCall = "Featured · ";
                else if(methodCall == "popular")
                  methodCall = "Popular · ";
                else
                  methodCall = ""; 
                if(typeof(city) == "undefined" ) { 
                  city = "";
                } else {
                  city = city+", ";
                }
                placename = $.trim(city+state+","+country);
                $("#where-to-go").val(methodCall+placename);
                $('#place-latitude').val(lat);
                $('#place-longitude').val(lng); 
                updateSearchList('map', 'click');
                //alert("city name is: " + city);
            } else  {
                //alert("address not found");
            }
          } else {
            //alert("Geocoder failed due to: " + status);
          }
        }
      );
    }
  });
  plotMarkers();
}

google.maps.event.addDomListener(window, 'load', initMap);

function plotMarkers(){
	for(var i=0; i < markerPoints.length; i++){
		addMarker(markerPoints[i], infoMarker[i]);
	}
}

var redimagepath = "//"+window.location.hostname+baseurl+'/images/red-dot.png';
var greenimagepath = "//"+window.location.hostname+baseurl+'/images/green-dot.png'; 
//Adds a marker to the map and push to the array.
var infowindow = new google.maps.InfoWindow();

function addMarker(location, info) {

  var marker = new google.maps.Marker({
    position: location,
    icon : redimagepath,
    map: map
  });
  google.maps.event.addListener(marker, 'click', function() { 
      infowindow.setContent(info);
      infowindow.open(map, marker);
  });
  markers.push(marker);
}

showme = function (index) {
  markers[index].setAnimation(google.maps.Animation.BOUNCE);
	markers[index].setIcon(greenimagepath);

}

hideme = function (index) {
  markers[index].setAnimation(null);
  markers[index].setIcon(redimagepath);
}

//Sets the map on all markers in the array.
function setMapOnAll(map) {
  for (var i = 0; i < markers.length; i++) {
    markers[i].setMap(map);
  }
}

//Removes the markers from the map, but keeps them in the array.
function clearMarkers() {
  setMapOnAll(null);
}

//Shows any markers currently in the array.
function showMarkers() {
  setMapOnAll(map);
}

//Deletes all markers in the array by removing references to them.
function deleteMarkers() {
  clearMarkers();
  markers = []; 
}
