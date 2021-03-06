const path = require('path');
const UglifyJsPlugin = require('uglifyjs-webpack-plugin');

module.exports = {
    entry: {
        index: ['babel-polyfill', './resources/scripts/app.js']
    },
    include: path.resolve(__dirname, "./resources/scripts"),
    output: {
        filename: "app.js",
        sourceMapFilename: "app.js.map",
    },
    devtool: 'source-map',
    module: {
        loaders: [
            {
                loader: 'babel-loader',
                test: /\.js?$/,
                query: {
                    presets: ['es2015', 'es2017'],
                    plugins: ['transform-class-properties', 'transform-object-rest-spread']
                }
            }
        ]
    },
    plugins: [new UglifyJsPlugin({sourceMap: true})],
}