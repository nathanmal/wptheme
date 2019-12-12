// Theme SASS
import '../scss/theme.scss';

// Import components
import Navbar  from './theme/navbar';

// Add/Remove autofill class based on whether or not input is auto-filled
const onAnimationStart = ({ target, name }) => {
    if( name == 'onAutoFillStart' )  $(target).addClass('has-autofill');
    if( name == 'onAutoFillCancel' ) $(target).removeClass('has-autofill');
}

class WPTheme
{
  /**
   * Theme constructor
   * @type {Object}
   */
  constructor() { 
    // init on DOM load
    jQuery(this.init.bind(this));
  }

  /**
   * Called when DOM is loaded
   */
  init()
  { 
    // Navbar
    this.navbar = new Navbar('#header .navbar');

    // Input autofill detection
    $('input').on('animationstart', onAnimationStart, false);

    // Mark init 
    console.log('Theme initialized');
  }


  initMap()
  {

    const config = {
        zoomControl: true,
        mapTypeControl: false,
        scaleControl: false,
        rotateControl: false,
        streetViewControl: false,
    };

    $('.wpt-map').each(function(i,map){
      const lat = $(map).data('map-lat');
      const lng = $(map).data('map-lng');
      const style = $(map).data('map-style');
      const zoom = $(map).data('map-zoom');

      config.zoom   = zoom || 14;
      config.styles = style || [];
      config.center = { lat, lng };

      // console.log(config);

      const gmap = new google.maps.Map(map,config);
      const gmkr = new google.maps.Marker({ 
            position: config.center, 
            map: gmap, 
            animation:google.maps.Animation.DROP, 
      });

      $(map).data('gmap', gmap);
      $(map).data('gmkr', gmkr);

    
    });
  }
}

// Instantiate in global context
window.theme = new WPTheme();