/**
 * Webpack configuration.
 */
 const wplib = [
    'blocks',
    'components',
    'date',
    'editor',
    'element',
    'i18n',
    'utils',
    'data',
];

module.exports = {
    entry: './src/index.js',
    output: {
        path: path.resolve(__dirname, 'build'),
        filename: 'myplugin.build.js',
        library: ['wp', '[name]'],
        libraryTarget: 'window',
    },
    externals: wplib.reduce((externals, lib) => {
        externals[`wp.${lib}`] = {
        window: ['wp', lib],
        };

        return externals;
    }, {
        'react': 'React',
        'react-dom': 'ReactDOM',
    }),
};