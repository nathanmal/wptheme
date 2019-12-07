class Modal
{
  constructor(element)
  {
    this.element = $(element);
  }

  open()
  {
    this.element.modal('show');
  }

  close()
  {
    this.element.modal('hide');
  }

  reset()
  {
    this.title('');
    this.body('');
    this.showFooter(true);
  }

  /**
   * Set the modal title
   */
  title( str )
  {
    this.ui.title.text(str);
  }

  /**
   * Set the body content
   */
  body( html )
  {
    this.ui.body.empty().html(html);
  }


  showFooter( show = true )
  {
    const display = show ? 'block' : 'none';
    this.ui.footer.css('display', display);
  }


  get ui() {

    return {
      title : this.element.find('.modal-title'),
      body : this.element.find('.modal-body'),
      footer : this.element.find('.modal-footer')
    }
  }

}


export default Modal;