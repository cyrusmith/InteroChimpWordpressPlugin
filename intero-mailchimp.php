<?php

/**
 * Plugin Name: Interosite's MailChimp
 * Plugin URI: http://interosite.ru
 * Description: Helps creating mailchimp subscribe forms
 * Version: 1.0
 * Author: cyrusmith
 * Author URI: http://interosite.ru
 * License: GPL2
 */

defined('ABSPATH') or die("No script kiddies please!");

define('INTEROCHIMP_NONCE', 'interochimp_nonce');

require_once 'Config.php';
require_once 'SubscribeWidget.php';
require_once 'FormHandler.php';

function interochimp_scripts() {

    wp_enqueue_script(
        'intero-mainchimp-main',
        plugins_url('/js/main.js', __FILE__),
        array('jquery'), '1.0.0', true
    );

    wp_enqueue_script(
        'intero-mainchimp-custombox',
        plugins_url(InterochimpConfig::$CUSTOMBOX_JS, __FILE__),
        array('jquery'), '1.0.0', true
    );

    wp_enqueue_style(
        'intero-mainchimp-css-custombox',
        plugins_url(InterochimpConfig::$CUSTOMBOX_CSS, __FILE__)
    );

    wp_enqueue_style(
        'intero-mainchimp-css-main',
        plugins_url('/css/styles.css', __FILE__),
        array(),
        /*filemtime(__DIR__.'/css/styles.css').*/"4.0.2"
    );

    wp_localize_script( 'intero-mainchimp-main', 'InteroChimpAjax', array(
        // URL to wp-admin/admin-ajax.php to process the request
        'ajaxurl' => admin_url( 'admin-ajax.php' ),

        // generate a nonce with a unique ID "myajax-post-comment-nonce"
        // so that you can check it later when an AJAX request is sent
        'security' => wp_create_nonce(INTEROCHIMP_NONCE)
    ));
}

add_action( 'wp_enqueue_scripts', 'interochimp_scripts' );

add_action('widgets_init', function () {
    register_widget('InteroChimpSubscribeWidget');
});

if ( is_admin() ) {
    $handler = new InteroChimpFormHandler("49c7f97915c90a99bb6bbaad8ccbfd7e-us9");
    add_action('wp_ajax_interochimp_action', array($handler, 'handle'));
    add_action('wp_ajax_nopriv_interochimp_action', array($handler, 'handle'));
}


/*if(isset($_REQUEST['action']) && $_REQUEST['action']=='interochimp_action'):
    do_action( 'wp_ajax_' . $_REQUEST['action'] );
endif;*/