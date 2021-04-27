class Onscroll
{
  /**
   * Class constructor
   */
  constructor()
  {
     // Scroll effects
    $(window).on('scroll', this.onWindowScroll.bind(this));

    // Trigger on load
    $(window).trigger('scroll');
  }

  /**
   * Listen for window scroll
   */
  onWindowScroll(e)
  {
    const top = $(window).scrollTop();

    const threshold = top + ($(window).height() * 0.75);

    $('.on-scroll').each(function(e){
      const t = $(this).offset().top;
      const visible = (t && ($(this).offset().top<threshold));
      $(this).toggleClass('on-scroll-visible', );
    });
  }
}

if( jQuery ) jQuery(function($){ new Onscroll();});

export default Onscroll;