<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
$item_id = get_the_ID();
get_header(); ?>

<section class="soc-category" id="content">

    <div class="wrap-breadcrumbs">
        <div class="container">
            <div class="flex">
                <?php woocommerce_breadcrumb(); ?>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="flex">
            <div itemscope="" itemtype="http://schema.org/Product">
                <div class="recat">
                    <h1 itemprop="name">
                        <?php the_title(); ?>
                    </h1>
                </div>
                <div itemprop="offers" itemtype="https://schema.org/AggregateOffer" itemscope="">
                    <meta itemprop="lowPrice" content="<?php echo get_per_pcs_by_item($item_id); ?>">
                    <meta itemprop="highPrice" content="<?php echo get_per_pcs_by_item($item_id); ?>">
                    <meta itemprop="offerCount" content="1">
                    <meta itemprop="priceCurrency" content="USD">
                </div>
                <div class="magazines-left">
                    <div class="mag-img">
                        <?php the_post_thumbnail('thumbnail'); ?>
                    </div>
                    <p><span class="bold">In stock </span>
                        <?php echo get_total_pcs_by_item($item_id); ?> pcs.
                    </p>
                    <span>
                        <span class="bold">Price for each </span><br> from $<span>
                            <?php echo get_per_pcs_by_item($item_id); ?>
                        </span>
                        <p></p>

                        <?php if (get_total_pcs_by_item($item_id) != 0): ?>
                            <div class="soc-cell">
                                <a type="button" class="basket-button" data-id="<?php echo $item_id; ?>">
                                    <img src="<?php echo get_template_directory_uri(); ?>/img/ic-basket.png"
                                        alt=""><span>Buy</span>
                                </a>
                            </div>
                        <?php else: ?>
                            <div class="subscribe-cell" data-help="Subscribe to newsletter">
                                <!-- Button trigger modal -->
                                <button type="button" class="subscribe_button" data-toggle="modal" data-target="#exampleModal<?php echo $item_id; ?>">
                                    <i class="fa-regular fa-envelope"></i>
                                </button>

                                <!-- Subscribe Modal -->
                                <div class="modal fade" id="exampleModal<?php echo $item_id; ?>" tabindex="-1" role="dialog" aria-labelledby="subscribeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document" style="width: 800px;">
                                        <div class="modal-content" style="margin-top: 200px;">
                                            <div class="modal-header" style="display: flex;">
                                                <h5 class="modal-title" id="subscribeModalLabel" style="font-size: 14px; text-transform: uppercase; line-height: 2.428571;">Subscribe to Newsletter</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-left: 500px !important; font-size: 35px; font-weight: 400; color: #000; margin: 0; border: 0;">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-bodys" style="padding: 25px;">
                                                <p style="font-size: 14px; font-weight: 400; color: #000;">You want to subscribe to an item update:</p>
                                                <p style="font-size: 14px; font-weight: 600; color: #000; margin-bottom: 10px !important;">GMail Accounts | Accounts could be used in some services. The accounts are verified through SMS. Phone number not included in Profile Security method. Male or female. Registered from different countries IPs.</>
                                                <form id="subscribe-form-<?php echo $item_id; ?>" action="<?php echo esc_url(admin_url('admin-ajax.php')); ?>" method="POST">
                                                    <input type="email" name="subscriber_email" placeholder="Enter Your Email" required>
                                                    <input type="hidden" name="action" value="subscribe_form">
                                                    <p style="margin-top: 10px; color: red; font-size: 14px; font-weight: 400;">After clicking "subscribe" you will need to confirm your subscription in the mail!</p>
                                                    <button type="submit" style="width: 120px; height: 30px; line-height: 1.2; text-align: center; color: #fff; font-size: 16px; margin-top: 10px; margin-left: 0; border-radius: 4px; background-color: #245F9B; border: none;">Subscribe</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                    </span>
                </div>
                <div class="magazines-right recat" itemprop="description">
                    <?php the_content(); ?>
                </div>
                <div style="clear: both;"></div>
            </div>
        </div>
    </div>
</section>
<?php
get_footer('shop');

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */