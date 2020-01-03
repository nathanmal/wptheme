

class Maps
{

  constructor()
  {
    this.key = null;

    this.select.on('click', function(e){

      this.key = $(e.target).data('key');

      // wpadmin.oldmodal({ title: 'Select Map Style', id: 'wpt-snazzymaps-modal'});

      wpadmin.modal.open('wpt-snazzymaps-modal','Select Map Style');

      this.loadSnazzyMaps();
      
    }.bind(this));
  }


  loadSnazzyMaps( page = 1 )
  {
    console.log('key',this.key);

    if( ! this.key ) return;

    let url = 'https://snazzymaps.com/explore.json?key=' + this.key;

    url += '&page=' + page;

    console.log(this.content);

    $.getJSON(url,{},function(data){
       
      if( data ) {

        this.content.empty();

        $.each(data.styles, function(i,style){

          const styleItem = this.createStyleItem(style);
          // console.log('item '+i, styleItem);
          this.content.append(styleItem);

        }.bind(this));

      }

    }.bind(this)).fail(function(xhr,message){ console.error(message)});
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
    const item  = $(e.target).parent();
    const style = $(item).data('mapstyle')
    const json  = item.find('input[type="hidden"]').val();

    if( item && style && json )
    {
      $('#wpt-snazzmaps-value').val( JSON.stringify(style) );
      $('#wpt-snazzymaps-style').val(style.json);

      this.current.find('.wpt-snazzymaps-current-img').css('background-image','url(\''+style.imageUrl+'\')');
      this.current.find('h3').text(style.name);
      this.current.find('p').text(style.description);
      this.current.removeClass('hidden');
    }
    


    tb_remove();
    

  }

  get current()
  {
    return $('#wpt-snazzymaps-current');
  }

  get select()
  {
    return $('#wpt-snazzymaps-select');
  }

  get content()
  {
    return $('#TB_ajaxContent .wpt-snazzymaps-modal-content');
  }
}


export default Maps;