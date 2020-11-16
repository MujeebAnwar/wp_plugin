<?php
/**
*Plugin Name: Adiyso Order
*Description: This Plugin Send Order to Adiyso
 *Author: Soft Services
 *Author URI: https://www.freelancer.com/u/SoftsServices
 * Version: 1.0.1
**/



function adiyso_action_woocommerce_checkout_order_processed($order_id, $posted_data, $order) {


        $orderDetails=[];
        foreach ($order->get_items() as $item_key => $item ):
            $product  = $item->get_product();
        if ($posted_data['restaurant_option']==1)
        {
            $product_unit_id= $product->get_meta('buca_product_id');
        }
        if ($posted_data['restaurant_option']==2)
        {
            $product_unit_id= $product->get_meta('bornova_product_id');
        }

        if (!empty($product_unit_id))
        {
            $quantity = $item->get_quantity();
            $ProductUnitId = (int)$product_unit_id;
            $orderDetails[] =['Quantity'=>$quantity,'ProductUnitId'=>$ProductUnitId];
        }

        endforeach;


    if (!empty($orderDetails))
    {
        $curl = curl_init();
        $url = 'https://adisyo.com/api/external/SaveExternalOrder';
        $ch = curl_init($url);
        $user = wp_get_current_user();

        $data = [

            'CustomerName' => $posted_data['billing_first_name'],
            'CustomerSurname'=>$posted_data['billing_last_name'],
            'CustomerPhone'=>$posted_data['billing_phone'],
            'Address'=>$posted_data['billing_address_1'],
            'Region'=>$posted_data['billing_state'],
            'City'=>$posted_data['billing_city'],
            'PaymentMethodId'=>'one',
            'WebOrderId'=>$order_id,
            'OrderNote'=>$posted_data['order_comments'],
            'CustomerId' =>  rand(10000,10000000).'ss'.rand(20000,30000).'caj',
            'Discount'=>$order->discount_total,
            'OrderDetails'=>$orderDetails
        ];





        $payload = json_encode($data);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

        if ($posted_data['restaurant_option']==1)
        {
            curl_setopt($ch, CURLOPT_HTTPHEADER, [

                    "API_KEY: 25b80b3556ca3a15353dd2fd312062fad27adcf5a1de51b75bdadea1fa8214ab",
                    "API_SECRET: 0450becf-ef5c-401e-a749-abc441470661",
                    'Content-Type:application/json'
                ]
            );
        }
        if ($posted_data['restaurant_option']==2)
        {
            curl_setopt($ch, CURLOPT_HTTPHEADER, [

                    "API_KEY: 25b80b3556ca3a15353dd2fd312062fad27adcf5a1de51b75bdadea1fa8214ab",
                    "API_SECRET: 8ab6914c-404a-4e9f-b016-ee4fc293a10a",
                    'Content-Type:application/json'
                ]
            );
        }


        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);

        session_start();
        $_SESSION['order'] = $result;
        curl_close($ch);
    }


 }
function adiyso_add_content_thankyou() {

    session_start();
    if (isset($_SESSION['order']))
    {
        $order = json_decode($_SESSION['order'],true);
        echo '<h2 class="h2thanks">Adiyso Order No : '.$order['orderId'].'</h2>';
        unset($_SESSION['order']);
    }

}


function adiyso_woocommerce_product_custom_fields()
{

    echo '<div class="product_custom_field">';
    // Custom Product Text Field
    woocommerce_wp_text_input(
        array(
            'id' => 'buca_product_id',
            'placeholder' => 'Enter Your Buca Product Unit Id',
            'label' => __('Buca Product Unit Id', 'woocommerce'),
            'type' => 'number',
            'custom_attributes' => array(
                'step' => 'any',
                'min' => '0'
            )
        )
    );
    woocommerce_wp_text_input(
        array(
            'id' => 'bornova_product_id',
            'placeholder' => 'Enter Your Bornova Product Unit Id',
            'label' => __('Bornova Product Unit Id', 'woocommerce'),
            'type' => 'number',
            'custom_attributes' => array(
                'step' => 'any',
                'min' => '0'
            )
        )
    );
    echo '</div>';

}


function adiyso_woocommerce_product_custom_fields_save($post_id)
{
    $buca_product_id = isset($_POST['buca_product_id']) ? $_POST['buca_product_id'] : '';
    $bornova_product_id = isset($_POST['bornova_product_id']) ? $_POST['bornova_product_id'] : '';

    if (!empty($buca_product_id))
        update_post_meta($post_id, 'buca_product_id', esc_attr($buca_product_id));

    if (!empty($bornova_product_id))
        update_post_meta($post_id, 'bornova_product_id', esc_attr($bornova_product_id));

    $product = wc_get_product($post_id);
    $product->update_meta_data('woocommerce_custom_fields', sanitize_text_field($buca_product_id));
    $product->save();
    $product->update_meta_data('woocommerce_custom_fields', sanitize_text_field($bornova_product_id));
    $product->save();


}


function adiyso_woocommerce_restaurant_field($fields)
{

    $fields['restaurant_option'] = array(
        'id'=>'restaurant_option',
        'label' => __('Select Restaurant', 'woocommerce'), // Add custom field label
        'required' => true, // if field is required or not
        'clear' => false, // add clear or not
        'type'=>'select',
        'input_class'=>array('input-text'),
        'options'  => [
            ''	=> __( 'Select Restaurant Branch', 'wps' ),
            1	=> __( 'Cajun Corner Buca', 'wps' ),
            2	=> __( 'Cajun Corner Bornova', 'wps' ),
        ],

    );

    return $fields;
}

add_action('woocommerce_checkout_order_processed', 'adiyso_action_woocommerce_checkout_order_processed',10, 3 );
add_action( 'woocommerce_thankyou', 'adiyso_add_content_thankyou');
add_action('woocommerce_product_options_general_product_data', 'adiyso_woocommerce_product_custom_fields');
add_action('woocommerce_process_product_meta', 'adiyso_woocommerce_product_custom_fields_save');
add_filter('woocommerce_billing_fields', 'adiyso_woocommerce_restaurant_field');


