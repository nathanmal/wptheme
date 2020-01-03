const _controlChars = {
  'Backspace' : 8,
  'Tab' : 9,
  'Enter' : 13,
  'Shift' : 16,
  'Control' : 17,
  'Alt' : 18,
  'Capslock' : 20,
  'Escape' : 27,
  'Spacebar' : 32,
  'Left' : 37,
  'Up' : 38,
  'Right' : 39,
  'Down' : 40,
  'Delete' : 46,
  'Meta' : 91, // Mac Command key, Windows key etc
};


const _defaults = {
  // Action
  action : '',

  // URL to query
  url : '',

  // min number of chars before searching
  limit : 3,

  // time to wait between keystrokes, in milliseconds
  delay : 500

};

class Search
{

  constructor( input, action, config = {} )
  {
    this.input = $(input);

    this.input.on('keyup', this.onKeyUp.bind(this));

    this.input.on('keydown', this.onKeyDown.bind(this));

    this.config = $.extend( _defaults, config );

    this.limit = this.config.limit || 3;

    this.delay = this.config.delay || 500;

    this.action = action;

    this.querying = false;

    this.timer = null;
  }

  /**
   * Get control char by code
   *
   * returns false if not a control character
   * 
   */
  controlChar(code)
  {
    return Object.keys(_controlChars).find(k=>_controlChars[k]===code) || false;
  }

  doAction()
  {
    this.action.call(this, this.input.val());
  }


  onKeyDown(e) 
  {  

    clearTimeout(this.timer);

    if( e.altKey ) return false;

    const cc = this.controlChar(e.keyCode); 

    if( ! cc ) return true;

    switch(cc)
    {
      case 'Enter':
        e.stopPropagation();
        e.preventDefault();
        this.doAction.bind(this);
        this.input.trigger('blur');
        break;

      case 'Escape':
        this.hideResults();
        this.input.val('');
        this.input.trigger('blur');
        break;

      default:
        break;
    }
    
    
  }

  onKeyUp(e)
  {
    const val = this.input.val();

    if( ! this.controlChar(e.keyCode) && val && val.length >= this.limit )
    {
       this.timer = setTimeout(this.doAction.bind(this), this.delay);
    }
  }

  filters()
  {
    return {};
  }

  doSearch(query)
  {
    console.log('do search',query);

    if( ! this.action ) 
    {
      console.warn('Search action not set');
      return
    }

    // Don't fire if already running query
    if( this.querying ) return;

    this.querying = true;

    this.input.addClass('is-querying');

    const postData = {
      query : query,
      filters : this.filters()
    };

    wpadmin.request( this.action, postData, function(data){

      console.log('data',data);
      this.querying = false;
      this.input.removeClass('is-querying');

      if( data.success && data.results && data.results.length )
      {
        this.showResults(data.results);
      }
      
    }.bind(this));
  }


  showResults( results )
  {
    console.log('results',results);

    if( ! results || ! results.length )
    {
      this.noResults();
      return;
    }

    this.results.empty();

    $.each(results,function(i,result){
      const item = this.renderItem(i,result);
      this.results.append(item);
    }.bind(this));


  }

  renderItem(index, result)
  {
    console.log('item result',result);

    if( this.config.onRenderItem ) 
    {
      return this.config.onRenderItem.call( this, index, result );
    }

    return $('<div/>', { class: 'wpt-result-item'}).text(result);
  }

  noResults()
  {
    this.results.empty().html('<div class="wpt-search-noresults">No Results</div>');
  }

  hideResults()
  {

  }


  get results() 
  {
    return this.element.find('.wpt-search-results');
  }

}



export default Search;