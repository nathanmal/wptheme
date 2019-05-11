import ready from './ready';

const defaults = {

}

class WPTheme
{
  /**
   * Theme constructor
   * @type {Object}
   */
  constructor( config = {} )
  {    
    this.config = config;

    // init on DOM load
    jQuery(function($){ this.onReady }.bind(this));

  }

  /**
   * Called when DOM is loaded
   */
  onReady()
  {
    $(window).resize(this.onResize.bind(this));
    $(window).scroll(this.onScroll.bind(this));
    $(document).mousemove(this.onMouseMove.bind(this));

    ready();
  }

  /**
   * Called when window is resized
   */
  onResize(e)
  {
    console.log('resize', $(window).width(), $(window).height());
  }

  /**
   * Called when window is scrolled
   */
  onScroll(e)
  {
    const top = $(window).scrollTop();
    const show = top > this.navbar.outerHeight();
    this.navbar.toggleClass('navbar-hidden', ! show );

    if( ! show ) this.navbar.find('.navbar-collapse').collapse('hide');

    console.log('scroll', $(window).scrollTop() );

  }

  /**
   * Show nav if hovered near it
   */
  onMouseMove(e)
  {
    if( $(window).scrollTop() > this.navbar.outerHeight() ) return;

    const show = e.pageY < this.navbar.outerHeight();
     
    this.navbar.toggleClass('navbar-hidden', ! show );

    if( ! show ) this.navbar.find('.navbar-collapse').collapse('hide');
  
  }

  
  get navbar()
  {
    return $('#header .navbar');
  }
}


export default WPTheme;