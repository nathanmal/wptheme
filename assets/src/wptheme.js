// Theme files
import './scss/wptheme.scss';
import './js/onscroll.js';
import './js/lazyloader.js';

// Import components
import Navbar    from './js/navbar';
import Sidebar   from './js/sidebar.js';


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
  init() { 
    console.log('Theme initialized');
  }
  
}

// Instantiate in global context
window.wptheme = new WPTheme();