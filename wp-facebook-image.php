<?php
/*
Plugin Name: Facebook suggested image from featured image
Plugin URI: http://github.com/sapht/wp-facebook-image
Description: Facebook suggested image from featured image
Version: 0.0.1
Author: Daniel Hjerth
Author URI: http://www.sapht.com/
Min WP Version: 3.0.0
*/

function facebook_image_suggest() {
	if (is_feed() || is_trackback() || !is_singular()) {
    	return null;
  	}
  	
	$url = get_featured_image_url();
	
	if(!is_null($url))
        printf ("<meta property=\"og:image\" content=\"%s\"/>\n", $url);
}

function get_featured_image_url() {
    if(is_single()){
        global $post;
        if (has_post_thumbnail( $post->ID )) {
            $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );
            if(0 !== strpos($image, "http://")) {
                return sprintf('http://%s/%s', get_option('home'), $image[0]);
            } else {
                return $image[0];
            }
        }
    }

    return null;
}

add_action('wp_head', 'facebook_image_suggest');
