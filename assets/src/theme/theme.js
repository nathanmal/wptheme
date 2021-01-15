// Theme SASS
import './theme.scss';

// Import components
import Navbar from './js/navbar';
import GoogleMap from './js/googlemap.js';
import Sidebar from './js/sidebar.js';

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

    // Attach components
    this.navbar = new Navbar();

    // Maps
    this.googlemap = new GoogleMap();

    // Sidebar 
    this.sidebar = new Sidebar();
    
    // init on DOM load
    jQuery(this.init.bind(this));
  }

  

  /**
   * Called when DOM is loaded
   */
  init()
  {     
    // Input autofill detection
    $('input').on('animationstart', onAnimationStart, false);

    // Scroll effects
    $(window).on('scroll', this.onWindowScroll.bind(this));

    // Trigger on load
    $(window).trigger('scroll');

    // Mark init 
    console.log('Theme initialized');

  }

  onWindowScroll(e)
  {
    const top = $(window).scrollTop();
    const bar = top + ($(window).height() * 0.75);

    $('.on-scroll').each(function(e){
      console.log($(this));
      const t = $(this).offset().top;
      $(this).toggleClass('on-scroll-visible', (t && ($(this).offset().top<bar)));
    });
  }
  
}

// Instantiate in global context
window.theme = new WPTheme();