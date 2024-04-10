<?php
/**
 * Created by PhpStorm.
 * User: Zorca
 * Date: 07.03.2017
 * Time: 22:33
 */

namespace Oxboot;


class Extend
{
    static function language_switcher() {
        $languages = apply_filters( 'wpml_active_languages', NULL, 'orderby=id&order=desc' );
        $output = '';

        if ( !empty( $languages ) ) {
            foreach( $languages as $l ) {
                $output .= $l['active'] ? '' : sprintf(
                    '<li class="language-switcher">
                        <a class="language-switcher__link %1$s" href="%2$s">%3$s</a>
                    </li>',
                    $l['active'] ? 'language-switcher__link--active' : '',
                    $l['url'],
                    ($l['native_name'] === 'English') ? 'EN' : 'HE'
                );
            }
        }
        return $output;
    }
}
