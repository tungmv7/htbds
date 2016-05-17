var pin_images=mapfunctions_vars.pin_images;
var images = jQuery.parseJSON(pin_images);
var ipad_time=0;
var infobox_id=0;
var shape = {
        coord: [1, 1, 1, 38, 38, 59, 59 , 1],
        type: 'poly'
    };

var mcOptions;
var mcluster;
var clusterStyles;
var pin_hover_storage;
var first_time_wpestate_show_inpage_ajax_half=0;
var panorama;
var infoBox_sh=null;

function wpestate_map_shortcode_function(){
    var selected_id       =   parseInt( jQuery('#googleMap_shortcode').attr('data-post_id'),10 );
    var curent_gview_lat    =   jQuery('#googleMap_shortcode').attr('data-cur_lat');
    var curent_gview_long   =   jQuery('#googleMap_shortcode').attr('data-cur_long');
    var zoom;

    var map2;
    var gmarkers_sh = [];
   
    if (typeof googlecode_property_vars === 'undefined') {
        zoom=5;
        heading=0;
    }else{
        zoom=googlecode_property_vars.page_custom_zoom;
        heading  = parseInt(googlecode_property_vars.camera_angle);
    }
    var mapOptions_intern = {
        flat:false,
        noClear:false,
        zoom:  parseInt(zoom),
        scrollwheel: false,
        draggable: true,
        center: new google.maps.LatLng(curent_gview_lat,curent_gview_long ),
        streetViewControl:false,
        disableDefaultUI: true
    };
   
    map2= new google.maps.Map(document.getElementById('googleMap_shortcode'), mapOptions_intern);
    google.maps.visualRefresh = true;
    width_browser       =   jQuery(window).width();
    
    infobox_width=700;
    vertical_pan=-215;
    if (width_browser<900){
      infobox_width=500;
    }
    if (width_browser<600){
      infobox_width=400;
    }
    if (width_browser<400){
      infobox_width=200;
    }
   var boxText         =   document.createElement("div");
 
    var myOptions = {
        content: boxText,
        disableAutoPan: true,
        maxWidth: infobox_width,
        boxClass:"mybox",
        zIndex: null,			
        closeBoxMargin: "-13px 0px 0px 0px",
        closeBoxURL: "",
        infoBoxClearance: new google.maps.Size(1, 1),
        isHidden: false,
        pane: "floatPane",
        enableEventPropagation: true                   
    };              
    infoBox_sh = new InfoBox(myOptions);    
    
    
    if(mapfunctions_vars.map_style !==''){
       var styles = JSON.parse ( mapfunctions_vars.map_style );
       map2.setOptions({styles: styles});
    }
    
    var id                    = selected_id;
    var lat                   = curent_gview_lat;
    var lng                   = curent_gview_long;
    var title                 = decodeURIComponent ( jQuery('#googleMap_shortcode').attr('data-title') ); 
    var pin                   = jQuery('#googleMap_shortcode').attr('data-pin');
    var counter               = 1;
    var image                 = decodeURIComponent ( jQuery('#googleMap_shortcode').attr('data-thumb' ));
    var price                 = decodeURIComponent ( jQuery('#googleMap_shortcode').attr('data-price' ));;
    var single_first_type     = decodeURIComponent ( jQuery('#googleMap_shortcode').attr('data-single-first-type') );        
    var single_first_action   = decodeURIComponent ( jQuery('#googleMap_shortcode').attr('data-single-first-action') );
    var link                  = '';
    var city                  = '';
    var area                  = '';
    var cleanprice            = '';
    var rooms                 = jQuery('#googleMap_shortcode').attr('data-rooms') ;
    var baths                 = jQuery('#googleMap_shortcode').attr('data-bathrooms') ;
    var size                  = jQuery('#googleMap_shortcode').attr('data-size') ;
    var single_first_type_name      =    decodeURIComponent ( jQuery('#googleMap_shortcode').attr('data-single-first-type') );  
    var single_first_action_name    =   decodeURIComponent ( jQuery('#googleMap_shortcode').attr('data-single-first-action') );
    var agent_id                    =   '' ;   
    var county_state                =   '' ;  
    var i = 1;
    var slug1                = '';
    var val1                 = '';
    var how1                 = '';
    var slug2                = '';
    var val2                 = '';
    var how2                 = '';
    var slug3                = '';
    var val3                 = '';
    var how3                 = '';
    var slug4                = '';
    var val4                 = '';
    var how4                 = '';
    var slug5                = '';
    var val5                 = '';
    var how5                 = '';
    var slug6                = '';
    var val6                 = '';
    var how6                 = '';
    var slug7                = '';
    var val7                 = '';
    var how7                 = '';
    var slug8                = '';
    var val8                 = '';
    var how8                 = '';
            
   
    createMarker_sh (infoBox_sh,gmarkers_sh,map2,county_state, size, i,id,lat,lng,pin,title,counter,image,price,single_first_type,single_first_action,link,city,area,rooms,baths,cleanprice,slug1,val1,how1,slug2,val2,how2,slug3,val3,how3,slug4,val4,how4,slug5, val5, how5, slug6, val6, how6 ,slug7 ,val7, how7, slug8, val8, how8, single_first_type_name, single_first_action_name );
  
    
    
    var viewPlace=new google.maps.LatLng(curent_gview_lat,curent_gview_long);
    panorama = map2.getStreetView();
    panorama.setPosition(viewPlace);


    panorama.setPov(/** @type {google.maps.StreetViewPov} */({
      heading: heading,
      pitch: 0
    }));
    
    jQuery('#slider_enable_street_sh').click(function(){
        cur_lat     =   jQuery('#googleMap_shortcode').attr('data-cur_lat');
        cur_long    =   jQuery('#googleMap_shortcode').attr('data-cur_long');
        myLatLng    =   new google.maps.LatLng(cur_lat,cur_long);
      
        panorama.setPosition(myLatLng);
        panorama.setVisible(true); 
        jQuery('#gmapzoomminus_sh,#gmapzoomplus_sh,#slider_enable_street_sh').hide();
     
    });
    google.maps.event.addListener(panorama, "closeclick", function() {
         jQuery('#gmapzoomminus_sh,#gmapzoomplus_sh,#slider_enable_street_sh').show();
    });
    
    
    
    
    if(  document.getElementById('gmapzoomplus_sh') ){
         google.maps.event.addDomListener(document.getElementById('gmapzoomplus_sh'), 'click', function () {      
           var current= parseInt( map2.getZoom(),10);
           current++;
           if(current>20){
               current=20;
           }
           map2.setZoom(current);
        });  
    }
    
    
    if(  document.getElementById('gmapzoomminus_sh') ){
         google.maps.event.addDomListener(document.getElementById('gmapzoomminus_sh'), 'click', function () {      
           var current= parseInt( map2.getZoom(),10);
           current--;
           if(current<0){
               current=0;
           }
           map2.setZoom(current);
        });  
    }
  
        google.maps.event.trigger(gmarkers_sh[0], 'click');  
}






