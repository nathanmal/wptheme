// Webpack 4
const webpack                 = require('webpack');
const path                    = require('path');
const MiniCssExtractPlugin    = require("mini-css-extract-plugin");
const CleanWebpackPlugin      = require('clean-webpack-plugin');
const UglifyJsPlugin          = require("uglifyjs-webpack-plugin");
const OptimizeCSSAssetsPlugin = require("optimize-css-assets-webpack-plugin");
const loader                  = require('./webpack.loaders.js'); 

// Webpack config
module.exports = (env, argv) => {

  // Test for production environment
  const production = argv.mode === 'production';

  // Config object
  const config = {

    // Project entry point(s)
    entry: { 
      // Main theme file
      theme: './assets/src/js/theme.js',
      // Bootstrap theme
      bootstrap: './assets/src/js/bootstrap.js'
    },

    // Output directory
    output: {
      path: path.resolve(  __dirname, '../assets/dist' ),
      filename: '[name].js'
    },

    // Module Rules
    module: {

      rules: [
        // Javascript
        {
          test: /\.js$/,
          exclude: /node_modules/,
          loader: loader('babel')
        },

        // Images
        {
          test: /images\/.*\.(png|jpg|gif)$/,
          loader: loader('file'),
          options: {
            name(file) {
              return production ? 'images/[path][hash].[ext]' : 'images/[path][name].[ext]';
            },
          },
        },

        // Font files
        {
           test: /fonts\/.*\.(ttf|otf|eot|svg|woff(2)?)(\?[a-z0-9]+)?$/,
           use: [{
             loader: loader('file'),
             options: {
               name: 'fonts/[name].[ext]',
             }
           }]
        },

        // Application Files
        {
          test: /app\/.*\.(png|jpg|ico|xml|webmanifest|xml)$/,
          loader: loader('file'),
          options: {
            name(file) {
              return production ? 'images/[path][hash].[ext]' : 'images/[path][name].[ext]';
            },
          }
        },

        // SASS
        {
          test: /\.[s]?css$/,
          use: [
            loader('style'),
            loader('extract'),
            loader('css'),
            loader('sass'),
            loader('postcss'),
          ]
        },
        
      ]
    },

    // Plugins
    plugins: [
      // clean distro
      new CleanWebpackPlugin('dist', {}),
      // css file name
      new MiniCssExtractPlugin({ filename: '[name].css' }),
      // external jquery
      new webpack.ProvidePlugin({  $: 'jquery', jQuery: 'jquery' })
    ]
    
  }

  // Add optimization in production
  if( production ){
    config.optimization = {
      minimizer: [
        new UglifyJsPlugin({ cache: true, parallel: true, sourceMap: true }),
        new OptimizeCSSAssetsPlugin({})
      ]
    }
  }

  // return webpack config object
  return config;

}