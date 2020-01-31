const path       = require('path')
const SOURCE_DIR = path.resolve(__dirname, '../../src/Public')
const PUBLIC_DIR = path.resolve(__dirname, '../../public')
const DIST_DIR   = path.resolve(__dirname, '../../public/js/dist')

module.exports = {
    mode: 'production',
    entry: {
        'main': [path.join(SOURCE_DIR, 'js/entry.js')],
    },
    output: {
        path: DIST_DIR,
        publicPath: PUBLIC_DIR,
        filename: '[name].[contenthash].bundle.js',
    }
}