const path = require('path')

const MiniCssExtractPlugin = require('mini-css-extract-plugin')
const CopyWebpackPlugin = require('copy-webpack-plugin')
const VueLoaderPlugin = require('vue-loader/lib/plugin')
const SOURCE_DIR = path.resolve(__dirname, '../../src/Public')
const PUBLIC_DIR = path.resolve(__dirname, '../../public')
const DIST_DIR   = path.resolve(__dirname, '../../public/js/dist')

module.exports = {
    mode: 'none',
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
        new VueLoaderPlugin()
        // new CopyWebpackPlugin([
        //     {
        //         from: path.join(SOURCE_DIR, 'js/'),
        //         to: DIST_DIR+'/js/[name].[ext]',
        //         toType: 'template',
        //     }
        // ]),
    ],
    module: {
        rules: [
            {
                test: /\.vue$/,
                loader: 'vue-loader'
            },
            {
                test: /\.css$/,
                use: ['style-loader', 'css-loader']
            }
        ]
    },
    resolve: {
        alias: {
            '@' : path.join(SOURCE_DIR, 'vue/')
        },
        extensions: ['.js', '.vue']
    },
}