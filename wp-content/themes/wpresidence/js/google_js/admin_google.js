/*global admin_google_vars*/
/*global google */


var map='';
var selected_city='';
var geocoder;
var gmarkers = [];

function initialize(){
    "use strict";
    geocoder       = new google.maps.Geocoder();
    var myPlace    = new google.maps.LatLng(admin_google_vars.general_latitude, admin_google_vars.general_longitude);
 
    var mapOptions = {
            flat:false,
            noClear:false,
            zoom: 17,
            scrollwheel: false,
            draggable: true,
            center: myPlace,
            mapTypeId: google.maps.MapTypeId.ROADMAP
          };

    map = new google.maps.Map(document.getElementById('googleMap'), mapOptions);
    google.maps.visualRefresh = true;

    
    var marker=new google.maps.Marker({
        position:myPlace
    });

    marker.setMap(map);
    gmarkers.push(marker);
    google.maps.event.addListener(map, 'click', function(event) {
    placeMarker(event.latLng);
});
}



function placeMarker(location) {
    "use strict";
    removeMarkersadmin();
    var marker = new google.maps.Marker({
        position: location,
        map: map
    });
   gmarkers.push(marker);
    var infowindow = new google.maps.InfoWindow({
        content: 'Latitude: ' + location.lat() + '<br>Longitude: ' + location.lng()  
    });
  
   infowindow.open(map,marker);
   document.getElementById("property_latitude").value=location.lat();
   document.getElementById("property_longitude").value=location.lng();
}

function removeMarkersadmin(){
    for (i = 0; i<gmarkers.length; i++){
        gmarkers[i].setMap(null);
    }
}
 
    google.maps.event.addDomListener(document.getElementById('estate_property-googlemap').getElementsByClassName("handlediv")[0], 'click', function () {
        google.maps.event.trigger(map, "resize");
    });



    google.maps.event.addDomListener(window, 'load', initialize);
 
     
    jQuery('#admin_place_pin').click(function(event){
        event.preventDefault();
        admin_codeAddress();  
    });  

    jQuery('#property_citychecklist label').click(function(event){
       selected_city=  jQuery(this).text() ;
    }); 

 
 
 
 function admin_codeAddress() {
    var state, city;
    var address   = document.getElementById('property_address').value;
    var full_addr= address;
  
   
    var checkedValue = jQuery('#property_city-all input:checked').parent();
    city=checkedValue.text();
 
    if(city){
        var full_addr=full_addr +','+city;
    }
    
    checkedValue = jQuery('#property_county_state-all input:checked').parent();
    state=checkedValue.text();
 
    if(state){
        var full_addr=full_addr +','+state;
    }

    var country   = document.getElementById('property_country').value;
    if(country){
         var full_addr=full_addr +','+country;
    }
  
  
 
    geocoder.geocode( { 'address': full_addr}, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
                map.setCenter(results[0].geometry.location);
                removeMarkersadmin();
                var marker = new google.maps.Marker({
                    map: map,
                    position: results[0].geometry.location
                });
                gmarkers.push(marker);
                var infowindow = new google.maps.InfoWindow({
                    content: 'Latitude: ' + results[0].geometry.location.lat() + '<br>Longitude: ' + results[0].geometry.location.lng()  
                });

                infowindow.open(map,marker);
                document.getElementById("property_latitude").value=results[0].geometry.location.lat();
                document.getElementById("property_longitude").value=results[0].geometry.location.lng();
        } else {
                alert(admin_google_vars.geo_fails  + status);
        }
    });
}
