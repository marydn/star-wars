const path = require('path')
const MiniCssExtractPlugin = require('mini-css-extract-plugin')
const SOURCE_DIR = path.resolve(__dirname, '../../src/Public')
const PUBLIC_DIR = path.resolve(__dirname, '../../public')
const DIST_DIR   = path.resolve(__dirname, '../../public/js/dist')

module.exports = {
    mode: 'development',
    entry: {
        'main': [path.join(SOURCE_DIR, 'js/entry.js')],
    },
    output: {
        path: DIST_DIR,
        publicPath: PUBLIC_DIR,
        filename: '[name].js',
    },
    plugins: [
        new MiniCssExtractPlugin({
            filename: 'css/[name].css',
            chunkFilename: '[id].css',
        }),
    ],
    module: {
        rules: [
            {
                test: /\.css$/,
                use: ['style-loader', 'css-loader']
            }
        ]
    }
}