function createMarker_sh (infoBox_sh,gmarkers_sh,map2,county_state, size, i,id,lat,lng,pin,title,counter,image,price,single_first_type,single_first_action,link,city,area,rooms,baths,cleanprice,slug1,val1,how1,slug2,val2,how2,slug3,val3,how3,slug4,val4,how4,slug5, val5, how5, slug6, val6, how6 ,slug7 ,val7, how7, slug8, val8, how8, single_first_type_name, single_first_action_name ){
   
    var new_title='';
    var myLatLng = new google.maps.LatLng(lat,lng);
    
    var marker = new google.maps.Marker({
           position: myLatLng,
           map: map2,
           icon: custompin(pin),
           shape: shape,
           title: title,
           zIndex: counter,
           image:image,
           idul:id,
           price:price,
           category:single_first_type,
           action:single_first_action,
           link:link,
           city:city,
           area:area,
           infoWindowIndex : i,
           rooms:rooms,
           baths:baths,
           cleanprice:cleanprice,
           size:size,
           county_state:county_state,
           category_name:single_first_type_name,
           action_name:single_first_action_name
          });
              
                  
    

    gmarkers_sh.push(marker);
 
    google.maps.event.addListener(marker, 'click', function(event) {
         
            if(this.image===''){
                 info_image='<img src="' + mapfunctions_vars.path + '/idxdefault.jpg" alt="image" />';
             }else{
                 info_image=this.image;
             }
            
            var category         =   decodeURIComponent ( this.category.replace(/-/g,' ') );
            var action           =   decodeURIComponent ( this.action.replace(/-/g,' ') );
            var category_name    =   decodeURIComponent ( this.category_name.replace(/-/g,' ') );
            var action_name      =   decodeURIComponent ( this.action_name.replace(/-/g,' ') );
            var in_type          =   mapfunctions_vars.in_text;
            if(category==='' || action===''){
                in_type=" ";
            }
            
           var infobaths; 
           if(this.baths!=''){
               infobaths ='<span id="infobath">'+this.baths+'</span>';
           }else{
               infobaths =''; 
           }
           
           var inforooms;
           if(this.rooms!=''){
               inforooms='<span id="inforoom">'+this.rooms+'</span>';
           }else{
               inforooms=''; 
           }
           
           var infosize;
           if(this.size!=''){
               infosize ='<span id="infosize">'+this.size;
               if(mapfunctions_vars.measure_sys==='ft'){
                   infosize = infosize+ ' ft<sup>2</sup>';
               }else{
                   infosize = infosize+' m<sup>2</sup>';
               }
               infosize =infosize+'</span>';
           }else{
               infosize=''; 
           }
        
        
           var title=  this.title.substr(0, 45)
           if(this.title.length > 45){
               title=title+"...";
           }
        
            infoBox_sh.setContent('<div class="info_details"><span id="infocloser" onClick=\'javascript:infoBox_sh.close();\' ></span><a href="'+this.link+'">'+info_image+'</a><a href="'+this.link+'" id="infobox_title">'+title+'</a><div class="prop_detailsx">'+category_name+" "+in_type+" "+action_name+'</div><div class="prop_pricex">'+this.price+infosize+infobaths+inforooms+'</div></div>' );
            infoBox_sh.open(map2, this);    
            map2.setCenter(this.position);   

            
           
    


            switch (infobox_width){
              case 700:
                 
                    if(mapfunctions_vars.listing_map === 'top'){
                       map2.panBy(100,-150);
                    }else{
                        if(mapfunctions_vars.small_slider_t==='vertical'){
                            map2.panBy(300,-300);
                          
                        }else{
                            map2.panBy(10,-110);
                        }    
                   }
                 
                   vertical_off=0;
                   break;
              case 500: 
                   map2.panBy(50,-120);
                   break;
              case 400: 
                   map2.panBy(100,-220);
                   break;
              case 200: 
                   map2.panBy(20,-170);
                   break;               
             }
            
            if (control_vars.show_adv_search_map_close === 'no') {
                $('.search_wrapper').addClass('adv1_close');
                adv_search_click();
            }
            
             close_adv_search();
            });/////////////////////////////////// end event listener
            
        if(mapfunctions_vars.generated_pins!=='0'){
            pan_to_last_pin(myLatLng);
        }    
            
        
}

















/////////////////////////////////////////////////////////////////////////////////////////////////
// change map
/////////////////////////////////////////////////////////////////////////////////////////////////  

function  wpestate_change_map_type(map_type){
 
    if(map_type==='map-view-roadmap'){
         map.setMapTypeId(google.maps.MapTypeId.ROADMAP);
    }else if(map_type==='map-view-satellite'){
         map.setMapTypeId(google.maps.MapTypeId.SATELLITE);
    }else if(map_type==='map-view-hybrid'){
         map.setMapTypeId(google.maps.MapTypeId.HYBRID);
    }else if(map_type==='map-view-terrain'){
         map.setMapTypeId(google.maps.MapTypeId.TERRAIN);
    }
   
}

/////////////////////////////////////////////////////////////////////////////////////////////////
//  set markers... loading pins over map
/////////////////////////////////////////////////////////////////////////////////////////////////  

function setMarkers(map, locations) {
    "use strict";
    console.log('setMarkers');
    var map_open;          
     
    var myLatLng;
    var selected_id     =   parseInt( jQuery('#gmap_wrapper').attr('data-post_id') );
    if( isNaN(selected_id) ){
        selected_id     =   parseInt( jQuery('#googleMapSlider').attr('data-post_id'),10 );
    }
   
    var open_height     =   parseInt(mapfunctions_vars.open_height,10);
    var closed_height   =   parseInt(mapfunctions_vars.closed_height,10);
    var boxText         =   document.createElement("div");
    width_browser       =   jQuery(window).width();
    
    infobox_width=700;
    vertical_pan=-215;
    if (width_browser<900){
      infobox_width=500;
    }
    if (width_browser<600){
      infobox_width=400;
    }
    if (width_browser<400){
      infobox_width=200;
    }
 
 
    var myOptions = {
        content: boxText,
        disableAutoPan: true,
        maxWidth: infobox_width,
        boxClass:"mybox",
        zIndex: null,			
        closeBoxMargin: "-13px 0px 0px 0px",
        closeBoxURL: "",
        infoBoxClearance: new google.maps.Size(1, 1),
        isHidden: false,
        pane: "floatPane",
        enableEventPropagation: true                   
    };              
    infoBox = new InfoBox(myOptions);         
                                

    for (var i = 0; i < locations.length; i++) {
        var beach                 = locations[i];
        var id                    = beach[10];
        var lat                   = beach[1];
        var lng                   = beach[2];
        var title                 = decodeURIComponent ( beach[0] );
        var pin                   = beach[8];
        var counter               = beach[3];
        var image                 = decodeURIComponent ( beach[4] );
        var price                 = decodeURIComponent ( beach[5] );
        var single_first_type     = decodeURIComponent ( beach[6] );          
        var single_first_action   = decodeURIComponent ( beach[7] );
        var link                  = decodeURIComponent ( beach[9] );
        var city                  = decodeURIComponent ( beach[11] );
        var area                  = decodeURIComponent ( beach[12] );
        var cleanprice            = beach[13];
        var rooms                 = beach[14];
        var baths                 = beach[15];
        var size                  = beach[16];
        var single_first_type_name      =   decodeURIComponent ( beach[17] );
        var single_first_action_name    =   decodeURIComponent ( beach[18] );
        var agent_id                    =   beach[19] ;   
        var county_state                =   beach[20] ;   
           
        if(mapfunctions_vars.custom_search==='yes'){
            var slug1                 = beach[21];
            var val1                  = beach[22];
            var how1                  = beach[23];
            
            var slug2                 = beach[24];
            var val2                  = beach[25];
            var how2                  = beach[26];
            
            var slug3                 = beach[27];
            var val3                  = beach[28];
            var how3                  = beach[29];
           
            var slug4                 = beach[30];
            var val4                  = beach[31];
            var how4                  = beach[32];
            
            var slug5                 = beach[33];
            var val5                  = beach[34];
            var how5                  = beach[35];
            
            var slug6                 = beach[36];
            var val6                  = beach[37];
            var how6                  = beach[38];
            
            var slug7                 = beach[39];
            var val7                  = beach[40];
            var how7                  = beach[41];
            
            var slug8                 = beach[42];
            var val8                  = beach[43];
            var how8                  = beach[44];
            
            
            if( typeof (val1)!=='number'){
                val1=val1.replace(" ","-");
            }
            
            if( typeof (val2)!=='number'){
                val2=val2.replace(" ","-");
            }
            
            if( typeof (val3)!=='number'){
                val3=val3.replace(" ","-");
            }
            
            if( typeof (val4)!=='number'){
                val4=val4.replace(" ","-");
            }

            if( typeof (val5)!=='number'){
                val5=val5.replace(" ","-");
            }
            
            if( typeof (val6)!=='number'){
                val6=val6.replace(" ","-");
            }
            
            if( typeof (val7)!=='number'){
                val7=val7.replace(" ","-");
            }
            
            if( typeof (val8)!=='number'){
                val8=val8.replace(" ","-");
            }
            
    
            
        } 
       
        if( typeof( googlecode_regular_vars2) !== 'undefined' && typeof( googlecode_regular_vars2.markers2 )!=='undefined' && googlecode_regular_vars2.markers2.length > 2 &&  typeof (googlecode_regular_vars2.taxonomy )!=='undefined'){      
            //single_first_type single_first_action city area
     
            if(googlecode_regular_vars2.taxonomy === 'property_city'){
                if( googlecode_regular_vars2.term === city){
                    createMarker (county_state, size, i,id,lat,lng,pin,title,counter,image,price,single_first_type,single_first_action,link,city,area,rooms,baths,cleanprice,slug1,val1,how1,slug2,val2,how2,slug3,val3,how3,slug4,val4,how4, slug5, val5, how5, slug6, val6, how6 ,slug7 ,val7, how7, slug8, val8, how8,single_first_type_name, single_first_action_name);
                }
            }
            
            if(googlecode_regular_vars2.taxonomy === 'property_area'){
                if( googlecode_regular_vars2.term === area){
                    createMarker (county_state ,size, i,id,lat,lng,pin,title,counter,image,price,single_first_type,single_first_action,link,city,area,rooms,baths,cleanprice,slug1,val1,how1,slug2,val2,how2,slug3,val3,how3,slug4,val4,how4, slug5, val5, how5, slug6, val6, how6 ,slug7 ,val7, how7, slug8, val8, how8,single_first_type_name, single_first_action_name);
                }    
            }
            
            if(googlecode_regular_vars2.taxonomy === 'property_category'){
                if( googlecode_regular_vars2.term === single_first_type){
                    createMarker (county_state, size, i,id,lat,lng,pin,title,counter,image,price,single_first_type,single_first_action,link,city,area,rooms,baths,cleanprice,slug1,val1,how1,slug2,val2,how2,slug3,val3,how3,slug4,val4,how4, slug5, val5, how5, slug6, val6, how6 ,slug7 ,val7, how7, slug8, val8, how8,single_first_type_name, single_first_action_name);
                }  
            }
            
            if(googlecode_regular_vars2.taxonomy === 'property_action_category'){
                if( googlecode_regular_vars2.term === single_first_action){
                    createMarker (county_state, size, i,id,lat,lng,pin,title,counter,image,price,single_first_type,single_first_action,link,city,area,rooms,baths,cleanprice,slug1,val1,how1,slug2,val2,how2,slug3,val3,how3,slug4,val4,how4, slug5, val5, how5, slug6, val6, how6 ,slug7 ,val7, how7, slug8, val8, how8,single_first_type_name, single_first_action_name);
                }  
            }
            
        }else if( typeof( googlecode_regular_vars2) !== 'undefined' && typeof( googlecode_regular_vars2.markers2 )!=='undefined' && googlecode_regular_vars2.markers2.length > 2 &&  typeof (googlecode_regular_vars2.agent_id )!=='undefined'){    
                if( parseInt( googlecode_regular_vars2.agent_id,10) === parseInt( agent_id,10) ){
                    createMarker (county_state, size, i,id,lat,lng,pin,title,counter,image,price,single_first_type,single_first_action,link,city,area,rooms,baths,cleanprice,slug1,val1,how1,slug2,val2,how2,slug3,val3,how3,slug4,val4,how4, slug5, val5, how5, slug6, val6, how6 ,slug7 ,val7, how7, slug8, val8, how8,single_first_type_name, single_first_action_name);
                }
                            
        }else{
       
            createMarker (county_state, size, i,id,lat,lng,pin,title,counter,image,price,single_first_type,single_first_action,link,city,area,rooms,baths,cleanprice,slug1,val1,how1,slug2,val2,how2,slug3,val3,how3,slug4,val4,how4, slug5, val5, how5, slug6, val6, how6 ,slug7 ,val7, how7, slug8, val8, how8,single_first_type_name, single_first_action_name);
        }
        // found the property
        if(selected_id===id){
            found_id=i;
        }
       
       // createMarker (i,id,lat,lng,pin,title,counter,image,price,single_first_type,single_first_action,link,city,area,rooms,baths,cleanprice )
    }//end for



    // pan to the latest pin for taxonmy and adv search  
    if(mapfunctions_vars.generated_pins!=='0'){
        myLatLng  = new google.maps.LatLng(lat, lng);
        pan_to_last_pin(myLatLng);
    }
    
  
    if(mapfunctions_vars.is_prop_list==='1' || mapfunctions_vars.is_tax==='1' ){
        show_pins_filters_from_file();
    }
   
   
}// end setMarkers


