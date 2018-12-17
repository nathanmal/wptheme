const path                    = require('path');
const MiniCssExtractPlugin    = require("mini-css-extract-plugin");

// Put all loader config here
module.exports = type => {
  switch(type){

    case 'css':
      return  { loader: 'css-loader',
                options: { 
                  importLoaders: 2
                }
              };
      break;

    case 'postcss':
      return  { loader : 'postcss-loader',
                options: {
                  config : { 
                    path : path.resolve( __dirname, 'postcss.config.js' )
                    // plugins : [ require('autoprefixer')()] ,
                  }
                }
              };
      break;

    case 'extract':
      return MiniCssExtractPlugin.loader;
      break;

    default: 
      return type + '-loader';
      break;
  }
}