const path = require('path');

module.exports = {
    entry: {
        index: ['babel-polyfill', './resources/scripts/app.js']
    },
    output: {
        filename: "app.js",
        sourceMapFilename: "app.map",
    },
    devtool: '#source-map',
    module: {
        loaders: [
            {
                loader: 'babel-loader',
                test: /\.js?$/,
                query: {
                    presets: ['es2015', 'es2017']
                }
            }
        ]
    }
}