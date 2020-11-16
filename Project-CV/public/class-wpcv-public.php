<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       ibrar9020@gmail.com
 * @since      1.0.0
 *
 * @package    Wpcv
 * @subpackage Wpcv/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Wpcv
 * @subpackage Wpcv/public
 * @author     Abrar <ibrar9020@gmail.com>
 */
class Wpcv_Public {

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

	private $error;
	private $success;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		$this->ab_shortcodes();

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wpcv-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wpcv-public.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Method to add shortcodes
	 *
	 * @return void
	 */
	public function ab_shortcodes(){

		add_shortcode( 'csf', array( $this, 'ab_csf' ) );
		add_shortcode( 'ab_registration_form', array( $this, 'ab_reg_form' ) );
		add_shortcode( 'ab_wpcv', array( $this, 'ab_wpcv' ) );
		add_shortcode( 'ab_wpcv_upload', array( $this, 'ab_wpcv_upload' ) );
		add_shortcode( 'ab_wpcv_plans', array( $this, 'ab_wpcv_plans' ) );
		add_shortcode( 'ab_wpcv_allplans', array( $this, 'ab_wpcv_allplans' ) );
		add_shortcode( 'ab_wpcv_dashboard', array( $this, 'ab_wpcv_dashboard' ) );
		add_shortcode( 'ab_wpcv_templates', array( $this, 'ab_wpcv_templates' ) );
		add_shortcode( 'ab_wpcv_cv_templates', array( $this, 'ab_wpcv_cv_templates' ) );
		add_shortcode( 'ab_wpcv_cover_templates', array( $this, 'ab_wpcv_cover_templates' ) );
		add_shortcode( 'ab_wpcv_thank_you', array( $this, 'ab_wpcv_thank_you' ) );
	}

	/**
	 * Method to add password field in WPCF7
	 *
	 * @param [type] $atts
	 * @param [type] $content
	 * @return void
	 */
	public function ab_csf( $atts, $content = null ){

		extract(shortcode_atts(array( "id" => "", "title" => "", "pwd" => "" ), $atts));

		if(empty($id) || empty($title)) return "";

		$cf7 = do_shortcode('[contact-form-7 404 "Not Found"]');

		$pwd = explode(',', $pwd);
		foreach($pwd as $p) {
			$p = trim($p);

			$cf7 = preg_replace('/<input type="text" name="' . $p . '"/usi', '<input type="password" name="' . $p . '"', $cf7);
		}

		return $cf7;
	}

