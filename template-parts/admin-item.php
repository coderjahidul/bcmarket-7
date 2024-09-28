<?php
$product = wc_get_product(get_the_ID());
$post_7 = get_post(get_the_ID());
$partner_id = get_post_field('post_author', get_the_ID());
$highlight = "viewed";
$highlight_color = "background-color:#fff";

if (get_post_meta(get_the_ID(), 'bid_status', true) == 'awaiting_upload' || get_post_meta(get_the_ID(), 'bid_status', true) == 'processing' || get_post_meta(get_the_ID(), 'bid_status', true) == 'checking_accounts') {
    $highlight = "unviewed";
    $highlight_color = "background-color:#f9f4b5";
}


?>
<tr class="tr_decline <?php echo $highlight ?>" style="<?php echo $highlight_color; ?>">
    <td><a target="blank" href="<?php echo get_permalink($product->get_id()); ?>">#&nbsp;
            <?php echo get_post_meta(get_the_ID(), 'custom_product_id', true); ?>
        </a></td>
    <td>
        <?php echo get_post_field('post_author', get_the_ID()); ?>
    </td>
    <td>
        <?php echo $product->get_date_created()->date('m.d.Y'); ?>
    </td>
    <td>

        <?php if (get_post_meta(get_the_ID(), 'bid_status', true) == 'checking_accounts'): ?>
            <div id="status_name<?php echo get_the_ID(); ?>">Checking Accounts</div>
        <?php elseif (get_post_meta(get_the_ID(), 'bid_status', true) == 'processing'): ?>
            <div id="status_name<?php echo get_the_ID(); ?>">In Processing</div>
        <?php elseif (get_post_meta(get_the_ID(), 'bid_status', true) == 'declined'): ?>
            <div id="status_name<?php echo get_the_ID(); ?>">Declined</div>
        <?php elseif (get_post_meta(get_the_ID(), 'bid_status', true) == 'onsale'): ?>
            <div id="status_name<?php echo get_the_ID(); ?>">On Sale</div>
        <?php elseif (get_post_meta(get_the_ID(), 'bid_status', true) == 'soldout'): ?>
            <div id="status_name<?php echo get_the_ID(); ?>">Sold Out</div>
        <?php elseif (get_post_meta(get_the_ID(), 'bid_status', true) == 'awaiting_upload'): ?>
            <div id="status_name<?php echo get_the_ID(); ?>">awaiting upload</div>
            <div class="upload" id="upload1<?php echo get_the_ID(); ?>">
                <a href="javascript:void(0)" onclick="bids.upload_dialog(<?php echo get_the_ID(); ?>)">upload accounts</a>
            </div>
        <?php endif; ?>

    </td>
    <td class="col_title">
        <div id="item_control_<?php echo get_the_ID(); ?>"><a href="<?php the_permalink(); ?>">
                <?php
                $name = $product->get_name(); // Get the product name
                $words = explode(' ', $name); // Split the name into an array of words
                $six_word_name = implode(' ', array_slice($words, 0, 5)); // Take the first 6 words and join them back into a string
                echo $six_word_name . "..."; // Output the truncated product name
                ?>
            </a></div>
        <a href="javascript:void(0)" onclick="bids.description_dialog(<?php echo get_the_ID(); ?>)">partner
            description</a>
        <div id="description_<?php echo get_the_ID(); ?>" style="display: none;">
            <?php echo $product->get_name(); ?>
        </div>
    </td>
    <td>
        <?php echo get_post_meta(get_the_ID(), 'item_format', true); ?>
    </td>
    <td>
        <div class="change_partner_price" data-id="<?php echo get_the_ID(); ?>"
            item-id="<?php echo $product->get_meta('item_id'); ?>">
            <?php echo get_post_meta($product->get_id(), 'partner_price', true); ?>&nbsp; USD
        </div>
    </td>
    <td>
        <?php echo total_uploaded_accounts_by_id(get_the_ID()); ?> /
        <?php echo total_free_accounts_by_id(get_the_ID()); ?>
    </td>
    <td>
        <a href="javascript:void(0)" onclick="bids.list(<?php echo get_the_ID(); ?>, 0, 0)">view uploaded</a>
        <?php if (total_free_accounts_by_id(get_the_ID()) != 0): ?>
            <a href="javascript:void(0)" onclick="bids.list(<?php echo get_the_ID(); ?>, 0, 1)">view free accounts</a>


            <a href="javascript:void(0)" onclick="bids.remove_unsold(<?php echo get_the_ID(); ?>)">delete unsold</a>
        <?php endif; ?>

        <a href="<?php echo esc_url(home_url('/partner/upload/')); ?>?id=<?php echo get_the_ID(); ?>">create like
            this</a>
    </td>

    <td>
        <div class="divTable" style="width: 100%;">
            <div class="divTableBody">
                <div class="divTableRow">
                    <div class="divTableCell"
                        style="text-align: right; font-weight: bold; width: 30%; border-right: 1px solid #999999; border-width: medium;">
                        &nbsp;Paid:</div>
                    <div class="divTableCell" style="text-align: left;">&nbsp;
                        <?php echo get_paid_pcs_by_product_id_interface(get_the_ID()); ?> pcs (
                        <?php echo get_paid_payment_by_product_id(get_the_ID()); ?> USD)
                    </div>
                </div>
                <div class="divTableRow">
                    <div class="divTableCell"
                        style="text-align: right; font-weight: bold; width: 30%; border-right: 1px solid #999999; border-width: medium; <?php if (get_pending_pcs_by_product_id_interface(get_the_ID()) != 0) {
                            echo 'color:red;';
                        } ?>">
                        &nbsp;Pending payment:</div>
                    <div class="divTableCell" style="text-align: left; ">&nbsp;
                        <?php echo get_pending_pcs_by_product_id_interface(get_the_ID()); ?> pcs (
                        <?php echo get_pending_payment_by_product_id_interface(get_the_ID()); ?> USD)
                    </div>
                </div>
                <div class="divTableRow">
                    <div class="divTableCell"
                        style="text-align: right; font-weight: bold; width: 30%; border-right: 1px solid #999999; border-width: medium;">
                        <a
                            href="<?php echo esc_url(home_url('/admin-interface')); ?>/view?pro_id=<?php echo get_post_meta(get_the_ID(), 'custom_product_id', true); ?>">Invalid:</a>
                    </div>
                    <div class="divTableCell" style="text-align: left;">&nbsp;
                        <?php echo get_invalid_total_by_pro_id(get_the_ID()); ?>
                    </div>
                </div>
                <div class="divTableRow">
                    <div class="divTableCell"
                        style="text-align: right; font-weight: bold; width: 30%; border-right: 1px solid #999999; border-width: medium;">Bad Account:
                    </div>
                    <div class="divTableCell" style="text-align: left;">&nbsp;
                        <?php echo count_bad_accounts($product->id); ?>
                    </div>
                </div>
            </div>
        </div>
    </td>
    <td>


        <div style="padding:20px" class="admin_all_infos">

            <form action="" class="update_item_status">

                <select name="status">
                    <option value="">Select Status</option>
                    <option <?php if (get_post_meta($product->get_id(), 'bid_status', true) == 'processing') {
                        echo 'selected';
                    } ?> value="processing">In Processing</option>
                    <option <?php if (get_post_meta($product->get_id(), 'bid_status', true) == 'awaiting_upload') {
                        echo 'selected';
                    } ?> value="awaiting_upload">Awaiting Upload</option>
                    <option <?php if (get_post_meta($product->get_id(), 'bid_status', true) == 'checking_accounts') {
                        echo 'selected';
                    } ?> value="checking_accounts">Checking Accounts</option>
                    <option <?php if (get_post_meta($product->get_id(), 'bid_status', true) == 'onsale') {
                        echo 'selected';
                    } ?> value="onsale">On sale</option>
                    <option <?php if (get_post_meta($product->get_id(), 'bid_status', true) == 'declined') {
                        echo 'selected';
                    } ?> value="declined">Declined</option>
                    <option <?php if (get_post_meta($product->get_id(), 'bid_status', true) == 'soldout') {
                        echo 'selected';
                    } ?> value="soldout">Sold Out</option>
                </select>
                <textarea name="note" id="" cols="30" rows="10" placeholder="Enter Declined Reason"></textarea>
                <button type="submit" class="btn btn-primary">Submit</button>
                <input type="hidden" name="action" value="change_item_status">
                <input type="hidden" name="product_id" value="<?php echo $product->get_id(); ?>">

            </form>


            <div class="connect_to_item">
                <form class="connect_to_item_form">
                    <input type="number" name="item_id" placeholder="Add Item Id"
                        value="<?php echo $product->get_meta('item_id'); ?>">
                    <button class="btn btn-primary" type="submit">Submit</button>
                    <input type="hidden" name="action" value="connect_item">
                    <input type="hidden" name="product_id" value="<?php echo get_the_ID(); ?>">
                    <input type="hidden" name="partner_id" value="<?php echo $partner_id; ?>">
                    <input type="hidden" name="item_partner_price"
                        value="<?php echo get_post_meta($product->get_id(), 'partner_price', true); ?>">
                </form>
                <div class="connect_to_item_form_message"></div>
                <div id="preloader">
                    <div id="loader"></div>
                </div>
            </div>

        </div>

    </td>

</tr>