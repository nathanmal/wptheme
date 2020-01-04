import Search from '../search.js';

class Maps
{

  constructor()
  {
    $('#wpt-add-snazzymaps').on('click', this.onAddStyleClick.bind(this));

    this.select = new Search('#wpt-snazzymaps-search', this.onMapSearch.bind(this) );

    this.input = $('#wpt-settings-maps-snazzymaps-style');
  }

  onMapSearch(query)
  {
    this.loadSnazzyMaps();
  }

  onAddStyleClick(e)
  {
    wpadmin.modal.open('wpt-modal-snazzymaps','Add Snazzymaps Style');

    $('#TB_ajaxContent .wpt-modal-snazzymaps').find('select').on('change',this.onFilterChange.bind(this));

    this.loadSnazzyMaps();
  }

  onFilterChange(e){
    this.loadSnazzyMaps();
  }


  loadSnazzyMaps()
  {
    if( this.loading ) return;

    const filters = {
      'text' : $('#wpt-snazzymaps-search').val(),
      'sort' : $('#wpt-snazzymaps-sort').val(),
      'tag' : $('#wpt-snazzymaps-tag').val(),
      'color' : $('#wpt-snazzymaps-color').val()
    };

    wpadmin.request( 'snazzymaps', { 'filters' : filters }, function(data){

      console.log('data', data);

      if( data.success && data.results && data.results.styles && data.results.styles.length )
      {
        this.showStyles(data.results.styles);
      }

      this.loading = false;
      
    }.bind(this));

  }

  showStyles(styles)
  {
    this.content.empty();

    $.each(styles, function(i, style)
    {
      const styleItem = this.createStyleItem(style);
      this.content.append(styleItem);
    }.bind(this));
  }

  createStyleItem( style )
  {
    const item = $('<div/>', { class: 'snazzymap-style-item' });

    item.data('mapstyle',style);

    const img  = $('<div/>', { class: 'snazzymap-style-image'}).css('background-image','url(\''+style.imageUrl+'\')');
    const title = $('<h4/>').text(style.name);
    const button = $('<button/>', { class: 'button button-primary'}).attr('type','button').text('Use This Style');
    const json = $('<input/>').attr('type','hidden').val(style.json)
    item.append(title, button, img, json);

    button.on('click', this.onSelectStyleClick.bind(this));

    return item;

  }

  onSelectStyleClick(e)
  {

    $('#TB_ajaxContent .wpt-modal-snazzymaps').find('select').off('change');

    const item  = $(e.target).parent();
    const style = $(item).data('mapstyle')


    console.log('style', JSON.stringify(style));

    if( style )
    {
      console.log('input', this.input);
      this.input.val( JSON.stringify(style) );

      this.setCurrentStyle(style);
    }
    


    tb_remove();

  }


  setCurrentStyle( style )
  {
    this.current.find('.wpt-snazzymaps-current-img').css('background-image','url(\''+style.imageUrl+'\')');
    this.current.find('h3').text(style.name);
    this.current.find('p').text(style.description);
    this.current.removeClass('hidden');
  }

  get current()
  {
    return $('#wpt-snazzymaps-current');
  }

  get modal()
  {
    return $('#TB_ajaxContent');
  }

  get content()
  {
    return this.modal.find('.wpt-modal-content');
  }

}


export default Maps;