	/**
	 * Method to add HTML of the registration form
	 *
	 * @return string
	 */
	public function ab_reg_form(){

		$content = '';

		$content .= '<h2>'.__( 'Register' ).'</h2>';
		if( isset( $this->success['success_register'] ) ){
			$content .= $this->success['success_register'];
		}
		
		$content .= '<form method="post" action="#">';

		$content .= '<p>'.__('Name').'</p>';
		$content .= '<input type="text" name="ab_name" class="" required />';
		
		if( isset( $this->error['username_space'] ) ){
			$content .= '<p class="valid_error">'.$this->error['username_space'].'</p>';
		}
		if( isset( $this->error['username_empty'] ) ){
			$content .= '<p class="valid_error">'.$this->error['username_empty'].'</p>';
		}
		if( isset( $this->error['username_exist'] ) ){
			$content .= '<p class="valid_error">'.$this->error['username_exist'].'</p>';
		}

		$content .= '<p>'.__('Phone Number').'</p>';
		$content .= '<input type="number" name="ab_phone" class="" required />';
		if( isset( $this->error['empty_phone'] ) ){
			$content .= '<p class="valid_error">'.$this->error['empty_phone'].'</p>';
		}
		if( isset( $this->error['numeric_phone'] ) ){
			$content .= '<p class="valid_error">'.$this->error['numeric_phone'].'</p>';
		}

		$content .= '<p>'.__('Email').'</p>';
		$content .= '<input type="email" name="ab_email" class="" required />';
		if( isset( $this->error['email_empty'] ) ){
			$content .= '<p class="valid_error">'.$this->error['email_empty'].'</p>';
		}
		if( isset( $this->error['email_existence'] ) ){
			$content .= '<p class="valid_error">'.$this->error['email_existence'].'</p>';
		}
		if( isset( $this->error['email_valid'] ) ){
			$content .= '<p class="valid_error">'.$this->error['email_valid'].'</p>';
		}

		$content .= '<p>'.__('Confirm Email').'</p>';
		$content .= '<input type="email" name="ab_conf_email" class="" required />';
		if( isset( $this->error['conf_email_empty'] ) ){
			$content .= '<p class="valid_error">'.$this->error['conf_email_empty'].'</p>';
		}
		if( isset( $this->error['conf_email_valid'] ) ){
			$content .= '<p class="valid_error">'.$this->error['conf_email_valid'].'</p>';
		}
		if( isset( $this->error['email_match'] ) ){
			$content .= '<p class="valid_error">'.$this->error['email_match'].'</p>';
		}

		$content .= '<p>'.__('City').'</p>';
		$content .= '<input type="text" name="ab_city" class="" required />';
		if( isset( $this->error['empty_city'] ) ){
			$content .= '<p class="valid_error">'.$this->error['empty_city'].'</p>';
		}
		if( isset( $this->error['valid_city'] ) ){
			$content .= '<p class="valid_error">'.$this->error['valid_city'].'</p>';
		}

		$content .= '<p>'.__('Country').'</p>';
		$content .= '<input type="text" name="ab_country" class="" required />';
		if( isset( $this->error['empty_country'] ) ){
			$content .= '<p class="valid_error">'.$this->error['empty_country'].'</p>';
		}
		if( isset( $this->error['valid_country'] ) ){
			$content .= '<p class="valid_error">'.$this->error['valid_country'].'</p>';
		}

		$content .= '<p>'.__('University').'</p>';
		$content .= '<input type="text" name="ab_uni" class="" />';

		$content .= '<p>'.__('Speciality').'</p>';

		$content .= '<p>'.__('Password').'</p>';
		$content .= '<input type="password" name="ab_pass" class="" required />';

		$content .= '<p>'.__('Confirm Password').'</p>';
		$content .= '<input type="password" name="ab_conf_pass" class="" required />';

		$content .= '<input type="submit" name="ab_regform_submit" class="button button-primary" value="'.__('Register').'" />';

		$content .= '</form>';

		return $content;
	}

	/**
	 * Method to validate and register a user
	 */
	public function ab_conf_user(){

		if( $_POST && isset( $_POST['ab_regform_submit'] ) ){

			$username      = sanitize_user($_POST['ab_name']);
			$email         = sanitize_email($_POST['ab_email']);
			$conf_email    = sanitize_email( $_POST['ab_conf_email'] );
			$phone         = $_POST['ab_phone'];
			$city          = sanitize_text_field( $_POST['ab_city'] );
			$country       = sanitize_text_field( $_POST['ab_country'] );
			$password      = $_POST['ab_pass'];
			$conf_password = $_POST['ab_conf_pass'];

			if( isset( $_POST['ab_uni'] ) ){
				$uni = sanitize_text_field( $_POST['ab_uni'] );
			}

			if( isset( $_POST['ab_speciality'] ) ){
				$speciality = sanitize_text_field( $_POST['ab_speciality'] );
			}
	   
			$this->error = array();
	   
			if(strpos($username,' ')!==FALSE){
			  $this->error['username_space']="username has space";
			}
	   
			if(empty($username)){
				$this->error['username_empty']="username needed";
			}
			if(username_exists($username)){
			$this->error['username_exist']="username already exists";
			}
	   
		 	if(!is_email($email)){
			 $this->error['email_valid']="enter valid email id";
			}
			if(empty($email)){
				$this->error['email_empty']="Email is required.";
			}
			if( $email !== $conf_email ){
				$this->error['email_match']="Emails are not identical";
			}
	   
			if(email_exists($email)){
			 $this->error['email_existence']="email already exists";
			}

			if(!is_email($conf_email)){
				$this->error['conf_email_valid']="enter valid email id";
			}
			if(empty($conf_email)){
				$this->error['conf_email_empty']="Email is required.";
			}

			if( $password !== $conf_password ){
				$this->error['conf_pass'] = "Password not matched";
			}

			if( empty( $phone ) ){
				$this->error['empty_phone'] = "Phone number is required.";
			}

			if( !is_numeric( $phone ) ){
				$this->error['numeric_phone'] = "Phone number should be numeric only.";
			}

			if( empty( $city ) ){
				$this->error['empty_city'] = "City is required.";
			}
			if( !preg_match( '/[A-Za-z]/', $city ) ){
				$this->error['valid_city'] = "City should only contain letters.";
			}

			if( empty( $country ) ){
				$this->error['empty_country'] = "Country is required.";
			}
			if( !preg_match( '/[A-Za-z]/', $country ) ){
				$this->error['valid_country'] = "Country should only contain letters.";
			}
	   
			if(count($this->error)==0) {

				$pwd = 'ABcv' . rand( 1111, 9999 );
				$user_id = wp_create_user($username,$pwd,$email);
		
				wp_new_user_notification($user_id);

				update_user_meta( $user_id, 'phone', $phone );
				update_user_meta( $user_id, 'city', $city );
				update_user_meta( $user_id, 'country', $country );
				update_user_meta( $user_id, 'ab_pass', $password );

				if( $uni ){
					update_user_meta( $user_id, 'university', $uni );
				}
				if( $speciality ){
					update_user_meta( $user_id, 'speciality', $speciality );
				}

				$code = md5(time());
		
				// make it into a code to send it to user via email
				$string = array('id'=>$user_id, 'code'=>$code);
				
				// create the activation code and activation status
				update_user_meta($user_id, 'account_activated', 0);
				update_user_meta($user_id, 'activation_code', $code);
				
				// create the url
				$url = get_site_url(). '/?act=' .base64_encode( serialize($string));

				update_user_meta( $user_id, 'urlcf', $url );
				
				// basically we will edit here to make this nicer
				$html = 'Please click the following links <br/><br/> <a href="'.$url.'">'.$url.'</a>';
				
				$headers = array('Content-Type: text/html; charset=UTF-8');

				// send an email out to user
				wp_mail( $email, __( '[CV] Confirm Your Account' ) , $html, $headers );

				$this->success = array();
				$this->success['success_register'] = "<h2 class='register_success'>". __( 'Confirmation mail sent to your email.') . "</h2>";
				
			}
	   }
	}

