
const _galleries = [];

const _defaults = {
  container: '.kp-gallery-photos',
  item: '.kp-gallery-photo',
  preload: true,
}

class Gallery
{

  static init( element, config )
  {
    const gallery = new KGallery( element, config );

    _galleries.push(gallery);

    gallery.index = _galleries.length-1;
  }

  constructor( index, element, config = {}) 
  {
    this.config = $.extend( {}, _defaults, config );

    this.element = $(element);

    this.gallery_title = this.element.data('title');
    this.gallery_subtitle = '';

    this.createLightbox();

    this.items.each( this.initItem.bind(this) );

    this.resizePhotos();

    this.currentPhoto = 0;

    



    $(window).on('resize', this.resizePhotos.bind(this) );

    $(document).on('keyup', this.onDocumentKeypress.bind(this) );

  }

  // Handle keys
  // 37  Left Arrow
  // 39  Right Arrow
  // 27  Escape
  // 32  Spacebar
  // 13  Enter
  // 9   Tab
  onDocumentKeypress(e)
  {  
    const key = e.which || e.keycode;

    if( [39,32,13,9].includes(key) ){
      this.showNextPhoto();
    } else if( key == 37 ) {
      this.showPrevPhoto();
    } else if ( key == 27 ) {
      this.closeLightbox();
    }

    // console.log(key);

    // alert(e.which);
  }

  initItem(index, item)
  {
    const img = $(item).find('img');
    const w   = $(img).outerWidth();
    const h   = $(img).outerHeight();
    const r   = w/h;

    const link = $(item).find('a');

    $(item).data('index', index);
    $(item).data('ratio',r);
    $(item).data('loaded', false);

    // Add clicktouch
    $(link).on('click touch', this.onItemClick.bind(this) );

    // Full size photo
    const photo = $('<div/>', { class: 'kgallery-lightbox-photo' } );

    photo.data( 'index', index );
    photo.data( 'url', $(link).attr('href') );
    photo.data( 'ratio', r );

    const loading = $('<div/>', { class: 'kgallery-lightbox-photo-loading' });
    loading.html('<div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>');
    
    const image = $('<div/>', { class: 'kgallery-lightbox-photo-image'});

    photo.append(loading,image);

    this.photos.append(photo);
  }

  resizePhotos()
  {
    const ph = $(this.photos).outerHeight();

    this.photos.find('.kgallery-lightbox-photo').each(function(i,photo){
      const ratio = $(photo).data('ratio');
      $(photo).css('width', ph*ratio);
    });
  }

  onItemClick(e)
  {
    e.preventDefault();
    e.stopPropagation();

    const item = $(e.target).closest(this.config.item);
    
    const index = $(item).data('index');
    const ratio = $(item).data('ratio');

    this.openLightbox();

    this.loadPhoto(index, function(){ this.showPhoto(index) }.bind(this));
  }

  showPhoto( index )
  { 
    // Get photos
    const photos = this.photos.find('.kgallery-lightbox-photo');

    $(photos[index]).css('opacity',1).addClass('current');

    // Load photo
    this.loadPhoto(index);

    

    //photos.find('.current').removeClass('current');
    //$(photos[index]).addClass('current');

    photos.each(function(i,photo){

      //const pindex = $(photo).data('index');

      //$(photo).toggleClass('current', i == index );

      if( i < index ) $(photo).removeClass('current').addClass('left');
      if( i > index ) $(photo).removeClass('current').addClass('right');
      if( i == index )$(photo).removeClass('left right').addClass('current');

    });

    const imgurl = $(this.items[index]).find('a').attr('href');

    // preload previous photo
    if( index > 0 ) {
      this.loadPhoto( index - 1 );
    }

    // preload next photo
    if( index < (photos.length-1) ){
      this.loadPhoto( index + 1 );
    }

    

    this.currentPhoto = index;
  }

