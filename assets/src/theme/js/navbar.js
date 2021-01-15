class Navbar 
{

  constructor()
  {
    this.element = $('nav.navbar');

    this.header = this.element.parent('header');

    this.last = $(window).scrollTop();

    // Listen for scroll
    $(window).scroll(this.onScroll.bind(this));

    // Show if hidden mouse hovers
    $(document).mousemove(this.onMouseMove.bind(this));

    this.header.hover(this.onHeaderHover.bind(this),this.onHeaderLeave.bind(this));

    // $(document).on('click', 'nav.navbar .navbar-toggler', this.onToggleClick.bind(this) );
    // Click on toggler (mobile)
    this.toggler.on('click', this.onToggleClick.bind(this));

  }

  onHeaderHover(e)
  {
    if( this.shy ) this.element.addClass('navbar-show');
  }

  onHeaderLeave(e)
  {
    if( this.shy ) this.element.removeClass('navbar-show');
  }

  onElementClick(e)
  {

    console.log('Navbar click',e.target);
  }

  /**
   * Toggler click
   */
  onToggleClick(e)
  {
    console.log('CLICK');
    this.element.toggleClass('navbar-toggled');
  }


  /**
   * Window scroll
   */
  onScroll(e)
  {
    if( this.fixed && this.shy && ! this.toggled )
    { 
      const top = $(window).scrollTop();
      const dir = top > this.last ? 'down' : 'up';
      this.last = top;

      this.element.toggleClass('navbar-hidden', ( dir=='down' && top > this.element.outerHeight()));
    }

  }

  get fixed()
  {
    return this.header.hasClass('header-fixed');
  }

  get shy()
  {
    return this.element.hasClass('navbar-shy');
  }

  get toggled()
  {
    return this.element.hasClass('navbar-toggled');
  }

  get toggler()
  {
    return this.element.find('.navbar-toggler');
  }

  get menu()
  {
    return this.element.find('.navbar-menu');
  }

  

  /**
   * Show nav if hovered near it
   */
  onMouseMove(e)
  {
    if( this.fixed && this.shy && this.element.hasClass('navbar-hidden') )
    {
      const y = Math.abs(e.pageY - $(window).scrollTop());
      
      if(y < this.height) this.element.removeClass('navbar-hidden');
     
    }

  }

  get height()
  {
    return this.element.outerHeight();
  }
}


export default Navbar;