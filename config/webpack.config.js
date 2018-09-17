// Webpack version 4
const webpack                 = require('webpack');
const path                    = require('path');
const MiniCssExtractPlugin    = require("mini-css-extract-plugin");
const CleanWebpackPlugin      = require('clean-webpack-plugin');
const UglifyJsPlugin          = require("uglifyjs-webpack-plugin");
const OptimizeCSSAssetsPlugin = require("optimize-css-assets-webpack-plugin");

module.exports = (env, argv) => {

  const production = argv.mode === 'production';

  return {
    // Project entry point(s)
    entry: { 
      theme: './assets/src/js/theme.js',
      fontawesome: './assets/src/vendor/fontawesome.js' 
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
            {
              loader: 'css-loader',
              options: { 
                importLoaders: 2
              }
            },
            {
              loader : 'sass-loader',
            },
            { 
              loader : 'postcss-loader',
              options: {
                config : { 
                  path : path.resolve( __dirname, 'postcss.config.js' )
                  //plugins : [ require('autoprefixer')()] ,
                }
              }
            },
           
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
               // publicPath: 'fonts/'     // override the default path
             }
           }]
         },
      ]
    },
    // Minification
    optimization: {
      minimizer: [
        new UglifyJsPlugin({
          cache: true,
          parallel: true,
          // sourceMap: true // set to true if you want JS source maps
        }),
        new OptimizeCSSAssetsPlugin({})
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

}