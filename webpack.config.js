const path = require('path');

module.exports = {
    entry: './resources/scripts/app.js',
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
                    presets: ['es2015']
                }
            }
        ]
    }
}