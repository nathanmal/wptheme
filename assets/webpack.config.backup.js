const webpack                 = require('webpack');
const path                    = require('path');
const MiniCssExtractPlugin    = require("mini-css-extract-plugin");
const CssMinimizerPlugin      = require('css-minimizer-webpack-plugin');

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
  return {

    // Project entry point(s)
    entry: { 
      // Main theme file
      theme: path.resolve( __dirname, 'src/theme/theme.js'),
      // Admin stuff
      admin: path.resolve( __dirname, 'src/admin/admin.js'),
      // Customizer
      customize: path.resolve( __dirname, 'src/customize/customize.js'),
      // Customizer controls
      controls: path.resolve( __dirname, 'src/controls/controls.js'),
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