/////////////////////////////////////////////////////////////////////////////////////////////////
//  create marker
/////////////////////////////////////////////////////////////////////////////////////////////////  

function createMarker (county_state, size, i,id,lat,lng,pin,title,counter,image,price,single_first_type,single_first_action,link,city,area,rooms,baths,cleanprice,slug1,val1,how1,slug2,val2,how2,slug3,val3,how3,slug4,val4,how4,slug5, val5, how5, slug6, val6, how6 ,slug7 ,val7, how7, slug8, val8, how8, single_first_type_name, single_first_action_name ){

    var new_title='';
    var myLatLng = new google.maps.LatLng(lat,lng);
    if(mapfunctions_vars.custom_search==='yes'){
        new_title =  title.replace('%',' ');
        new_title = decodeURIComponent(  new_title.replace(/\+/g,' '));
 
        Encoder.EncodeType = "entity";
 
        new_title =Encoder.htmlDecode( new_title);

        var marker = new google.maps.Marker({
            position: myLatLng,
            map: map,
            icon: custompin(pin),
            shape: shape,
            title:new_title,
            zIndex: counter,
            image:image,
            idul:id,
            price:price,
            category:single_first_type,
            action:single_first_action,
            link:link,
            city:city,
            area:area,
            infoWindowIndex : i,
            rooms:rooms,
            baths:baths,
            size:size,
            county_state:county_state,
            cleanprice:cleanprice,
            size:size,
            category_name:single_first_type_name,
            action_name:single_first_action_name,
            slug1: slug1,
            val1: val1,
            howto1:how1,
            slug2:slug2,
            val2: val2,
            howto2:how2,
            slug3:slug3,
            val3: val3,
            howto3:how3,
            slug4:slug4,
            val4: val4,
            howto4:how4,
            slug5:slug5,
            val5: val5,
            howto5:how5,
            slug6:slug6,
            val6: val6,
            howto6:how7,
            slug7:slug7,
            val7: val7,
            howto7:how7,
            slug8:slug8,
            val8: val8,
            howto8:how8
            });
            
    }else{
         var marker = new google.maps.Marker({
                position: myLatLng,
                map: map,
                icon: custompin(pin),
                shape: shape,
                title: title,
                zIndex: counter,
                image:image,
                idul:id,
                price:price,
                category:single_first_type,
                action:single_first_action,
                link:link,
                city:city,
                area:area,
                infoWindowIndex : i,
                rooms:rooms,
                baths:baths,
                cleanprice:cleanprice,
                size:size,
                county_state:county_state,
                category_name:single_first_type_name,
                action_name:single_first_action_name
               });
              
                  
    }

    gmarkers.push(marker);
 
    google.maps.event.addListener(marker, 'click', function(event) {
            
          //  new_open_close_map(1);

            map_callback( new_open_close_map );
            google.maps.event.trigger(map, 'resize');

            if(this.image===''){
                 info_image='<img src="' + mapfunctions_vars.path + '/idxdefault.jpg" alt="image" />';
             }else{
                 info_image=this.image;
             }
            
            var category         =   decodeURIComponent ( this.category.replace(/-/g,' ') );
            var action           =   decodeURIComponent ( this.action.replace(/-/g,' ') );
            var category_name    =   decodeURIComponent ( this.category_name.replace(/-/g,' ') );
            var action_name      =   decodeURIComponent ( this.action_name.replace(/-/g,' ') );
            var in_type          =   mapfunctions_vars.in_text;
            if(category==='' || action===''){
                in_type=" ";
            }
            
           var infobaths; 
           if(this.baths!=''){
               infobaths ='<span id="infobath">'+this.baths+'</span>';
           }else{
               infobaths =''; 
           }
           
           var inforooms;
           if(this.rooms!=''){
               inforooms='<span id="inforoom">'+this.rooms+'</span>';
           }else{
               inforooms=''; 
           }
           
           var infosize;
           if(this.size!=''){
               infosize ='<span id="infosize">'+this.size;
               if(mapfunctions_vars.measure_sys==='ft'){
                   infosize = infosize+ ' ft<sup>2</sup>';
               }else{
                   infosize = infosize+' m<sup>2</sup>';
               }
               infosize =infosize+'</span>';
           }else{
               infosize=''; 
           }
        
        
           var title=  this.title.substr(0, 45)
           if(this.title.length > 45){
               title=title+"...";
           }
        
            infoBox.setContent('<div class="info_details"><span id="infocloser" onClick=\'javascript:infoBox.close();\' ></span><a href="'+this.link+'">'+info_image+'</a><a href="'+this.link+'" id="infobox_title">'+title+'</a><div class="prop_detailsx">'+category_name+" "+in_type+" "+action_name+'</div><div class="prop_pricex">'+this.price+infosize+infobaths+inforooms+'</div></div>' );
            infoBox.open(map, this);    
            map.setCenter(this.position);   

            
           
    


            switch (infobox_width){
              case 700:
                 
                    if(mapfunctions_vars.listing_map === 'top'){
                        map.panBy(100,-150);
                    }else{
                        if(mapfunctions_vars.small_slider_t==='vertical'){
                            map.panBy(300,-300);
                          
                        }else{
                            map.panBy(10,-110);
                        }    
                   }
                 
                   vertical_off=0;
                   break;
              case 500: 
                   map.panBy(50,-120);
                   break;
              case 400: 
                   map.panBy(100,-220);
                   break;
              case 200: 
                   map.panBy(20,-170);
                   break;               
             }
            
            if (control_vars.show_adv_search_map_close === 'no') {
                $('.search_wrapper').addClass('adv1_close');
                adv_search_click();
            }
            
             close_adv_search();
            });/////////////////////////////////// end event listener
            
        if(mapfunctions_vars.generated_pins!=='0'){
            pan_to_last_pin(myLatLng);
        }    
            
        
}

