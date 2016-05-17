/*global google */
/*global Modernizr */
/*global InfoBox */
/*global googlecode_regular_vars*/
var gmarkers = [];
var current_place=0;
var actions=[];
var categories=[];
var vertical_pan=-190;
var map_open=0;
var vertical_off=150;
var pins='';
var markers='';
var infoBox = null;
var category=null;
var width_browser=null;
var infobox_width=null;
var wraper_height=null;
var info_image=null;
var map;
var found_id;
var selected_id         =   jQuery('#gmap_wrapper').attr('data-post_id');
var curent_gview_lat    =   jQuery('#gmap_wrapper').attr('data-cur_lat');
var curent_gview_long   =   jQuery('#gmap_wrapper').attr('data-cur_long');
var heading=0;
var panorama;
var oms;


function initialize(){
    "use strict";

    if(curent_gview_lat===''){
        curent_gview_lat=googlecode_property_vars.general_latitude;
    }
    
    if(curent_gview_long===''){
       curent_gview_long=googlecode_property_vars.general_longitude;
    } 
    var viewPlace=new google.maps.LatLng(curent_gview_lat,curent_gview_long);
       
    var mapOptions = {
        flat:false,
        noClear:false,
        zoom: parseInt(googlecode_property_vars.page_custom_zoom),
        scrollwheel: false,
        draggable: true,
        center: new google.maps.LatLng(curent_gview_lat,curent_gview_long ),
        streetViewControl:false,
        mapTypeId: googlecode_property_vars.type.toLowerCase(),
        disableDefaultUI: true
    };
    var mapOptions_intern = {
        flat:false,
        noClear:false,
        zoom:  parseInt(googlecode_property_vars.page_custom_zoom),
        scrollwheel: false,
        draggable: true,
        center: new google.maps.LatLng(curent_gview_lat,curent_gview_long ),
        streetViewControl:false,
        mapTypeId: googlecode_property_vars.type.toLowerCase(),
       disableDefaultUI: true
    };
           
    
    if(  document.getElementById('googleMap') ){
        map = new google.maps.Map(document.getElementById('googleMap'), mapOptions);
    }else if( document.getElementById('googleMapSlider') ){
        map = new google.maps.Map(document.getElementById('googleMapSlider'), mapOptions_intern);
    } else{
        return;
    }   
 
   
    google.maps.visualRefresh = true;
  
   
    if(mapfunctions_vars.map_style !==''){
       var styles = JSON.parse ( mapfunctions_vars.map_style );
       map.setOptions({styles: styles});
    }
    
    google.maps.event.addListener(map, 'tilesloaded', function() {
        jQuery('#gmap-loading').remove();
    });
    
    if (Modernizr.mq('only all and (max-width: 1025px)')) {
        map.setOptions({'draggable': false});
    }

    
    if(googlecode_property_vars.generated_pins==='0'){
        pins=googlecode_property_vars.markers;
        markers = jQuery.parseJSON(pins);
    }else{
        if( typeof( googlecode_regular_vars2) !== 'undefined' && googlecode_regular_vars2.markers2.length > 2){          
            pins=googlecode_regular_vars2.markers2;
            markers = jQuery.parseJSON(pins);                 
        }           
    }
  
    if (markers.length>0){
        setMarkers(map, markers);
    }
    
    if(googlecode_property_vars.idx_status==='1'){
        placeidx(map,markers);
    }
    
    if(mapfunctions_vars.show_g_search_status==='yes' && googlecode_property_vars.small_map!=='1'){
        set_google_search(map);
    }
  
    
    google.maps.event.trigger(gmarkers[found_id], 'click');
   
  
   
  
    //  set map cluster
    map_cluster();
    
    

    
    panorama = map.getStreetView();
    panorama.setPosition(viewPlace);
    heading  = parseInt(googlecode_property_vars.camera_angle);

    panorama.setPov(/** @type {google.maps.StreetViewPov} */({
      heading: heading,
      pitch: 0
    }));
    
    
    /*
    function scrollwhel(event){
        if(map.scrollwheel===true){
            event.stopPropagation();
        };
    }
    
    if(  document.getElementById('googleMap') ){
        google.maps.event.addDomListener(document.getElementById('googleMap'), 'mousewheel', scrollwhel);
        google.maps.event.addDomListener(document.getElementById('googleMap'), 'DOMMouseScroll', scrollwhel);
    }
    */
    google.maps.event.addListener(panorama, "closeclick", function() {
     
        jQuery('#gmap-next,#gmap-prev ,#geolocation-button,#gmapzoomminus,#gmapzoomplus').show();
        jQuery('#street-view').removeClass('mapcontrolon');
    });
    

    oms = new OverlappingMarkerSpiderfier(map);   
      setOms(gmarkers);
      
      
   /* oms.addListener('spiderfy', function(markers) {
    });
    
    oms.addListener('unspiderfy ', function(markers) {
    });
   */
  
  
}
///////////////////////////////// end initialize
/////////////////////////////////////////////////////////////////////////////////// 
 
 
if (typeof google === 'object' && typeof google.maps === 'object') {                                         
    google.maps.event.addDomListener(window, 'load', initialize);
}

function toggleStreetView() {
   "use strict";
   if (panorama.visible){
        panorama.setVisible(false); 
        jQuery('#gmap-next,#gmap-prev ,#geolocation-button,#gmapzoomminus,#gmapzoomplus').show();
        jQuery('#street-view').removeClass('mapcontrolon');
        jQuery('#street-view').html('<i class="fa fa-location-arrow"></i> '+control_vars.street_view_on);
   }else{
        panorama.setVisible(true);  
        jQuery('#gmap-next,#gmap-prev ,#geolocation-button,#gmapzoomminus,#gmapzoomplus').hide();
        jQuery('#street-view').addClass('mapcontrolon');
        jQuery('#street-view').html('<i class="fa fa-location-arrow"></i> '+control_vars.street_view_off);
   }
}
