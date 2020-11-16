<?php
/**
 *Plugin Name: Languague
 *Description: This Plugin Send Order to Adiyso
 *Author: Soft Services
 *Author URI: https://www.freelancer.com/u/SoftsServices
 * Version: 1.0.3
 **/

function search_box_function( $nav, $args ) {


    $nav.='<div id="google_translate_element"></div>';
    $nav.="<li class='menu-header-search'><form action='http://example.com/' id='searchform' method='get'><input type='text' name='s' id='s' placeholder='Search'></form></li>";

    return $nav;
}

function hi_contour_add_css()
{
    wp_enqueue_script( 'googlw','//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit','','',true);
    wp_enqueue_script( 'googles',plugin_dir_url( __FILE__ ).'js/myjs.js', false,time(),true);


}


add_action('wp_footer', function (){



//    hi_contour_add_css();
    add_action( 'wp_enqueue_scripts', 'hi_contour_add_css');

});
add_filter('wp_nav_menu_items','search_box_function', 10, 2);

