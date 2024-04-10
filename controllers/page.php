<?php

function parse_gallery_images($content) {
    $attachment_ids = [];
    $pattern = get_shortcode_regex();
    $images = [];
    if (preg_match_all( '/'. $pattern .'/s', $content, $matches ) ) {
        //finds the "gallery" shortcode and puts the image ids in an associative array at $matches[3]
        $count = count($matches[3]);      //in case there is more than one gallery in the post.
        for ($i = 0; $i < $count; $i++){
            $atts = shortcode_parse_atts( $matches[3][$i] );
            if ( isset( $atts['ids'] ) ){
                $attachment_ids = explode( ',', $atts['ids'] );
                $attachementsCount = count($attachment_ids);
                if ($attachementsCount > 0){
                    for ($j = 0; $j < $attachementsCount ; $j++) {
                        $image = [];
                        $attachmentId = intval($attachment_ids[$j]);
                        $image['id'] = $attachmentId;
                        $image['full'] = wp_get_attachment_image_src($attachmentId, 'full');
                        $image['medium'] = wp_get_attachment_image_src($attachmentId, 'medium');
                        $image['thumbnail'] = wp_get_attachment_image_src($attachmentId, 'thumbnail');
                        array_push($images, $image);
                    }
                }
            }
        }
    }
    return $images;
}

$context['slider'] = parse_gallery_images(carbon_get_the_post_meta('slider_field'));
$context['gallery'] = parse_gallery_images(carbon_get_the_post_meta('gallery_field'));
