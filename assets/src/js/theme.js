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
}

// Instantiate in global context
window.theme = new WPTheme();