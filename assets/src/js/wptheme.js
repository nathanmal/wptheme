import ready from './ready';

class WPTheme
{
  /**
   * Theme constructor
   * @type {Object}
   */
  constructor( config = {} )
  {    
    this.config = config;


    this.onReady = this.onReady.bind(this);
    this.onResize = this.onResize.bind(this);
    this.onScroll = this.onScroll.bind(this);
    this.onMouseMove = this.onMouseMove.bind(this);

    // init on DOM load
    jQuery(this.onReady);

  }

  /**
   * Called when DOM is loaded
   */
  onReady()
  {
    $(window).resize(this.onResize);
    $(window).scroll(this.onScroll);
    $(document).mousemove(this.onMouseMove);

    ready();
  }

  /**
   * Called when window is resized
   */
  onResize(e)
  {
    // console.log('resize', $(window).width(), $(window).height());
  }

  /**
   * Called when window is scrolled
   */
  onScroll(e)
  {
    const top = $(window).scrollTop();
    const show = top > this.navbar.outerHeight();

    if( this.navbar.hasClass('navbar-hidden') )
    {
      this.navbar.toggleClass('navbar-show', show );
    }
  }

  /**
   * Show nav if hovered near it
   */
  onMouseMove(e)
  {
    if( $(window).scrollTop() > this.navbar.outerHeight() ) return;

    const show = e.pageY < this.navbar.outerHeight();
     
    if( this.navbar.hasClass('navbar-hidden') )
    {
      this.navbar.toggleClass('navbar-show', show );
    }
  }
  
  get navbar()
  {
    return $('#header .navbar');
  }
}


export default WPTheme;