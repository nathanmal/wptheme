// Theme SASS
import './theme.scss';

import './js/onscroll.js';
import './js/lazyloader.js';

// Import components
import Navbar    from './js/navbar';
import Sidebar   from './js/sidebar.js';

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

    // Mark init 
    console.log('Theme initialized');

  }

  
  
}

// Instantiate in global context
window.theme = new WPTheme();