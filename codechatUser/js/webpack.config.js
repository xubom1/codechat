const path = require('path');

module.exports = {
    mode: 'development',
    //mode: 'production',
    entry: './src/viewer3d.js',
    output: {
        path: path.resolve(__dirname, 'build'),
        filename: 'viewer3d.bundle.js'
    }
};