function  pan_to_last_pin(myLatLng){
       map.setCenter(myLatLng);   
}




/////////////////////////////////////////////////////////////////////////////////////////////////
//  map set search
/////////////////////////////////////////////////////////////////////////////////////////////////  
function setOms(gmarkers){
    for (var i = 0; i < gmarkers.length; i++) {
        if(typeof oms !== 'undefined'){
           oms.addMarker(gmarkers[i]);
        }else{
      
        }
    }
    
}

/////////////////////////////////////////////////////////////////////////////////////////////////
//  map set search
/////////////////////////////////////////////////////////////////////////////////////////////////  

function set_google_search(map){
    var input,searchBox,places;
    
    input = (document.getElementById('google-default-search'));
 //   map.controls[google.maps.ControlPosition.TOP_RIGHT].push(input);
    searchBox = new google.maps.places.SearchBox(input);
    
   
    google.maps.event.addListener(searchBox, 'places_changed', function() {
    places = searchBox.getPlaces();
        
        if (places.length == 0) {
          return;
        }
        
        var bounds = new google.maps.LatLngBounds();
        for (var i = 0, place; place = places[i]; i++) {
          var image = {
            url: place.icon,
            size: new google.maps.Size(71, 71),
            origin: new google.maps.Point(0, 0),
            anchor: new google.maps.Point(17, 34),
            scaledSize: new google.maps.Size(25, 25)
          };

        // Create a marker for each place.
        var marker = new google.maps.Marker({
          map: map,
          icon: image,
          title: place.name,
          position: place.geometry.location
        });

        gmarkers.push(marker);

        bounds.extend(place.geometry.location);
    
    }

    map.fitBounds(bounds);
    map.setZoom(15);
  });

  
    google.maps.event.addListener(map, 'bounds_changed', function() {
    var bounds = map.getBounds();
    searchBox.setBounds(bounds);
  });
    
}




/////////////////////////////////////////////////////////////////////////////////////////////////
//  open close map
/////////////////////////////////////////////////////////////////////////////////////////////////  

function new_open_close_map(type){
    
    if( jQuery('#gmap_wrapper').hasClass('fullmap') ){
        return;
    }
    
    if(mapfunctions_vars.open_close_status !== '1'){ // we can resize map
        
        var current_height  =   jQuery('#googleMap').outerHeight();
        var closed_height   =   parseInt(mapfunctions_vars.closed_height,10);
        var open_height     =   parseInt(mapfunctions_vars.open_height,10);
        var googleMap_h     =   open_height;
        var gmapWrapper_h   =   open_height;
          
        if( infoBox!== null){
            infoBox.close(); 
        }
     
        if ( current_height === closed_height )  {                       
            googleMap_h = open_height;                                
            if (Modernizr.mq('only all and (max-width: 940px)')) {
               gmapWrapper_h = open_height;
            } else {
                jQuery('#gmap-menu').show(); 
                gmapWrapper_h = open_height;
            }
        
            new_show_advanced_search();
            vertical_off=0;
            jQuery('#openmap').empty().append('<i class="fa fa-angle-up"></i>'+mapfunctions_vars.close_map);

        } else if(type===2) {
            jQuery('#gmap-menu').hide();
            jQuery('#advanced_search_map_form').hide();
            googleMap_h = gmapWrapper_h = closed_height;
           
            // hide_advanced_search();
            new_hide_advanced_search();
            vertical_off=150;           
        }
        jQuery('#gmap_wrapper').css('height', gmapWrapper_h+'px');
        jQuery('#googleMap').css('height', googleMap_h+'px');
        jQuery('.tooltip').fadeOut("fast");
        
        
        setTimeout(function(){google.maps.event.trigger(map, "resize"); }, 300);
    }
}





/////////////////////////////////////////////////////////////////////////////////////////////////
//  build map cluter
/////////////////////////////////////////////////////////////////////////////////////////////////   
  function map_cluster(){
       if(mapfunctions_vars.user_cluster==='yes'){
        clusterStyles = [
            {
            textColor: '#ffffff',    
            opt_textColor: '#ffffff',
            url: mapfunctions_vars.path+'/cloud.png',
            height: 72,
            width: 72,
            textSize:15,
           
            }
        ];
        mcOptions = {gridSize: 50,
                    ignoreHidden:true, 
                    maxZoom: parseInt( mapfunctions_vars.zoom_cluster,10), 
                    styles: clusterStyles
                };
        mcluster = new MarkerClusterer(map, gmarkers, mcOptions);
        mcluster.setIgnoreHidden(true);
    }
   
  }  
    
    
      
/////////////////////////////////////////////////////////////////////////////////////////////////
/// zoom
/////////////////////////////////////////////////////////////////////////////////////////////////
  
    
if(  document.getElementById('gmapzoomplus') ){
     google.maps.event.addDomListener(document.getElementById('gmapzoomplus'), 'click', function () {      
       var current= parseInt( map.getZoom(),10);
       current++;
       if(current>20){
           current=20;
       }
       map.setZoom(current);
    });  
}
    
    
if(  document.getElementById('gmapzoomminus') ){
     google.maps.event.addDomListener(document.getElementById('gmapzoomminus'), 'click', function () {      
       var current= parseInt( map.getZoom(),10);
       current--;
       if(current<0){
           current=0;
       }
       map.setZoom(current);
    });  
}
        
    
    
/////////////////////////////////////////////////////////////////////////////////////////////////
/// geolocation
/////////////////////////////////////////////////////////////////////////////////////////////////

if(  document.getElementById('geolocation-button') ){
    google.maps.event.addDomListener(document.getElementById('geolocation-button'), 'click', function () {      
        myposition(map);
        close_adv_search();
    });  
}


if(  document.getElementById('mobile-geolocation-button') ){
    google.maps.event.addDomListener(document.getElementById('mobile-geolocation-button'), 'click', function () {   
         myposition(map);
         close_adv_search();
    });  
}


jQuery('#mobile-geolocation-button,#geolocation-button').click(function(){   
     myposition(map);
})



function myposition(map){    
    if(navigator.geolocation){
        navigator.geolocation.getCurrentPosition(showMyPosition,errorCallback,{timeout:10000});
    }
    else
    {
        alert(mapfunctions_vars.geo_no_brow);
    }
}


function errorCallback(){
    alert(mapfunctions_vars.geo_no_pos);
}





function showMyPosition(pos){
   
    var shape = {
       coord: [1, 1, 1, 38, 38, 59, 59 , 1],
       type: 'poly'
   }; 
   
   var MyPoint=  new google.maps.LatLng( pos.coords.latitude, pos.coords.longitude);
   map.setCenter(MyPoint);   
   
   var marker = new google.maps.Marker({
             position: MyPoint,
             map: map,
             icon: custompinchild(),
             shape: shape,
             title: '',
             zIndex: 999999999,
             image:'',
             price:'',
             category:'',
             action:'',
             link:'' ,
             infoWindowIndex : 99 ,
             radius: parseInt(mapfunctions_vars.geolocation_radius,10)+' '+mapfunctions_vars.geo_message
            });
    
     var populationOptions = {
      strokeColor: '#67cfd8',
      strokeOpacity: 0.6,
      strokeWeight: 1,
      fillColor: '#67cfd8',
      fillOpacity: 0.2,
      map: map,
      center: MyPoint,
      radius: parseInt(mapfunctions_vars.geolocation_radius,10)
    };
    var cityCircle = new google.maps.Circle(populationOptions);
    
        var label = new Label({
          map: map
        });
        label.bindTo('position', marker);
        label.bindTo('text', marker, 'radius');
        label.bindTo('visible', marker);
        label.bindTo('clickable', marker);
        label.bindTo('zIndex', marker);

}
    
    
    
