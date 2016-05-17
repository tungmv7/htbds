/*global dsidx */
/*global markers */
/*global google */
/*global custompin */
/*global gmarkers */
var found_lat='';
var found_long='';

function placeidx(map, locations){
"use strict";
var wraper_height=null;
var map_open=0;
var array_title=null;
var title=null;
var found_idx;

if(typeof(dsidx)!=='object'){
  return; 
}
    
if(typeof (dsidx.dataSets)==='undefined'){
  return;
}   
    
var x=null;
var code=null;

var shape = {
    coord: [1, 1, 1, 38, 38, 59, 59 , 1],
    type: 'poly'
};
   
for (x in dsidx.dataSets){
    code=x;
}
  
if(code===null){
    return;
}
var initial_length=gmarkers.length;
var property_no    =   dsidx.dataSets[code].length; 

    for (var i = 0; i < property_no; i++) {
        var myLatLng = new google.maps.LatLng(dsidx.dataSets[code][i].Latitude,dsidx.dataSets[code][i].Longitude);
        if (dsidx.dataSets[code][i].ShortDescription!==undefined){
            title=dsidx.dataSets[code][i].ShortDescription;
            array_title=title.split(",");
            title=array_title[0]+', '+array_title[1];
        }
        else{
            var title=dsidx.dataSets[code][i].Address +", "+dsidx.dataSets[code][i].City;
        }
        
        if(found_lat === dsidx.dataSets[code][i].Latitude && found_long=== dsidx.dataSets[code][i].Longitude){
            found_idx=i+initial_length;
        }
            
        
        var marker = new google.maps.Marker({
                position: myLatLng,
                map: map,
                icon: custompin('idxpin'),
                shape: shape,
                title: title,
                zIndex: i,
                image: dsidx.dataSets[code][i].PhotoUriBase,
                price:dsidx.dataSets[code][i].Price,
                type:dsidx.dataSets[code][i].BedsShortString,
                type2:dsidx.dataSets[code][i].BathsShortString,
                link:dsidx.dataSets[code][i].PrettyUriForUrl,
                infoWindowIndex : i,
                rooms:dsidx.dataSets[code][i].BedsShortString,
                baths:dsidx.dataSets[code][i].BathsShortString,
        
            });
          
         gmarkers.push(marker);
         
         
         
         
            google.maps.event.addListener(marker, 'click', function() {
            
                new_open_close_map(1);
                infoBox.setContent('<div class="info_details info_idx "><span id="infocloser" onClick=\'javascript:infoBox.close();\' ></span><div class=""><a href="/idx/'+this.link+'"><img src="'+this.image+'1-full.jpg" alt=""></a></div><a href="/idx/'+this.link+'" id="infobox_title" class="idx-title">'+this.title+'</a><div class="prop_details"><span id="info_inside">'+this.type+' / '+this.type2+' <span><span class="idx-price"> - '+this.price+'</span></div>' );
   
                infoBox.open(map, this);    
                map.setCenter(this.position);   

                switch (infobox_width){
                 case 700:

                      if(mapfunctions_vars.listing_map === 'top'){
                           map.panBy(100,-150);
                      }else{
                           map.panBy(10,-110);
                      }

                      vertical_off=0;
                      break;
                 case 500: 
                      map.panBy(210,0);
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
            });
            
    
            
   }

    google.maps.event.trigger(gmarkers[found_idx], 'click');
}

if(typeof (dsidx.details.latitude) !=='undefined' && typeof (dsidx.details.longitude) !=='longitude' ){
   found_lat=dsidx.details.latitude;
   found_long=dsidx.details.longitude;
}
 
