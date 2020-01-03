
class Modalsearch
{
  constructor( button, config = {} )
  {
    this.button = $(button);
    
    this.button.on('click', this.onButtonClick.bind(this));


  }

  onButtonClick(e)
  {
    
  }
}


export default Modalsearch;