function custompinchild(){
    "use strict";

    var custom_img;
    var extension='';
    var ratio = jQuery(window).dense('devicePixelRatio');
    
    if(ratio>1){
        extension='_2x';
    }
    
    
    if( typeof( images['userpin'] )=== 'undefined' ||  images['userpin']===''){
        custom_img= mapfunctions_vars.path+'/'+'userpin'+extension+'.png';     
    }else{
        custom_img=images['userpin'];
        if(ratio>1){
            custom_img=custom_img.replace(".png","_2x.png");
        }
    }
   
   
    
    
    
    if(ratio>1){
         
        var   image = {
            url: custom_img, 
            size: new google.maps.Size(88, 96),
            scaledSize   :  new google.maps.Size(44, 48),
            origin: new google.maps.Point(0,0),
            anchor: new google.maps.Point(16,59 )
        };
     
    }else{
       var   image = {
            url: custom_img, 
            size: new google.maps.Size(59, 59),
            origin: new google.maps.Point(0,0),
            anchor: new google.maps.Point(16,59 )
        };
    }
    
    
    return image;
  
}



// same thing as above but with ipad double click workaroud solutin
jQuery('#googleMap').click(function(event){
    var time_diff; 
    time_diff=event.timeStamp-ipad_time;
    
    if(time_diff>300){
       // alert(event.timeStamp-ipad_time);
        ipad_time=event.timeStamp;
       /* if(map.scrollwheel===false){
            map.setOptions({'scrollwheel': true});
            jQuery('#googleMap').addClass('scrollon');
        }else{
            map.setOptions({'scrollwheel': false});
             jQuery('#googleMap').removeClass('scrollon');
        }
        */
        jQuery('.tooltip').fadeOut("fast"); 


        if (Modernizr.mq('only all and (max-width: 1025px)')) {    
           if(map.draggable === false){
                 map.setOptions({'draggable': true});
            }else{
                 map.setOptions({'draggable': false});
            }    
         }
         
     }     
});









/////////////////////////////////////////////////////////////////////////////////////////////////
/// 
/////////////////////////////////////////////////////////////////////////////////////////////////

if( document.getElementById('gmap') ){
    google.maps.event.addDomListener(document.getElementById('gmap'), 'mouseout', function () {           
      //  map.setOptions({'scrollwheel': true});
        google.maps.event.trigger(map, "resize");
    });  
}     


if(  document.getElementById('search_map_button') ){
    google.maps.event.addDomListener(document.getElementById('search_map_button'), 'click', function () {  
        infoBox.close();
    });  
}



if(  document.getElementById('advanced_search_map_button') ){
    google.maps.event.addDomListener(document.getElementById('advanced_search_map_button'), 'click', function () {  
       infoBox.close();
    }); 
}
 
////////////////////////////////////////////////////////////////////////////////////////////////
/// navigate troguh pins 
///////////////////////////////////////////////////////////////////////////////////////////////

jQuery('#gmap-next').click(function(){
    current_place++;  
    if (current_place>gmarkers.length){
        current_place=1;
    }
    while(gmarkers[current_place-1].visible===false){
        current_place++; 
        if (current_place>gmarkers.length){
            current_place=1;
        }
    }
    
    if( map.getZoom() <15 ){
        map.setZoom(15);
    }
    google.maps.event.trigger(gmarkers[current_place-1], 'click');
});


jQuery('#gmap-prev').click(function(){
    current_place--;
    if (current_place<1){
        current_place=gmarkers.length;
    }
    while(gmarkers[current_place-1].visible===false){
        current_place--; 
        if (current_place>gmarkers.length){
            current_place=1;
        }
    }
    if( map.getZoom() <15 ){
        map.setZoom(15);
    }
    google.maps.event.trigger(gmarkers[current_place-1], 'click');
});








///////////////////////////////////////////////////////////////////////////////////////////////////////////
/// filter pins 
//////////////////////////////////////////////////////////////////////////////////////////////////////////

jQuery('.advanced_action_div li').click(function(){
   var action = jQuery(this).val();
   //alert ('action: '+action);

});





if(  document.getElementById('gmap-menu') ){
    google.maps.event.addDomListener(document.getElementById('gmap-menu'), 'click', function (event) {
        infoBox.close();

        if (event.target.nodeName==='INPUT'){
            category=event.target.className; 

                if(event.target.name==="filter_action[]"){            
                    if(actions.indexOf(category)!==-1){
                        actions.splice(actions.indexOf(category),1);
                    }else{
                        actions.push(category);
                    }
                }

                if(event.target.name==="filter_type[]"){            
                    if(categories.indexOf(category)!==-1){
                        categories.splice(categories.indexOf(category),1);
                    }else{
                        categories.push(category);
                    }
                }

          show(actions,categories);
        }

    }); 
}
 
function getCookieMap(cname) {
   var name = cname + "=";
   var ca = document.cookie.split(';');
   for(var i=0; i<ca.length; i++) {
       var c = ca[i];
       while (c.charAt(0)==' ') c = c.substring(1);
       if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
   }
   return "";
}

//!visible_or_not(mapfunctions_vars.hows[0], gmarkers[i].val1, val1, mapfunctions_vars.slugs[0])
  
function visible_or_not(how, slug, value, read){
  
    //console.log("how "+how+" slug "+slug+" value "+value+" read "+read);
    if(value!=='' && typeof(value)!=='undefined' ){
        // value = value.replace('%',''); 
        //  console.log("value "+value);   
        //  value=value.toLowerCase();
    }
    if(slug!=='' && typeof(slug)!=='undefined'){
        // slug = slug.replace('%',''); 
        if(typeof slug ==='string'){
            slug=slug.toLowerCase();
        }
    }

    //////////////////////////////////////////////
    // in case of slider - 
    if(read==='property_price' && mapfunctions_vars.slider_price==='yes' ){
        var slider_min= parseInt ( jQuery('#price_low').val() );
        var slider_max= parseInt ( jQuery('#price_max').val() );    
     
      
       if( document.cookie.indexOf('my_custom_curr_coef') >= 0) {
           
            var my_custom_curr_coef    =   parseFloat( getCookieMap('my_custom_curr_coef'));
            if(my_custom_curr_coef!=0){
            
                //    slider_min=slider_min*my_custom_curr_coef;
                //    slider_max=slider_max*my_custom_curr_coef;
                slug= slug *my_custom_curr_coef;
            }
        }else{
        }
       
        if( slug >=  slider_min && slug<= slider_max){
            return true;
        }else{
            return  false;
        } 
    }
    //////////////////////////////////////////////
    // END in case of slider - 

    if(read==='none'){
        return true;
    }
    

    
    if (value !=='' && value !==' ' && value !=='all' && value !=='All' ){
       
        var parsevalue = parseInt(value, 10);
        
        if( how === 'greater' ){
          
            if( slug >=  parsevalue){
                return true
            }else{
                return false;
            }
        } else if( how === 'smaller' ){
         
            slug=parseInt(slug, 10);
            if( slug <= parsevalue ){
               return true;
             
            } else{
                return false;
            }
        } else if( how === 'equal' ){            
            if(  String(slug) === value || value == 'all' ){
                return true;
            } else{
                return false;
            }
        } else if( how === 'like' ){
          
            
            
            slug= decodeURIComponent(slug);
            //         Encoder.EncodeType = "entity";
 
            slug =Encoder.htmlDecode( slug);
        
            // console.log ("vefore check "+slug+" vs "+value);
            //  value=encodeURIComponent(value)
            slug = slug.replace(/%20/gi,' ');
            slug = slug.toLowerCase();
            slug = decodeURI(slug);
            value = value.toLowerCase();
            value=decodeURI(value);
            
            slug = slug.split(' ').join('-');
            value = value.split(' ').join('-');
            
            value   =   value.latinise() ;
            slug    =   slug.latinise() ;
            
            
            
           // console.log ("check "+slug+" vs "+value);
            if(slug.indexOf(value)> -1 ){
                return true;
            } else{
                return false;
            }
        } else if( how === 'date bigger' ){
          
            slug    =   new Date(slug);
            value   =   new Date(value);
            
            if( slug >= value ){
                return true;
            } else{
                return false;
            }
        } else if( how === 'date smaller' ){
        
            slug    =   new Date(slug);
            value   =   new Date(value);
            
            if( slug <= value ){
                return true;
            } else{
                return false;
            }
        }

        //return false;
    }else{
        return true;
    }
        
}


