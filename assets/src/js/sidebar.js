class Sidebar
{
  constructor()
  {
    this.element = $('#sidebar');
    this.inner   = this.element.children('.sidebar-inner');

    if( ! this.element.length ) return;

    if( this.element.hasClass('sidebar-sticky') )
    {
      $(window).on('scroll', this.onWindowScroll.bind(this));
      $(window).on('resize', this.onWindowResize.bind(this));
    }

  }


  onWindowScroll(e)
  {
    const top = $(window).scrollTop();
    const wh  = $(window).height();
    const st  = this.element.position().top;
    const p   = top - st;

    // this.inner.css({'transform':'translate3d(0,'+top+'px,0)'});

  }

  onWindowResize(e)
  {

  }
}

export default Sidebar;