function hexToRgb(hex) {
  var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
  return result ? {
    r: parseInt(result[1], 16),
    g: parseInt(result[2], 16),
    b: parseInt(result[3], 16)
  } : null;
}

function colorValues(color)
{ 
  const c = color.split(',');
  const vals = [];
  $.each(c,function(i,e){
    const v = e.replace(/[^0-9.]/g,'');
    vals.push(v);
  });

  return vals;
}

class Customize
{
  constructor()
  {  
    wp.customize('header[height]', function(value){
      value.bind( function(newval){
        $('header#header').css('height', newval+'px');
      });
    });

    wp.customize('header[bgcolor]', function(value){
      value.bind( function(newval){
        const color = $('header#header').css('background-color');
        const vals  = colorValues(color);
        const rgb = hexToRgb(newval);
        const alpha = (vals.length == 4 ) ? vals[3] : 1;
        const newcolor = 'rgba(' + rgb.r + ',' + rgb.g + ',' + rgb.b + ',' + alpha + ')';

        $('header#header').css('background-color', newcolor);
      });
    });


    wp.customize('header[bgalpha]', function(value){
       value.bind( function(newval){
         const color = $('header#header').css('background-color');
         const vals  = colorValues(color);
         const newcolor = 'rgba(' + vals[0] + ',' + vals[1] + ',' + vals[2] + ',' + newval + ')';
         $('header#header').css('background-color',newcolor);
       });
    });
  }

}


(function($){ new Customize(); })(jQuery);
