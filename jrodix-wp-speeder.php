<?php
/*
Plugin Name: WP Speeder
Plugin URI: https://www.jrodix.com
Description: WordPress sitenizin hızını artırmak için optimize edici eklenti
Version: 1.0
Author: Ömer ATABER - OmerAti 
Author URI: https://www.jrodix.com
*/


if (!defined('ABSPATH')) {
    exit;
}

require_once plugin_dir_path(__FILE__) . 'options.php';

function jrodix_remove_query_strings() {
    $options = get_option('jrodix_wp_speeder_settings');
    if (isset($options['remove_query_strings']) && !is_admin()) {
        add_filter('script_loader_src', 'jrodix_remove_query_strings_split', 15);
        add_filter('style_loader_src', 'jrodix_remove_query_strings_split', 15);
    }
}
function jrodix_remove_query_strings_split($src){
    $output = preg_split("/(&ver|\?ver)/", $src);
    return $output[0];
}
add_action('init', 'jrodix_remove_query_strings');

function jrodix_remove_emojis() {
    $options = get_option('jrodix_wp_speeder_settings');
    if (isset($options['remove_emojis'])) {
        remove_action('wp_head', 'print_emoji_detection_script', 7);
        remove_action('wp_print_styles', 'print_emoji_styles');
    }
}
add_action('init', 'jrodix_remove_emojis');


function jrodix_defer_parsing_of_js($url) {
    $options = get_option('jrodix_wp_speeder_settings');
    if (isset($options['defer_js']) && !is_user_logged_in()) {
        if (FALSE === strpos($url, '.js')) return $url;
        return "$url' defer='defer"; 
    }
    return $url;
}
add_filter('clean_url', 'jrodix_defer_parsing_of_js', 11, 1);



function jrodix_lazy_load_iframes($content) {
    $options = get_option('jrodix_wp_speeder_settings');
    if (isset($options['lazy_load_iframes']) && !is_admin()) {
        $content = preg_replace('/<iframe/', '<iframe loading="lazy"', $content);
    }
    return $content;
}
add_filter('the_content', 'jrodix_lazy_load_iframes');


function jrodix_remove_jquery_migrate($scripts) {
    $options = get_option('jrodix_wp_speeder_settings');
    if (isset($options['remove_jquery_migrate']) && !is_admin() && isset($scripts->registered['jquery'])) {
        $script = $scripts->registered['jquery'];
        if ($script->deps) { 
            $script->deps = array_diff($script->deps, array('jquery-migrate'));
        }
    }
}
add_action('wp_default_scripts', 'jrodix_remove_jquery_migrate');


function jrodix_remove_unnecessary_css() {
    $options = get_option('jrodix_wp_speeder_settings');
    if (isset($options['remove_css']) && !is_admin()) {
        wp_dequeue_style('wp-block-library');
        wp_dequeue_style('wp-block-library-theme');
        wp_dequeue_style('wc-block-style'); 
    }
}
add_action('wp_enqueue_scripts', 'jrodix_remove_unnecessary_css', 100);


function jrodix_admin_assets() {
    wp_enqueue_style('jrodix-admin-styles', plugin_dir_url(__FILE__) . 'css/admin-styles.css');
    wp_enqueue_script('jrodix-admin-scripts', plugin_dir_url(__FILE__) . 'js/admin-scripts.js', array(), null, true);
}
add_action('admin_enqueue_scripts', 'jrodix_admin_assets');


function jrodix_convert_to_webp($attachment_id) {
    $mime_type = get_post_mime_type($attachment_id);
    if ($mime_type == 'image/jpeg' || $mime_type == 'image/png') {
        $file_path = get_attached_file($attachment_id);
        $webp_file_path = preg_replace('/\\.[^.\\s]{3,4}$/', '', $file_path) . '.webp';
        if (function_exists('imagewebp')) {
            $image = wp_get_image_editor($file_path);
            if (!is_wp_error($image)) {
                $image->set_quality(80); 
                $image->save($webp_file_path, 'image/webp');
            }
        }
    }
}
add_action('add_attachment', 'jrodix_convert_to_webp');


?>
