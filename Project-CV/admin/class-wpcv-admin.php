<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       ibrar9020@gmail.com
 * @since      1.0.0
 *
 * @package    Wpcv
 * @subpackage Wpcv/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wpcv
 * @subpackage Wpcv/admin
 * @author     Abrar <ibrar9020@gmail.com>
 */
class Wpcv_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wpcv_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wpcv_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wpcv-admin.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'datatable-css', 'https://cdn.datatables.net/v/dt/dt-1.10.22/datatables.min.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wpcv_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wpcv_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wpcv-admin.js', array( 'jquery' ), $this->version, false );
		wp_localize_script( $this->plugin_name, 'my_ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
		
		wp_enqueue_script( 'datatable-js', 'https://cdn.datatables.net/responsive/2.2.6/js/dataTables.responsive.min.js', array( 'jquery' ), $this->version, false );

	}

	public function ab_admin_menu(){

		add_menu_page(
			__( 'Files' ),
			__( 'Review Requests' ),
			'manage_options',
			'review-requests',
			array( $this, 'ab_admin_page_contents' ),
			'dashicons-schedule',
			3
		);

		add_menu_page(
			__( 'CVs Templates' ),
			__( 'CVs Templates' ),
			'manage_options',
			'cv-template',
			array( $this, 'ab_cv_contents' ),
			'dashicons-schedule',
			3
		);

		add_menu_page(
			__( 'Cover Templates' ),
			__( 'Cover Templates' ),
			'manage_options',
			'cover-templates',
			array( $this, 'ab_cover_contents' ),
			'dashicons-schedule',
			3
		);
	}

	public function ab_admin_page_contents(){

		global $wpdb;
		echo "<h2>WELCOME</h2>";

		$data    = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}ab_user_files" );
		$content = '<div class="col-md-12">';
		$content .= '<table id="abcvFileTable" class="wp-list-table widefat fixed striped table-view-list posts"><thead><th>User ID</th><th>File</th><th>Reviewed</th></thead><tbody>';

		foreach( $data as $key => $record ){
			$content .= "<tr>";
			$content .= "<td>{$record->user_id}</td><td><a target='_blank' href='{$record->file_url}'><button class='button button-primary'>File</button></a></td>";
			if( $record->is_read == 0 ){
				$content .= "<td><button id='{$record->id}' class='button button-primary abIsRead'>Reviewed</button></td>";
			}
			if( $record->is_read == 1 ){
				$content .= "<td><button id='{$record->id}' class='button abIsNotRead'>Not Reviewed</button></td>";
			}
			$content .= "</tr>";
		}
		$content .= '</tbody></table>';
        $content .= '</div>';

		echo $content;
	}


	public function ab_is_reviewed( ){

		if( isset( $_POST['ab_is_read_id'] ) ){
			$id = $_POST['ab_is_read_id'];

			global $wpdb;
			$wpdb->query( $wpdb->prepare( "UPDATE {$wpdb->prefix}ab_user_files SET is_read = %d WHERE id=%d", 1, $id ) );

			echo json_encode( array( "status" => 200 ) );
		}
		wp_die();
	}

	public function ab_is_not_reviewed( ){

		if( isset( $_POST['ab_is_not_read_id'] ) ){
			$id = $_POST['ab_is_not_read_id'];

			global $wpdb;
			$wpdb->query( $wpdb->prepare( "UPDATE {$wpdb->prefix}ab_user_files SET is_read = %d WHERE id=%d", 0, $id ) );

			echo json_encode( array( "status" => 200 ) );
		}
		wp_die();
	}

	public function ab_cv_delete(  ){
		
		if( isset( $_POST['ab_cv_delete_id'] ) ){
			$id = $_POST['ab_cv_delete_id'];

			global $wpdb;
			$wpdb->query( $wpdb->prepare( "DELETE FROM {$wpdb->prefix}ab_admin_cv_files WHERE id=%d", $id ) );

			echo json_encode( array( "status" => 200 ) );
		}
		wp_die();
	}

	public function ab_cover_delete(  ){
		
		if( isset( $_POST['ab_cover_delete_id'] ) ){
			$id = $_POST['ab_cover_delete_id'];

			global $wpdb;
			$wpdb->query( $wpdb->prepare( "DELETE FROM {$wpdb->prefix}ab_admin_cover_files WHERE id=%d", $id ) );

			echo json_encode( array( "status" => 200 ) );
		}
		wp_die();
	}

	public function ab_cv_contents(  ){

		global $wpdb;
		$content = "<h2>Upload a new CV template</h2>";

		$content .= '  <form action="" enctype="multipart/form-data" method="post">
		<input id="fileToUpload" name="fileToUpload" type="file"> 
		<input name="abwpcv_admin_cv_file" type="submit" value="Upload File">
		  </form>';

		$data = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}ab_admin_cv_files" );

		$content .= "<h2>Current Files</h2>";
		$content .= '<table id="abcvFileTable"></thead><th>ID</th><th>File</th><th>Delete</th></thead><tbody>';

		foreach( $data as $key => $record ){
			$content .= "<tr>";
			$content .= "<td>{$record->id}</td><td><a target='_blank' href='{$record->file_url}'><button class='button button-primary'>File</button></a></td>";
			$content .= "<td><button id='{$record->id}' class='button button-primary abCvDelete'>Delete</button></td>";
			$content .= "</tr>";
		}
		$content .= '</tbody></table>';

		  
		echo $content;
	}

	public function ab_cover_contents(  ){
		
		global $wpdb;
		$content = "<h2>Upload a new Cover template</h2>";

		$content .= '  <form action="" enctype="multipart/form-data" method="post">
		<input id="fileToUpload" name="fileToUpload" type="file"> 
		<input name="abwpcv_admin_cover_file" type="submit" value="Upload File">
		  </form>';

		$data = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}ab_admin_cover_files" );

		$content .= "<h2>Current Files</h2>";
		$content .= '<table id="abcvFileTable"></thead><th>ID</th><th>File</th><th>Delete</th></thead><tbody>';

		foreach( $data as $key => $record ){
			$content .= "<tr>";
			$content .= "<td>{$record->id}</td><td><a target='_blank' href='{$record->file_url}'><button class='button button-primary'>File</button></a></td>";
			$content .= "<td><button id='{$record->id}' class='button button-primary abCoverDelete'>Delete</button></td>";
			$content .= "</tr>";
		}
		$content .= '</tbody></table>';

		echo $content;
	}

	public function ab_admin_init(){

		if (isset($_POST['abwpcv_admin_cv_file'])) {     
			
			$upload = wp_upload_bits($_FILES['fileToUpload']['name'], null, file_get_contents($_FILES['fileToUpload']['tmp_name']));
			if( $upload ){
				
				global $wpdb;
				$wpdb->query( $wpdb->prepare( "INSERT INTO {$wpdb->prefix}ab_admin_cv_files(file_url) VALUES(%s)", $upload['url'] ) );

			}
		}

		if (isset($_POST['abwpcv_admin_cover_file'])) {     
			
			$upload = wp_upload_bits($_FILES['fileToUpload']['name'], null, file_get_contents($_FILES['fileToUpload']['tmp_name']));
			if( $upload ){
				
				global $wpdb;
				$wpdb->query( $wpdb->prepare( "INSERT INTO {$wpdb->prefix}ab_admin_cover_files(file_url) VALUES(%s)", $upload['url'] ) );

			}
		}
	}


}
