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
    .js("resources/js/profile_image_preview.js", "public/js")
    .js("resources/js/cover_image_preview.js", "public/js")
    .js("resources/js/introduction_pop.js", "public/js")
    .sass("resources/sass/mixin.scss", "public/css")
    .sass("resources/sass/varia.scss", "public/css")
    .sass("resources/sass/top-page.scss", "public/css")
    .sass("resources/sass/footer.scss", "public/css")
    .sass("resources/sass/create.scss", "public/css/post")
    .sass("resources/sass/index.scss", "public/css/post")
    .sass("resources/sass/show.scss", "public/css/post")
    .sass("resources/sass/introduction_show.scss", "public/css/introduction")
    .sass("resources/sass/introduction_create.scss", "public/css/introduction");

// .postCss(
//     "resources/css/app.css",
//     "public/css",
//     [require("postcss-import"), require("tailwindcss")]

// );
