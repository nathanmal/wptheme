const webpack                 = require('webpack');
const path                    = require('path');
const MiniCssExtractPlugin    = require("mini-css-extract-plugin");
const CssMinimizerPlugin      = require('css-minimizer-webpack-plugin');

// Webpack config
module.exports = (env, argv) => {

  // Config object
  return {

    // Project entry point(s)
    entry: { 
      // Base theme assets
      wptheme: path.resolve( __dirname, 'src/wptheme.js'),
      // Customized theme assets
      theme: path.resolve( __dirname, 'theme/theme.js')
    },

    // Output directory
    output: {
      // Path to distro
      path: path.resolve(  __dirname, 'dist' ),
      // Set filename
      filename: '[name].js'
    },

    // Add jQuery as external library
    externals: {
      jquery: 'jQuery'
    },

    // Module Rules
    module: {

      rules: 
      [
        // Javascript Files
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
            outputPath: 'images',
            name(file) {
              return '[name].[ext]';
            },
          },
        },

        // SASS
        {
          test: /\.[s]?css$/,
          use: [
            'style-loader',
            {
              loader: MiniCssExtractPlugin.loader,
              options: {
                esModule: false,
              },
            },
            
            { 
              loader: 'css-loader',
                options: { 
                  importLoaders: 2
                }
            },
            { 
              loader : 'postcss-loader',
              options: {
                postcssOptions: {
                  config : path.resolve( __dirname, 'postcss.config.js' )
                }
              }
            },
            'sass-loader'
          ]
        },
        
      ]
    },

    // Plugins
    plugins: [
      // Show progress
      new webpack.ProgressPlugin(),
      // Set CSS file name
      new MiniCssExtractPlugin({ filename: '[name].css' }),
      // Provide external jQuery
      new webpack.ProvidePlugin({  $: 'jquery', jQuery: 'jquery' }), 
    ],

    // Minimize
    optimization: {
      minimize: true,
      minimizer: [
         new CssMinimizerPlugin(),
      ],
    },

    // Prevents warnings when file sizes are too large
    performance: 
    {
      hints: false
    }
  }



}