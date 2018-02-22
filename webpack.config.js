const path = require('path');

module.exports = {
    entry: {
        index: ['babel-polyfill', './resources/scripts/app.js']
    },
    output: {
        filename: "app.js"
    },
    devtool: 'eval-cheap-module-source-map',
    module: {
        loaders: [
            {
                loader: 'babel-loader',
                test: /\.js?$/,
                query: {
                    presets: ['es2015', 'es2017'],
                    plugins: ['transform-class-properties']
                }
            }
        ]
    }
}