  loadPhoto( index, cb )
  {
    const item   = $(this.items[index]);
    const photos = this.photos.find('.kgallery-lightbox-photo');
    const photo  = photos[index]; 
    const url    = item.find('a').attr('href');

    // Do nothing if already loaded
    if( $(photo).hasClass('loaded') ) return;

    console.log('LOAD',url, item.data('loaded'),photo);

    const xhr = new XMLHttpRequest();

    xhr.responseType = 'arraybuffer';

    xhr.onload = function(e) {

      const type = xhr.getResponseHeader("Content-Type");
      // console.log('XHR',e,xhr.getResponseHeader("Content-Type"));
      // Obtain a blob: URL for the image data.
      // const arrayBuffer = new Uint8Array( this.response );
      const blob = new Blob( [xhr.response], { type: type } );
      const urlCreator = window.URL || window.webkitURL;
      const imageUrl = urlCreator.createObjectURL( blob );
      const bg = 'url(\'' + imageUrl + '\')';

      $(photo).find('.kgallery-lightbox-photo-image').css('background-image', bg);

      $(photo).addClass('loaded');

      if( cb ) {
        cb.call();
      }
      // console.log($(photo).css('background-image'));
    }.bind(this);

    xhr.open('GET',url);
    xhr.send();

  }

  showNextPhoto()
  {
    const count = this.photos.find('.kgallery-lightbox-photo').length;

    if( this.currentPhoto < count-1 )
    {
      this.showPhoto(this.currentPhoto+1);
    }
  }

  showPrevPhoto()
  {
    if( this.currentPhoto > 0 )
    {
      this.showPhoto(this.currentPhoto-1);
    }
  }

  createLightbox()
  {
    if( this.lightbox ) return this.lightbox;

    this.lightbox = $('<div/>', { id:'kgallery-lightbox', });

    this.header = $('<div/>', { class: 'kgallery-lightbox-header' });
    this.photos = $('<div/>', { class: 'kgallery-lightbox-photos' });
    this.footer = $('<div/>', { class: 'kgallery-lightbox-footer' });

    this.title = $('<div/>', { class: 'kgallery-lightbox-title'}).text( this.gallery_title );
    this.subtitle = $('<span/>', { class: 'kgallery-lightbox-subtitle'} ).text(this.gallery_subtitle);
    this.title.append(this.subtitle);

    // Close button
    this.close = $('<button/>', { type: 'button', class: 'kgallery-lightbox-close'});
    this.close.html('<i class="fa fa-times"></i>');
    this.close.on('click', this.onCloseClick.bind(this) );

    this.header.append(this.title, this.close);

    // Next/Prev buttons
    this.prev = $('<button/>', { type: 'button', class: 'kgallery-lightbox-prev'});
    this.next = $('<button/>', { type: 'button', class: 'kgallery-lightbox-next'});

    this.prev.html('<i class="fa fa-chevron-left"></i>');
    this.next.html('<i class="fa fa-chevron-right"></i>');

    this.prev.on('click', this.onPrevClick.bind(this));
    this.next.on('click', this.onNextClick.bind(this));

    this.photos.append(this.prev,this.next);

    this.lightbox.append(this.header,this.photos,this.footer);

    $('body').append(this.lightbox);

    return this.lightbox;

  }

  onCloseClick()
  {
    this.closeLightbox();
  }

  onPrevClick()
  {
    this.showPrevPhoto();
  }

  onNextClick()
  {
    this.showNextPhoto();
  }

  openLightbox()
  {
    $('body').css('overflow','hidden');
    this.lightbox.addClass('kgallery-lightbox-open');
  }

  closeLightbox()
  {
    $('body').css('overflow','auto');
    this.lightbox.removeClass('kgallery-lightbox-open');
  }

  get container()
  {
    return this.element.find(this.config.container);
  }

  get items()
  {
    if( ! this._items ) this._items = this.container.find(this.config.item);

    return this._items;
  }


  get ui()
  {
    if( ! this._ui ) this._ui = {
      header : this.element.find('.kgallery-lightbox-header'),
      title : this.element.find('.kgallery-lightbox-title'),
      subtitle : this.element.find('.kgallery-lightbox-subtitle'),
      photos : this.element.find('.kgallery-lightbox-photos'),
      footer : this.element.find('.kgallery-lightbox-footer'),
    }

    return this._ui;

  }

  
}


export default Gallery;