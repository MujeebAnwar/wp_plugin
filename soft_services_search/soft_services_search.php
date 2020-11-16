<?php
/**
 *Plugin Name: Products and Vendors Search for Dokan
 *Description: This Plugin Search Products and  Vendors In Dokan
 *Author: Soft Services
 *Author URI: https://www.freelancer.com/u/SoftsServices
 * Version: 1.1.4
 **/

function soft_services_custom_search()
{

    $finalurl = get_permalink( get_page_by_path( 'search' ) );
    $value = isset($_GET['custom_search']) ? $_GET['custom_search']:'';
    $content='<div class="row">';
    $content.='<div class="col-md-12">';
    $content.='<form id="ss_search_from" method="GET" action="'.$finalurl.'">';
    $content.='<input type="text" id="ss_search" class="form-control" value="'.$value.'" name="custom_search" placeholder="Search for an Product or Influencers">';
    $content.='<input type="submit" class="btn" id="ss_submit_btn" value="Search" style="">';
    $content.='</form></div></div>';
    return $content;

}

function soft_services_capture_from($content)
{
    if (isset($_GET['custom_search']))
    {

        $con=soft_services_custom_search();
        if(empty($_GET['custom_search']))
        {
            $con.= '<header  class="ss_searching_heading woocommerce-products-header"><h1 class="woocommerce-products-header__title page-title">"Nothing Found"</h1></header>';
        }else{


            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

            
            $products = array(
                'post_status' => 'publish',
                'post_type' => 'product',
                's'=>esc_attr( $_GET['custom_search']),
                'posts_per_page'=>1,
                'paged' => $paged

            );

//            echo '<pre>';


//
            $all_products = new WP_Query($products);
//            var_dump($products);
//            exit();
            $con .= '<header class="woocommerce-products-header ss_searching_heading"><h1 class="woocommerce-products-header__title page-title">Search results: "'.$_GET['custom_search'].'"</h1></header>';
            if (!empty($all_products->posts))
            {
                $con.='<h1 class="ss_pro_search_result_heading">Your Searching Products</h1>';
                $con.='<ul class="products columns-3">';
                foreach ($all_products->posts as $product)
                {
                    $get_product_info = wc_get_product( $product->ID );
                    $con.=' <li class="product type-product">';
                    $con.='<a href="'.$get_product_info->get_permalink().'" class="woocommerce-LoopProduct-link woocommerce-loop-product__link">';
                    $con.='<span class="et_shop_image">'.$get_product_info->get_image().'<span class="et_overlay"></span></span>';
                    $con.='<h2 class="woocommerce-loop-product__title">'.$get_product_info->get_name().'</h2>';
                    $con.='<span class="price">';

                    if ($get_product_info->is_on_sale())
                    {
                        $con.='<del>';
                        $con.='<span class="woocommerce-Price-amount amount">';
                        $con.='<span class="woocommerce-Price-currencySymbol">'.get_woocommerce_currency_symbol(get_option('woocommerce_currency')).'</span>'.sprintf("%.2f",  $get_product_info->get_regular_price());
                        $con.='</span>';
                        $con.='</del>';
                        $con.=' <ins>';
                        $con.='<span class="woocommerce-Price-amount amount">';
                        $con.='<span class="woocommerce-Price-currencySymbol">'.get_woocommerce_currency_symbol(get_option('woocommerce_currency')).'</span>'.sprintf("%.2f",  $get_product_info->get_sale_price());
                        $con.='</span>';
                        $con.='</ins>';
                    }else{

                        $con.='<span class="woocommerce-Price-amount amount">';
                        $con.='<span class="woocommerce-Price-currencySymbol">'.get_woocommerce_currency_symbol(get_option('woocommerce_currency')).'</span>'.sprintf("%.2f",  $get_product_info->get_price());
                        $con.='</span>';

                    }



                    $con.='</span>';
                    $con.='</a></li>';

                }




                $con.='</ul>';


            }
            previous_posts_link( '&laquo; PREV', $all_products->max_num_pages);
            next_posts_link( 'NEXT &raquo;', $all_products->max_num_pages);
            wp_reset_query();

            $user_query = new WP_User_Query( array(
                'role' => 'seller',
                'meta_query'=>[
                    [
                        'key'=>'dokan_store_name',
                        'value'=>$_GET['custom_search'],
                        'compare'=>'LIKE'
                    ]
                ]
            ));

            if(!empty($user_query->get_results()))
            {
                $con.='<h1 class="ss_ven_search_result_heading">Your Searching Influencers</h1>';
                $con .='<div id="dokan-seller-listing-wrap" class="grid-view">';
                $con .=' <div class="seller-listing-content">';
                $con .=' <ul class="dokan-seller-wrap">';
                foreach ( $user_query->get_results() as $user ) {

                    $name = !empty(implode(' ',get_user_meta($user->ID,'dokan_store_name'))) ? implode(' ',get_user_meta($user->ID,'dokan_store_name')) :$user->display_name;
                    $get_author_gravatar = get_avatar_url($user->ID);
                    $con .='  <li class="dokan-single-seller woocommerce coloum-3 ">';
                    $con .='<div class="store-wrapper">';
                    $con .=' <div class="store-header"></div><div class="store-content "><div class="store-data-container"><div class="featured-favourite"></div><div class="store-data"></div></div>';
                    $con.='</div>';
                    $con .=' <div class="store-footer">';
                    $con .='  <h2><a href="'.home_url().'/store/'.$user->user_nicename.'">'.ucwords($name).'</a></h2>';
                    $con .=' <div class="seller-avatar">';
                    $con .='<img alt="" src="'.$get_author_gravatar.'" srcset="'.$get_author_gravatar.'" class="avatar avatar-150 photo" height="150" width="150" loading="lazy">';
                    $con .='</div>';
                    $con .='<a href="'.$user->user_url.'" title="Visit Store">';
                    $con .='</a>';
                    $con .='</div>';
                    $con .='</div>';
                    $con .=' </li>';

                }
                $con .='</ul>';
                $con .='</div>';

}
            if (empty($all_products->posts) && empty($user_query->get_results()))
            {
                $con.='<p class="woocommerce-info ss_pro_search_result_heading">No Product or Influencers were found matching your selection.</p>';
            }


        }

        return $con;


    }
    return $content;



}
function soft_services_add_css()
{
    wp_enqueue_style( 'ss_search',plugin_dir_url( __FILE__ ) . 'css/soft_search.css', false, time() );

}
function soft_services_title_update($title)
{
    if ($title=='Search')
    {
        $title='';
    }
    return $title;
}




add_shortcode('soft_services_search_box','soft_services_custom_search');
add_filter('the_content','soft_services_capture_from',1);
add_filter('the_title', 'soft_services_title_update', 10, 1);
//add_filter('pre_get_document_title','pppp_title_update',50,1);
add_action( 'wp_enqueue_scripts', 'soft_services_add_css');
