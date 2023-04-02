const path = require('path');

module.exports = {
    mode: 'development',
    mode: 'production',
    entry: {
        loadingPage: './src/loadingPage.js',
        logo3D: './src/logo3D.js'
    },
    output: {
        path: path.resolve(__dirname, 'build'),
        filename: '[name].bundle.js'
    }
};