function get_custom_value(slug){
    var value;
    var is_drop=0;
    if(slug === 'adv_categ' || slug === 'adv_actions' ||  slug === 'advanced_city' ||  slug === 'advanced_area'  ||  slug === 'county-state'){     
        value = jQuery('#'+slug).attr('data-value');
    } else if(slug === 'property_price' && mapfunctions_vars.slider_price==='yes'){
        value = jQuery('#price_low').val();
    }else if(slug === 'property-country'){
        value = jQuery('#advanced_country').attr('data-value');
    }else{
      
        if( jQuery('#'+slug).hasClass('filter_menu_trigger') ){ 
            //console.log('triger slug '+slug);
            value = jQuery('#'+slug).attr('data-value');
            //console.log ('trigger find value '+value);
            is_drop=1;
        }else{
            // console.log('simple slug '+slug);
            value = jQuery('#'+slug).val() ;
            
        }
    }
    
  
    if (typeof(value)!=='undefined'&& is_drop===0){
      //  value=  value .replace(" ","-");
    }
    
    return value;
 
}
  
  
  
  
  
function show_pins_custom_search(){
    console.log ('show_pins_custom_search');
    var val1, val2, val3, val4, val5, val6, val7, val8, position;
    
    val1 =  get_custom_value (mapfunctions_vars.slugs[0]);
    val2 =  get_custom_value (mapfunctions_vars.slugs[1]);
    val3 =  get_custom_value (mapfunctions_vars.slugs[2]);
    val4 =  get_custom_value (mapfunctions_vars.slugs[3]);
    val5 =  get_custom_value (mapfunctions_vars.slugs[4]);
    val6 =  get_custom_value (mapfunctions_vars.slugs[5]);
    val7 =  get_custom_value (mapfunctions_vars.slugs[6]);
    val8 =  get_custom_value (mapfunctions_vars.slugs[7]);

    //console.log(mapfunctions_vars.slugs[0] +' / '+ val1+' / ');
    //console.log(mapfunctions_vars.slugs[5] +' / '+ val6);

    position = parseInt( mapfunctions_vars.slider_price_position );
    if( mapfunctions_vars.slider_price ==='yes' && position>0 ){
        eval("val"+String(mapfunctions_vars.slider_price_position)+"="+jQuery('#price_low').val()+";");   
        eval("val"+String(position+1)+"="+jQuery('#price_max').val()+";");
    }
  
    if(typeof(val1)==='undefined'){
         val1='';
     }
     if(typeof(val2)==='undefined'){
         val2='';
     }
     if(typeof(val3)==='undefined'){
         val3='';
     }
     if(typeof(val4)==='undefined'){
         val4='';
     }
     if(typeof(val5)==='undefined'){
         val5='';
     }
     if(typeof(val6)==='undefined'){
         val6='';
     }
     if(typeof(val7)==='undefined'){
         val7='';
     }
     if(typeof(val8)==='undefined'){
         val8='';
     }
 
   
 
   
    if(  typeof infoBox!=='undefined' && infoBox!== null ){
        infoBox.close(); 
    }
    
    var results_no  =   0;    
    var bounds = new google.maps.LatLngBounds();
   
    if(!isNaN(mcluster) ){
        mcluster.setIgnoreHidden(true);
    }
    

    if(  typeof gmarkers!=='undefined'){
        for (var i=0; i<gmarkers.length; i++) {    
            //console.log("xxxxxxxxxxxxxx      "+mapfunctions_vars.slugs[4] +' / '+ val5+' / '+ gmarkers[i].val5);
                if ( !visible_or_not(mapfunctions_vars.hows[0], gmarkers[i].val1, val1, mapfunctions_vars.slugs[0]) ){
                    gmarkers[i].setVisible(false);
                } else if ( !visible_or_not(mapfunctions_vars.hows[1],gmarkers[i].val2, val2, mapfunctions_vars.slugs[1]) ){
                    gmarkers[i].setVisible(false);
                } else if ( !visible_or_not(mapfunctions_vars.hows[2],gmarkers[i].val3, val3, mapfunctions_vars.slugs[2]) ){
                    gmarkers[i].setVisible(false);
                } else if ( !visible_or_not(mapfunctions_vars.hows[3],gmarkers[i].val4, val4, mapfunctions_vars.slugs[3]) ){
                    gmarkers[i].setVisible(false);
                } else if ( !visible_or_not(mapfunctions_vars.hows[4],gmarkers[i].val5, val5, mapfunctions_vars.slugs[4]) ){
                     gmarkers[i].setVisible(false);
                } else if ( !visible_or_not(mapfunctions_vars.hows[5],gmarkers[i].val6, val6, mapfunctions_vars.slugs[5]) ){
                    gmarkers[i].setVisible(false);
                } else if ( !visible_or_not(mapfunctions_vars.hows[6],gmarkers[i].val7, val7, mapfunctions_vars.slugs[6]) ){
                    gmarkers[i].setVisible(false);
                } else if ( !visible_or_not(mapfunctions_vars.hows[7],gmarkers[i].val8, val8, mapfunctions_vars.slugs[7]) ){
                    gmarkers[i].setVisible(false);
                } else{
                    gmarkers[i].setVisible(true);
                    results_no++;
                    bounds.extend( gmarkers[i].getPosition() );           
                }
                
         }//end for   
        if(!isNaN(mcluster) ){
            mcluster.repaint();   
        }
    }//end if


    if(mapfunctions_vars.generated_pins==='0' || googlecode_regular_vars2.half_map_results=='1'){
 
        if(results_no===0){         
        
            jQuery('#gmap-noresult').show();
            if(  document.getElementById('google_map_prop_list_wrapper') ){
                jQuery('#listing_ajax_container').empty().append('<p class=" no_results_title ">'+mapfunctions_vars.half_no_results+'</p>');
            }
            
            jQuery('#results').hide();
        }else{
            jQuery('#gmap-noresult').hide(); 
            if( !bounds.isEmpty() ){
                map.fitBounds(bounds);
            } 
            jQuery("#results, #showinpage,#showinpage_mobile").show();
            jQuery("#results_no").show().empty().append(results_no); 
          
            if ( parseInt(mapfunctions_vars.is_half)===1 ){

                if(first_time_wpestate_show_inpage_ajax_half===0){
                    first_time_wpestate_show_inpage_ajax_half=1
                }else{
                    wpestate_show_inpage_ajax_half();
                }
            }
        }
    }else{
       
        custom_get_filtering_ajax_result(); 
    }
   
    google.maps.event.trigger(map, 'resize');    

    
    if(typeof(mcluster)!=='undefined'){
       mcluster.repaint();    
    }

    
}  
 
 
 
 
 
 function wpestate_classic_form_tax_visible($onpin,$onreq){
    $onpin = $onpin.toLowerCase();
    $onpin = decodeURI($onpin);
    $onreq = $onreq.toLowerCase();
    $onreq = decodeURI($onreq);            
    $onpin = $onpin.split(' ').join('-');
    $onreq = $onreq.split(' ').join('-');
    
    $onpin = $onpin.latinise();
    $onreq = $onreq.latinise() 

    if($onpin.indexOf($onreq)> -1 ){
        return true;
    } else{
        return false;
    }
 }
 
 
 
 
 
 
 
 
 
 
 
 
