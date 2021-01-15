


const _defaults = {
    zoom: 14,
    zoomControl: true,
    mapTypeControl: false,
    scaleControl: false,
    rotateControl: false,
    streetViewControl: false,
};



class GoogleMap
{
  constructor( config = {} )
  {
    this.maps = $('.wpt-map');

    this.config = $.extend( _defaults, config );
  }

  init()
  {
    this.maps.each(function(i,element){

      const config = this.config;
      
      config.zoom    = $(element).data('zoom') || 14;
      config.styles  = $(element).data('style') || [];

      const center  = $(element).data('center');//.split(',').map( coord => parseFloat(coord));

      config.center = this.center(center);

      const map = new google.maps.Map(element,config);

      const marker = $(element).data('marker');

      if( marker )
      {
        const mkr = new google.maps.Marker({
          position: this.center(marker),
          map: map,
          animation: google.maps.Animation.DROP
        });

        const title   = $(element).data('marker-title');
        const content = $(element).data('marker-content');

        if( title  ) {


          let infoContent = '<div class="wpt-map-info">';
          infoContent += '<div class="wpt-map-info-title">'+title+'</div>';
          infoContent += '<div class="wpt-map-info-content">'+content+'</div>';
          infoContent += '</div>';

          const info = new google.maps.InfoWindow({ content: infoContent });

          google.maps.event.addListener(mkr,'click',function(){
            const m = info.getMap();
            if( m !== null && typeof m !== 'undefined'){
              info.close();
            }else{
              info.open(map,mkr);
            }
            
          });
        }
        
      }

      $(element).data('googlemap',map);

    
    }.bind(this));
  }

  center( str )
  {
    const c = str.split(',').map( coord => parseFloat(coord));
    const center = { lat: c[0], lng: c[1] };

    console.log('center',center);
    return center;
  }
}


export default GoogleMap;