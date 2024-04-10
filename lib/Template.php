<?php

namespace Oxboot;

use Timber\Post;
use Timber\Timber;
use Timber\Menu;
use Oxboot\Extend;

class Template
{
    public function __construct($custom_template)
    {
        /**
         * Theme assets
         */
        add_action('wp_enqueue_scripts', function () {
            //wp_enqueue_style('dashicons');
            wp_enqueue_style('oxboot/main.css', get_template_directory_uri() . '/assets/css/main.css', false, null);
			wp_enqueue_style('oxboot/custom.css', get_template_directory_uri() . '/assets/css/custom.css', false, null);
            wp_enqueue_script('oxboot/jquery.easing.min.js', get_template_directory_uri() . '/assets/js/jquery.easing.min.js', ['jquery'], null, true);
            wp_enqueue_script('oxboot/jquery.slimmenu.min.js', get_template_directory_uri() . '/assets/js/jquery.slimmenu.min.js', ['jquery'], null, true);
            wp_enqueue_script('oxboot/camera.min.js', get_template_directory_uri() . '/assets/js/camera.min.js', ['jquery'], null, true);
            wp_enqueue_script('oxboot/main.js', get_template_directory_uri() . '/assets/js/main.js', ['jquery'], null, true);
        }, 100);

        /**
         * Timber compilation
         */
        $template_engine = new Timber();
        $context = $template_engine::get_context();
        $post_type = get_post_type();
        if (function_exists('is_woocommerce')) {
            if (is_woocommerce()) $post_type = 'product';
        }
        $context['posts'] = $template_engine::get_posts();
        $context['page'] = new Post();
        $context['title'] = single_post_title( '', false );
        $context['subtitle'] = carbon_get_post_meta($context['page']->ID, 'subtitle');
        $context['breadcrumbs'] = yoast_breadcrumb('<div class="breadcrumbs">','</div>', false);
        $context['link'] = str_replace('/', '', substr(get_permalink(), strlen(get_option('home'))));
        $context['language_code'] = ICL_LANGUAGE_CODE;
        $context['language_class'] = 'lang-' . ICL_LANGUAGE_CODE;
        $context['language_switcher'] = Extend::language_switcher();
        $context['pagination'] = $template_engine::get_pagination();
        $context['address'] = carbon_get_theme_option('address');
        $context['address_en'] = carbon_get_theme_option('address_en');
        $context['map'] = carbon_get_theme_option('map');
        $context['phone'] = carbon_get_theme_option('phone');
        $context['fax'] = carbon_get_theme_option('fax');
        $context['email'] = carbon_get_theme_option('email');
        $context['facebook'] = carbon_get_theme_option('facebook');
        $context['youtube'] = carbon_get_theme_option('youtube');
        $context['instagram'] = carbon_get_theme_option('instagram');
        $context['googleplus'] = carbon_get_theme_option('googleplus');
        $context['pinterest'] = carbon_get_theme_option('pinterest');
        $context['copyright'] = carbon_get_theme_option('copyright');
        $context['copyright_en'] = carbon_get_theme_option('copyright_en');

        $context['sidebar_articles'] = Timber::get_widgets('sidebar-primary');
        $context['sidebar_articles_en'] = Timber::get_widgets('sidebar-primary-en');

        $context['sidebar_about'] = Timber::get_widgets('sidebar-secondary');
        $context['sidebar_about_en'] = Timber::get_widgets('sidebar-secondary-en');

        foreach (get_nav_menu_locations() as $menu_location => $menu_id) {
            $context['menu_' . $menu_location ] = new Menu($menu_id);
        }
        if (is_404()) :
            $templates[] = '404.twig';
        elseif ($custom_template) :
            $templates[] = $custom_template;
        elseif (is_search()) :
            $templates[] = 'search.twig';
        elseif (is_author()) :
            $templates[] = 'author.twig';
        elseif (is_front_page()) :
            require THEME . 'controllers/front-page.php';
            $templates[] = 'front-page.twig';
        endif;
        if (is_post_type_archive()) :
            $templates[] = $post_type . '.archive.twig';
        elseif (is_singular()) :
            if ($context['link'] === '%d7%95%d7%99%d7%93%d7%90%d7%95' || $context['link'] === 'videos') {
                require THEME . 'controllers/videos-page.php';
                $templates[] = $post_type . '.videos.single.twig';
            }
            if ($post_type === 'post') {
                $args = 'post_type=post&numberposts=25&orderby=data';
                $context['articles'] = Timber::get_posts($args);
            }
            if ($post_type === 'page') {
                require THEME . 'controllers/page.php';
            }
            $templates[] = $post_type . '.single.twig';
        elseif (is_archive()) :
            if (function_exists('is_woocommerce')) {
                if (is_woocommerce()) $templates[] = 'product.archive.twig';
            }
            $templates[] = 'archive.twig';
        elseif (is_home()) :
            $templates[] = 'post.archive.twig';
        endif;
        $templates[] = 'index.twig';
        $template_engine::render($templates, $context);
    }
}
