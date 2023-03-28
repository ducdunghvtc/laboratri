<?php
define( 'THEME_URL', get_stylesheet_directory() );

if ( !isset($content_width) ) {
	$content_width = 620;
}

if ( !function_exists('wp_theme_setup') ) {
	function wp_theme_setup() {

		/* textdomain */
		$language_folder = THEME_URL . '/languages';
		load_theme_textdomain( 'wp', $language_folder );
		/* link RSS len <head> **/
		add_theme_support( 'automatic-feed-links' );

		/* Theme post thumbnail */
		add_theme_support( 'post-thumbnails' );

		/* Post Format */
		add_theme_support( 'post-formats', array(
			'image',
			'video',
			'gallery',
			'quote',
			'link'
		) );

		/* Theme title-tag */
		add_theme_support( 'title-tag' );

		/* Theme menu */
		register_nav_menus( array(
	    	'primary-menu' => __( 'Primary Menu', 'text_domain' ),
	    	'footer-menu'  => __( 'Footer Menu', 'text_domain' ),
	    	'contact-menu'  => __( 'Contact Menu', 'text_domain' ),
		) );

		/* sidebar */
		$sidebarThumbnail = array(
			'name' => __('Image sidebar', 'wp'),
			'id' => 'thumbnail-sidebar',
			'description' => __('Default sidebar'),
			'class' => 'thumbnail-sidebar',
		);
		register_sidebar( $sidebarThumbnail );
		
		$sidebar = array(
			'name' => __('Main Sidebar', 'wp'),
			'id' => 'main-sidebar',
			'description' => __('Default sidebar'),
			'class' => 'main-sidebar',
			'before_title' => '<h3 class="widgettitle">',
			'after_title' => '</h3>'
		);
		register_sidebar( $sidebar );

	}
	add_action( 'init', 'wp_theme_setup' );
}

remove_action( 'wp_head', '_wp_render_title_tag', 1 );


/*--------
TEMPLATE FUNCTIONS */
if (!function_exists('wp_header')) {
	function wp_header() { ?>
		<div class="site-name">
			<?php
				global $tp_options;

				if( $tp_options['logo-on'] == 0 ) :
			?>
				<?php
					if ( is_home() ) {
						printf( '<h1><a href="%1$s" title="%2$s">%3$s</a></h1>',
						get_bloginfo('url'),
						get_bloginfo('description'),
						get_bloginfo('sitename') );
					} else {
						printf( '<p><a href="%1$s" title="%2$s">%3$s</a></p>',
						get_bloginfo('url'),
						get_bloginfo('description'),
						get_bloginfo('sitename') );
					}
				?>

			<?php
				else :
			?>
				<img src="<?php echo $tp_options['logo-image']['url']; ?>" />
		<?php endif; ?>
		</div>
		<div class="site-description"><?php bloginfo('description'); ?></div><?php
	}
}

/**
*menu
**/
if ( !function_exists('wp_menu') ) {
	function wp_menu($menu) {
		$menu = array(
			'theme_location' => $menu,
			'container' => 'nav',
			'container_class' => $menu,
			'items_wrap' => '<ul id="%1$s" class="%2$s sf-menu">%3$s</ul>'
		);
		wp_nav_menu( $menu );
	}
}

add_filter('nav_menu_css_class' , 'special_nav_class' , 10 , 2);

function special_nav_class ($classes, $item) {
    if (in_array('current-menu-item', $classes) ){
        $classes[] = 'active';
    }
    return $classes;
}

/**
*pagination
**/
if ( !function_exists('wp_pagination') ) {
	function wp_pagination() {
		if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
			return '';
		} ?>
		<nav class="pagination" role="navigation">
			<?php if ( get_next_posts_link() ) : ?>
				<div class="next"><?php next_posts_link( __('Next', 'wp') ); ?></div>
			<?php endif; ?>
			<?php if ( get_previous_posts_link() ) : ?>
				<div class="prev"><?php previous_posts_link( __('Previous', 'wp') ); ?></div>
			<?php endif; ?>
		</nav>
	<?php }
}

