<?php 
if(is_user_logged_in() && !current_user_has_approve_bid()){
    wp_safe_redirect( home_url('/partner/offers') );
}else if(!is_user_logged_in()){
    wp_safe_redirect( home_url('/my/') );
}
/*
Template Name: Upload
*/
get_header(); 
$like_id = '';
if(isset($_GET['id']) && !empty($_GET['id'])) : 
$args = array(
    'post_type' => 'product', // change this to your post type
    'meta_query' => array(
        array(
            'key' => 'custom_product_id', 
            'value' => $_GET['id']
        )
    ), 
    'post_status' => array('publish', 'pending','draft')
);

$query = new WP_Query($args);

if ($query->have_posts()) {
    $query->the_post();
    $like_id =  get_the_ID();
} wp_reset_postdata();

endif; 

?>
<section class="soc-category" id="content" id="uploding">
    <div class="wrap-breadcrumbs">
        <div class="container">
            <div class="flex">
                <div class="block" itemscope="" itemtype="http://schema.org/BreadcrumbList" id="breadcrumbs">
                    <div itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                        <a href="/" itemprop="item">
                            <span itemprop="name">Home</span>
                            <meta itemprop="position" content="0" />
                        </a>
                        <span class="divider">/</span>
                    </div>
                    <div itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                        <span class="current" itemprop="name">Partner interface</span>
                        <meta itemprop="position" content="1" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="flex">
            <h1>Partner interface</h1>
            <?php get_template_part( 'partner/menu'); ?>
            <form action="#" method="post" id="new_bid_form" class="partner-reg__form_step_2">
                <h2>Accounts upload</h2>
                <?php wp_nonce_field('bcmarket_bids_nonce' ); ?>
                <input type="hidden" name="action" value="add_bids" />
                <table class="form small table order-list reg-accounts">
                    <thead>
                        <tr>
                            <th>
                                Accounts category <span>*</span>
                                <div class="help" data-help="Example, Twitter"></div>
                            </th>
                            <th>
                                Description <span>*</span>
                                <div class="help" data-help="with avatar, 100 friends, registered on Gmail email"></div>
                            </th>
                            <th>
                                Registration country (IP) <span>*</span>
                                <div class="help" data-help="from which country ip accounts are registered?"></div>
                            </th>
                            <th>
                                Accounts formats <span>*</span>
                                <div class="help" data-help="example: login:password:email:emails password"></div>
                            </th>
                            <th colspan="2">
                                Price for 1 pc. <span>*</span>
                                <div class="help" data-help="Indicate what price you want to get for 1 account after it is sold"></div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="thead desktop-hide">
                                    Accounts category <span>*</span>
                                    <div class="help" data-help="Example, Twitter"></div>
                                </div>
                                <select name="categories[]" class="form-control">
                                    <option value="" disabled="" selected="" hidden="">Select a category</option>
                                    <?php 
                                        $terms = get_terms( array(
                                            'taxonomy' => 'product_cat',
                                            'hide_empty' => false,
                                            'parent' => 0
                                        ) );

                                        if($terms) : foreach($terms as $term) : ?>
                                            <option value="<?php echo $term->term_id; ?>"><?php echo $term->name; ?></option>
                                        <?php endforeach; endif; ?>
                                </select>
                            </td>
                            <td>
                                <div class="thead desktop-hide">
                                    Description <span>*</span>
                                    <div class="help" data-help="with avatar, 100 friends, registered on Gmail email"></div>
                                </div>
                                <textarea name="description[]" class="form-control-dsc"><?php  

                                    if(!empty($like_id)){
                                        echo get_the_title($like_id);
                                    }

                                 ?></textarea>
                            </td>
                            <td>
                                <div class="thead desktop-hide">
                                    Registration country (IP) <span>*</span>
                                    <div class="help" data-help="from which country ip accounts are registered?"></div>
                                </div>
                                <textarea name="country[]" class="form-control"><?php  

                                    if(!empty($like_id)){
                                        echo get_post_meta($like_id, 'item_country', true);
                                    }

                                 ?></textarea>
                            </td>
                            <td class="account_format_row">
                                <div class="thead desktop-hide">
                                    Accounts format <span>*</span>
                                    <div class="help" data-help="example: login:password:email:emails password"></div>
                                </div>
                                <select class="format_fi" name="format[0][]" multiple>
                                    <option value="">Select</option>
                                    <option value="login">Login ID</option>
                                    <option value="username">Username</option>
                                    <option value="email">Email ID</option>
                                    <option value="password">Passoword</option>
                                    <option value="mailpassword">Mail Passoword</option>
                                    <option value="alt_email">Alt Email</option>
                                    <option value="phone">Phone</option>
                                    <option value="dob">Date of Birth</option>
                                    <option value="gender">Gender</option>
                                    <option value="cookies">Cookies</option>
                                    <option value="gauth">Google Authentication Code</option>
                                    <option value="profile_link">Profile Link</option>
                                </select>
                                <!-- <select class="format_fi" name="format[0][]" multiple>
                                    <option value="" disabled="" selected="" hidden="">Select</option>
                                    <?php 
                                        // $terms = get_terms( array(
                                        //     'taxonomy' => 'accounts_cat',
                                        //     'hide_empty' => false,
                                        //     'parent' => 0
                                        // ) );

                                        // if($terms) : foreach($terms as $term) : ?>
                                            <option value="<?php //echo $term->term_id; ?>"><?php //echo $term->name; ?></option>
                                        <?php //endforeach; endif; ?>
                                </select> -->
                                

                            </td>
                            <td>
                                <div class="thead desktop-hide">
                                    Price for 1 pc. <span>*</span>
                                    <div class="help" data-help="Indicate what price you want to get for 1 account after it is sold"></div>
                                </div>
                                <div class="accounts_count partner_price">
                                    <input name="partner_cost[]" value="<?php 
                                    if(!empty($like_id)){
                                        $product = wc_get_product($like_id); 
                                        echo get_post_meta($like_id, 'partner_price', true);
                                    }?>" class="form-control" />
                                    <div class="form-control-currency">USD</div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                    <!-- <tfoot>
                        <tr>
                            <td colspan="6" align="center">
                                <input type="button" class="btn btn-lg btn-block" id="addrow" value="+ Add another line" />
                            </td>
                        </tr>
                        <tr></tr>
                    </tfoot> -->
                </table>
                <input type="hidden" name="like_this[]" value="<?php if(!empty($like_id)){
                   echo $like_id;
                } ?>">
                <button type="submit" class="partner_uploads_button">Add bids</button>
            </form>
            <div class="bid_error_message"></div>
            <div class="bid_success_message"></div>
        </div>
    </div>
</section>


<?php get_footer() ?>