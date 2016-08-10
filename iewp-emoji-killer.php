<?php
if ( ! defined( 'WPINC' ) ) { die('Direct access prohibited!'); }
/**
 * Plugin Name: IEWP Emoji Killer
 * Plugin URI: https://github.com/corenominal/iewp-emoji-killer
 * Description: This WordPress plugin disables all emoji and smiley conversions.
 * Author: Philip Newborough
 * Version: 0.0.1
 * Author URI: https://corenominal.org
 */
function iewp_emoji_killer_activate()
{
    update_option( 'use_smilies', false );
}
register_activation_hook( __FILE__, 'iewp_emoji_killer_activate' );

function iewp_disable_emojis()
{
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_action( 'admin_print_styles', 'print_emoji_styles' );
    remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
    remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
    remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
    add_filter( 'tiny_mce_plugins', 'iewp_disable_emojis_tinymce' );
}
add_action( 'init', 'iewp_disable_emojis' );

function iewp_disable_emojis_tinymce( $plugins )
{
    if ( is_array( $plugins ) )
    {
        return array_diff( $plugins, array( 'wpemoji' ) );
    }
    else
    {
        return array();
    }
}
