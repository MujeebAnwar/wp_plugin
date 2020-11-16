<?php

/**
 * Fired during plugin activation
 *
 * @link       ibrar9020@gmail.com
 * @since      1.0.0
 *
 * @package    Wpcv
 * @subpackage Wpcv/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Wpcv
 * @subpackage Wpcv/includes
 * @author     Abrar <ibrar9020@gmail.com>
 */
class Wpcv_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		global $wpdb;
		$table_files     = $wpdb->prefix . "ab_user_files";
		$table_cv_files     = $wpdb->prefix . "ab_admin_cv_files";
		$table_cover_files     = $wpdb->prefix . "ab_admin_cover_files";
		$charset_collate = $wpdb->get_charset_collate();

		$query[] = "CREATE TABLE IF NOT EXISTS $table_files (
			id mediumint(9) NOT NULL AUTO_INCREMENT,
			user_id INT NOT NULL,
			file_url VARCHAR(255) NOT NULL,
			is_read TINYINT NULL,
			PRIMARY KEY (id)
		) $charset_collate;";

		$query[] = "CREATE TABLE IF NOT EXISTS $table_cv_files (
			id mediumint(9) NOT NULL AUTO_INCREMENT,
			file_url VARCHAR(255) NOT NULL,
			PRIMARY KEY (id)
		) $charset_collate;";

		$query[] = "CREATE TABLE IF NOT EXISTS $table_cover_files (
			id mediumint(9) NOT NULL AUTO_INCREMENT,
			file_url VARCHAR(255) NOT NULL,
			PRIMARY KEY (id)
		) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		foreach ($query as $key => $value) {
			dbDelta( $value );
		}

	}

}
