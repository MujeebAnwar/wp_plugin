<?php
/**
 *Plugin Name: Hi Contour Shipping & Cart Text
 *Description: This Plugin Shows Shipping Information
 *Author: Hi Contour
 *Author URI: https://www.hicontour.com/
 * Version: 1.0
 **/




function hi_contour_add_css()
{
//    wp_register_style( 'myCss', );
    wp_enqueue_style( 'hi-contour',plugin_dir_url( __FILE__ ) . 'css/hi-contour-style.css', false, time() );

}

function hi_contour_cart_and_shipping_text() {

    echo '<h1 class="hi-contour-shipping-text">In Calgary 100$ and more shipping is free.<br>Less then 100$ dollars you have to pay shipping.</h1>';
}


add_action('woocommerce_checkout_before_customer_details', 'hi_contour_cart_and_shipping_text');
add_action('woocommerce_before_cart_table', 'hi_contour_cart_and_shipping_text');
add_action( 'wp_enqueue_scripts', 'hi_contour_add_css');
add_action('after_setup_theme',function (){

});