/**
*thumbnail
**/
if ( !function_exists('wp_thumbnail') ) {
	function wp_thumbnail($size) {
		if( !is_single() && has_post_thumbnail() && !post_password_required() || has_post_format('image') ) : ?>
		<figure class="post-thumbnail"><?php the_post_thumbnail( $size ); ?></figure>
	<?php endif; ?>
	<?php }
}

/**
*wp_entry_header = title post
**/
if ( !function_exists('wp_entry_header') ) {
	function wp_entry_header() { ?>
		<?php if ( is_single() ) : ?>
			<!-- <h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h1> -->
			<h2 class="entry-title"><?php the_title(); ?></h2>
		<?php else : ?>
					<h2 class="entry-title"><?php the_title(); ?></h2>
		<?php endif; ?>
	<?php }
}

/**
*wp_entry_meta = get posts
**/
if ( !function_exists('wp_entry_meta') ) {
	function wp_entry_meta() { ?>
		<?php if ( !is_page() ) : ?>
			<div class="entry-meta">
			<?php
				printf( __('<span class="author">Posted by %1$s', 'wp'),
				get_the_author() );

				printf( __('<span class="date-published"> at %1$s', 'wp'),
				get_the_date() );

				printf( __('<span class="category"> in %1$s ', 'wp'),
				get_the_category_list( ',' ) );

				if ( comments_open() ) :
					echo '<span class="meta-reply">';
						comments_popup_link(
							__('Leave a comment', 'wp'),
							__('One comment', 'wp'),
							__('% comments', 'wp'),
							__('Read all comments', 'wp')
							);
					echo '</span>';
				endif;
			?>
			</div>
		<?php endif; ?>
	<?php }
}

/**
*wp_entry_content = post/page
**/
if ( !function_exists('wp_entry_content') ) {
	function wp_entry_content() {
		if( !is_single() && !is_page() ) {
			the_excerpt();
		} else {
			the_content();

			/* Phan trang trong single */
			$link_pages = array(
				'before' => __('<p>Page: ', 'wp'),
				'after' => '</p>',
				'nextpagelink' => __('Next Page', 'wp'),
				'previouspagelink' => __('Previous Page', 'wp')
			);
			wp_link_pages( $link_pages );
		}
	}
}

// function wp_readmore() {
// 	return '<a class="read-more" href="'. get_permalink( get_the_ID() ) . '">'.__('...[Read More]', 'wp').'</a>';
// }
// add_filter('excerpt_more', 'wp_readmore');


/**
*wp_entry_tag = show tag
**/
if ( !function_exists('wp_entry_tag') ) {
	function wp_entry_tag() {
		if ( has_tag() ) :
			echo '<div class="entry-tag">';
			printf( __('Tagged in %1$s', 'wp'), get_the_tag_list( '', ',' ) );
			echo '</div>';
		endif;
	}
}
/*=====import style.css=====*/
function wp_style() {
	wp_register_style( 'style', get_template_directory_uri() . "/style.css", 'all' );
	wp_enqueue_style('style');

	wp_register_style( 'common-style', get_template_directory_uri() . "/common/css/common.css", 'all' );
	wp_enqueue_style('common-style');

	wp_register_style( 'main-style', get_template_directory_uri() . "/common/css/style.css", 'all' );
	wp_enqueue_style('main-style');

	wp_register_style( 'slick-style', get_template_directory_uri() . "/common/css/slick.css", 'all' );
	wp_enqueue_style('slick-style');

	wp_register_script( 'jquery-3-script', "https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js", array('jquery') );
	wp_enqueue_script('jquery-3-script');
	wp_register_script( 'slick-script', get_template_directory_uri() . "/common/js/slick.min.js", array('jquery') );
	wp_enqueue_script('slick-script');
	wp_register_script( 'main-script', get_template_directory_uri() . "/common/js/common.js", array('jquery') );
	wp_enqueue_script('main-script');
	
}
add_action('wp_enqueue_scripts', 'wp_style');

function nd_dosth_theme_setup() {
    add_theme_support( 'title-tag' );  
    add_theme_support( 'custom-logo' );
}
add_action( 'after_setup_theme', 'nd_dosth_theme_setup');

function remove_core_updates (){ 
	global $wp_version ; return ( object ) array ( 'last_checked' => time (), 'version_checked' => $wp_version ,); 
} 
add_filter ( 'pre_site_transient_update_core' , 'remove_core_updates' ); 
add_filter ( 'pre_site_transient_update_plugins' , 'remove_core_updates' ); 
add_filter ( 'pre_site_transient_update_themes' , 'remove_core_updates' );



