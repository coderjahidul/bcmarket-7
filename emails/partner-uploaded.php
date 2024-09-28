<?php get_template_part('emails/email', 'header');
$product_id = get_post_meta($args['post_id'], 'custom_product_id', true);
?> 
<p style="text-align:center">
	<span style="font-size:18px">Accounts for request <?php echo $product_id; ?> are uploaded.</span>
</p>
<p style="text-align:center">
	<span style="font-size:18px">Upload: <?php echo total_uploaded_accounts_by_id($args['post_id']); ?> pcs.</span>
</p>
<p style="text-align:center">
	<span style="font-size:18px">Repeats: <?php
	
// 	 total_repeat_accounts_by_id($args['post_id']);
$repeatAccount = get_option('repeat_account');

if($repeatAccount){
    echo $repeatAccount ;
}else{
    echo 0 ;
}
	
	?> pcs.</span>
</p>

<?php get_template_part('emails/email', 'footer'); ?> 