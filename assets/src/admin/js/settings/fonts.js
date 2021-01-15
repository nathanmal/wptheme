import Search from '../search.js';
import WebFont from 'webfontloader';


class Fonts 
{
  constructor()
  {
    this.fonts = {};

    $('#wpt-add-googlefonts').on('click', this.onAddFontClick.bind(this) );

    this.input = new Search('#wpt-font-search', this.onFontSearch.bind(this) );

    this.content.find('input,select').on('change',this.onFilterChange.bind(this));

    $('#wpt-font-sample').on('keyup', this.onSampleTextKeyUp.bind(this));

  }

  onAddFontClick(e) 
  {
     wpadmin.modal.open('wpt-modal-googlefonts','Add Google Font');
     this.loadFonts();
  }

  onFontSearch( query )
  {
    if( this.loading ) return;

    this.loadFonts();
  }

  onSearchKeyDown(e)
  {
    if( e.key == 'Enter' )
    {
      if( this.loadTimeout ) clearTimeout(this.loadTimeout);

      this.loadFonts();

      $(e.target).trigger('blur');
    }
    
  }

  onSampleTextKeyUp(e)
  {
    if( $(e.target).val() )
    {
      this.content.find('.wpt-font-list-item').each(function(i,item){
        $(item).find('.wpt-font-list-item-panagram').text($(e.target).val());
      });
    }
    else
    {
      this.content.find('.wpt-font-list-item').each(function(i,item){
        $(item).find('.wpt-font-list-item-panagram').text($(item).data('font-family'));
      });

    }
  }

 

  onFilterChange(e)
  {
    if( this.loading ) return;

    if( $(e.target).attr('id') == 'wpt-font-sample') return true;

    if( this.loadTimeout ) clearTimeout(this.loadTimeout);

    this.loadTimeout = setTimeout( this.loadFonts.bind(this), 2000 );
  }

  loadFonts()
  {
    if( this.loading ) return;

    this.content.empty();

    this.loading = true;

    const filters = {
      'keyword' : $('#wpt-font-search').val(),
      'sort' : $('#wpt-font-sort').val(),
      'categories' : []
    }

    $('.wpt-font-categories input[type="checkbox"]').each(function(i,cat){
      if( $(cat).prop('checked') )
      {
        filters.categories.push(cat.val());
      }
    });

    console.log('filters',filters);

    wpadmin.request( 'googlefonts', { 'filters' : filters }, function(data){

      console.log(data);

      if( data.success && data.results && data.results.length )
      {
        this.showFonts(data.results);
      }

      this.loading = false;
      
    }.bind(this));

  }

  showFonts( fonts )
  {
    $.each(fonts, function(i, font){

      if( this.fonts[font.family] ) {
        this.fontActivated(font.family);
        return true;
      }

      WebFont.load({ 
        google : {
          families : [font.family]
        },
        fontactive : this.fontActivated.bind(this)
      });

      this.fonts[font.family] = font;

    }.bind(this));
  }

  fontActivated(family)
  {
    const item = this.createFontItem(family);

    this.content.append(item);
  }

  createFontItem( family )
  {
    const item = $('<div/>', { class: 'wpt-font-list-item'} );
    const name = $('<span/>', { class: 'wpt-font-list-item-name'});
    const panagram = $('<span/>', { class: 'wpt-font-list-item-panagram'});
    panagram.text('The five boxing wizards jump quickly.');
    const link = wpadmin.adminURL('assets', { 'add_font' : encodeURI(family) } );
    const add = $('<a/>', { class: 'button button-primary'}).text('Install Font');
    add.attr('href',link);

    item.data('font-family', family);
    name.text(family);

    panagram.css('font-family', family);
    item.append(name,panagram, add);

    return item;
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


export default Fonts;