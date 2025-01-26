<?php

/**
 * The Header template for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */
?>
<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width">
<title><?php wp_title('|', true, 'right'); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script>
<![endif]-->
	<?php wp_head(); ?>
</head>
	
<body <?php body_class(); ?>>
	
	<header id="masthead" class="site-header" role="banner">
		<div class="site_header">
			<div class="container site-header-container">
				<div class="sthd_flx">
					<div class="row">

						<div class="col-md-2 logo-col-cl">
							<div class="sthd_item sthd_logo">

								<div class="sthd_logo_inner">

									<a href="#" id="pull">
										<span class="bars"><i class="fas fa-bars"></i></span>
										<span class="close" style="display:none;"><i class="fas fa-times"></i></span>
									</a>
									
									<?php if ( has_custom_logo()) : ?>
									<div class="site-logo"><a href="<?php echo esc_url(home_url('/')); ?>"> <?php the_custom_logo(); ?></a></div>
									<?php endif; ?>
									
									<a href="<?php echo esc_url(home_url('/')); ?>"><img id="logo" alt="Manjula's Kitchen Logo"
								    src="https://manjulaskitchen.com/wp-content/uploads/manjul_logo_mn-1.webp"></a>
								</div>
							</div>
						</div>
						
						
						<div class="col-md-8 d-flex align-items-center header-nav-main-col ">
						
							<div class="sthd_item sthd_nav">
								<div class="sthd_nav_innner ">
								
									<?php wp_nav_menu(array('menu' => 'Top Menu')); ?>
										
			


								</div>
							</div>
				</div>
								
									<div class="col-md-2  d-flex align-items-center header-login-signup-col">
											<div class="sthd_item sthd_icon">
										<div class="sthd_icon_inner">

											<div class="sthd_login">
												<?php wp_loginout(); ?>
											</div>

										<div class="sthd_register">
									<?php if (is_user_logged_in()) : ?>
							     <a href="https://manjulaskitchen.com/saved-post/" id="save-post-button" class="button">Saved Post</a>
													<?php else : ?>
														<?php wp_register('', ''); ?>
													<?php endif; ?>
												</div>



											<?php if (0) { ?>
												<p class="top-login">
													<a href="<?php echo home_url(); ?>/favorites/"><span class="genericon genericon-star">                                                             </span>Favorites</a>
												</p>
											<?php } ?>
										</div>
									</div>
									</div>
					</div>
									<div class="row">
										<div class="col-md-12">
											<div id="hoverDiv" class="modal">
												 <span class="closeRecipeHover d-none">&times;</span>
    <div id="expand-content-w" >
        <article>
            <h3>All Recipe Categories</h3>
            <section class="new">
                <?php
                    $page_s = explode("</li>", wp_list_categories('child_of=15&title_li=&echo=0'));
                    $page_n = count($page_s) - 1;
                    $page_col = round($page_n / 2);
                    for ($i = 0; $i < $page_n; $i++) {
                        if ($i < $page_col) {
                            $page_left = $page_left . '' . $page_s[$i] . '</li>';
                        } elseif ($i >= $page_col) {
                            $page_right = $page_right . '' . $page_s[$i] . '</li>';
                        }
                    }
                ?>
                <ul>
                    <?php echo $page_left; ?>
                </ul>
                <ul>
                    <?php echo $page_right; ?>
                </ul>
            </section>
        </article>
        <article>
            <h3>Festival Recipes</h3>
            <section>
                <ul>
                    <?php wp_list_categories('child_of=2413&title_li='); ?>
                </ul>
            </section>
        </article>
        <article>
            <h3>Special Diets</h3>
            <section>
                <ul>
                    <?php wp_list_categories('child_of=2422&title_li='); ?>
                </ul>
            </section>
        </article>
        <article>
            <h3>Special Occasions</h3>
            <section>
                <ul>
                    <?php wp_list_categories('child_of=2426&title_li='); ?>
                </ul>
            </section>
        </article>
        <article>
            <h3>Misc</h3>
            <section>
                <ul>
                    <?php wp_list_categories('child_of=8&title_li='); ?>
                </ul>
            </section>
        </article>
    </div>
</div>
										</div>
						</div>
									
							
							</div>
						
					</div>
				</div>


			<?php if (0) { ?>

				<div id="center-bar" class="group">

					<a href="<?php echo esc_url(home_url('/')); ?>"><img id="logo" alt="Manjula's Kitchen Logo" src="<?php bloginfo('stylesheet_directory'); ?>/images/logo@2x.png" width="330" height="104" /></a>
					<?php $searchform = get_search_form(false);
					$searchform = str_replace("Search &hellip;", "Search Indian Vegetarian Recipes &hellip;", $searchform);
					$searchform = str_replace('value="Search"', 'value=""', $searchform);
					echo $searchform;
					?>

				</div>


				<div id="navbar" class="navbar">
					<nav id="site-navigation" class="navigation main-navigation" role="navigation">
						<h3 class="menu-toggle"><?php _e('Most Popular', 'twentythirteen'); ?></h3>
						<a class="screen-reader-text skip-link" href="#content" title="<?php esc_attr_e('Skip to content', 'twentythirteen'); ?>"><?php _e('Skip to content', 'twentythirteen'); ?></a>
						<?php wp_nav_menu(array('theme_location' => 'primary', 'menu_class' => 'nav-menu')); ?>
						<?php //get_search_form(); 
						?>
					</nav><!-- #site-navigation -->
				</div><!-- #navbar -->
		
			<?php } ?>
	</header><!-- #masthead -->



	<div id="page" class="hfeed site">

		<div id="main" class="site-main">
		



        Manjula's Kitchen is your home for Indian vegetarian recipes and delicious cooking videos. Watch Manjula teach mouthwatering appetizers, curries, desserts and many more, easy to make for all ages.