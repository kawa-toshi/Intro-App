const mix = require("laravel-mix");

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js("resources/js/app.js", "public/js")
    .js("resources/js/ajaxlike.js", "public/js")
    .js("resources/js/ajaxComment.js", "public/js")
    .js("resources/js/ajaxCommentDelete.js", "public/js")
    .js("resources/js/imagePreview.js", "public/js")
    .sass("resources/sass/top-page.scss", "public/css")
    .sass("resources/sass/create.scss", "public/css")
    .sass("resources/sass/index.scss", "public/css")
    .sass("resources/sass/show.scss", "public/css");

// .postCss(
//     "resources/css/app.css",
//     "public/css",
//     [require("postcss-import"), require("tailwindcss")]

// );
