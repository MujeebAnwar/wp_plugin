<?php
/**
 *Plugin Name: Test Plugin
 *Description: This Plugin Send Order to Adiyso
 *Author: Soft Services
 *Author URI: https://www.freelancer.com/u/SoftsServices
 * Version: 1.0
 **/


function test_method()
{
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://jsonplaceholder.typicode.com/posts",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "Cookie: __cfduid=de2758bca8b887d6af794fdd9604d72121603806942"
        ),
    ));

    $response = curl_exec($curl);


    $result= json_decode($response,true);

    $data='<table class="table table-hover table-bordered"> <thead> <tr> <th>Id</th></thead>';
    foreach ($result as $res)
    {
        $data .= '<tr> <td>' .$res['userId'].'</td></tr>';
    }
    curl_close($curl);
    return $data;

}
add_shortcode('test','test_method');