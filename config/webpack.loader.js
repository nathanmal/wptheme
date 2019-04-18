/**
 * Loader file
 *
 * helps clean up webpack config file
 * 
 * @type {[type]}
 */
const path                    = require('path');
const MiniCssExtractPlugin    = require("mini-css-extract-plugin");

module.exports = type => {

  switch(type){

    // CSS Loaders
    // importLoaders specifies # of loaders that run before it
    case 'css':
      return  { loader: 'css-loader',
                options: { 
                  importLoaders: 2
                }
              };
      break;

    // Post CSS loader
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

    // CSS Extract loader
    case 'extract':
      return MiniCssExtractPlugin.loader;
      break;

    // By default just hypenate the loader
    default: 
      return type + '-loader';
      break;
  }
}