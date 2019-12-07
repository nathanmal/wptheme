// Theme SASS
import '../scss/theme.scss';

import Navbar from './theme/navbar';
import Modal from './theme/modal';
import Player from './theme/player';
import Gallery from './theme/gallery';

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

    // Modal
    this.modal = new Modal('#kp-modal');

    // Input autofill detection
    $('input').on('animationstart', onAnimationStart, false);

    // Dismiss notices
    $('.form-error button, .form-notice button').on('click',function(e){
       $(this).parent().fadeOut().remove();
    });

    // Initialize video players
    $('.kp-video').each(function(i,v){
      new Player(i,v);
    });

    // Initialize galleries
    $('.kp-gallery').each(function(i,v){
      new Gallery(i,v);
    });

    $('a#clip-download').on('click', this.onClipDownloadClick.bind(this) );

  }

  onClipDownloadClick(e)
  {
    e.preventDefault();

    const video_id = $(e.target).data('video-id');

    window.kp.userdata( function(data){

      const count = data.downloads.clip;
      const url   = window.kp.downloadURL(video_id);
      const txt   = $('<p/>').html('You have <strong>' + count + '</strong> downloads remaining');
      const btn   = $('<a/>', { class: 'btn btn-primary' });

      btn.attr('href', url);
      // btn.attr('target', '_blank');
      btn.html('Download <i class="fa fa-download"></i>');

      btn.on('click', function(e){
        this.modal.close();
      }.bind(this));

      const content = $('<div/>');

      if( count >= 0 ) 
      {
        if( count == 0 ) btn.attr('disabled','disabled').addClass('disabled');
        content.append(txt,btn);
      } else {
        content.append(btn);
      }

      this.modal.title('Video Download');
      this.modal.body(content);
      this.modal.showFooter(false);
      this.modal.open();
     
    }.bind(this));
  }

 
}


export default WPTheme;