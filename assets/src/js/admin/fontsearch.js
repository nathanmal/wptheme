import Search from './search.js';

class Fontsearch
{
  constructor(id)
  {

     const config = {
       onRenderItem : this.renderItem.bind(this)
     }

     this.search = new Search('#'+id, 'googlefonts', config);

     // console.log(this.search);
  }

  renderItem(index, result)
  {
    const item = $('<div/>', { class: 'wpt-result-item'} );

    const family = $('<span/>', { class: 'font-family'}).text(result.family);
    
  }
}


export default Fontsearch;