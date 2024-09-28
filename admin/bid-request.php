<?php 
if(is_user_logged_in()){
    $current_user = wp_get_current_user();
    $roles = array('administrator', 'employee');
    $found = 0; 
    foreach($roles as $role){
        if(in_array( $role, (array) $current_user->roles) ){
            $found = 1;
           
        }
    }

    if($found == 0){
         wp_redirect( home_url('/my/') );
            exit(); 
    }
    
}else{
    wp_redirect( home_url('/my/') );
    exit(); 
}
get_header(); ?>

<section class="soc-category" id="content">
    
    <?php get_template_part('template-parts/admin', 'breadcrumb'); ?>

    <div class="container">
        <div class="flex">
            <h1><?php the_title(); ?></h1>
           
            <?php get_template_part( 'admin/admin', 'menu'); ?>
            <div class="body partner_cabinet partner-reg__form_step_2 2_step_user_offer user_offers">
                
                <div class="request_menu">
                    <ul>
                        <li><a class="btn <?php if(!isset($_GET['app'])){echo 'btn-primary';} ?>" href="<?php echo esc_url(home_url('/admin-interface/bid-request/')); ?>">Pending Applications</a></li>
                        <li><a class="btn <?php if(isset($_GET['app']) && $_GET['app'] == 'approved'){echo 'btn-primary';} ?>" href="<?php echo esc_url(home_url('/admin-interface/bid-request/')); ?>?app=approved">Approved Applications</a></li>
                        <li><a class="btn <?php if(isset($_GET['app']) && $_GET['app'] == 'reject'){echo 'btn-primary';} ?>"  href="<?php echo esc_url(home_url('/admin-interface/bid-request/')); ?>?app=reject">Rejected Applications</a></li>
                    </ul>
                </div>

                <div id="datatable_wrapper" class="dataTables_wrapper no-footer">
                    <table class="form small table order-list reg-accounts dataTable no-footer" id="datatable" role="grid" aria-describedby="datatable_info">
                        <thead>
                            <tr role="row">
                                <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 180px;">Category and quantity</th>
                                <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 180px;">Partner ID</th>
                                <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 401.833px;">Account description</th>
                                <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 283.467px;">Status</th>
                                <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 132.7px;">Comment</th>
                                <th>
                                    Change Status
                                </th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php  

                            $current_url = esc_url_raw($_SERVER['REQUEST_URI']);
                            $page_number = intval(preg_replace('/[^0-9]+/', '', $current_url), 10);

                            // Calculate the 'paged' value, ensuring it's at least 1
                            $paged = $page_number == 0 ? 1 : $page_number;

                            $args = array(
                                'post_type' => 'bids', 
                                'posts_per_page' => 10, 
                                'meta_query' => array(
                                    array(
                                        'key' => 'offer_status', 
                                        'value' => ''
                                    )
                                ),
                                'paged' => $paged // Add this line for pagination
                            );

                            if(isset($_GET['app']) && $_GET['app'] == 'approved'){
                                $args['meta_query'][0]['value'] = 'approved';
                            } elseif(isset($_GET['app']) && $_GET['app'] == 'reject'){
                                $args['meta_query'][0]['value'] = 'rejected';
                            } else {
                                $args['meta_query'][0]['value'] = 'under_considertion';
                            }

                            $offer_query = new WP_Query($args);


                            if($offer_query->have_posts()) : 

                                while($offer_query->have_posts()) : $offer_query->the_post();

                                    $cat_term =  get_term_by('id', get_post_meta(get_the_ID(), 'offer_cat', true), 'product_cat'); 


                                    ?>
                                    <tr role="row" class="odd">
                                        <td>
                                            <div class="user_offer_cat_and_qty">
                                                <div class="user_offer_cat"><?php echo $cat_term->name; ?></div>
                                                <div class="user_offer_qty"><?php echo get_post_meta(get_the_ID(), 'offer_count', true); ?> / Per <?php echo get_post_meta(get_the_ID(), 'offer_days', true); ?></div>
                                            </div>
                                        </td>
                                        <td>
                                            <?php echo get_post_field( 'post_author', get_the_ID() ); ?>
                                        </td>
                                        <td>
                                            <?php the_title(); ?><br />
                                            <strong>Registration country (IP):</strong> <?php echo get_post_meta(get_the_ID(), 'offer_country', true); ?><br />
                                            <strong>Accounts format:</strong> <?php echo get_post_meta(get_the_ID(), 'offer_format', true); ?>
                                        </td>
                                        <td>
                                            <div class="status_wrapper">
                                                <div class="thead desktop-hide">Status:</div>
                                                <div class="user_offer_checking"><?php echo get_post_meta(get_the_ID(), 'offer_status', true); ?></div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="thead desktop-hide">Comment:</div>
                                        </td>
                                        <th>
                                            <?php if(get_post_meta(get_the_ID(), 'offer_status', true) != 'approved') : ?>
                                            <button data-id="<?php echo get_the_ID(); ?>" style="margin-bottom:10px;" class="btn btn-primary approve_bids">Approve</button>
                                            <?php endif; ?> 
                                            <br> 
                                            <?php if(get_post_meta(get_the_ID(), 'offer_status', true) != 'rejected') : ?>
                                            <input type="text" placeholder="Add Reject Reason">
                                            <button data-id="<?php echo get_the_ID(); ?>"  class="btn  btn-danger reject_bids">Reject</button>
                                        <?php endif; ?>
                                        </th>
                                    </tr>
                                <?php endwhile; else : echo '<tr><td>No Application Found!</td></tr>'; endif; ?>
                            
                        </tbody>
                    </table>
                    <div class="pager_wrap" style="display:flex;justify-content:center;">

					<?php
						$big = 999999999; // need an unlikely integer

                        echo paginate_links( array(
                            'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                            'format' => '?paged=%#%',
                            'current' => $paged,
                            'total' => $offer_query->max_num_pages
                        ) );
                        
                        wp_reset_postdata(); // Restore original post data
					?>
                </div>
                    
                </div>
            </div> 

        </div>
    </div>
</section>

<?php get_footer() ?>