	/**
	 * Method to generate and send a confirmation link to registered user's email
	 */
	public function ab_user_registration( $user_id ){

		// get user data
		$user_info = get_userdata($user_id);

		// create md5 code to verify later
		$code = md5(time());
		
		// make it into a code to send it to user via email
		$string = array('id'=>$user_id, 'code'=>$code);
		
		// create the activation code and activation status
		update_user_meta($user_id, 'account_activated', 0);
		update_user_meta($user_id, 'activation_code', $code);
		
		// create the url
		$url = get_site_url(). '/?act=' .base64_encode( serialize($string));

		update_user_meta( $user_id, 'urlcf', $url );
		
		// basically we will edit here to make this nicer
		$html = 'Please click the following links <br/><br/> <a href="'.$url.'">'.$url.'</a>';
		
		// send an email out to user
		wp_mail( $user_info->user_email, __( 'Email Subject' ) , $html);
	}

	public function public_init(){

		$this->ab_verify_user_code();
		// $this->ab_verify_payment();

	}

	/**
	 * Method to process,validate payment and generate Cookie
	 *
	 * @return void
	 */
	public function ab_verify_payment(){

        if( isset( $_GET['tx'] ) ){
            $pp_hostname = "www.sandbox.paypal.com";

        	// read the post from PayPal system and add 'cmd'
			$req = 'cmd=_notify-synch';
    		$tx_token = $_GET['tx'];
    		$auth_token = "-DmkMO3tNbOCLJVW6IOZqBaMAc7Y1R2U6wdI_ocfJAZG7JyR5ZHC4hVbUwu";
    		$req .= "&tx=$tx_token&at=$auth_token";
    		
    		$ch = curl_init();
    		curl_setopt($ch, CURLOPT_URL, "https://$pp_hostname/cgi-bin/webscr");
    		curl_setopt($ch, CURLOPT_POST, 1);
    		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    		curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
    		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
			
			//set cacert.pem verisign certificate path in curl using 'CURLOPT_CAINFO' field here,
    		//if your server does not bundled with default verisign certificates.
    		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Host: $pp_hostname"));
    		$res = curl_exec($ch);
    		curl_close($ch);

    		if(!$res){
    			//HTTP ERROR
			}
			else{

    			 // parse the data
    			$lines = explode("\n", trim($res));
				$keyarray = array();
				
    			if (strcmp ($lines[0], "SUCCESS") == 0) {
    				for ($i = 1; $i < count($lines); $i++) {
    					$temp = explode("=", $lines[$i],2);
    					$keyarray[urldecode($temp[0])] = urldecode($temp[1]);
					}
					
					// check the payment_status is Completed
					// check that txn_id has not been previously processed
					// check that receiver_email is your Primary PayPal email
					// check that payment_amount/payment_currency are correct
					// process payment
					
					fc_write_log( $keyarray );
					echo "<pre>";
					print_r( $keyarray );
					echo "</pre>";
					
    			}
    			else if (strcmp ($lines[0], "FAIL") == 0) {
    				// log for manual investigation
    			}
    		}
        }

	}

