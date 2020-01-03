import Search from '../search.js';

class Package
{
  constructor()
  {
    $('#wpt-add-package').on('click', this.onAddPackageClick.bind(this) );

    this.input = new Search('#wpt-package-search', this.onPackageSearch.bind(this) );

    $('.wpt-package').each(function(i,pkg){

      $(pkg).find('.wpt-package-enqueue').sortable();

      $(pkg).find('.wpt-package-enqueue-file').on('click',function(e){
        $(this).toggleClass('is-enqueued');
        const v = $(this).hasClass('is-enqueued') ? '1' : '0';
        $(this).find('input').val(v);
      });

      $(pkg).find('a.wpt-package-action-enqueue').on('click',function(e){
        e.preventDefault();
        $(pkg).find('.wpt-package-enqueue').toggleClass('open');
      });

    });

  }

  onAddPackageClick(e)
  {
    e.preventDefault();
    e.stopPropagation();
    wpadmin.modal.open('wpt-modal-packages','Install Package');
  }

  onPackageSearch( query )
  {
    if( this.searching ) return false;

    this.searching = true;

    console.log('query',query);

    wpadmin.request('packagesearch', { query : query }, function(data){

      this.searching = false;

      console.log('data',data);
      
      if( data.success && data.packages.results && data.packages.results.length ){
        this.showPackageResults(data.packages);
      } else {
        this.showNoPackageResults();
      }
    }.bind(this));

  }

  showPackageResults( packages )
  {
    this.content.empty();

    $.each(packages.results, function(i,pkg){
      const item = this.createPackageResult(pkg);
      this.content.append(item);
    }.bind(this));

  }
 
  showNoPackageResults()
  {
    this.content.empty().html('<p>No results found!</p>');
  }

  createPackageResult( pkg )
  {
    const item    = $('<div/>', { class: 'wpt-package-search-result'} );
    const name    = $('<span/>', { class: 'package-name'} ).text(pkg.name);
    const desc    = $('<span/>', { class: 'package-description'}).text(pkg.description);
    const version = $('<span/>', { class: 'package-version'}).text(pkg.version);
    const link    = wpadmin.adminURL('assets', { 'add_package': pkg.name});
    const add     = $('<a/>', { class: 'package-add button button-primary'}).attr('href',link).text('Add Package');

    item.append(name,version,desc,add);

    return item;

  }

  get modal()
  {
    return $('#TB_ajaxContent');
  }

  get search()
  {
    return $('#wpt-package-search');
  }

  get content()
  {
    return this.modal.find('.wpt-modal-content');
  }


}

export default Package;