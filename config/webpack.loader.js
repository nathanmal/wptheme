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

  /*  case 'file':
      return { loader: 'file-loader' };
      break;*/

    default: 
      return type + '-loader';
      break;
  }
}