function show_pins() {
    "use strict";
    console.log('show pins ');
    if(mapfunctions_vars.custom_search==='yes'){
       show_pins_custom_search();
       return;
    }    
    
    var results_no  =   0;
    var action      =   jQuery('#adv_actions').attr('data-value');
    var category    =   jQuery('#adv_categ').attr('data-value');
    var city        =   jQuery('#advanced_city').attr('data-value');
    var area        =   jQuery('#advanced_area').attr('data-value');   
    var rooms       =   parseInt( jQuery('#adv_rooms').val(),10 );
    var baths       =   parseInt( jQuery('#adv_bath').val(),10 );
    var min_price   =   parseInt( jQuery('#price_low').val() );
    var price_max   =   parseInt( jQuery('#price_max').val() );
    
 
       
    action      =   action.trim().toLowerCase();
    action      =   action.replace(/ /g,'-',action);
    
    category    =   category.trim().toLowerCase();
    category    =   category.replace(/ /g,'-',category);
    
    city        =   city.trim().toLowerCase();
    city        =   city.replace(/ /g,'-',city);
    
    area        =   area.trim().toLowerCase();
    area        =   area.replace(/ /g,'-',area);
    
    if(isNaN(rooms)){
        rooms=0;
    }
    
    if(isNaN(baths)){
        baths=0;
    }
    
     if(isNaN(min_price)){
        min_price=0;
    }
    
     if(isNaN(price_max)){
        price_max=0;
    }
    
     
    if(  typeof infoBox!=='undefined' && infoBox!== null ){
        infoBox.close(); 
    }
   
    var bounds = new google.maps.LatLngBounds();
    
    if(!isNaN(mcluster) ){
        mcluster.setIgnoreHidden(true);    
    }
    
    
    if(  typeof gmarkers!=='undefined'){
   
    if( document.cookie.indexOf('my_custom_curr_coef') >= 0) {
        var my_custom_curr_coef    =   parseFloat( getCookieMap('my_custom_curr_coef'));
        var curency_price;
    }
    
        for (var i=0; i<gmarkers.length; i++) {
            
            if( document.cookie.indexOf('my_custom_curr_coef') >= 0) {

                if(my_custom_curr_coef!=0){
                    curency_price    = parseInt(gmarkers[i].cleanprice,10 ) *my_custom_curr_coef;
                    }
                }else{
                    curency_price    = parseInt(gmarkers[i].cleanprice,10 ) 
                }
      
      
                if( !wpestate_classic_form_tax_visible (gmarkers[i].action, action) && action!='all' ){
                    gmarkers[i].setVisible(false);   
                }else if ( !wpestate_classic_form_tax_visible (gmarkers[i].category, category) && category!='all' ) {   
                    gmarkers[i].setVisible(false); 
                }else if(  !wpestate_classic_form_tax_visible (gmarkers[i].area, area) && area!='all'  ){
                    gmarkers[i].setVisible(false);
                }else if( !wpestate_classic_form_tax_visible (gmarkers[i].city, city) && city!='all'){
                    gmarkers[i].setVisible(false);
                }else if( parseInt(gmarkers[i].rooms,10) !== rooms  && rooms!==0){
                    gmarkers[i].setVisible(false);
                }else if( parseInt(gmarkers[i].baths,10 ) !== baths  && baths!==0){
                    gmarkers[i].setVisible(false);
                }else if( curency_price < min_price  && min_price!==0){
                    gmarkers[i].setVisible(false);
                }else if( curency_price > price_max  && price_max!==0){
                     gmarkers[i].setVisible(false);
                }else{
                    gmarkers[i].setVisible(true);
                    results_no++;
                    bounds.extend( gmarkers[i].getPosition() );       
                }                    
        }//end for
        
        
       
    }//end if
       

    
    if(mapfunctions_vars.generated_pins==='0' || googlecode_regular_vars2.half_map_results=='1'){
    
        if(results_no===0){
            jQuery('#gmap-noresult').show();
            if(  document.getElementById('google_map_prop_list_wrapper') ){
                jQuery('#listing_ajax_container').empty().append('<p class=" no_results_title ">'+mapfunctions_vars.half_no_results+'</p>');
            }
            jQuery('#results').hide();
        }else{
            jQuery('#gmap-noresult').hide(); 
        
            if( !bounds.isEmpty() ){
                map.fitBounds(bounds);
            } 
            jQuery("#results, #showinpage,#showinpage_mobile").show();
            jQuery("#results_no").show().empty().append(results_no); 
        
            
            if ( parseInt(mapfunctions_vars.is_half)===1 ){
                if(first_time_wpestate_show_inpage_ajax_half===0){
                    first_time_wpestate_show_inpage_ajax_half=1
                }else{
                    wpestate_show_inpage_ajax_half();
                }
            }
        }
        
                
    }else{
    
        get_filtering_ajax_result();  
        if( !bounds.isEmpty() ){
            map.fitBounds(bounds);
        } 
        
        if( mapfunctions_vars.adv_search_type ===2 || mapfunctions_vars.adv_search_type ==='2' ){
            wpestate_show_inpage_ajax_tip2();
        }
    }    
    if(typeof(mcluster)!=='undefined' ){
        mcluster.repaint();
    }
}
 
    function wpestate_show_inpage_ajax_tip2(){
        if( jQuery('#gmap-full').hasClass('spanselected')){
            jQuery('#gmap-full').trigger('click');
        }
      
        if(mapfunctions_vars.custom_search==='yes'){
            custom_search_start_filtering_ajax(1);
        }else{
            start_filtering_ajax(1);  
        } 
    }
 
 
 
    function wpestate_show_inpage_ajax_half(){
        jQuery('.half-pagination').remove();
        if(mapfunctions_vars.custom_search==='yes'){
            custom_search_start_filtering_ajax(1);
        }else{
            start_filtering_ajax(1);  
        } 
        
    }


    function enable_half_map_pin_action (){
      
        jQuery('#google_map_prop_list_sidebar .listing_wrapper').hover(
            function() {

                var listing_id = jQuery(this).attr('data-listid');
                wpestate_hover_action_pin(listing_id);
            }, function() {
                var listing_id = jQuery(this).attr('data-listid');         
                wpestate_return_hover_action_pin(listing_id);
            }
        );
    }
    
    
/////////////////////////////////////////////////////////////////////////////////////////////////
/// get pin image
/////////////////////////////////////////////////////////////////////////////////////////////////
function convertToSlug(Text)
{
    return Text
        .toLowerCase()
        .replace(/ /g,'-')
        .replace(/[^\w-]+/g,'')
        ;
}


function custompin(image){
    "use strict";    
  
    var extension='';
    var ratio = jQuery(window).dense('devicePixelRatio');
  
    if(ratio>1){
    
        extension='_2x';
    }


    var custom_img;
 
    if(image!==''){
        if( typeof( images[image] )=== 'undefined' || images[image]===''){
            custom_img= mapfunctions_vars.path+'/'+image+extension+'.png';     
        }else{
            custom_img=images[image];   
         
            if(ratio>1){
                custom_img=custom_img.replace(".png","_2x.png");
            }
        }
    }else{
        custom_img= mapfunctions_vars.path+'/none.png';   
    }

    if(typeof (custom_img)=== 'undefined'){
        custom_img= mapfunctions_vars.path+'/none.png'; 
    }
   
    if(ratio>1){
        image = {
            url: custom_img, 
            size :  new google.maps.Size(118, 118),
            scaledSize   :  new google.maps.Size(44, 48),
            origin: new google.maps.Point(0,0),
            anchor: new google.maps.Point(16,49 ),
            optimized:false
        };
     
    }else{
        image = {
            url: custom_img, 
            size :  new google.maps.Size(59, 59),
            origin: new google.maps.Point(0,0),
            anchor: new google.maps.Point(16,49 )
        };
    }
    return image;
}

/*

function custompin2(image){
    "use strict";
   
    image = {
      url: mapfunctions_vars.path+'/'+image+'.png',  
      size: new google.maps.Size(59, 59),
      origin: new google.maps.Point(0,0),
      anchor: new google.maps.Point(16,59 )
    };
    return image;
}


*/




/////////////////////////////////////////////////////////////////////////////////////////////////
//// Circle label
/////////////////////////////////////////////////////////////////////////////////////////////////

function Label(opt_options) {
  // Initialization
  this.setValues(opt_options);


  // Label specific
  var span = this.span_ = document.createElement('span');
  span.style.cssText = 'position: relative; left: -50%; top: 8px; ' +
  'white-space: nowrap;  ' +
  'padding: 2px; background-color: white;opacity:0.7';


  var div = this.div_ = document.createElement('div');
  div.appendChild(span);
  div.style.cssText = 'position: absolute; display: none';
};
Label.prototype = new google.maps.OverlayView;


// Implement onAdd
Label.prototype.onAdd = function() {
  var pane = this.getPanes().overlayImage;
  pane.appendChild(this.div_);


  // Ensures the label is redrawn if the text or position is changed.
  var me = this;
  this.listeners_ = [
    google.maps.event.addListener(this, 'position_changed', function() { me.draw(); }),
    google.maps.event.addListener(this, 'visible_changed', function() { me.draw(); }),
    google.maps.event.addListener(this, 'clickable_changed', function() { me.draw(); }),
    google.maps.event.addListener(this, 'text_changed', function() { me.draw(); }),
    google.maps.event.addListener(this, 'zindex_changed', function() { me.draw(); }),
    google.maps.event.addDomListener(this.div_, 'click', function() { 
      if (me.get('clickable')) {
        google.maps.event.trigger(me, 'click');
      }
    })
  ];
};


// Implement onRemove
Label.prototype.onRemove = function() {
  this.div_.parentNode.removeChild(this.div_);


  // Label is removed from the map, stop updating its position/text.
  for (var i = 0, I = this.listeners_.length; i < I; ++i) {
    google.maps.event.removeListener(this.listeners_[i]);
  }
};


