<?php

namespace Oxboot;

use Carbon_Fields\Container;
use Carbon_Fields\Field;

class Carbon
{
    public function __construct()
    {
        Container::make('theme_options', 'Contact Us + Copyright')
            ->add_fields(array(
                Field::make('text', 'address', __('Address')),
                Field::make('text', 'address_en', __('Address - EN')),
                Field::make('text', 'map', __('Map Link')),
                Field::make('text', 'phone', __('Phone')),
                Field::make('text', 'fax', __('Fax')),
                Field::make('text', 'email', __('E-mail')),
                Field::make('text', 'facebook', __('Facebook')),
                Field::make('text', 'youtube', __('Youtube')),
                Field::make('text', 'instagram', __('Instagram')),
                Field::make('text', 'googleplus', __('Google +')),
                Field::make('text', 'pinterest', __('Pinterest')),
                Field::make('text', 'copyright', __('Copyright')),
                Field::make('text', 'copyright_en', __('Copyright - EN'))
            ));
        add_action('carbon_register_fields', function () {
            Container::make('post_meta', 'Subtitle')
                ->show_on_post_type(['page', 'post'])
                ->add_fields(array(
                    Field::make('text', 'subtitle', __('Subtitle'))
                ));
            Container::make('post_meta', 'Main Page Slider')
                ->show_on_page('הראשי')
                ->add_fields(array(
                    Field::make('complex', 'slider_slides', __('Slider'))
                        ->add_fields(array(
                            Field::make('text', 'title', __('Title')),
                            Field::make('image', 'image', __('Image')),
                        )),
                    Field::make('textarea', 'slider_description', __('Slider Description')),
                    Field::make('text', 'slider_shop_label', __('Slider Shop Label')),
                    Field::make('text', 'slider_shop_link', __('Slider Shop URL')),
                ));
            Container::make('post_meta', 'Main Page Slider En')
                ->show_on_page('main-page')
                ->add_fields(array(
                    Field::make('complex', 'slider_slides', __('Slider'))
                        ->add_fields(array(
                            Field::make('text', 'title', __('Title')),
                            Field::make('image', 'image', __('Image')),
                        )),
                    Field::make('textarea', 'slider_description', __('Slider Description')),
                ));
            Container::make('post_meta', 'About the salon Carousel')
                ->show_on_page('הראשי')
                ->add_fields(array(
                    Field::make('complex', 'carousel_slides', __('Carousel'))
                        ->add_fields(array(
                            Field::make('text', 'title', __('Title')),
                            Field::make('relationship', 'link', __('Link'))->set_post_type('page')->set_max(1),
                            Field::make('image', 'image', __('Image')),
                        ))
                ));
            Container::make('post_meta', 'About the salon Carousel En')
                ->show_on_page('main-page')
                ->add_fields(array(
                    Field::make('complex', 'carousel_slides', __('Carousel'))
                        ->add_fields(array(
                            Field::make('text', 'title', __('Title')),
                            Field::make('relationship', 'link', __('Link'))->set_post_type('page')->set_max(1),
                            Field::make('image', 'image', __('Image')),
                        ))
                ));
        });
        add_action('carbon_register_fields', function () {
            Container::make('post_meta', 'Videos')
                ->show_on_page('וידאו')
                ->add_fields(array(
                    Field::make('complex', 'videos_items', __('Videos Items'))
                        ->add_fields(array(
                            Field::make('text', 'title', __('Title')),
                            Field::make('text', 'iframe', __('Iframe')),
                        )),
                ));
        });
        add_action('carbon_register_fields', function () {
            Container::make('post_meta', 'Videos En')
                ->show_on_page('videos')
                ->add_fields(array(
                    Field::make('complex', 'videos_items', __('Videos Items'))
                        ->add_fields(array(
                            Field::make('text', 'title', __('Title')),
                            Field::make('text', 'iframe', __('Iframe')),
                        )),
                ));
        });
        add_action('carbon_register_fields', function () {
            Container::make('post_meta', 'Icon')
                ->show_on_post_type('page')
                ->add_fields(array(
                    Field::make('image', 'category_icon', __('Icon For Category List'))
                ));
        });
        add_action('carbon_register_fields', function () {
            Container::make('post_meta', 'Slider')
                ->show_on_post_type('page')
                ->add_fields(array(
                    Field::make('rich_text', 'slider_field', __('Slider Field (No Text)'))
                ));
        });
        add_action('carbon_register_fields', function () {
            Container::make('post_meta', 'Gallery')
                ->show_on_post_type('page')
                ->add_fields(array(
                    Field::make('rich_text', 'gallery_field', __('Gallery Field (No Text)'))
                ));
        });
    }
}