function clean_custom_menu( $theme_location ) {
	if ( ($theme_location) && ($locations = get_nav_menu_locations()) && isset($locations[$theme_location]) ) {
		$menu = get_term( $locations[$theme_location], 'nav_menu' );
		$menu_items = wp_get_nav_menu_items($menu->term_id);
		$menu_list  = '<nav class="contact-nav">';
		$menu_list .= '<ul class="d-flex flex-wrap align-items-md-center list-style-none flex-column flex-md-row">' ."\n";
	
			
		foreach( $menu_items as $menu_item ) {
			$link = $menu_item->url;
			$title = $menu_item->title;
			$menu_list .= '<li class="fs-12 fs-lg-14 text-fifth my-1h my-md-0">';
			$menu_list .= '<a class="d-flex align-items-start align-items-md-center fs-12 fs-lg-14 text-fifth" href="'.$link.'" ><img src="'.get_field('icon', $menu_item->ID).'">'.$title.'</a>';
			$menu_list .= '</li>';
			
		}
		
		$menu_list .= '</ul></nav>' ."\n";
	
	} else {
		$menu_list = '<!-- no menu defined in location "'.$theme_location.'" -->';
	}
	echo $menu_list;
}

//shortcode
function create_shortcode_getpost($args) {
	$random_query = new WP_Query(array(
		'post_type' => $args['type'],
		'posts_per_page' => $args['number'],
		'category_name'         => $args['category'],
	));

	$randomID = rand(10,100);
	ob_start();
	if ( $random_query->have_posts() ) :
		echo '<div id="slide_'.$randomID.'" class="js-slide equipment-slide">';
		while ( $random_query->have_posts() ) :
			$random_query->the_post();?>

				<div>
					<a data-id="<?php echo get_the_ID(); ?>" href="javascript:void(0)" class="js-loaddetail d-block thumbnail">
						<img src="<?php echo get_the_post_thumbnail_url();?>" alt="<?php the_title();?>">
						<p class="title"><?php the_title();?></p>
					</a>
				</div>

		<?php endwhile;
		echo '</div>';
	endif;
	?>
		<script type="text/javascript">
			$(document).ready(function(){
				$('#slide_<?php echo $randomID;?>').slick({
					dots: false,
					infinite: true,
					autoplay: true,
					speed: 500,
					slidesToShow: 3,
					slidesToScroll: 1,
					prevArrow:"<button class='slick-btn prev slick-prev'></button>",
    				nextArrow:"<button class='slick-btn next slick-next'></button>",
					responsive: [
						{
							breakpoint: 1024,
							settings: {
								slidesToShow: 2,
								slidesToScroll: 1,
							},
						},
						{
							breakpoint: 767,
							settings: {
								slidesToShow: 1,
								slidesToScroll: 1,
							},
						},
					],

				});
			});
		</script>
	<?php
	$list_post = ob_get_contents();

	ob_end_clean();


	return $list_post;
}
add_shortcode('get_post', 'create_shortcode_getpost');

function create_shortcode_products($args) {
	$random_query = new WP_Query(array(
		'post_type' => $args['type'],
		'posts_per_page' => $args['number'],
		'category_name'         => $args['category'],
	));

	$randomID = rand(10,100);
	ob_start();
	if ( $random_query->have_posts() ) :
		echo '<div id="slide_'.$randomID.'" class="products-list d-flex flex-wrap">';
		while ( $random_query->have_posts() ) :
			$random_query->the_post();?>

				<div class="products-items">
					<a data-id="<?php echo get_the_ID(); ?>" href="javascript:void(0)" class="js-loaddetail d-flex flex-column thumbnail">
						<figure class="d-flex align-items-center justify-content-center">
							<img src="<?php echo get_the_post_thumbnail_url();?>" alt="<?php the_title();?>">
						</figure>
						<div class="products-text p-1h">
							<p class="title fs-20 fw-bold"><?php the_title();?></p>
							<div class="text fs-14 mt-0hq">
								<?php the_excerpt();?>
							</div>
						</div>
					</a>
				</div>

		<?php endwhile;
		echo '</div>';
	endif;
	?>
	<?php
	$list_post = ob_get_contents();

	ob_end_clean();


	return $list_post;
}
add_shortcode('get_products', 'create_shortcode_products');

