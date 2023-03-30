let mix = require('laravel-mix');
require('laravel-mix-postcss-config');

mix.setResourceRoot('../');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

//sass('resources/assets/sass/common.scss', 'public/css')
//   mix.postCss('resources/assets/postCSS/app.css', 'public/compiled/')


mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/user.js', 'public/js')

    .postCss('resources/assets/postCSS/app.css', 'public/compiled/')
    .postCss('resources/assets/postCSS/user.css', 'public/compiled/')
    .postCss('resources/assets/postCSS/admin.css', 'public/compiled/')
    .options({
        postCss: [
            require('postcss-import')(),
            require('postcss-mixins')(),
            require('postcss-nested')(),
            require('postcss-responsive-type')(),
            require('postcss-simple-vars')(),
            require('lost')(),
            require('postcss-cssnext')({ browsers: ["last 2 versions", "> 5%"] }),
        ]
    })

    .browserSync('http://booking.test:8000');

//.browserSync('http://booking.test:8000');


//   .postCssConfig("postcss-import","postcss-mixins","postcss-nested","postcss-responsive-type","postcss-simple-vars")
//   .sourceMaps();
//   .js('resources/js/app.js', 'public/js');
