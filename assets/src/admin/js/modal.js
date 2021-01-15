class Modal 
{

  constructor()
  {
    this.margin = 30;
  }

  open( id, title )
  {
    console.log(title, id);

    tb_show(title, '#TB_inline?inlineId=' + id);

    $(window).on('resize',this.resize.bind(this)).trigger('resize');

    $('#TB_ajaxContent').attr('style','');

  }

  close()
  {
    tb_remove();

    $(window).off('resize', this.resize);
  }

  resize(e)
  {
    const ww = $(window).outerWidth();
    const wh = $(window).outerHeight();

    this.tb.attr('style','').css({ 
      marginLeft: -((ww/2)-this.margin) + 'px',
      marginTop: -((wh/2)-this.margin) + 'px',
      width: (ww-(2*this.margin)) + 'px',
      height: (wh-(2*this.margin)) + 'px',
      visibility: 'visible'
    });
  }


  get tb()
  {
    return $('#TB_window');
  }
}


export default Modal;