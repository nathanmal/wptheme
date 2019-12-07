import '../scss/admin.scss';

class WPAdmin
{

  constructor()
  {
    console.log('WPTheme Admin');
    jQuery(this.init.bind(this));

  }


  init($)
  {
    console.log('WPTheme Admin Ready');


    $('.wpt-setting-image').each(this.imageSetting.bind(this));

    
    // this.frame.open();
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