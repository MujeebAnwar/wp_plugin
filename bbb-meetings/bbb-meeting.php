<?php
require_once dirname(__FILE__) . '/vendor/autoload.php';
require_once(ABSPATH . 'wp-admin/includes/plugin.php');
use BigBlueButton\Util\UrlBuilder;
use BigBlueButton\BigBlueButton;
use BigBlueButton\Parameters\CreateMeetingParameters;
/**
 *Plugin Name: BBB
 *Description: Big Blue Button
 *Author: Soft Services
 *Author URI: https://www.freelancer.com/u/SoftsServices
 * Version: 1.0.2
 **/


class SoftServices extends BigBlueButton
{


    public function __construct()
    {

        putenv('BBB_SECRET=RwV0gEfEJBt4ThETSes79B9ROZqprM7uafKqrx0wICU');
        putenv('BBB_SERVER_BASE_URL=https://5df16.bigbluemeeting.com/bigbluebutton/');
        parent::__construct();
        add_action('admin_menu',array( $this, 'bbb_new_page_menu' ));


    }

    public function bbb_my_menu_output()
    {


        $this->securitySecret='RwV0gEfEJBt4ThETSes79B9ROZqprM7uafKqrx0wICU';
        $this->bbbServerBaseUrl='https://5df16.bigbluemeeting.com/bigbluebutton/';

        $response = $this->getMeetings();
        $con ='';
        if ($response->getReturnCode() == 'SUCCESS') {
            foreach ($response->getRawXml()->meetings->meeting as $meeting) {

                $con.='<h1>'.$meeting->meetingName.'</h1>';
            }
        }
        echo $con;
    }





    public function bbb_new_page_menu()
    {
        add_menu_page('Rooms', 'Room', 'manage_options', 'bbb-rooms',array( $this, 'bbb_my_menu_output' ), '', 3);
    }
}


new SoftServices();

