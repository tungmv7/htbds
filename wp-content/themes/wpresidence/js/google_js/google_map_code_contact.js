/*global google */
/*global Modernizr */
/*global InfoBox */
/*global googlecode_contact_vars*/

var gmarkers = [];
var map_open=0;
var first_time=1;
var pins='';
var markers='';
var infoBox = null;
var vertical_off=''; 
var map;
var selected_id='';
var width_browser=null;
var infobox_width=null;
var wraper_height=null;
var info_image=null;

 function initialize(){
        "use strict";
        var mapOptions = {
        zoom: parseInt(googlecode_contact_vars.page_custom_zoom),
        scrollwheel: false,
        center: new google.maps.LatLng(googlecode_contact_vars.hq_latitude, googlecode_contact_vars.hq_longitude),
        mapTypeId: googlecode_contact_vars.type.toLowerCase(),
        streetViewControl:false,
        disableDefaultUI: true
    };

    map = new google.maps.Map(document.getElementById('googleMap'), mapOptions);

    if (Modernizr.mq('only all and (max-width: 1025px)')) {
        map.setOptions({'draggable': false});
    }

    google.maps.event.addListener(map, 'tilesloaded', function() {
        jQuery('#gmap-loading').remove();
    });


    if(mapfunctions_vars.map_style !==''){
       var styles = JSON.parse ( mapfunctions_vars.map_style );
       map.setOptions({styles: styles});
    }

    pins=googlecode_contact_vars.markers;
    markers = jQuery.parseJSON(pins);
    setMarkers_contact(map, markers);
    google.maps.event.trigger(gmarkers[0], 'click');

  
}
 
 
 
 ////////////////////////////////////////////////////////////////////
 /// custom pin function
 //////////////////////////////////////////////////////////////////////
 
 function custompincontact(image){
   "use strict";
    image = {
     url: googlecode_contact_vars.path+'/sale.png', 
     size: new google.maps.Size(59, 59),
     origin: new google.maps.Point(0,0),
     anchor: new google.maps.Point(16,59 )
   };
   return image;
 }
  
 ////////////////////////////////////////////////////////////////////
 /// set markers function
 //////////////////////////////////////////////////////////////////////
 

function setMarkers_contact(map, beach) {
   "use strict";
   var shape = {
       coord: [1, 1, 1, 38, 38, 59, 59 , 1],
       type: 'poly'
   };
   var title;
    var boxText = document.createElement("div");
      var myOptions = {
                      content: boxText,
                      disableAutoPan: true,
                      maxWidth: 500,
                      pixelOffset: new google.maps.Size(-90, -210),
                      zIndex: null,
                      closeBoxMargin: "-13px 0px 0px 0px",
                      closeBoxURL: "",
                      draggable: true,
                      infoBoxClearance: new google.maps.Size(1, 1),
                      isHidden: false,
                      pane: "floatPane",
                      enableEventPropagation: false
              };              
      infoBox = new InfoBox(myOptions);         
                

   
     
     var myLatLng = new google.maps.LatLng(googlecode_contact_vars.hq_latitude, googlecode_contact_vars.hq_longitude);
     var marker = new google.maps.Marker({
         position: myLatLng,
         map: map,
         icon: custompincontact(beach[8]),
         shape: shape,
         title: decodeURIComponent(  beach[0].replace(/\+/g,' ')),
         zIndex: 1,
         image:beach[4],
         price:beach[5],
         type:beach[6],
         type2:beach[7],
         infoWindowIndex : 0 
     });

   gmarkers.push(marker);


    google.maps.event.addListener(marker, 'click', function() { 
       /*if(map_open === 0 && first_time === 0){
             map_open=1;
             jQuery('#googleMap').animate({'height': '590px'});
             jQuery('.gmap_wrapper').animate({'height': '590px'},500,function(){ 
                   map.setOptions({'scrollwheel': false});
                   jQuery('#gmap-next,#gmap-prev').show();
                   jQuery('#gmap-menu').show();
                   show_advanced_search('close');
                   google.maps.event.trigger(map, "resize");  
                  
                   
             });                
        }*/
        first_time=0;
        title = this.title;
        infoBox.setContent('<div class="info_details contact_info_details"><span id="infocloser" onClick=\'javascript:infoBox.close();\' ></span><h2 id="contactinfobox">'+title+'</h2><div class="contactaddr">'+googlecode_contact_vars.address+'</div></div>' );
  
        infoBox.open(map, this);    
        map.setCenter(this.position);      
        map.panBy(0,-120);
        
        close_adv_search()
    });


}// end setMarkers

                       
                         
google.maps.event.addDomListener(window, 'load', initialize);