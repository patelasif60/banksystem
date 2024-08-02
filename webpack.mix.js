let mix = require('laravel-mix');
mix.js('resources/js/app.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css');

    mix.css('resources/css/styles.css', 'public/css/style.css');
    mix.scripts("resources/js/scripts.js", "public/js/scripts.js");
    mix.scripts("resources/js/datatables-simple-demo.js", "public/js/datatables-simple-demo.js");