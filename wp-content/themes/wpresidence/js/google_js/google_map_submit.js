/*global google */
/*global Modernizr */
/*global InfoBox */
/*global googlecode_home_vars*/
var geocoder;
var map;
var selected_id         =   '';

var gmarkers = [];

function initialize(){
    "use strict";
    geocoder = new google.maps.Geocoder();
    
    var listing_lat=jQuery('#property_latitude').val();
    var listing_lon=jQuery('#property_longitude').val();
    
    if(listing_lat===''){
        listing_lat=google_map_submit_vars.general_latitude
    }
    
     if(listing_lon===''){
        listing_lon= google_map_submit_vars.general_longitude
    }
    
    var mapOptions = {
             flat:false,
             noClear:false,
             zoom: 17,
             scrollwheel: false,
             draggable: true,
             disableDefaultUI:false,
             center: new google.maps.LatLng( listing_lat, listing_lon),
             mapTypeId: google.maps.MapTypeId.ROADMAP
           };
    map = new google.maps.Map(document.getElementById('googleMapsubmit'), mapOptions);
    google.maps.visualRefresh = true;
    
    var point=new google.maps.LatLng( listing_lat, listing_lon);
    placeSavedMarker(point);
    
    if(mapfunctions_vars.map_style !==''){
       var styles = JSON.parse ( mapfunctions_vars.map_style );
       map.setOptions({styles: styles});
    }
    
    google.maps.event.addListener(map, 'click', function(event) {
        placeMarker(event.latLng);
    });
}
 


function placeSavedMarker(location) {
 "use strict";
  removeMarkers();
  var marker = new google.maps.Marker({
    position: location,
    map: map
  });
   gmarkers.push(marker);
    
  var infowindow = new google.maps.InfoWindow({
    content: 'Latitude: ' + location.lat() + '<br>Longitude: ' + location.lng()  
  });
  
   infowindow.open(map,marker);


}


function codeAddress() {
  var address   = document.getElementById('property_address').value;
  //var e = document.getElementById("property_city_submit"); 
  //var city      = e.options[e.selectedIndex].text;
  city=jQuery ("#property_city_submit").val();
 
  var full_addr= address+','+city;
  
  var state     = document.getElementById('property_county').value;
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
            alert(google_map_submit_vars.geo_fails + status);
    }
  });
}
















function placeMarker(location) {
 "use strict";
  removeMarkers();
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


 ////////////////////////////////////////////////////////////////////
 /// set markers function
 //////////////////////////////////////////////////////////////////////
 
function removeMarkers(){
    for (i = 0; i<gmarkers.length; i++){
        gmarkers[i].setMap(null);
    }
}

function setMarkers(map, locations) {
 
}// end setMarkers

                         
jQuery('#open_google_submit').click(function(){
     
        setTimeout(function(){
                 initialize();
                google.maps.event.trigger(map, "resize");
        },300)
   
  });
               
    
jQuery('#google_capture').click(function(event){
    event.preventDefault();
    removeMarkers();
    codeAddress();  
});  
    
google.maps.event.addDomListener(window, 'load', initialize);






jQuery(document).ready(function ($) {
    "use strict";
    
    $( "#imagelist" ).sortable({
        revert: true,
        update: function( event, ui ) {
            var all_id,new_id;
            all_id="";
            $( "#imagelist .uploaded_images" ).each(function(){

                new_id = $(this).attr('data-imageid'); 
                if (typeof new_id != 'undefined') {
                    all_id=all_id+","+new_id; 
                   
                }

            });
           
            $('#attachid').val(all_id);
        },
    });

    
    

    var autocomplete,autocomplete2;
    var options = {
        types: ['(cities)'],
        componentRestrictions: {country: 'uk'}
    };




    var componentForm = {
        establishment:'long_name',
        street_number: 'short_name',
        route: 'long_name',
        locality: 'long_name',
        administrative_area_level_1: 'long_name',
        administrative_area_level_2: 'long_name',
        country: 'long_name',
        postal_code: 'short_name',
        postal_code_prefix:'short_name',
        neighborhood:'long_name'
    };



    if ( google_map_submit_vars.enable_auto ==='yes' ){
    
        autocomplete = new google.maps.places.Autocomplete(
          /** @type {HTMLInputElement} */(document.getElementById('property_address')),
            {   types: ['geocode'],
                "partial_match" : true
            }
        );
        google.maps.event.addListener(autocomplete, 'place_changed', function() {
            var place = autocomplete.getPlace();
            fillInAddress(place);
        });
        
        autocomplete2 = new google.maps.places.Autocomplete(
            /** @type {HTMLInputElement} */(document.getElementById('property_city_submit')),
            {    types: ['(cities)']        }
        );
    
        google.maps.event.addListener(autocomplete2, 'place_changed', function() {
             var place = autocomplete2.getPlace();
            fillInAddress(place);
        });
    }
    
    
    
    
    
    
    
    function fillInAddress(place) {
      
        $('#property_area').val('');
        $('#property_zip').val('');
        $('#property_county').val('');
        $('#property_city_submit').val('');
        
        for (var i = 0; i < place.address_components.length; i++) {
          var addressType = place.address_components[i].types[0];
       
            var temp='';
            var val = place.address_components[i][componentForm[addressType]];
           
      
                
            if(addressType=== 'street_number' || addressType=== 'route'){
              //  document.getElementById('property_address').value =  document.getElementById('property_address').value +', '+ val;
            }else if(addressType=== 'neighborhood'){
                 $('#property_area').val(val);
            }else if(addressType=== 'postal_code_prefix'){
               // temp = $('#property_zip').val();
                $('#property_zip').val(val);
            }else if(addressType=== 'postal_code'){
               // temp = $('#property_zip').val();
                $('#property_zip').val(val);
            }else if(addressType=== 'administrative_area_level_2'){
                $('#property_county').val(val);
            }else if(addressType=== 'administrative_area_level_1'){
                $('#property_county').val(val);
            }else if(addressType=== 'locality'){
                $('#property_city_submit').val(val);
            }else if(addressType=== 'country'){
                $('#property_country').val(val);
            }else{
               
            }
            
          
        }
        
    }
    
    
  
   
    jQuery('#google_capture2').click(function(event){
        event.preventDefault();
        codeAddress_child();  
    });  
    
    

    function codeAddress_child() {
        var address   = document.getElementById('property_address').value;
        //var e = document.getElementById("property_city_submit"); 
        //var city      = e.options[e.selectedIndex].text;
        var city=jQuery("#property_city_submit").val();

        var full_addr= address+','+city;
        if(  document.getElementById('property_state') ){
            var state     = document.getElementById('property_state').value;
            if(state){
                 var full_addr=full_addr +','+state;
            }
        }

        if(  document.getElementById('property_country') ){
            var country   = document.getElementById('property_country').value;
            if(country){
                 var full_addr=full_addr +','+country;
            }
        }   


        geocoder.geocode( { 'address': full_addr}, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                    map.setCenter(results[0].geometry.location);
                    var marker = new google.maps.Marker({
                        map: map,
                        position: results[0].geometry.location
                    });

                    var infowindow = new google.maps.InfoWindow({
                        content: 'Latitude: ' + results[0].geometry.location.lat() + '<br>Longitude: ' + results[0].geometry.location.lng()  
                     });

                    infowindow.open(map,marker);
                    document.getElementById("property_latitude").value=results[0].geometry.location.lat();
                    document.getElementById("property_longitude").value=results[0].geometry.location.lng();
            } else {
                    alert(google_map_submit_vars.geo_fails + status);
            }
        });
    }
    
    
    /////////////////////////////////////// search code
 
});