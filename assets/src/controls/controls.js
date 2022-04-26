import './controls.scss';


class CustomizerControls
{
  constructor()
  {  
    $('.wpt-customize-control-slider input[type="range"]').each(function(i,e){
      const unit = $(this).data('unit');
      $(this).siblings('span.wpt-customize-control-slider-value').text($(this).val()+unit);
    });

    $('.wpt-customize-control-slider input[type="range"]').on('input',function(e){
      console.log('height changed to' + $(this).val());
      const unit = $(this).data('unit');
      $(this).siblings('span.wpt-customize-control-slider-value').text($(this).val()+unit);
    });
  }

}

jQuery(document).ready(function($){
  new CustomizerControls();
});



