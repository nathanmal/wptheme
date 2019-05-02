// Import stylesheets (will be combined in order)
// Bootstrap 4
import 'bootstrap/dist/css/bootstrap.min.css';
// Bootstrap JS
import 'bootstrap/dist/js/bootstrap.min.js';
// Font awesome
import '@fortawesome/fontawesome-free/css/all.min.css';
// App icon files
import './icons';
// Theme SASS
import '../scss/theme.scss';
// Import core theme class
import Theme from './wptheme/theme';

// Fire when ready
jQuery(function($) {
    window.wptheme = new Theme();
});