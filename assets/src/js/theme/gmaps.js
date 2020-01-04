


const _defaults = {
    zoom: 14,
    zoomControl: true,
    mapTypeControl: false,
    scaleControl: false,
    rotateControl: false,
    streetViewControl: false,
};



class Gmaps
{


  constructor( selector, config = {} )
  {
    this.maps = $(selector);

    console.log(this.maps);

    this.config = $.extend( _defaults, config );
  }

  init()
  {
    this.maps.each(function(i,map){

      map = $(map).get(0);

      const lat = $(map).data('map-lat');
      const lng = $(map).data('map-lng');

      this.config.zoom   = $(map).data('map-zoom')  || 14;
      this.config.styles = $(map).data('map-style') || [];
      this.config.center = { lat, lng };

      // console.log(config);

      if( lat && lng ) {
        const gmap = new google.maps.Map(map,this.config);
        const gmkr = new google.maps.Marker({ 
              position: this.config.center, 
              map: gmap, 
              animation:google.maps.Animation.DROP, 
        });

        $(map).data('gmap', gmap);
        $(map).data('gmkr', gmkr);
      } else {
        console.warn('coordinates not set');
      }
    
    }.bind(this));
  }
}


export default Gmaps;