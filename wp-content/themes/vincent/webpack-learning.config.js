/**
 * Webpack configuration.
 */
const path = require( 'path' );
const MiniCSSExtractPlugin = require( 'mini-css-extract-plugin' );
const OptimizeCssAssetsPlugin = require( 'optimize-css-assets-webpack-plugin' );
const cssnano = require( 'cssnano' );

const { CleanWebpackPlugin } = require( 'clean-webpack-plugin' ); // to remove/clean your build folder(s)
const UglifyJsPlugin = require( 'uglifyjs-webpack-plugin' );

// const CopyPlugin = require('copy-webpack-plugin'); // https://webpack.js.org/plugins/copy-webpack-plugin/
const JS_DIR = path.resolve( __dirname, 'js' );
const IMG_DIR = path.resolve( __dirname, 'images' );
const BUILD_DIR = path.resolve( __dirname, 'build' );

const entry = {
    main: JS_DIR + '/main.js',
};

const output = {
    path: BUILD_DIR,
    filename: 'js/[name].js'
};

const rules = [
    {
        test: /\.js$/,
        include: [ JS_DIR ],
        exclude: /node_module/,
        use: 'babel-loader'
    },
    {
        test: /\.scss$/,
        exclude: /node_module/,
        use: [
            MiniCSSExtractPlugin.loader,
            // Creates `style` nodes from JS strings
            // "style-loader",
            // Translates CSS into CommonJS
            "css-loader",
            // Compiles Sass to CSS
            "sass-loader",
        ]
    },
    {
        test: /\.(png|jpg|svg|jpeg|gif|ico)$/,
        use: {
            loader: 'file-loader',
            options: {
                name: '[path][name].[ext]',
                publicPath: 'production' === process.env.NODE_ENV ? '../' : '../../'
            }
        }
    },
];

/**
 * Note: argv.mode will return 'development' or 'production'.
 * The NODE_ENV environment variable will be set by cross-env.
 */
const plugins = ( argv ) => [
    new CleanWebpackPlugin({
        cleanStaleWebpackAssets: ( 'production' === argv.mode )
    }),

    new MiniCSSExtractPlugin({
        filename: 'css/[name].css'
    })
];

module.exports = ( env, argv ) => (    
    { 
        entry: entry,

        output: output,

        devtool: 'source-map',

        module: {
            rules: rules,
        },

        plugins: plugins( argv ),

        optimization: {
            minimizer: [
                new OptimizeCssAssetsPlugin({
                    cssProcessor: cssnano
                }),
                new UglifyJsPlugin({
                    cache: false,
                    parallel: true,
                    sourceMap: false
                })
            ]
        },

        externals: {
            jQuery: 'jQuery'
        },      
    }
);