function create_shortcode_mainvisual($args) {
	$visual_query = new WP_Query(array(
		'post_type' => $args['type'],
        'order'          => 'DESC',
        'orderby'        => 'date',
		'posts_per_page' => $args['number'],
	));

	$randomID = rand(10,100);
	ob_start();
	if ( $visual_query->have_posts() ) :
		echo '<div id="slide_'.$randomID.'" class="main-visual">';
		while ( $visual_query->have_posts() ) : $visual_query->the_post();
            $subTitleVisual = get_field('sub_title', $visual_query->ID);
            $urlVisual = get_field('link', $visual_query->ID);
            //echo print_r($urlVisual);
            ?>

				<div class="position-relative main-visual-wrap">
                    <img src="<?php echo get_the_post_thumbnail_url();?>" alt="<?php the_title();?>">
                    <div class="visual-content">
                        <h2 class="title"><?php the_title();?></h2>
                        <p><?php echo $subTitleVisual;?></p>
                        <a class="btn" href="<?php echo $urlVisual['url'];?>" <?php if($urlVisual['target'] == '_blank'): echo 'target="_blank"'; endif;?>><?php echo $urlVisual['title'];?></a>
                    </div>
				</div>

		<?php endwhile;
		echo '</div>';
	endif;
	?>
		<script type="text/javascript">
			$(document).ready(function(){
				$('#slide_<?php echo $randomID;?>').slick({
					dots: true,
					arrows: false,
					infinite: true,
					autoplay: true,
					speed: 500,
					slidesToShow: 1,
					slidesToScroll: 1,
					// prevArrow:"<button class='slick-btn prev slick-prev'><img src='/wp-content/themes/laboratri/common/images/prev.svg'></button>",
    				// nextArrow:"<button class='slick-btn next slick-next'><img src='/wp-content/themes/laboratri/common/images/next.svg'></button>"
				});
			});
		</script>
	<?php
	$list_post = ob_get_contents();

	ob_end_clean();


	return $list_post;
}
add_shortcode('get_main_visual', 'create_shortcode_mainvisual');

// Custom Post Type

add_action('init', 'create_post_type');
function create_post_type()
{
	//------------------------------------------
	// Main Visual
	//------------------------------------------
	$main_visual = 'main_visual';
	register_post_type($main_visual,
		array(
			'labels' => array(
				'name'          => __('Main Visual'),
				'singular_name' => __('main visual'), 
			),
			'public'        => true,
			'menu_position' => 5,
			'rewrite'       => array('with_front' => true),
			'supports'      => array('title', 'thumbnail')
		)
	);

}

// get post where id
add_action('wp_ajax_idPost', 'get_post_detail');
add_action('wp_ajax_nopriv_idPost', 'get_post_detail');
function get_post_detail() {
   $idPost = isset($_POST['idPost']) ? (int)$_POST['idPost'] : 0;
   $getPost = array(
      'post_type' => 'post',
      'post_status' => 'publish',
      'p' => $idPost
   );
   $getPost = new WP_Query( $getPost );
   if($getPost->have_posts()) : 
         while ( $getPost->have_posts() ) : $getPost->the_post(); 
            $urlThumbnail = get_the_post_thumbnail_url();
            $title = get_the_title();
            $content = get_the_content();
            if(!$urlThumbnail):
				$urlThumbnail = get_template_directory_uri().'/common/images/default.jpg';
            endif;
			echo "
				<div class='modal-header'>
					<h1 class='ttl text-center w-100 fs-24 fs-lg-32'>{$title}</h1>
					<button type='button' class='close'></button>
				</div>
				<div class='modal-body'>
					<figure class='thumbnail order-lg-2 col-lg-6 pl-lg-4 mb-1 mb-lg-0'>
						<img src='{$urlThumbnail}' alt='{$title}'>
					</figure>
					<div class='content-post order-lg-1 col-lg-6'>
						{$content}
					</div>
				</div>
			";
         endwhile;
      endif;
   die(); 
}