	/**
	 * Method to verify the user from the email confirmation link
	 */
	public function ab_verify_user_code(){

		if(isset($_GET['act'])){

			$data = unserialize(base64_decode($_GET['act']));
			$code = get_user_meta($data['id'], 'activation_code', true);
			
			// verify whether the code given is the same as ours
			if( $code == $data['code'] ){
				
				$user_id = $data['id'];

				// update the user meta
				update_user_meta($data['id'], 'is_activated', 1);
				$pwd = get_user_meta( $user_id, 'ab_pass', true );
				wp_set_password( $pwd, $user_id );

				$login_url = site_url( 'wp-login.php' );

				echo "<h2>".__("SUCCESS. Please return to the site for login.")."</h2><a href='{$login_url}'>".__( "Login Page" )."</a>";
				die;

			}
		}

		if (isset($_POST['abwpcv_file'])) {     
			
			$upload = wp_upload_bits($_FILES['fileToUpload']['name'], null, file_get_contents($_FILES['fileToUpload']['tmp_name']));
			if( $upload ){
				
				global $wpdb;
				$user = wp_get_current_user();
				$wpdb->query( $wpdb->prepare( "INSERT INTO {$wpdb->prefix}ab_user_files(user_id, file_url, is_read) VALUES(%d, %s, %d)", $user->ID, $upload['url'], 0 ) );

				$this->success = array();
				$this->success['success_upload'] = "<h2 class='upload_success'>". __( 'File has been successfully uploaded') . "</h2>";

			} else{
				$this->success = array();
				$this->success['success_upload'] = "<h2 class='upload_fail'>". __( 'File cannot be uploaded.') . "</h2>";
			}
		}
	}

	/**
	 * Short code for the main page
	 */
	public function ab_wpcv(  ){

		$content = '';

		$content .= '<div>';
		$content .= '<a href="http://localhost/cv/revise-cv-cover-letter/"><button name="ab_upload_cv" class="button button-primary ab_pad">'.__( 'CV/COVER LETTER UPLOAD' ).'</button></a></div><br><br>';

		$content .= '<div>';
		$content .= '<a href="http://localhost/cv/plans/"><button name="ab_membership" class="button button-primary ab_pad">'.__( 'MEMBERSHIP' ).'</button></a></div>';

		return $content;

	}

