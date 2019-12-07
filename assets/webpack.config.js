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

  // Absolute path to distro
  const dist = path.resolve( __dirname, 'dist' );

  // Absolute path to source
  const src  = path.resolve( __dirname, 'src' );

  // Hash filenames on production
  const filename = production ? '[hash].[ext]' : '[name].[ext]';

  // Config object
  const config = {

    // Project entry point(s)
    entry: { 
      // Main theme file
      theme: path.resolve( __dirname, 'src/js/theme.js'),
      // Admin stuff
      admin: path.resolve( __dirname, 'src/js/admin.js')
    },

    // Output directory
    output: {
      path: path.resolve(  __dirname, 'dist' ),
      filename: '[name].js'
    },

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
              return filename;
            },
          },
        },

        // Web fonts
        {
           test: /fonts\/.*\.(ttf|otf|eot|svg|woff(2)?)(\?[a-z0-9]+)?$/,
           use: [{
             loader: 'file-loader',
             options: {
               name: 'fonts/[name].[ext]',
             }
           }]
        },

        // Application Icons & Images
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

      // Clean distro, except for images directory
      new CleanWebpackPlugin({
        cleanOnceBeforeBuildPatterns: ['!**/images/*'],
        cleanAfterEveryBuildPatterns: ['!**/images/*']
      }),

      // Set CSS file name
      new MiniCssExtractPlugin({ filename: '[name].css' }),

      // Provide external jQuery
      new webpack.ProvidePlugin({  $: 'jquery', jQuery: 'jquery' }), 

      //new UglifyJsPlugin({ cache: true, parallel: true, sourceMap: true }),
    ],

    // Prevents warnings when file sizes are too large
    performance: 
    {
      hints: false
    }
  }

  // Add optimization in production
  // Terser Webpack Plugin seems to be the only one that works
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

  return config;

}