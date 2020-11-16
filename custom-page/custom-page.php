<?php

/**
 *Plugin Name: Custom Page
 *Description: Custom Page
 *Author: Soft Services
 *Author URI: https://www.freelancer.com/u/SoftsServices
 * Version: 1.0
 **/



function new_page_menu()
{
    add_menu_page('My Page Title', 'My Menu Title', 'manage_options', 'my-menu', 'my_menu_output','',3 );
}

function my_menu_output()
{

//    $heading = '';

     $action= $_SERVER['PHP_SELF'];
     $content='<div class="col-md-12">';
     $content.='<h1>New Posts</h1>';
     $content .= '<table class="wp-list-table widefat fixed striped table-view-list posts">';
     $content .= '<thead>';
     $content .= '<tr><th>Id</th><th>Author</th><th>Email</th></tr>';
     $content .='</thead>';
     $content .='<tbody> <tr> <td>John</td><td>Doe</td><td>john@example.com</td></tr></tbody></table>';
     $content .='</div><br>';
//     $content .='<div class="row">';
     $content .='<div class="col-md-6">';
     $content .='<form action="'.$action.'" method="POST">';
     $content .='<input type="text" name="myname" class="form-control"><br>';
     $content .='<input type="submit" name="yes" class="btn btn-primary" value="Save">';
     $content .='</div>';

    echo  $content;

}

function add_style()
{
    wp_enqueue_style( 'new_script',plugin_dir_url( __FILE__ ) .'css/custom_page.css', false, time() );

}

//if (isset($_POST['yes']))
//{
//
//
//    var_dump('exit');
//    exit();
//}
add_action( 'admin_enqueue_scripts', 'add_style');
add_action('admin_menu','new_page_menu');
//add_action( 'admin_post_nopriv_your_action_name', 'your_function_to_process_form' );