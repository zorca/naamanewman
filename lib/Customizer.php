<?php

namespace Oxboot;

class Customizer
{
    public function __construct()
    {
        add_action('customize_register', function($customizer){
            $customizer->add_section(
                'contacts',
                array(
                    'title' => 'Contacts',
                    'description' => 'Contacts Customization',
                    'priority' => 998,
                )
            );
            $customizer->add_setting(
                'contacts_address',
                array(
                    'default' => '',
                    'sanitize_callback' => 'sanitize_text_field',
                )
            );
            $customizer->add_control(
                'contacts_address',
                array(
                    'label' => 'Contacts - Address',
                    'section' => 'contacts',
                    'type' => 'text',
                )
            );
            $customizer->add_setting(
                'contacts_email',
                array(
                    'default' => '',
                    'sanitize_callback' => 'sanitize_text_field',
                )
            );
            $customizer->add_control(
                'contacts_email',
                array(
                    'label' => 'Contacts - Email',
                    'section' => 'contacts',
                    'type' => 'text',
                )
            );
        });

        add_action('customize_register', function($customizer){
            $customizer->add_section(
                'footer',
                array(
                    'title' => 'Footer',
                    'description' => 'Footer Customization',
                    'priority' => 999,
                )
            );
            $customizer->add_setting(
                'footer_contact-us',
                array(
                    'default' => '',
                    'sanitize_callback' => 'sanitize_text_field',
                )
            );
            $customizer->add_control(
                'footer_contact-us',
                array(
                    'label' => 'Footer - Contact Us',
                    'section' => 'footer',
                    'type' => 'text',
                )
            );
        });
    }
}