// Implement draw
Label.prototype.draw = function() {
  var projection = this.getProjection();
  var position = projection.fromLatLngToDivPixel(this.get('position'));


  var div = this.div_;
  div.style.left = position.x + 'px';
  div.style.top = position.y + 'px';


  var visible = this.get('visible');
  div.style.display = visible ? 'block' : 'none';


  var clickable = this.get('clickable');
  this.span_.style.cursor = clickable ? 'pointer' : '';


  var zIndex = this.get('zIndex');
  div.style.zIndex = zIndex;


  this.span_.innerHTML = this.get('text').toString();
};



/////////////////////////////////////////////////////////////////////////////////////////////////
/// close advanced search
/////////////////////////////////////////////////////////////////////////////////////////////////
function close_adv_search(){
    
}
/*

function close_adv_search(){
    // for advanced search 2
    
    if (!Modernizr.mq('only all and (max-width: 960px)')) {
        if(mapfunctions_vars.adv_search === '2' || mapfunctions_vars.adv_search === 2 ){
            adv_search2=0;
            jQuery('#adv-search-2').fadeOut(50,function(){
                jQuery('#search_wrapper').animate({
                    top:112+"px"
                    },200);             
            });        
            jQuery(this).removeClass('adv2_close');
        }
        
        // for advanced search 2           
        if(mapfunctions_vars.adv_search === '4' || mapfunctions_vars.adv_search === 4){
            adv_search4=0;
            jQuery('#adv-search-4').fadeOut(50,function(){
                    jQuery('#search_wrapper').animate({
                        top:112+"px"
                        },200);
                 });  
            jQuery(this).addClass('adv4_close');
        }
   }
}
*/

//////////////////////////////////////////////////////////////////////
/// show advanced search
//////////////////////////////////////////////////////////////////////


function new_show_advanced_search(){
    jQuery("#search_wrapper").removeClass("hidden");
}

function new_hide_advanced_search(){
    if( mapfunctions_vars.show_adv_search ==='no' ){
        jQuery("#search_wrapper").addClass("hidden"); 
    }

}

function wpestate_hover_action_pin(listing_id){

    for (var i = 0; i < gmarkers.length; i++) {        
        if ( parseInt( gmarkers[i].idul,10) === parseInt( listing_id,10) ){
           pin_hover_storage=gmarkers[i].icon;
           gmarkers[i].setIcon(custompinhover());
           // var pin_latLng = gmarkers[i].getPosition(); // returns LatLng object
           // map.setCenter(pin_latLng)
        }
    }
}

function wpestate_return_hover_action_pin(listing_id){
    
    for (var i = 0; i < gmarkers.length; i++) {  
        if ( parseInt( gmarkers[i].idul,10) === parseInt( listing_id,10) ){
            gmarkers[i].setIcon(pin_hover_storage);
        }
    }
    
}


function custompinhover(){
    "use strict";    
 
    var custom_img,image;
    var extension='';
    var ratio = jQuery(window).dense('devicePixelRatio');
    
    if(ratio>1){
        extension='_2x';
    }
    custom_img= mapfunctions_vars.path+'/hover'+extension+'.png'; 
 
    if(ratio>1){
  
        image = {
            url: custom_img, 
            size :  new google.maps.Size(132, 144),
            scaledSize   :  new google.maps.Size(66, 72),
            origin: new google.maps.Point(0,0),
            anchor: new google.maps.Point(25,72 )
          };
    
    }else{
        image = {
            url: custom_img, 
            size: new google.maps.Size(90, 90),
            origin: new google.maps.Point(0,0),
            anchor: new google.maps.Point(25,72 )
        };
    }
   
    
    return image;
}




/*
function show_advanced_search(closer){
    if (!Modernizr.mq('only all and (max-width: 960px)')) {
         jQuery('#search_map_button,#advanced_search_map_button').show();
         jQuery('#adv-contact-3,#adv-search-header-contact-3,#adv-search-header-3,#adv-search-3').show();
    }
   

    if(closer==='close'){
         close_adv_search();
         if (!Modernizr.mq('only all and (max-width: 960px)')) {
            if(mapfunctions_vars.adv_search === '4' ){
               jQuery('#adv-search-header-4').show();
               jQuery('#adv-search-4').css({display:'none'});
               jQuery('#search_wrapper') .css({top:'112px'});
            }
            if(mapfunctions_vars.adv_search === '2'){            
               jQuery('#adv-search-header-2').show();
               jQuery('#adv-search-2').css({display:'none'});
               jQuery('#search_wrapper') .css({top:'112px'});
       
            }
         }
        
         
         
    }else{
          jQuery('#adv-search-header-4,#adv-search-4').show();
          jQuery('#adv-search-header-2,#adv-search-2').show();
          jQuery('#search_wrapper') .css({top:'200px'});
    }
    
    
    
    
    jQuery('#openmap').addClass('mapopen');
}


//////////////////////////////////////////////////////////////////////
/// show advanced search
//////////////////////////////////////////////////////////////////////

function hide_advanced_search(){
    jQuery('#search_map_button,#search_map_form, #advanced_search_map_button,#advanced_search_map_form').hide();
    jQuery('#adv-search-header-4,#adv-search-4').hide();
    jQuery('#adv-contact-3,#adv-search-header-contact-3,#adv-search-header-3,#adv-search-3').hide();
    jQuery('#adv-search-header-2,#adv-search-2').hide();
     jQuery('#advanced_search_map_form').hide();
   jQuery('#openmap').removeClass('mapopen');
}

*/


 
function show_pins_filters_from_file() {
    "use strict";
 
  console.log('show_pins_filters_from_file');
   
   if(jQuery("#a_filter_action").length == 0) {
        var action      =   jQuery('#second_filter_action').attr('data-value');
        var category    =   jQuery('#second_filter_categ').attr('data-value');
        var city        =   jQuery('#second_filter_cities').attr('data-value');
        var area        =   jQuery('#second_filter_areas').attr('data-value'); 
        var county      =   jQuery('#second_filter_county').attr('data-value');   
    
    }else{
        var action      =   jQuery('#a_filter_action').attr('data-value');
        var category    =   jQuery('#a_filter_categ').attr('data-value');
        var city        =   jQuery('#a_filter_cities').attr('data-value');
        var area        =   jQuery('#a_filter_areas').attr('data-value');
        var county      =   jQuery('#a_filter_county').attr('data-value');
    }
   

 
    if( typeof(action)!=='undefined'){
        action      = action.toLowerCase().trim().replace(" ", "-");
    }
    
    if( typeof(action)!=='undefined'){
        category    = category.toLowerCase().trim().replace(" ", "-");
    }
    
    if( typeof(action)!=='undefined'){
        city        = city.toLowerCase().trim().replace(" ", "-");
    }
    
    if( typeof(action)!=='undefined'){
        area        = area.toLowerCase().trim().replace(" ", "-");
    }
    if( typeof(county)!=='undefined'){
        county        = county.toLowerCase().trim().replace(" ", "-");
    }
    
    if(  typeof infoBox!=='undefined' && infoBox!== null ){
        infoBox.close(); 
    }
   
    var bounds = new google.maps.LatLngBounds();
    
    if(!isNaN(mcluster) ){
        mcluster.setIgnoreHidden(true);
    }

    if(  typeof gmarkers!=='undefined'){

        for (var i=0; i<gmarkers.length; i++) {
                if( !wpestate_classic_form_tax_visible (gmarkers[i].action, action) && action!='all' && action!='all' && action!='all-actions' ){
                    gmarkers[i].setVisible(false);
                
                }else if (!wpestate_classic_form_tax_visible (gmarkers[i].category, category) && category!='all' && category!='all-types') {   
                    gmarkers[i].setVisible(false);
                
                }else if( !wpestate_classic_form_tax_visible (gmarkers[i].area, area) && area!='all'  && area!='all-areas'){
                    gmarkers[i].setVisible(false);
                
                }else if( !wpestate_classic_form_tax_visible (gmarkers[i].city, city)  && city!='all' && city!='all-cities' ){
                    gmarkers[i].setVisible(false);
                
                }else if(!wpestate_classic_form_tax_visible (gmarkers[i].county_state, county)  && county!='all' && county!='all-counties/states' ){
                    gmarkers[i].setVisible(false);
                
                }else{
                    gmarkers[i].setVisible(true);
                    bounds.extend( gmarkers[i].getPosition() );       
                }                    
        }//end for
        if(!isNaN(mcluster) ){
            mcluster.repaint();
        }
    }//end if
       
        if( !bounds.isEmpty() ){
            map.fitBounds(bounds);
        } 
        
}


function map_callback(callback){
    callback(1);
}