	/**
	 * Modify the logo on the login page
	 */
	public function ab_login_logo(  ){
		?>
		<style type="text/css">
        #login h1 a, .login h1 a {
            background-image: url(<?php echo plugin_dir_url( __DIR__ )."images/cvlogo.jpeg" ?>);
			height:150px;
			width:320px;
			background-size: 320px 150px;
			background-repeat: no-repeat;
        	padding-bottom: 2px;
        }
    	</style>
		<?php
	}

	/**
	 * Short code to upload CV/Cover Letter
	 */
	public function ab_wpcv_upload(  ){

		$content = '';
		$content .= '<h2 class="ab_heading">'.__("Upload Your Documents to be revised").'</h2>';
		if( isset( $this->success['success_upload'] ) ){
			$content .= $this->success['success_upload'];
		}
		$content .= '  <form action="" enctype="multipart/form-data" method="post">
		<input id="fileToUpload" name="fileToUpload" type="file"> 
		<input name="abwpcv_file" type="submit" value="Upload File">
	  	</form><span class="ab_money">$'.__("3").'</span>';

		$user = wp_get_current_user();
		if( ! $user->ID == 0 ){
			$content .= "<h2 >". __( "Dear " ).$user->data->user_login."</h2>";
		} else{
			$content .= "<h2 >". __( "Dear User" ) ."</h2>";
		}

		$content .= "<p>". __( "This submission is not final once your order accepted, we will send you an email to pay the total amount in 2 days or it will cancel." ) ."</p>";

		return $content;
	}

	/**
	 * Method to list all the plans
	 */
	public function ab_wpcv_plans(  ){

		$content = '';
		$content .= '<h2 >'. __("Welcome to our app choose one of the following plans") .'</h2>';

		$content .= '<button class="button button-primary">'. __("Basic(Free)") .'</button><br><br>';
		$content .= '<button class="button button-primary">'. __("Limited ($5/weekly)") .'</button><br><br>';
		$content .= '<button class="button button-primary">'. __("Full access($10/weekly)") .'</button><br><br>';
		$content .= '<a href="http://localhost/cv/all-plans/"><button class="button button-primary">'. __("Show All Plans") .'</button></a>';

		return $content;
	}

	/**
	 * Method to show all the plans
	 *
	 * @return void
	 */
	public function ab_wpcv_allplans(){

		$content = '';
		
		$user = wp_get_current_user();
		if( ! $user->ID == 0 ){
			$content .= "<h2 >". __( "Welcome " ).$user->data->user_login."</h2>";
		} else{
			$content .= "<h2 >". __( "Welcome User" ) ."</h2>";
		}
		$content .= '<table><thead><th>'. __("Features") .'</th><th>'. __("Basic") .'</th><th>'. __("Limited") .'</th><th>'. __("Full-Access") .'</th></thead>';
		$content .= '<tbody><tr><td>'. __("Directory") .'</td><td>'. __("Yes") .'</td><td>'. __("Yes") .'</td><td>'. __("Yes") .'</td></tr>';
		$content .= '<tr><td>'. __("Search & filter the directory") .'</td><td>'. __("No") .'</td><td>'. __("Yes") .'</td><td>'. __("Yes") .'</td></tr>';
		$content .= '<tr><td>'. __("Cvs and cover letters") .'</td><td>'. __("No") .'</td><td>'. __("2 CVs") .'</td><td>'. __("All") .'</td></tr>';
		$content .= '<tr><td>'. __("Learn work skills") .'</td><td>'. __("No") .'</td><td>'. __("No") .'</td><td>'. __("Yes") .'</td></tr>';
		$content .= '<tr><td></td><td><button>'. __("Choose") .'</button></td><td><button>'. __("Choose") .'</button></td><td><button>'. __("Choose") .'</button></td></tr></tbody></table>';

		return $content;
	}

	public function ab_wpcv_dashboard(  ){
		
		$content = '';
		$user = wp_get_current_user();
		if( ! $user->ID == 0 ){
			$content .= '<h2 >'. __("Welcome ").$user->data->user_login .'</h2><br>';
		} else{
			$content .= "<h2 >". __( "Welcome User" ) ."</h2>";
		}

		$content .= '<button class="button button-primary">'. __("Directory") .'</button><br><br>';
		$content .= '<a href="http://localhost/cv/templates/"><button class="button button-primary">'. __("CV & Cover letter Templates") .'</button></a><br><br>';
		$content .= '<button class="button button-primary">'. __("Learning work skills") .'</button><br><br>';

		return $content;
	}

	public function ab_wpcv_templates(){

		$content = '';
		$user = wp_get_current_user();
		if( ! $user->ID == 0 ){
			$content .= '<h2 >'. __("Welcome ").$user->data->user_login .'</h2>';
		} else{
			$content .= "<h2 >". __( "Welcome User" ) ."</h2>";
		}

		$content .= '<button class="button button-primary">'. __("CVs") .'</button><br><br>';
		$content .= '<button class="button button-primary">'. __("Cover Letters") .'</button><br><br>';

		return $content;
	}

	public function ab_wpcv_cv_templates(  ){
		
		global $wpdb;
		$content = '';
		$user = wp_get_current_user();
		if( ! $user->ID == 0 ){
			$content .= '<h2 >'. __("Welcome ").$user->data->user_login .'</h2>';
		} else{
			$content .= "<h2 >". __( "Welcome User" ) ."</h2>";
		}

		$data = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}ab_admin_cv_files" );
		$i = 1;
		foreach ($data as $key => $value) {
			$content .= "<button class='button button-primary' href='{$value->file_url}'>". __("CV Template {$i}") ."</button><br><br>";
			$i ++;	
		}

		return $content;
	}

	public function ab_wpcv_cover_templates(  ){
		
		global $wpdb;
		$content = '';
		$user = wp_get_current_user();
		if( ! $user->ID == 0 ){
			$content .= '<h2 >'. __("Welcome ").$user->data->user_login .'</h2>';
		} else{
			$content .= "<h2 >". __( "Welcome User" ) ."</h2>";
		}

		$data = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}ab_admin_cover_files" );
		$i = 1;
		foreach ($data as $key => $value) {
			$content .= "<button class='button button-primary' href='{$value->file_url}'>". __("Cover Template {$i}") ."</button><br><br>";
			$i ++;	
		}

		return $content;
	}

	public function ab_wpcv_thank_you(){

		global $wpdb;

		$content = '';
		$user    = wp_get_current_user();
		$user_id = $user->ID;

		if( isset( $_GET['tx'] ) ){
            $pp_hostname = "www.sandbox.paypal.com";

        	// read the post from PayPal system and add 'cmd'
			$req = 'cmd=_notify-synch';
    		$tx_token = $_GET['tx'];
    		$auth_token = "-DmkMO3tNbOCLJVW6IOZqBaMAc7Y1R2U6wdI_ocfJAZG7JyR5ZHC4hVbUwu";
    		$req .= "&tx=$tx_token&at=$auth_token";
    		
    		$ch = curl_init();
    		curl_setopt($ch, CURLOPT_URL, "https://$pp_hostname/cgi-bin/webscr");
    		curl_setopt($ch, CURLOPT_POST, 1);
    		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    		curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
    		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
			
			//set cacert.pem verisign certificate path in curl using 'CURLOPT_CAINFO' field here,
    		//if your server does not bundled with default verisign certificates.
    		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Host: $pp_hostname"));
    		$res = curl_exec($ch);
    		curl_close($ch);

    		if(!$res){
    			//HTTP ERROR
			}
			else{

    			 // parse the data
    			$lines = explode("\n", trim($res));
				$keyarray = array();
				
    			if (strcmp ($lines[0], "SUCCESS") == 0) {
    				for ($i = 1; $i < count($lines); $i++) {
    					$temp = explode("=", $lines[$i],2);
    					$keyarray[urldecode($temp[0])] = urldecode($temp[1]);
					}
					

					$txn_id = get_user_meta( $user_id, 'ab_txn_id', true );

					// check the payment_status is Completed
					// check that txn_id has not been previously processed
					// check that receiver_email is your Primary PayPal email
					// check that payment_amount/payment_currency are correct
					// process payment
					if( !empty( $txn_id ) && $txn_id == $keyarray['txn_id'] ){

						return '<h2>This transaction have already been processed.</h2>';

					} else{
						
						if( $keyarray['payment_status'] == 'Completed' && $keyarray['receiver_email'] == 'sb-uw7dj1405625@business.example.com' ){
							if( $keyarray['transaction_subject'] == 'limited' ){
								if( $keyarray['payment_gross'] == '5.00' && $keyarray['mc_currency'] == 'USD'  ){
	
									update_user_meta( $user_id, 'ab_txn_id', $keyarray['txn_id'] );
									update_user_meta( $user_id, 'ab_user_subcr', 'limited' );
									update_user_meta( $user_id, 'ab_is_subscription', true );

									return '<h2>Thank You for subscription. Your subscription has been activated.</h2>';
	
								}
	
							} elseif( $keyarray['transaction_subject'] == 'unlimited' ){
								if( $keyarray['payment_gross'] == '10.00' && $keyarray['mc_currency'] == 'USD'  ){
	
									update_user_meta( $user_id, 'ab_txn_id', $keyarray['txn_id'] );
									update_user_meta( $user_id, 'ab_user_subcr', 'unlimited' );
									update_user_meta( $user_id, 'ab_is_subscription', true );

									return '<h2>Thank You for subscription. Your subscription has been activated.</h2>';
								}
							}
						}
					}
					
    			}
    			else if (strcmp ($lines[0], "FAIL") == 0) {
    				// log for manual investigation
    			}
    		}
        }
	}
}
