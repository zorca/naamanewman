<?php

namespace Oxboot;

class Init
{
    public function __construct()
    {
        /**
         * Theme setup
         */
        add_action('after_setup_theme', function () {
            /**
             * Make theme available for translation
             */
            load_theme_textdomain('oxboot', get_template_directory() . '/lang');

            /**
             * Enable plugins to manage the document title
             * @link https://developer.wordpress.org/reference/functions/add_theme_support/#title-tag
             */
            add_theme_support('title-tag');

            /**
             * Register navigation menus
             * @link https://developer.wordpress.org/reference/functions/register_nav_menus/
             */
            register_nav_menus([
                'primary' => __('Primary Menu', 'oxboot'),
                'secondary' => __('Secondary Menu', 'oxboot'),
                'sidebar' => __('Sidebar Menu', 'oxboot'),
                'additional' => __('Additional Menu', 'oxboot'),
                'footer' => __('Footer Menu', 'oxboot')
            ]);

            /**
             * Enable post thumbnails
             * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
             */
            add_theme_support('post-thumbnails');

            /**
             * Enable post formats
             * @link http://codex.wordpress.org/Post_Formats
             */
            add_theme_support('post-formats', ['aside', 'gallery', 'link', 'image', 'quote', 'video', 'audio']);

            /**
             * Enable HTML5 markup support
             * @link https://developer.wordpress.org/reference/functions/add_theme_support/#html5
             */
            add_theme_support('html5', ['caption', 'comment-form', 'comment-list', 'gallery', 'search-form']);

            /**
             * Enable selective refresh for widgets in customizer
             * @link https://developer.wordpress.org/themes/advanced-topics/customizer-api/#theme-support-in-sidebars
             */
            add_theme_support('customize-selective-refresh-widgets');

            /**
             * Use main stylesheet for visual editor
             * @see assets/styles/layouts/_tinymce.scss
             */
            //add_editor_style(get_template_directory_uri() . '/public/css/main.css');
        }, 20);

        /**
         * Register sidebars
         */
        add_action('widgets_init', function () {
            $config = [
                'before_widget' => '<section class="widget %1$s %2$s">',
                'after_widget'  => '</section>',
                'before_title'  => '<h3>',
                'after_title'   => '</h3>'
            ];
            register_sidebar([
                    'name'          => __('Primary Sidebar', 'oxboot'),
                    'id'            => 'sidebar-primary'
                ] + $config);
            register_sidebar([
                    'name'          => __('Primary Sidebar English', 'oxboot'),
                    'id'            => 'sidebar-primary-en'
                ] + $config);
            register_sidebar([
                    'name'          => __('Secondary Sidebar', 'oxboot'),
                    'id'            => 'sidebar-secondary'
                ] + $config);
            register_sidebar([
                    'name'          => __('Secondary Sidebar English', 'oxboot'),
                    'id'            => 'sidebar-secondary-en'
                ] + $config);
        });

        add_action( 'init', function() {
            add_image_size('content-795', 795, 795, false);
        });

        add_filter('image_size_names_choose', function ($sizes) {
            $sizes['content-795'] = __('Content Image 795x795');
            return $sizes;
        });

        add_theme_support('woocommerce');

        add_action('admin_enqueue_scripts', function () {
            wp_enqueue_style('oxboot/admin.css', get_template_directory_uri().'/assets/css/admin.css');
        });

        //add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

        //add_filter( 'wpseo_canonical', '__return_false' );

        /* --------------------------------------------------------------------------
         * Remove Emojii
         * -------------------------------------------------------------------------- */
        remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
        remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
        remove_action( 'wp_print_styles', 'print_emoji_styles' );
        remove_action( 'admin_print_styles', 'print_emoji_styles' );
        remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
        remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
        remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
        add_filter( 'emoji_svg_url', '__return_false' );
        add_filter( 'tiny_mce_plugins', function ( $plugins ) {
            if ( is_array( $plugins ) ) {
                return array_diff( $plugins, array( 'wpemoji' ) );
            } else {
                return array();
            }
        });


        /* --------------------------------------------------------------------------
         * Disable REST API
         * -------------------------------------------------------------------------- */
        add_filter('rest_enabled', '__return_false');
        remove_action( 'xmlrpc_rsd_apis',            'rest_output_rsd' );
        remove_action( 'wp_head',                    'rest_output_link_wp_head', 10, 0 );
        remove_action( 'template_redirect',          'rest_output_link_header', 11, 0 );
        remove_action( 'auth_cookie_malformed',      'rest_cookie_collect_status' );
        remove_action( 'auth_cookie_expired',        'rest_cookie_collect_status' );
        remove_action( 'auth_cookie_bad_username',   'rest_cookie_collect_status' );
        remove_action( 'auth_cookie_bad_hash',       'rest_cookie_collect_status' );
        remove_action( 'auth_cookie_valid',          'rest_cookie_collect_status' );
        remove_filter( 'rest_authentication_errors', 'rest_cookie_check_errors', 100 );
        remove_action( 'init','rest_api_init' );
        remove_action( 'rest_api_init', 'rest_api_default_filters', 10, 1 );
        remove_action( 'parse_request', 'rest_api_loaded' );
        remove_action( 'rest_api_init','wp_oembed_register_route');
        remove_filter( 'rest_pre_serve_request', '_oembed_rest_pre_serve_request', 10, 4 );
        remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
        remove_action( 'template_redirect', 'rest_output_link_header', 11, 0 );
        remove_action( 'wp_head', 'rest_output_link_wp_head' );
        remove_action( 'wp_head','wp_oembed_add_host_js');

        /* --------------------------------------------------------------------------
         * Clean head
         * -------------------------------------------------------------------------- */
        remove_action( 'wp_head', 'feed_links', 2 );
        remove_action( 'wp_head', 'feed_links_extra', 3 );
        remove_action( 'wp_head', 'rsd_link' );
        remove_action( 'wp_head', 'wlwmanifest_link' );
        remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0);
        remove_action( 'wp_head', 'wp_generator' );
        remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );

        /**
         * Optimize WooCommerce Scripts
         * Remove WooCommerce Generator styles, and scripts from non WooCommerce pages.
         */
        add_action( 'wp_enqueue_scripts', function () {
            if ( function_exists( 'is_woocommerce' ) ) {
                if ( ! is_woocommerce() && ! is_cart() && ! is_checkout() ) {
                    # Styles
                    wp_dequeue_style( 'woocommerce-general' );
                    wp_dequeue_style( 'woocommerce-layout' );
                    wp_dequeue_style( 'woocommerce-smallscreen' );
                    wp_dequeue_style( 'woocommerce_frontend_styles' );
                    wp_dequeue_style( 'woocommerce_fancybox_styles' );
                    wp_dequeue_style( 'woocommerce_chosen_styles' );
                    wp_dequeue_style( 'woocommerce_prettyPhoto_css' );
                    # Scripts
                    wp_dequeue_script( 'wc_price_slider' );
                    wp_dequeue_script( 'wc-single-product' );
                    wp_dequeue_script( 'wc-add-to-cart' );
                    wp_dequeue_script( 'wc-cart-fragments' );
                    wp_dequeue_script( 'wc-checkout' );
                    wp_dequeue_script( 'wc-add-to-cart-variation' );
                    wp_dequeue_script( 'wc-single-product' );
                    wp_dequeue_script( 'wc-cart' );
                    wp_dequeue_script( 'wc-chosen' );
                    wp_dequeue_script( 'woocommerce' );
                    wp_dequeue_script( 'prettyPhoto' );
                    wp_dequeue_script( 'prettyPhoto-init' );
                    wp_dequeue_script( 'jquery-blockui' );
                    wp_dequeue_script( 'jquery-placeholder' );
                    wp_dequeue_script( 'fancybox' );
                    wp_dequeue_script( 'jqueryui' );
                }
            }
        });
    }
}
