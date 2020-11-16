<?php

/**
 *Plugin Name: New Option
 *Description: New Options
 *Author: Soft Services
 *Author URI: https://www.freelancer.com/u/SoftsServices
 * Version: 1.0.0
 **/



class My_Custom_Widget extends WP_Widget {

    // Main constructor
    public function __construct() {
        parent::__construct(
            'my_custom_widget',
            __( 'My Custom Widget', 'text_domain' ),
            array(
                'customize_selective_refresh' => true,
            )
        );
    }

    // The widget form (for the backend )
    public function form( $instance ) {
        /* ... */
    }

    // Update widget settings
    public function update( $new_instance, $old_instance ) {
        /* ... */
    }

    // Display the widget
    public function widget( $args, $instance ) {
        $finalurl = get_permalink( get_page_by_path( 'search' ) );
        $content='<div class="row">';
        $content.='<div class="col-md-12">';
        $content.='<form id="ss_search_from" method="GET" action="'.$finalurl.'">';
        $content.='<input type="text" id="ss_search" class="form-control" name="custom_search" placeholder="Search for an Product or Influencers">';
        $content.='<input type="submit" class="btn" id="ss_submit_btn" value="Search" style="">';
        $content.='</form></div></div>';
        echo $content;
    }

}

// Register the widget
function my_register_custom_widget() {
    register_widget( 'My_Custom_Widget' );
}
function myplugin_register_settings() {

    add_option( 'bbb_url', 'Url');
    add_option( 'bbb_secret', 'Secret');
    register_setting( 'myplugin_options_group', 'bbb_url', 'myplugin_callback' );
    register_setting( 'myplugin_options_group', 'bbb_secret', 'myplugin_callback' );
}
function my_option_page()
{
    echo get_option('bbb_url');
    echo get_option('bbb_secret');
}
function myplugin_register_options_page() {

    add_menu_page('Options Pages','BBB Options','manage_options','rooms','my_option_page','',3);
    add_options_page('Page Title', 'Plugin Menu', 'manage_options', 'myplugin', 'myplugin_options_page');
}

function myplugin_options_page()
{?>
 <div>
<!--  --><?php // screen_icon(); ?>
     <h2>My Plugin Page Title</h2>
     <form method="post" action="options.php">
         <?php settings_fields( 'myplugin_options_group' ); ?>
      <h3>This is my option</h3>
      <p>Some text here.</p>
      <table class="form-table">
          <tr>
              <th scope="row"><label for="myplugin_option_name">Url</label></th>
              <td>
                  <input type="text" class="regular-text" id="myplugin_option_name" name="bbb_url" value="<?php echo get_option('bbb_url'); ?>" />
              </td>
          </tr>
          <tr>
              <th scope="row"><label for="myplugin_option_name">Secret</label></th>
              <td>
                  <input type="text" class="regular-text" id="myplugin_option_name" name="bbb_secret" value="<?php echo get_option('bbb_secret'); ?>" />
              </td>
          </tr>
      </table>
         <?php  submit_button(); ?>
     </form>
 </div>
<?php
}


add_action('admin_menu', 'myplugin_register_options_page');
add_action( 'admin_init', 'myplugin_register_settings' );
add_action( 'widgets_init', 'my_register_custom_widget' );