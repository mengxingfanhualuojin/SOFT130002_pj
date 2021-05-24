module.exports = {
    devServer: {
        port: 80,
        proxy: {
            '/api': {
                target: 'http://localhost:8888',
                changeOrigin: true,
                pathRewrite: {
                    '/api': ''
                }
            }
        }
    },

}