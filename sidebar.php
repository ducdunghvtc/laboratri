<div class="side-bar mt-5 mt-md-12h px-2 ml-md-4 px-md-0 col-12 col-md-3">
    <h3 class="fs-20 font-weight-regular py-1 bg-secondary text-center text-light w-100">
        <?php $lang = get_bloginfo("language"); if ($lang == 'en-GB') : echo 'Related Products'; elseif( $lang == 'vi'): echo 'Các sản phẩm liên quan'; endif; ?>
    </h3>
    <ul class="mt-2 list-style-none">
    <?php 
        $args = array(
            'posts_per_page' => 3,
            'post_type'   => 'post',
            'post_status' => 'publish',
            'orderby'           => 'date',
            'order'             => 'DESC',
        );
        $the_query = new WP_Query( $args );
        ?>
        <?php if( $the_query->have_posts() ): ?>
        <?php while( $the_query->have_posts() ) : $the_query->the_post(); 
            $urlThumbnail = get_the_post_thumbnail_url($the_query->ID,'full');
        ?>
        <li class="pb-2">
            <a href="<?php the_permalink(); ?>" class="d-block position-relative">
                <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>">
                <p class="title px-2 fs-14"><?php the_title(); ?></p>
            </a>
        </li>
        <?php endwhile; ?>
        <?php endif; ?>
        <?php wp_reset_query(); 
    ?>
    </ul>
</div>
