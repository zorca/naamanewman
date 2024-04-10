<?php

namespace Oxboot;

use Oxboot\Template;

class Render
{
    public function __construct()
    {
        add_filter('template_include', function ($template) {
            if (file_exists($template)) require $template;
            $template = str_replace(
                [THEME, BASE . 'wp-content' . DS, '.php'],
                ['', '', '.twig'],
                str_replace(DIRECTORY_SEPARATOR, DS, $template)
            );
            new Template($template == 'index.twig' ? null : $template);
            return get_theme_file_path('index.php');
        });
    }
}
