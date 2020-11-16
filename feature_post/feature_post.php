<?php
/**
 *Plugin Name: Feature Plugin
 *Description: This Plugin Send Order to Adiyso
 *Author: Soft Services
 *Author URI: https://www.freelancer.com/u/SoftsServices
 * Version: 1.0
 **/


function add_publish_meta_options($post_obj) {

    global $post;

    $value = get_post_meta($post_obj->ID, 'check_meta', true); // If saving value to post_meta
    echo  '<div class="misc-pub-section misc-pub-section-last">'
        .'<label>Check meta <input type="checkbox"' . (!empty($value) ? ' checked="checked" ' : null) . ' value="1" name="check_meta" /> </label>'
        .'</div>';

}
function extra_publish_options_save($post_id, $post, $update) {


    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return false;
    if ( !current_user_can( 'edit_page', $post_id ) ) return false;
    if(empty($post_id)) return false;

    if (isset($_POST['action']))
    {
        if($_POST['action'] == 'editpost'){
            delete_post_meta($post_id, 'check_meta');
        }
        add_post_meta($post_id, 'check_meta', $_POST['check_meta']);
    }




}


function filter_manage_posts_columns( $posts_columns, $post_type ) {
    $posts_columns['feature'] = __( 'Feature', '1' );
    $posts_columns['newfeature'] = __( 'newfeature', '2' );
    return $posts_columns;
};

function display_posts_stickiness( $column, $post_id ) {
    $meta = get_post_meta($post_id);
    $content ='<input type="checkbox" disabled ';
    $content .=!empty($meta["check_meta"][0]) ? "Checked":"";
    $content.='/>';
    $content.='<input value="adsa">';
    // $con = '<input type="checkbox" disabled',!empty($meta["check_meta"][0])?'checked':'','/>';
// $content ='<input type="checkbox" disabled' !empty($meta["check_meta"][0]) ? 'checked':'',/>';
    echo $content;

}

add_action( 'manage_posts_custom_column' , 'display_posts_stickiness', 10, 2 );
add_filter( 'manage_posts_columns', 'filter_manage_posts_columns', 10, 2 );
add_action('save_post', 'extra_publish_options_save', 10 , 3);
add_action('post_submitbox_misc_actions', 'add_publish_meta_options');