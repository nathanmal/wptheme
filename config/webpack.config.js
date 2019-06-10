// Webpack 4
const webpack                 = require('webpack');
const path                    = require('path');
const MiniCssExtractPlugin    = require("mini-css-extract-plugin");
const { CleanWebpackPlugin }  = require('clean-webpack-plugin');
const OptimizeCSSAssetsPlugin = require("optimize-css-assets-webpack-plugin");
const TerserPlugin            = require('terser-webpack-plugin');

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
          loader: 'babel-loader'
        },
        
        // Images
        {
          test: /images\/.*\.(png|jpg|gif)$/,
          loader: 'file-loader',
          options: {
            name(file) {
              const filename = production ? '[hash].[ext]' : '[name].[ext]';
              return 'images/' + filename;
            },
          },
        },

        // Font files
        {
           test: /fonts\/.*\.(ttf|otf|eot|svg|woff(2)?)(\?[a-z0-9]+)?$/,
           use: [{
             loader: 'file-loader',
             options: {
               name: 'fonts/[name].[ext]',
             }
           }]
        },

        // Application Files
        {
          test: /app\/.*\.(png|jpg|ico|xml|webmanifest|xml)$/,
          loader: 'file-loader',
          options: {
            name(file) {
              //const filename = production ? '[hash].[ext]' : '[name].[ext]';
              // const filename = production ? '[hash].[ext]' : ;
              return 'app/[name].[ext]';
            },
          }
        },

        // SASS
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
            'sass-loader',
            { 
              loader : 'postcss-loader',
              options: {
                config : { 
                  path : path.resolve( __dirname, 'postcss.config.js' )
                }
              }
            },
          ]
        },
        
      ]
    },

    // Plugins
    plugins: [
      new webpack.ProgressPlugin(),
      // clean distro
      new CleanWebpackPlugin(),
      // css file name
      new MiniCssExtractPlugin({ filename: '[name].css' }),
      // external jquery
      new webpack.ProvidePlugin({  $: 'jquery', jQuery: 'jquery' }), 

      //new UglifyJsPlugin({ cache: true, parallel: true, sourceMap: true }),
    ],

    performance: {
      hints: false
    }


  }

  // Add optimization in production
  
  if( production )
  {
    config.optimization = {
      minimizer: [
        new TerserPlugin({
          test: /\.js(\?.*)?$/i,
          cache: true,
          parallel: true,
          sourceMap: true
          // extractComments: true,
        }),
        new OptimizeCSSAssetsPlugin({})
      ]
    }


  }
  

  // return webpack config object
  return config;

}