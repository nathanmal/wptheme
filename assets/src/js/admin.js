import '../scss/admin.scss';
import Settings from './admin/settings.js';
import Modal from './admin/modal.js';


class WPAdmin
{

  constructor()
  {
    this.settings = new Settings;
    this.modal    = new Modal;

    jQuery(this.init.bind(this));
  }

  adminURL( page = 'general', params = {} )
  {
    let url = ajaxurl.replace('-ajax','') + '?page=wptheme.' + page;
    
    for( let prop in params )
    {
       url += '&' + prop + '=' + encodeURIComponent(params[prop]);
    }

    return url;
  }

  

  init($)
  {
    console.log('WPTheme Admin Ready');


    this.settings.init();


    $('.wpt-setting-image').each(this.imageSetting.bind(this));


    
    
    // this.frame.open();
  }

  request( action, data, callback )
  {
    const url = ajaxurl + '?action=wpt_' + action;

    data == data || {};

    const nonce = $('#wpt-settings-nonce');

    data.nonce = nonce.length ? nonce.val() : false;

    console.log('requesting url', url);
    return $.post(url, data, callback, 'json').fail(this.onRequestFail.bind(this));
     
  }

  oldmodal( config )
  {
    const tb = $('#TB_window');

    let URL = '#TB_inline?';

    if( config.width ) URL += '&width='+config.width;
    if( config.height ) URL += '&height='+config.height;
    if( config.id ) URL += '&inlineId='+config.id;
    if( config.modal ) URL += '&modal=1';

    const margin = config.margin || 30;
     
    console.log(URL);
    tb_show(config.title, URL);

    tb.data('modal-margin', margin);
    tb.data('modal-width', config.width);
    tb.data('modal-height', config.height);

    $(window).on('resize',this.resizeModal.bind(this)).trigger('resize');

    $('#TB_ajaxContent').attr('style','');

      
  }

  resizeModal(e)
  {
    const m  = $('#TB_window').data('modal-margin') || 30;
    const ww = $(window).outerWidth();
    const wh = $(window).outerHeight();

    $('#TB_window').attr('style','').css({ 
      marginLeft: -((ww/2)-m) + 'px',
      marginTop: -((wh/2)-m) + 'px',
      width: (ww-(2*m)) + 'px',
      height: (wh-(2*m)) + 'px',
      visibility: 'visible'
    });


  }

  /**
   * Log request failures
   */
  onRequestFail(xhr,message,error)
  {
    console.warn(message,error);
  }

  


  

  imageSetting(i,setting)
  {
    $(setting).find('.wpt-setting-image-upload').on('click',function(e){
      this.frame.open();
    }.bind(this));
  }

  get frame() 
  {
    if( this._frame != undefined ) return this._frame;
     
    this._frame = wp.media.frames.file_frame = wp.media({
      title: 'Select a image to upload',
      button: {
        text: 'Use this image',
      },
      multiple: false  // Set to true to allow multiple files to be selected
    }); 


    this._frame.on( 'select', function() {
      // We set multiple to false so only get one image from the uploader
      attachment = file_frame.state().get('selection').first().toJSON();
      // Do something with attachment.id and/or attachment.url here
      $( '#image-preview' ).attr( 'src', attachment.url ).css( 'width', 'auto' );
      $( '#image_attachment_id' ).val( attachment.id );
      // Restore the main post ID
      wp.media.model.settings.post.id = wp_media_post_id;
    });

    return this._frame;
  }

}

window.wpadmin = new WPAdmin();
