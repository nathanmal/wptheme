

class Lazyloader
{


  constructor()
  {
    console.log('Lazy Loader');

    // Images with lazy loader
    this.images = $('img[data-src]');

    // Elements with lazy load background
    this.backgrounds = $('[data-bg]');

    // Check if intersection observer is supported
    if( "IntersectionObserver" in window ){
      this.lazyloadObserver();
    } else {
      this.lazyloadDetector();
    }
  }


  lazyloadObserver()
  {
    this.imageObserver = new IntersectionObserver(this.observerCallback);
  }

  observerCallback(entries, observer)
  {
    
  }



  lazyload()
  {
    this.images.each(this.lazyloadImage);
    this.backgrounds.each(this.lazyloadBackground);
  }


  lazyloadImage(i,element)
  {

  }

  lazyloadBackground(i,element)
  {

  }


  isVisible(element)
  {

  }

  isLoaded(element)
  {

  }



}

if( jQuery ) jQuery(function($){ new Lazyloader();});