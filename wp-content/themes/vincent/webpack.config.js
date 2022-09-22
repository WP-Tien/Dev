/**
 * Webpack configuration.
 */
const defaultConfig = require( '@wordpress/scripts/config/webpack.config' );

module.exports = {
    ...defaultConfig,

    entry: {
        'main': './inc/main.js',
        'block-one': './inc/blocks/block-one',
        'block-two': './inc/blocks/block-two',
        'block-three': './inc/blocks/block-three',
        'block-four': './inc/blocks/block-four',
        'block-five': './inc/blocks/block-five',
        'block-six': './inc/blocks/block-six'
    },
};