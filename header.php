<!DOCTYPE html>
<html lang="ja">
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb#">
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
	<meta name="format-detection" content="telephone=no">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css" integrity="sha512-17EgCFERpgZKcm0j0fEq1YCJuyAWdz9KUtv1EjVuaOz8pDnh/0nZxmU6BBXwaaxqoi9PQXnRWqlcDB027hgv9A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<header class="header d-flex flex-column">
	<div class="bd-bottom-fourth-1 w-100 pb-1 mb-1 d-none d-md-block">
		<div class="container header-top">
			<nav class="header-contact d-flex align-items-center">
				<?php clean_custom_menu("contact-menu");?>
			</nav>
			<div class="language d-none d-md-block">
				<img src="<?php echo get_template_directory_uri(); ?>/common/images/<?php $lang = get_bloginfo("language"); echo 'ico-'.$lang ?>.png" alt="language">
				<?php pll_the_languages(array('dropdown'=>1)); ?>
			</div>
		</div>
	</div>
	<div class="container">
		<h1 class="header-logo">
			<?php the_custom_logo();?>
		</h1>
		<div class="header-nav">
			<?php wp_nav_menu(array("theme_location" => "primary-menu"));?>
			<div class="w-100 d-block d-md-none">
				<div class="header-contact">
					<?php clean_custom_menu("contact-menu");?>
					<div class="language w-100 text-center d-md-none">
						<ul class="d-flex align-items-md-center list-style-none"><?php pll_the_languages(array('show_flags'=>1,'show_names'=>0)); ?></ul>
					</div>
				</div>
			</div>
		</div>
		<button class="header-toggle-navi js-toggle-navi d-md-none">
			<span></span>
			<span></span>
			<span></span>
		</button>
	</div>
</header>