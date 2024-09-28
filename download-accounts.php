<?php
/*
Template Name: Download Accounts
*/ 
if(isset($_GET['order_id']) && !empty($_GET['order_id']) && isset($_GET['order_key']) && !empty($_GET['order_key'])){

	$args = array(
        'post_type' => 'shop_order', 
        'post_status'    => 'any',
        'meta_query' => array(
            array(
                'key' => '_order_number', 
                'value' => $_GET['order_id']
            )
        )
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        $query->the_post();
        $order_id = get_the_ID();
    } wp_reset_postdata();


	global $wpdb;
	$table_name = $wpdb->prefix . "accounts";

	//$order_id = $_GET['order_id'];

	$order = wc_get_order( $order_id );

	$file = 'order'. $order->get_order_number() .'.txt';

	$results = $wpdb->get_results( "SELECT * FROM $table_name WHERE order_id = $order_id"); 

	$txt = fopen($file, "w") or die("Unable to open file!");

	

	$item_id = '';

	foreach ( $order->get_items() as $item_id => $item ) {
		$item_id = $item->get_product_id();
	}

	$item_format = get_post_meta($item_id, 'item_format', true);
    $item_format_ex = explode(',', $item_format);

	if($results){
		foreach($results as $result){

			$all_items = array();
            foreach($item_format_ex as $item_single){
                $all_items[] = $result->$item_single; 
            }
            $item_line =  implode(':', $all_items);

			fwrite($txt, $item_line . "\n");
		}
	}
	
	fclose($txt);


	header('Content-Description: File Transfer');
	header('Content-Disposition: attachment; filename='.basename($file));
	header('Expires: 0');
	header('Cache-Control: must-revalidate');
	header('Pragma: public');
	header('Content-Length: ' . filesize($file));
	header("Content-Type: text/plain");
	readfile($file);
}



?>