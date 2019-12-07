class Navbar 
{

  constructor( element )
  {
    this.element = $(element);

    $(window).scroll(this.onScroll.bind(this));

    $(document).mousemove(this.onMouseMove.bind(this));

    this.toggle.on('click', this.onToggleClick.bind(this));
  }

  get toggle()
  {
    return this.element.find('.navbar-toggle');
  }

  get menu()
  {
    return this.element.find('.navbar-menu');
  }

  onToggleClick(e)
  {
    this.menu.toggleClass('navbar-open');
    this.toggle.toggleClass('navbar-toggle-open');
  }
  /**
   * Called when window is scrolled
   */
  onScroll(e)
  {
    if( this.element.hasClass('navbar-hidden') )
    {
      this.element.toggleClass('navbar-show', ($(window).scrollTop() > this.height) );
    }
  }

  /**
   * Show nav if hovered near it
   */
  onMouseMove(e)
  {
    if( $(window).scrollTop() > this.height ) return;
     
    if( this.element.hasClass('navbar-hidden') )
    {
      this.element.toggleClass('navbar-show', (e.pageY < this.height) );
    }
  }

  get height()
  {
    return this.element.outerHeight();
  }
}


export default Navbar;