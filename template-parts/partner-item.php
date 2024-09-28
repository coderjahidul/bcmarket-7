<?php 
$product = wc_get_product( get_the_ID() );
$post_7 = get_post( get_the_ID());

?>
<tr class="tr_decline">
    <td><a target="blank" href="<?php echo esc_url(home_url('/')); ?>partner/view?pro_id=<?php echo get_post_meta(get_the_ID(), 'custom_product_id', true); ?>">#&nbsp;<?php echo get_post_meta(get_the_ID(), 'custom_product_id', true); ?></a></td>
    <td><?php echo $product->get_date_created()->date('m.d.Y'); ?></td>
    <td>

        <?php if(get_post_meta(get_the_ID(), 'bid_status', true)  == 'checking_accounts') : ?>
             <div id="status_name<?php echo get_the_ID(); ?>">Checking Accounts</div>
        <?php elseif(get_post_meta(get_the_ID(), 'bid_status', true)  == 'processing') : ?>
             <div id="status_name<?php echo get_the_ID(); ?>">In Processing</div>
       <?php elseif(get_post_meta(get_the_ID(), 'bid_status', true)  == 'declined') : ?>
             <div id="status_name<?php echo get_the_ID(); ?>">Declined</div>
        <?php elseif(get_post_meta(get_the_ID(), 'bid_status', true)  == 'onsale') : ?>
             <div id="status_name<?php echo get_the_ID(); ?>">On Sale</div> 
        <?php elseif(get_post_meta(get_the_ID(), 'bid_status', true)  == 'soldout') : ?>
             <div id="status_name<?php echo get_the_ID(); ?>">Sold Out</div> 
        <?php elseif(get_post_meta(get_the_ID(), 'bid_status', true)  == 'awaiting_upload') : ?>
            <div id="status_name<?php echo get_the_ID(); ?>">awaiting upload</div>
            <div class="upload" id="upload1<?php echo get_the_ID(); ?>">
                <a href="javascript:void(0)" class="upload_partner_account" data-id="<?php echo get_the_ID(); ?>"  
                    onclickss="bids.upload_dialog(<?php // echo get_the_ID(); ?>)"  >
                    upload accounts
                </a>
            </div> 
        <?php endif; ?>

    </td>
    <td class="col_title">
        <div id="item_control_<?php echo get_the_ID(); ?>">
            <a href="<?php the_permalink(); ?>"><?php echo $product->get_name(); ?></a>
        </div>
        <a href="javascript:void(0)" onclick="bids.description_dialog(<?php echo get_the_ID(); ?>)">partner description</a>
        <div id="description_<?php echo get_the_ID(); ?>" style="display: none;"><?php echo $product->get_name(); ?></div>
        <?php
            // Get the 'item_format' meta value from the current post
            $item_format = get_post_meta(get_the_ID(), 'item_format', true);

            // Split the item format value into an array
            $output_values = explode(',', $item_format);

            // Split the output into two parts: first three values and the remaining values
            $first_three = array_slice($output_values, 0, 3);
            $remaining = array_slice($output_values, 3);

            // Combine the first three values into a single string
            $first_three_str = implode(',', $first_three);

            // Combine the remaining values into a single string
            $remaining_str = implode(',', $remaining);

            // Print the first three values on one line and the remaining values on the next line
            echo "<div id='account_format'>{$first_three_str}</div>";
            if (!empty($remaining_str)) {
                echo "<div id='account_format'>{$remaining_str}</div>";
            }
        ?>

    </td>
    <td>
        <?php  echo "Price Per: " . get_post_meta($product->get_id(), 'partner_price', true); ?>&nbsp; USD <br>
        <?php 
            $partner_price = get_post_meta($product->get_id(), 'partner_price', true);
            $admin_percentage = get_theme_mod('admin_percentage');
			$new_price = $partner_price + (($admin_percentage / 100) * $partner_price);
            // Retrieve the selling price from post meta and convert it to a float
            

            // Display the new selling price with a descriptive text
            echo "Selling Price Per: " . $new_price . " USD";
        ?>
    </td>
    <td>
        <?php if(get_post_meta(get_the_ID(), 'bid_status', true)  == 'processing') : ?>
            <a href="#" class="processing_tool" data-toggle="tooltip" title="Expect your accounts to be uploaded and displayed in the application soon"><i class="fa fa-question" aria-hidden="true"></i></a>

        <?php else : ?>
            <?php echo total_uploaded_accounts_by_id(get_the_ID()); ?> / <?php echo total_free_accounts_by_id(get_the_ID()); ?>
        <?php endif; ?>
            
        </td>
    <td>
        <a href="javascript:void(0)" onclick="bids.list(<?php echo get_the_ID(); ?>, 0, 0)">view uploaded</a>
        <?php if(total_free_accounts_by_id(get_the_ID()) != 0) : ?>
            <a href="javascript:void(0)" onclick="bids.list(<?php echo get_the_ID(); ?>, 0, 1)">view free accounts</a>

        
            <a href="javascript:void(0)" onclick="bids.remove_unsold(<?php echo get_the_ID(); ?>)">delete unsold</a>
        <?php endif; ?>

        <a href="<?php echo esc_url(home_url('/partner/upload/')); ?>?id=<?php echo get_post_meta(get_the_ID(), 'custom_product_id', true); ?>">create like this</a>
    </td>
    <td>
        <div class="divTable" style="width: 100%;">
            <div class="divTableBody">
                <div class="divTableRow">
                    <div class="divTableCell" style="text-align: right; font-weight: bold; width: 30%; border-right: 1px solid #999999; border-width: medium;">&nbsp;Paid:</div>
                    <div class="divTableCell" style="text-align: left;">&nbsp;<?php echo get_paid_pcs_by_product_id_interface(get_the_ID()); ?> pcs (<?php echo get_paid_payment_by_product_id(get_the_ID()); ?> USD)</div>
                </div>
                <div class="divTableRow">
                    <div class="divTableCell" style="text-align: right; font-weight: bold; width: 30%; border-right: 1px solid #999999; border-width: medium; <?php if(get_pending_pcs_by_product_id_interface(get_the_ID()) != 0 ){echo 'color:red;';} ?>">&nbsp;Pending payment:</div>
                    <div class="divTableCell" style="text-align: left; ">&nbsp;<?php echo get_pending_pcs_by_product_id_interface(get_the_ID()); ?> pcs (<?php echo get_pending_payment_by_product_id_interface(get_the_ID()); ?> USD)</div>
                </div>
                <div class="divTableRow">
                    <div class="divTableCell" style="text-align: right; font-weight: bold; width: 30%; border-right: 1px solid #999999; border-width: medium;"><a href="<?php echo esc_url(home_url('/')); ?>partner/view?pro_id=<?php echo get_post_meta(get_the_ID(), 'custom_product_id', true); ?>">Invalid:</a></div>
                    <div class="divTableCell" style="text-align: left;">&nbsp;<?php echo get_invalid_total_by_pro_id(get_the_ID()); ?></div>
                </div>
                <div class="divTableRow">
                    <div class="divTableCell" style="text-align: right; font-weight: bold; width: 30%; border-right: 1px solid #999999; border-width: medium;">Bad Account:</div>
                    <div class="divTableCell" style="text-align: left;">&nbsp;<?php echo count_bad_accounts($product->id); ?></div>
                </div>
            </div>
        </div>
    </td>
</tr>


