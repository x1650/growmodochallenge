import { js } from 'laravel-mix';

js('resources/js/app.js', 'public/js').version(false)
    .css('resources/css/app.css', 'public/css').version(false);;