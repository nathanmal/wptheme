// Webpack version 4
const path                 = require('path');
//const glob = require('glob');
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const CleanWebpackPlugin   = require('clean-webpack-plugin');
const webpack = require('webpack');


module.exports = {

  // Project entry point(s)
  entry: {
    // Custom post types core
    theme: './assets/src/js/theme.js',
  },

  // Output directory
  output: 
  {
    path: path.resolve( __dirname, 'assets/dist' ),
    filename: '[name].js'
  },

  // Module Rules
  module: {

    rules: [
      // Javascript
      {
        test: /\.js$/,
        exclude: /node_modules/,
        use: {
          loader: "babel-loader"
        }
      },
      // Check first for url:() paths in SASS
      {
        test: /\.(png|jpg|gif)$/,
        loader: "url-loader",
      }, 

      // SASS, CSS..
      {
        test: /\.[s]?css$/,
        use: [
          'style-loader',
          MiniCssExtractPlugin.loader,
          'css-loader',
          { 
            loader : 'postcss-loader',
            options: {
              config : { 'path' : path.resolve( __dirname, 'postcss.config.js' ) }
            }
          },
          'sass-loader'
        ]
      },
      // Font files
      {
         test: /.(ttf|otf|eot|svg|woff(2)?)(\?[a-z0-9]+)?$/,
         use: [{
           loader: 'file-loader',
           options: {
             name: '[name].[ext]',
             outputPath: 'fonts/',    // where the fonts will go
             publicPath: 'fonts/'     // override the default path
           }
         }]
       },
    ]
  },

  // Plugins
  plugins: [
    new CleanWebpackPlugin('dist', {}),
    new MiniCssExtractPlugin({
      filename: '[name].css',
    }),
    new webpack.ProvidePlugin({
      $: 'jquery',
      jQuery: 'jquery'
    })
  ]
  
}