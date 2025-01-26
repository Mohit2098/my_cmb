<?php

/**
 * Twenty Thirteen functions and definitions
 *
 * Sets up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development
 * and http://codex.wordpress.org/Child_Themes), you can override certain
 * functions (those wrapped in a function_exists() call) by defining them first
 * in your child theme's functions.php file. The child theme's functions.php
 * file is included before the parent theme's file, so the child theme
 * functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters, @link http://codex.wordpress.org/Plugin_API
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */

/*
 * Set up the content width value based on the theme's design.
 *
 * @see twentythirteen_content_width() for template-specific adjustments.
 */


if (!isset($content_width))
	$content_width = 930;

/**
 * Add support for a custom header image.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Twenty Thirteen only works in WordPress 3.6 or later.
 */
if (version_compare($GLOBALS['wp_version'], '3.6-alpha', '<'))
	require get_template_directory() . '/inc/back-compat.php';

/**
 * Twenty Thirteen setup.
 *
 * Sets up theme defaults and registers the various WordPress features that
 * Twenty Thirteen supports.
 *
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses add_editor_style() To add Visual Editor stylesheets.
 * @uses add_theme_support() To add support for automatic feed links, post
 * formats, and post thumbnails.
 * @uses register_nav_menu() To add support for a navigation menu.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 * @since Twenty Thirteen 1.0
 *
 * @return void
 */
function twentythirteen_setup()
{
	/*
	 * Makes Twenty Thirteen available for translation.
	 *
	 * Translations can be added to the /languages/ directory.
	 * If you're building a theme based on Twenty Thirteen, use a find and
	 * replace to change 'twentythirteen' to the name of your theme in all
	 * template files.
	 */
	load_theme_textdomain('twentythirteen', get_template_directory() . '/languages');

	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, icons, and column width.
	 */
	add_editor_style(array('css/editor-style.css', 'fonts/genericons.css', twentythirteen_fonts_url()));

	// Adds RSS feed links to <head> for posts and comments.
	add_theme_support('automatic-feed-links');

	/*
	 * Switches default core markup for search form, comment form,
	 * and comments to output valid HTML5.
	 */
	add_theme_support('html5', array('search-form', 'comment-form', 'comment-list'));

	/*
	 * This theme supports all available post formats by default.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support('post-formats', array(
		'aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video'
	));

	// This theme uses wp_nav_menu() in one location.
	register_nav_menu('primary', __('Navigation Menu', 'twentythirteen'));

	/*
	 * This theme uses a custom image size for featured images, displayed on
	 * "standard" posts and pages.
	 */
	add_theme_support('post-thumbnails');
	//set_post_thumbnail_size( 604, 270, true );

	// This theme uses its own gallery styles.
	add_filter('use_default_gallery_style', '__return_false');


	add_theme_support("custom-background", $args);
}
add_action('after_setup_theme', 'twentythirteen_setup');

/**
 * Return the Google font stylesheet URL, if available.
 *
 * The use of Source Sans Pro and Bitter by default is localized. For languages
 * that use characters not supported by the font, the font can be disabled.
 *
 * @since Twenty Thirteen 1.0
 *
 * @return string Font stylesheet or empty string if disabled.
 */
function twentythirteen_fonts_url()
{
	$fonts_url = '';

	/* Translators: If there are characters in your language that are not
	 * supported by Source Sans Pro, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$source_sans_pro = _x('on', 'Source Sans Pro font: on or off', 'twentythirteen');

	/* Translators: If there are characters in your language that are not
	 * supported by Bitter, translate this to 'off'. Do not translate into your
	 * own language.
	 */
	$bitter = _x('on', 'Bitter font: on or off', 'twentythirteen');

	if ('off' !== $source_sans_pro || 'off' !== $bitter) {
		$font_families = array();

		if ('off' !== $source_sans_pro)
			$font_families[] = 'Source Sans Pro:300,400,700,300italic,400italic,700italic';

		if ('off' !== $bitter)
			$font_families[] = 'Bitter:400,700';

		$query_args = array(
			'family' => urlencode(implode('|', $font_families)),
			'subset' => urlencode('latin,latin-ext'),
		);
		$fonts_url = add_query_arg($query_args, "//fonts.googleapis.com/css");
	}

	return $fonts_url;
}

/**
 * Enqueue scripts and styles for the front end.
 *
 * @since Twenty Thirteen 1.0
 *
 * @return void
 */


function twentythirteen_scripts_styles()
{
	/*
	 * Adds JavaScript to pages with the comment form to support
	 * sites with threaded comments (when in use).
	 */
	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}

	// Adds Masonry to handle vertical alignment of footer widgets.
	// Uncomment the following lines if you need to use Masonry for the footer widgets.
	// if (is_active_sidebar('sidebar-1')) {
	//     wp_enqueue_script('jquery-masonry');
	// }

	

	    wp_enqueue_style('twentythirteen-style', get_stylesheet_uri(), array(), filemtime(get_stylesheet_directory() . '/style.css'));

	// Loads JavaScript file with functionality specific to Twenty Thirteen.
	wp_enqueue_script('twentythirteen-script', get_template_directory_uri() . '/js/functions.js', array('jquery'), '2013-07-18', true);

	// Add Source Sans Pro and Bitter fonts, used in the main stylesheet.
	wp_enqueue_style('twentythirteen-fonts', twentythirteen_fonts_url(), array(), null);

	// Add additional Google Fonts.
	wp_enqueue_style('custom-google-fonts', 'https://fonts.googleapis.com/css?family=Roboto|DM+Mono|Inter|Roboto+Flex|Raleway|Source+Serif+Pro|Work+Sans|Open+Sans|Jost|STIX+Two+Text', array(), null);

	wp_enqueue_style('bootstrap-css', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css');


	wp_enqueue_style('font-awesome', 'https://use.fontawesome.com/releases/v5.7.0/css/all.css', array(), '5.7.0');

	// Add a custom script file.
	wp_enqueue_script('script-js', get_template_directory_uri() . '/js/script.js', array(), time(), true);

	// Add Bootstrap JavaScript.
	wp_enqueue_script('bootstrap-js', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js', array('jQuery'), null, true);

	// Add Genericons font, used in the main stylesheet.
	wp_enqueue_style('genericons', get_template_directory_uri() . '/fonts/genericons.css', array(), '2.09');

	// Loads our main stylesheet.
	wp_enqueue_style('twentythirteen-style', get_stylesheet_uri(), array(), '2013-07-18');

	// Loads the Internet Explorer specific stylesheet.
	wp_enqueue_style('twentythirteen-ie', get_template_directory_uri() . '/css/ie.css', array('twentythirteen-style'), '2013-07-18');
	wp_style_add_data('twentythirteen-ie', 'conditional', 'lt IE 9');
}
add_action('wp_enqueue_scripts', 'twentythirteen_scripts_styles');



/**
These are additional jquery scripts to load

 **/
function custom_scripts()
{

	wp_enqueue_script('flex-slider-script', get_template_directory_uri() . '/js/jquery.flexslider-min.js', array('jquery'));
	wp_enqueue_style('flex-slider-style',  get_template_directory_uri() . '/css/flexslider.css');

	wp_enqueue_script('modernizr-script', get_template_directory_uri() . '/js/modernizr.min.js');

	wp_enqueue_script('gsap-script', get_template_directory_uri() . '/js/jquery.gsap.min.js', array('jquery'));
	wp_enqueue_script('gasp-tweenlite-script', get_template_directory_uri() . '/js/TweenLite.min.js', array('jquery'));

	wp_enqueue_script('masonry-script', get_template_directory_uri() . '/js/masonry.pkgd.min.js', array('jquery'));
}

add_action('wp_enqueue_scripts', 'custom_scripts');



/**
 * Filter the page title.
 *
 * Creates a nicely formatted and more specific title element text for output
 * in head of document, based on current view.
 *
 * @since Twenty Thirteen 1.0
 *
 * @param string $title Default title text for current view.
 * @param string $sep   Optional separator.
 * @return string The filtered title.
 */

function twentythirteen_wp_title($title, $sep)
{
	global $paged, $page;

	if (is_feed())
		return $title;

	// Add the site name.
	$title .= get_bloginfo('name');

	// Add the site description for the home/front page.
	$site_description = get_bloginfo('description', 'display');
	if ($site_description && (is_home() || is_front_page()))
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ($paged >= 2 || $page >= 2)
		$title = "$title $sep " . sprintf(__('Page %s', 'twentythirteen'), max($paged, $page));

	return $title;
}
add_filter('wp_title', 'twentythirteen_wp_title', 10, 2);

/**
 * Register two widget areas.
 *
 * @since Twenty Thirteen 1.0
 *
 * @return void
 */
function twentythirteen_widgets_init()
{
	register_sidebar(array(
		'name'          => __('Main Widget Area', 'twentythirteen'),
		'id'            => 'sidebar-1',
		'description'   => __('Appears in the footer section of the site.', 'twentythirteen'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	));

	register_sidebar(array(
		'name'          => __('Right Side Widget Area', 'twentythirteen'),
		'id'            => 'sidebar-2',
		'description'   => __('Appears on posts and pages in the sidebar (right).', 'twentythirteen'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	));
		
	register_sidebar( array(
		'name'          => __( 'Left Side Widget Area', 'twentythirteen' ),
		'id'            => 'sidebar-3',
		'description'   => __( 'Appears on posts and pages in the sidebar (left).', 'twentythirteen' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

}
add_action('widgets_init', 'twentythirteen_widgets_init');

if (!function_exists('twentythirteen_paging_nav')) :
	/**
	 * Display navigation to next/previous set of posts when applicable.
	 *
	 * @since Twenty Thirteen 1.0
	 *
	 * @return void
	 */
	function twentythirteen_paging_nav()
	{
		global $wp_query;

		// Don't print empty markup if there's only one page.
		if ($wp_query->max_num_pages < 2)
			return;
?>
		<nav class="navigation paging-navigation" role="navigation">
			<h1 class="screen-reader-text"><?php _e('Posts navigation', 'twentythirteen'); ?></h1>
			<div class="nav-links">

				<?php if (get_next_posts_link()) : ?>
					<div class="nav-previous"><?php next_posts_link(__('<span class="meta-nav">&larr;</span> Previous Entries', 'twentythirteen')); ?></div>
				<?php endif; ?>

				<?php if (get_previous_posts_link()) : ?>
					<div class="nav-next"><?php previous_posts_link(__('Next Entries <span class="meta-nav">&rarr;</span>', 'twentythirteen')); ?></div>
				<?php endif; ?>

			</div><!-- .nav-links -->
		</nav><!-- .navigation -->
	<?php
	}
endif;

if (!function_exists('twentythirteen_post_nav')) :
	/**
	 * Display navigation to next/previous post when applicable.
	 *
	 * @since Twenty Thirteen 1.0
	 *
	 * @return void
	 */
	function twentythirteen_post_nav()
	{
		global $post;

		// Don't print empty markup if there's nowhere to navigate.
		$previous = (is_attachment()) ? get_post($post->post_parent) : get_adjacent_post(false, '', true);
		$next     = get_adjacent_post(false, '', false);

		if (!$next && !$previous)
			return;
	?>
		<nav class="navigation post-navigation" role="navigation">
			<h1 class="screen-reader-text"><?php _e('Post navigation', 'twentythirteen'); ?></h1>
			<div class="nav-links">

				<?php previous_post_link('%link', _x('<span class="meta-nav">&larr;</span> %title', 'Previous post link', 'twentythirteen')); ?>
				<?php next_post_link('%link', _x('%title <span class="meta-nav">&rarr;</span>', 'Next post link', 'twentythirteen')); ?>

			</div><!-- .nav-links -->
		</nav><!-- .navigation -->
	<?php
	}
endif;

if (!function_exists('twentythirteen_entry_meta')) :
	/**
	 * Print HTML with meta information for current post: categories, tags, permalink, author, and date.
	 *
	 * Create your own twentythirteen_entry_meta() to override in a child theme.
	 *
	 * @since Twenty Thirteen 1.0
	 *
	 * @return void
	 */
	function twentythirteen_entry_meta()
	{
		if (is_sticky() && is_home() && !is_paged())
			echo '<span class="featured-post">' . __('Sticky', 'twentythirteen') . '</span>';

		if (!has_post_format('link') && 'post' == get_post_type())
			twentythirteen_entry_date();

		// Translators: used between list items, there is a space after the comma.
		$categories_list = get_the_category_list(__(', ', 'twentythirteen'));
		if ($categories_list) {
			echo '<span class="categories-links">' . $categories_list . '</span>';
		}

		// Translators: used between list items, there is a space after the comma.
		$tag_list = get_the_tag_list('', __(', ', 'twentythirteen'));
		if ($tag_list) {
			echo '<span class="tags-links">' . $tag_list . '</span>';
		}

		// Post author
		if ('post' == get_post_type()) {
			printf(
				'<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
				esc_url(get_author_posts_url(get_the_author_meta('ID'))),
				esc_attr(sprintf(__('View all posts by %s', 'twentythirteen'), get_the_author())),
				get_the_author()
			);
		}
	}
endif;

if (!function_exists('twentythirteen_entry_date')) :
	/**
	 * Print HTML with date information for current post.
	 *
	 * Create your own twentythirteen_entry_date() to override in a child theme.
	 *
	 * @since Twenty Thirteen 1.0
	 *
	 * @param boolean $echo (optional) Whether to echo the date. Default true.
	 * @return string The HTML-formatted post date.
	 */
	function twentythirteen_entry_date($echo = true)
	{
		if (has_post_format(array('chat', 'status')))
			$format_prefix = _x('%1$s on %2$s', '1: post format name. 2: date', 'twentythirteen');
		else
			$format_prefix = '%2$s';

		$date = sprintf(
			'<span class="date"><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a></span>',
			esc_url(get_permalink()),
			esc_attr(sprintf(__('Permalink to %s', 'twentythirteen'), the_title_attribute('echo=0'))),
			esc_attr(get_the_date('c')),
			esc_html(sprintf($format_prefix, get_post_format_string(get_post_format()), get_the_date()))
		);

		if ($echo)
			echo $date;

		return $date;
	}
endif;

if (!function_exists('twentythirteen_the_attached_image')) :
	/**
	 * Print the attached image with a link to the next attached image.
	 *
	 * @since Twenty Thirteen 1.0
	 *
	 * @return void
	 */
	function twentythirteen_the_attached_image()
	{
		/**
		 * Filter the image attachment size to use.
		 *
		 * @since Twenty thirteen 1.0
		 *
		 * @param array $size {
		 *     @type int The attachment height in pixels.
		 *     @type int The attachment width in pixels.
		 * }
		 */
		$attachment_size     = apply_filters('twentythirteen_attachment_size', array(724, 724));
		$next_attachment_url = wp_get_attachment_url();
		$post                = get_post();

		/*
	 * Grab the IDs of all the image attachments in a gallery so we can get the URL
	 * of the next adjacent image in a gallery, or the first image (if we're
	 * looking at the last image in a gallery), or, in a gallery of one, just the
	 * link to that image file.
	 */
		$attachment_ids = get_posts(array(
			'post_parent'    => $post->post_parent,
			'fields'         => 'ids',
			'numberposts'    => -1,
			'post_status'    => 'inherit',
			'post_type'      => 'attachment',
			'post_mime_type' => 'image',
			'order'          => 'ASC',
			'orderby'        => 'menu_order ID'
		));

		// If there is more than 1 attachment in a gallery...
		if (count($attachment_ids) > 1) {
			foreach ($attachment_ids as $attachment_id) {
				if ($attachment_id == $post->ID) {
					$next_id = current($attachment_ids);
					break;
				}
			}

			// get the URL of the next image attachment...
			if ($next_id)
				$next_attachment_url = get_attachment_link($next_id);

			// or get the URL of the first image attachment.
			else
				$next_attachment_url = get_attachment_link(array_shift($attachment_ids));
		}

		printf(
			'<a href="%1$s" title="%2$s" rel="attachment">%3$s</a>',
			esc_url($next_attachment_url),
			the_title_attribute(array('echo' => false)),
			wp_get_attachment_image($post->ID, $attachment_size)
		);
	}
endif;

/**
 * Return the post URL.
 *
 * @uses get_url_in_content() to get the URL in the post meta (if it exists) or
 * the first link found in the post content.
 *
 * Falls back to the post permalink if no URL is found in the post.
 *
 * @since Twenty Thirteen 1.0
 *
 * @return string The Link format URL.
 */
function twentythirteen_get_link_url()
{
	$content = get_the_content();
	$has_url = get_url_in_content($content);

	return ($has_url) ? $has_url : apply_filters('the_permalink', get_permalink());
}

/**
 * Extend the default WordPress body classes.
 *
 * Adds body classes to denote:
 * 1. Single or multiple authors.
 * 2. Active widgets in the sidebar to change the layout and spacing.
 * 3. When avatars are disabled in discussion settings.
 *
 * @since Twenty Thirteen 1.0
 *
 * @param array $classes A list of existing body class values.
 * @return array The filtered body class list.
 */
function twentythirteen_body_class($classes)
{
	if (!is_multi_author())
		$classes[] = 'single-author';

	if (is_active_sidebar('sidebar-2') && !is_attachment() && !is_404())
		$classes[] = 'sidebar';

	if (!get_option('show_avatars'))
		$classes[] = 'no-avatars';

	return $classes;
}
add_filter('body_class', 'twentythirteen_body_class');

/**
 * Adjust content_width value for video post formats and attachment templates.
 *
 * @since Twenty Thirteen 1.0
 *
 * @return void
 */
function twentythirteen_content_width()
{
	global $content_width;

	if (is_attachment())
		$content_width = 724;
	elseif (has_post_format('audio'))
		$content_width = 484;
}
add_action('template_redirect', 'twentythirteen_content_width');

/**
 * Add postMessage support for site title and description for the Customizer.
 *
 * @since Twenty Thirteen 1.0
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 * @return void
 */
function twentythirteen_customize_register($wp_customize)
{
	$wp_customize->get_setting('blogname')->transport         = 'postMessage';
	$wp_customize->get_setting('blogdescription')->transport  = 'postMessage';
	$wp_customize->get_setting('header_textcolor')->transport = 'postMessage';
}
add_action('customize_register', 'twentythirteen_customize_register');

/**
 * Enqueue Javascript postMessage handlers for the Customizer.
 *
 * Binds JavaScript handlers to make the Customizer preview
 * reload changes asynchronously.
 *
 * @since Twenty Thirteen 1.0
 *
 * @return void
 */
function twentythirteen_customize_preview_js()
{
	wp_enqueue_script('twentythirteen-customizer', get_template_directory_uri() . '/js/theme-customizer.js', array('customize-preview'), '20130226', true);
}
add_action('customize_preview_init', 'twentythirteen_customize_preview_js');





function myTruncate($str, $length = 10, $trailing = '...')
{
	// take off chars for the trailing 
	$length -= strlen($trailing);
	if (strlen($str) > $length) {
		// string exceeded length, truncate and add trailing dots 
		return substr($str, 0, $length) . $trailing;
	} else {
		// string was already short enough, return the string 
		$res = $str;
	}

	return $res;
}



//DISABLED at the moment
// Add ID and CLASS attributes to the first <ul> occurence in wp_page_menu
//function add_products($content) {
//    return preg_replace ("/Contact<\/a><\/li>(?!.*<\/li>)/", "Contact</a></li><li class=\"online_store\"><a href=\"#\" onclick=\"window.open('http://astore.amazon.com/manjulaskcom-20',2343,'width=815,height=600,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1')\">Products</a></li>", $content, -1);
//}
//add_filter('wp_nav_menu','add_products');



//This wraps a div container around the video embeds
//useful for styling - so dont affect other iframes on the same page
function custom_oembed_filter($html, $url, $attr, $post_ID)
{
	$return = '<div class="video-container">' . $html . '</div>';
	return $return;
}
add_filter('embed_oembed_html', 'custom_oembed_filter', 10, 4);



//Automatically insert google ads below the youtube videos
function add_googleAd_under_video($content)
{

	//Don't add the google ad for the home page.
	if (!is_page('home')) {

		//return preg_replace ("/\[\/youtube\]/", "[/youtube]
		return preg_replace("/allowfullscreen\>\<\/iframe\>\<\/div\>/", "allowfullscreen></iframe></div>
        
            <div class=\"google_ad\">
			<script async src=\"//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js\"></script>
			<!-- 336x280, below recipe -->
			<ins class=\"adsbygoogle\"
				 style=\"display:inline-block;width:336px;height:280px\"
				 data-ad-client=\"ca-pub-7375354652362298\"
				 data-ad-slot=\"4719842520\"></ins>
			<script>
			(adsbygoogle = window.adsbygoogle || []).push({});
			</script>
            </div>
        
        ", $content, -1);
	}
}
//add_filter('the_content','add_googleAd_under_video');


//Add google ad (336x280) under the User Submitted Recipe Image
function add_googleAd_under_image($content)
{
	return preg_replace("/Recipe submitted by/", "
    
        <div class=\"google_ad\">
		<script async src=\"//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js\"></script>
		<!-- 336x280, below recipe -->
		<ins class=\"adsbygoogle\"
			 style=\"display:inline-block;width:336px;height:280px\"
			 data-ad-client=\"ca-pub-7375354652362298\"
			 data-ad-slot=\"4719842520\"></ins>
		<script>
		(adsbygoogle = window.adsbygoogle || []).push({});
		</script>
        </div>
    
    Recipe submitted by", $content, -1);
}
add_filter('the_content','add_googleAd_under_image');


//Add Pagination

function numeric_posts_nav()
{

	if (is_singular())
		return;

	global $wp_query;

	/** Stop execution if there's only 1 page */
	if ($wp_query->max_num_pages <= 1) {
		printf("<span>&nbsp;</span>");  //needed for empty padding
		return;
	}

	$paged = get_query_var('paged') ? absint(get_query_var('paged')) : 1;
	$max   = intval($wp_query->max_num_pages);

	/**	Add current page to the array */
	if ($paged >= 1)
		$links[] = $paged;

	/**	Add the pages around the current page to the array */
	if ($paged >= 3) {
		$links[] = $paged - 1;
		$links[] = $paged - 2;
	}

	if (($paged + 2) <= $max) {
		$links[] = $paged + 2;
		$links[] = $paged + 1;
	}

	echo '<div class="paged-navigation"><ul>' . "\n";

	/**	Previous Post Link */
	if (get_previous_posts_link())
		printf('<li>%s</li>' . "\n", get_previous_posts_link());

	/**	Link to first page, plus ellipses if necessary */
	if (!in_array(1, $links)) {
		$class = 1 == $paged ? ' class="active"' : '';

		printf('<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link(1)), '1');

		if (!in_array(2, $links))
			echo '<li>…</li>';
	}

	/**	Link to current page, plus 2 pages in either direction if necessary */
	sort($links);
	foreach ((array) $links as $link) {
		$class = $paged == $link ? ' class="active"' : '';
		printf('<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link($link)), $link);
	}

	/**	Link to last page, plus ellipses if necessary */
	if (!in_array($max, $links)) {
		if (!in_array($max - 1, $links))
			echo '<li>…</li>' . "\n";

		$class = $paged == $max ? ' class="active"' : '';
		printf('<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link($max)), $max);
	}

	/**	Next Post Link */
	if (get_next_posts_link())
		printf('<li>%s</li>' . "\n", get_next_posts_link());

	echo '</ul></div>' . "\n";
}


//Add Pagination
function numeric_posts_nav_for_page($max_num_pages = 0)
{

	/** Stop execution if there's only 1 page */
	if ($max_num_pages <= 1)
		return;

	$paged = get_query_var('paged') ? absint(get_query_var('paged')) : 1;
	$max = $max_num_pages;
	/** Add current page to the array */
	if ($paged >= 1)
		$links[] = $paged;

	/** Add the pages around the current page to the array */
	if ($paged >= 3) {
		$links[] = $paged - 1;
		$links[] = $paged - 2;
	}

	if (($paged + 2) <= $max) {
		$links[] = $paged + 2;
		$links[] = $paged + 1;
	}

	echo '<div class="paged-navigation"><ul>' . "\n";

	/**	Previous Post Link */
	if (get_previous_posts_link())
		printf('<li>%s</li>' . "\n", get_previous_posts_link());

	/**	Link to first page, plus ellipses if necessary */
	if (!in_array(1, $links)) {
		$class = 1 == $paged ? ' class="active"' : '';

		printf('<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link(1)), '1');

		if (!in_array(2, $links))
			echo '<li>…</li>';
	}

	/**	Link to current page, plus 2 pages in either direction if necessary */
	sort($links);
	foreach ((array) $links as $link) {
		$class = $paged == $link ? ' class="active"' : '';
		printf('<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link($link)), $link);
	}

	/**	Link to last page, plus ellipses if necessary */
	if (!in_array($max, $links)) {
		if (!in_array($max - 1, $links))
			echo '<li>…</li>' . "\n";

		$class = $paged == $max ? ' class="active"' : '';
		printf('<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link($max)), $max);
	}

	/**	Next Post Link */
	if (get_next_posts_link())
		printf('<li>%s</li>' . "\n", get_next_posts_link());

	echo '</ul></div>' . "\n";
}



//Customize the LOGIN Screen with custom logo and link

function my_login_logo()
{ ?>
	<style type="text/css">
	
		body.login div#login h1 a {
			background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/images/logo.png);
			padding-bottom: 30px;
			background-size: 330px 104px !important;
			width: 100% !important;
		}
	</style>
	<?php }
add_action('login_enqueue_scripts', 'my_login_logo');


//disable the admin toolbar or logged-in users
add_filter('show_admin_bar', '__return_false');

//Remove the website field from the comments form
add_filter('comment_form_default_fields', 'unset_url_field');
function unset_url_field($fields)
{
	if (isset($fields['url']))
		unset($fields['url']);
	return $fields;
}




// register nav menu for quick links 
function register_quick_links_menu()
{
	register_nav_menu('quick-links-menu', __('Quick Links Menu'));
}
add_action('init', 'register_quick_links_menu');


// Handle AJAX request to load more blog posts
// 

add_action('wp_ajax_load_more_posts', 'load_more_posts');
add_action('wp_ajax_nopriv_load_more_posts', 'load_more_posts');

function load_more_posts() {
     $paged = isset($_POST['paged']) ? intval($_POST['paged']) : 1;
    $banner_post_id = isset($_POST['banner_post_id']) ? intval($_POST['banner_post_id']) : 0;
    $posts_per_page = 2;

    // Calculate the offset
    $offset = ($paged) * $posts_per_page;

    // Define the query parameters
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => $posts_per_page,
        'category_name' => 'news-and-updates',
        'paged' => $paged,
        'offset' => $offset,
        'post__not_in' => array($banner_post_id), // Exclude the banner post
    );

    // Execute the query
    $blogs = new WP_Query($args);

    // Check if there are posts
    if ($blogs->have_posts()) {
        ob_start();
        while ($blogs->have_posts()) : $blogs->the_post();
            $post_id = get_the_ID();
            $user_id = get_current_user_id();
            $saved_posts = get_user_meta($user_id, 'saved_posts', true);
            $is_saved = is_array($saved_posts) && in_array($post_id, $saved_posts);?>
            <div class="blog-card aaa" data-post-id="<?php echo esc_attr($post_id); ?>">
               
						 <?php 
    $thumbnail_url = get_the_post_thumbnail_url($post_id, 'large');
    $noImage = get_stylesheet_directory_uri() . "/images/no-post-img.jpg";
    ?>
				<a href="<?php the_permalink(); ?>">
					<?php if ($thumbnail_url) : ?>
						<div class="grid-post-thumbnail" style="background-image: url('<?php echo esc_url($thumbnail_url); ?>'); background-size: cover; background-position: center;">
						</div>
					<?php else : ?>
						<div class="grid-post-thumbnail" style="background-image: url('<?php echo esc_url($noImage); ?>'); background-size: cover; background-position: center;">
						</div>
				<?php endif;?>
				</a>
				
                <div class="grid-post-content">
                    <div class="grid-post-category">
                        <?php
                        $categories = get_the_category();
                        if (!empty($categories)) :
                            $category_links = array();
                            foreach ($categories as $category) :
                                $category_links[] = '<a href="' . esc_url(get_category_link($category->term_id)) . '" class="grid-category-label">' . esc_html($category->name) . '</a>';
                            endforeach;
                            echo implode(', ', $category_links);
                        endif;
                        ?>
                    </div>
                    <h4 class="grid-post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                    <p><a class="grid-post-desc" href="<?php the_permalink(); ?>"><?php echo wp_trim_words(get_the_excerpt(), 40, '...'); ?></a></p>
                    <div class="grid-post-meta">
                        <span class="grid-post-author-info">Posted By
                           	
                                        <?php $avatar =  get_avatar(get_the_author_meta('ID'), 32); 
										
										if ($avatar) {
											echo $avatar;
										} 
										else {
										?>
	                                  <img src="<?php echo get_template_directory_uri(); ?>/images/author-default-icon.png" alt="author-default-icon" class="author-default-icon-cl">
    <?php
}
?>
                            <?php the_author(); ?> | <?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' ago'; ?>
                        </span>
                        <span class="read-time"></span>
						   <?php if (is_user_logged_in()) : ?>
                            <div class="svg-container">
                                <?php $svg = get_template_directory_uri() . '/images/Vector.svg'; ?>
                                <img class="save-post-icon" src="<?php echo $svg; ?>">
                                <button class="save-post-btn <?php echo $is_saved ? 'saved' : ''; ?>" data-post-id="<?php echo esc_attr($post_id); ?>">
                                    <div class="icon-cl">
                                        <?php echo $is_saved ? '-' : '+'; ?>
                                    </div>
                                </button>
                            </div>
						<?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endwhile;
        $response = ob_get_clean();
        echo $response;
    }
    wp_die();
}



// Check if a post is saved by the current user
function check_saved_status()
{
	if (isset($_POST['post_id'])) {
		$post_id = intval($_POST['post_id']);
		$user_id = get_current_user_id();
		$saved_posts = get_user_meta($user_id, 'saved_posts', true);

		if (is_array($saved_posts) && in_array($post_id, $saved_posts)) {
			echo 'saved';
		} else {
			echo 'not_saved';
		}
	}
	wp_die();
}

// Save a post for the current user
function save_post()
{
	if (isset($_POST['post_id'])) {
		$post_id = intval($_POST['post_id']);
		$user_id = get_current_user_id();
		$saved_posts = get_user_meta($user_id, 'saved_posts', true);

		if (!$saved_posts) {
			$saved_posts = array();
		}

		if (!in_array($post_id, $saved_posts)) {
			$saved_posts[] = $post_id;
			update_user_meta($user_id, 'saved_posts', $saved_posts);
			echo 'saved';
		} else {
			echo 'already_saved';
		}
	}
	wp_die();
}

// Unsave a post for the current user
function unsave_post()
{
	if (isset($_POST['post_id'])) {
		$post_id = intval($_POST['post_id']);
		$user_id = get_current_user_id();
		$saved_posts = get_user_meta($user_id, 'saved_posts', true);

		if (($key = array_search($post_id, $saved_posts)) !== false) {
			unset($saved_posts[$key]);
			update_user_meta($user_id, 'saved_posts', $saved_posts);
			echo 'unsaved';
		} else {
			echo 'not_saved';
		}
	}
	wp_die();
}

add_action('wp_ajax_save_post', 'save_post');
add_action('wp_ajax_unsave_post', 'unsave_post');
add_action('wp_ajax_check_saved_status', 'check_saved_status');

// Register a custom post type for FAQs

// Function to create the FAQ custom post type
function create_faq_cpt() {
    // Define the labels for the FAQ post type
    $labels = array(
        'name' => 'Faqs',
        'singular_name' => 'Faq',
    );

    // Define the arguments for the FAQ post type
    $args = array(
        'label' => 'FAQ',
        'labels' => $labels,
        'supports' => array('title', 'editor', 'thumbnail'),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => true,
        'can_export' => true,
        'has_archive' => true,
        'hierarchical' => false,
        'exclude_from_search' => false,
        'show_in_rest' => true,
        'publicly_queryable' => true,
        'capability_type' => 'post',
    );

    // Register the FAQ post type
    register_post_type('faq', $args);
}

// Function to create the FAQ category taxonomy
function create_faq_category_taxonomy() {
    // Define the labels for the FAQ category taxonomy
    $labels = array(
        'name' => 'Faq Categories',
        'singular_name' => 'FAQ Category',
    );

    // Define the arguments for the FAQ category taxonomy
    $args = array(
        'labels' => $labels,
        'hierarchical' => true, // Set to true for category-like behavior
        'public' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => true,
        'show_tagcloud' => true,
        'show_in_rest' => true,
    );

    // Register the FAQ category taxonomy
    register_taxonomy('faq_category', array('faq'), $args);
}

// Hook into the 'init' action to register the FAQ post type and FAQ category taxonomy
add_action('init', 'create_faq_cpt');
add_action('init', 'create_faq_category_taxonomy');


// Handle AJAX request to search FAQs
function ajax_faq_search()
{
	// Get the search query from the POST request
	$search_query = isset($_POST['query']) ? sanitize_text_field($_POST['query']) : '';

	// Define the query parameters for searching FAQs
	$faq_query_args = array(
		'post_type' => 'faq',
		'posts_per_page' => -1
	);

	// If a search query is provided, add it to the query parameters
	if (!empty($search_query)) {
		$faq_query_args['s'] = $search_query;
	}

	// Execute the query
	$faq_query = new WP_Query($faq_query_args);

	// Check if there are any FAQs that match the query
	if ($faq_query->have_posts()) :
		while ($faq_query->have_posts()) : $faq_query->the_post(); ?>
			<div class="col-md-4">
				<div class="faq-item">
					<?php if (has_post_thumbnail()) : ?>
						<div class="faq-image">
							<?php the_post_thumbnail('thumbnail', ['class' => 'img-fluid']); ?>
						</div>
					<?php endif; ?>
					<div>
						<h4 class="faq-title"><?php the_title(); ?></h4>
						<span class="faq-text"><?php the_content(); ?></span>
					</div>
				</div>
			</div>
		<?php endwhile;
		wp_reset_postdata();
	else :

		echo '<p>' . __('Sorry, no FAQs found.') . '</p>';
	endif;

	// Terminate the AJAX request
	wp_die();
}
add_action('wp_ajax_faq_search', 'ajax_faq_search');
add_action('wp_ajax_nopriv_faq_search', 'ajax_faq_search');

// Enqueue Font Awesome CSS
function enqueue_font_awesome()
{
	// Enqueue the Font Awesome stylesheet from a CDN
	wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css');
}
add_action('wp_enqueue_scripts', 'enqueue_font_awesome');

// Shortcode to display the last modified date of the Terms and Conditions page
function terms_last_modified_date_shortcode()
{

	$terms_page = get_page_by_path('terms-and-conditions');

	if ($terms_page) {

		// Get the last modified date of the page
		$last_modified_date = get_the_modified_date('F j, Y', $terms_page->ID);

		// Return the last modified date
		return $last_modified_date;
	}
}
add_shortcode('terms_last_modified_date', 'terms_last_modified_date_shortcode');


// function get_star_rating_html($rating_average) {
//     if (empty($rating_average)) {
//         return '<span>No data found</span>';
//     }

//     $full_stars = floor($rating_average);
//     $decimal_part = $rating_average - $full_stars;

//     // Determine fill percentage for half star
//     $fill_percentage = 0;
//     if ($decimal_part >= 0.75) {
//         $fill_percentage = 75;
//     } elseif ($decimal_part >= 0.50) {
//         $fill_percentage = 50;
//     } elseif ($decimal_part >= 0.25) {
//         $fill_percentage = 25;
//     }

//     $empty_stars = 5 - ceil($rating_average);

//     $full_star_svg = '<svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 36.09 36.09">
//         <path fill="#000000" d="M36.042,13.909c-0.123-0.377-0.456-0.646-0.85-0.688l-11.549-1.172L18.96,1.43c-0.16-0.36-0.519-0.596-0.915-0.596
//         s-0.755,0.234-0.915,0.598L12.446,12.05L0.899,13.221c-0.394,0.04-0.728,0.312-0.85,0.688c-0.123,0.377-0.011,0.791,0.285,1.055
//         l8.652,7.738L6.533,34.045c-0.083,0.387,0.069,0.787,0.39,1.02c0.175,0.127,0.381,0.191,0.588,0.191
//         c0.173,0,0.347-0.045,0.503-0.137l10.032-5.84l10.03,5.84c0.342,0.197,0.77,0.178,1.091-0.059c0.32-0.229,0.474-0.633,0.391-1.02
//         l-2.453-11.344l8.653-7.737C36.052,14.699,36.165,14.285,36.042,13.909z M25.336,21.598c-0.268,0.24-0.387,0.605-0.311,0.957
//         l2.097,9.695l-8.574-4.99c-0.311-0.182-0.695-0.182-1.006,0l-8.576,4.99l2.097-9.695c0.076-0.352-0.043-0.717-0.311-0.957
//         l-7.396-6.613l9.87-1.002c0.358-0.035,0.668-0.264,0.814-0.592l4.004-9.077l4.003,9.077c0.146,0.328,0.456,0.557,0.814,0.592
//         l9.87,1.002L25.336,21.598z"/>
//     </svg>';

//     $half_star_svg = '<svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 36.09 36.09">
//         <path fill="#343434" d="M36.042,13.909c-0.123-0.377-0.456-0.646-0.85-0.688l-11.549-1.172L18.96,1.43c-0.16-0.36-0.519-0.596-0.915-0.596
//         s-0.755,0.234-0.915,0.598L12.446,12.05L0.899,13.221c-0.394,0.04-0.728,0.312-0.85,0.688c-0.123,0.377-0.011,0.791,0.285,1.055
//         l8.652,7.738L6.533,34.045c-0.083,0.387,0.069,0.787,0.39,1.02c0.175,0.127,0.381,0.191,0.588,0.191
//         c0.173,0,0.347-0.045,0.503-0.137l10.032-5.84l10.03,5.84c0.342,0.197,0.77,0.178,1.091-0.059c0.32-0.229,0.474-0.633,0.391-1.02
//         l-2.453-11.344l8.653-7.737C36.052,14.699,36.165,14.285,36.042,13.909z M25.336,21.598c-0.268,0.24-0.387,0.605-0.311,0.957
//         l2.097,9.695l-8.574-4.99c-0.311-0.182-0.695-0.182-1.006,0l-8.576,4.99l2.097-9.695c0.076-0.352-0.043-0.717-0.311-0.957
//         l-7.396-6.613l9.87-1.002c0.358-0.035,0.668-0.264,0.814-0.592l4.004-9.077l4.003,9.077c0.146,0.328,0.456,0.557,0.814,0.592
//         l9.87,1.002L25.336,21.598z"/>
//     </svg>';

//     $stars_html = '<div class="star-rating">';

//     // Full stars
//     for ($i = 0; $i < $full_stars; $i++) {
//         $stars_html .= '<span class="star full-star">' . $full_star_svg . '</span>';
//     }

//     // Half star
//     if ($fill_percentage > 0) {
//         $stars_html .= '<span class="star half-star fill-' . $fill_percentage . '">' . $half_star_svg . '</span>';
//     }

//     // Empty stars
//     for ($i = 0; $i < $empty_stars; $i++) {
//         $stars_html .= '<span class="star empty-star">&#9734;</span>';
//     }

//     $stars_html .= '</div>';

//     return $stars_html;
// }



function get_star_rating_html($rating_average) {
    if (empty($rating_average)) {
        return '<span class="no-ratings">No ratings yet</span>';
    }

    $full_stars = floor($rating_average);
    $decimal_part = $rating_average - $full_stars;

    // Determine fill percentage for half star
    $fill_percentage = 0;
    if ($decimal_part >= 0.75) {
        $fill_percentage = 75;
    } elseif ($decimal_part >= 0.50) {
        $fill_percentage = 50;
    } elseif ($decimal_part >= 0.25) {
        $fill_percentage = 25;
    }

    $empty_stars = 5 - ceil($rating_average);

    $full_star_svg = '<svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 36.09 36.09">
        <path fill="#000000" d="M36.042,13.909c-0.123-0.377-0.456-0.646-0.85-0.688l-11.549-1.172L18.96,1.43c-0.16-0.36-0.519-0.596-0.915-0.596
        s-0.755,0.234-0.915,0.598L12.446,12.05L0.899,13.221c-0.394,0.04-0.728,0.312-0.85,0.688c-0.123,0.377-0.011,0.791,0.285,1.055
        l8.652,7.738L6.533,34.045c-0.083,0.387,0.069,0.787,0.39,1.02c0.175,0.127,0.381,0.191,0.588,0.191
        c0.173,0,0.347-0.045,0.503-0.137l10.032-5.84l10.03,5.84c0.342,0.197,0.77,0.178,1.091-0.059c0.32-0.229,0.474-0.633,0.391-1.02
        l-2.453-11.344l8.653-7.737C36.052,14.699,36.165,14.285,36.042,13.909z M25.336,21.598c-0.268,0.24-0.387,0.605-0.311,0.957
        l2.097,9.695l-8.574-4.99c-0.311-0.182-0.695-0.182-1.006,0l-8.576,4.99l2.097-9.695c0.076-0.352-0.043-0.717-0.311-0.957
        l-7.396-6.613l9.87-1.002c0.358-0.035,0.668-0.264,0.814-0.592l4.004-9.077l4.003,9.077c0.146,0.328,0.456,0.557,0.814,0.592
        l9.87,1.002L25.336,21.598z"/>
    </svg>';

    $half_star_svg = '<svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 36.09 36.09">
        <path fill="#000000" d="M36.042,13.909c-0.123-0.377-0.456-0.646-0.85-0.688l-11.549-1.172L18.96,1.43c-0.16-0.36-0.519-0.596-0.915-0.596
        s-0.755,0.234-0.915,0.598L12.446,12.05L0.899,13.221c-0.394,0.04-0.728,0.312-0.85,0.688c-0.123,0.377-0.011,0.791,0.285,1.055
        l8.652,7.738L6.533,34.045c-0.083,0.387,0.069,0.787,0.39,1.02c0.175,0.127,0.381,0.191,0.588,0.191
        c0.173,0,0.347-0.045,0.503-0.137l10.032-5.84l10.03,5.84c0.342,0.197,0.77,0.178,1.091-0.059c0.32-0.229,0.474-0.633,0.391-1.02
        l-2.453-11.344l8.653-7.737C36.052,14.699,36.165,14.285,36.042,13.909z M25.336,21.598c-0.268,0.24-0.387,0.605-0.311,0.957
        l2.097,9.695l-8.574-4.99c-0.311-0.182-0.695-0.182-1.006,0l-8.576,4.99l2.097-9.695c0.076-0.352-0.043-0.717-0.311-0.957
        l-7.396-6.613l9.87-1.002c0.358-0.035,0.668-0.264,0.814-0.592l4.004-9.077l4.003,9.077c0.146,0.328,0.456,0.557,0.814,0.592
        l9.87,1.002L25.336,21.598z"/>
    </svg>';

    $empty_star_svg = '<svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 36.09 36.09">
        <path fill="#343434" d="M36.042,13.909c-0.123-0.377-0.456-0.646-0.85-0.688l-11.549-1.172L18.96,1.43c-0.16-0.36-0.519-0.596-0.915-0.596
        s-0.755,0.234-0.915,0.598L12.446,12.05L0.899,13.221c-0.394,0.04-0.728,0.312-0.85,0.688c-0.123,0.377-0.011,0.791,0.285,1.055
        l8.652,7.738L6.533,34.045c-0.083,0.387,0.069,0.787,0.39,1.02c0.175,0.127,0.381,0.191,0.588,0.191
        c0.173,0,0.347-0.045,0.503-0.137l10.032-5.84l10.03,5.84c0.342,0.197,0.77,0.178,1.091-0.059c0.32-0.229,0.474-0.633,0.391-1.02
        l-2.453-11.344l8.653-7.737C36.052,14.699,36.165,14.285,36.042,13.909z M25.336,21.598c-0.268,0.24-0.387,0.605-0.311,0.957
        l2.097,9.695l-8.574-4.99c-0.311-0.182-0.695-0.182-1.006,0l-8.576,4.99l2.097-9.695c0.076-0.352-0.043-0.717-0.311-0.957
        l-7.396-6.613l9.87-1.002c0.358-0.035,0.668-0.264,0.814-0.592l4.004-9.077l4.003,9.077c0.146,0.328,0.456,0.557,0.814,0.592
        l9.87,1.002L25.336,21.598z"/>
    </svg>';

    $html = '<div class="star-rating">';

    for ($i = 0; $i < $full_stars; $i++) {
        $html .= '<span class="star full-star">' . $full_star_svg . '</span>';
    }

    if ($fill_percentage > 0) {
        $html .= '<span class="star half-star fill-' . $fill_percentage . '">' . $half_star_svg . '</span>';
    }

    for ($i = 0; $i < $empty_stars; $i++) {
        $html .= '<span class="star empty-star">' . $empty_star_svg . '</span>';
    }

    $html .= '</div>';

    return $html;
}


// Ajax for homepage
// 
// 
function set_post_views($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}

// To keep the count accurate, prevent bots from triggering it
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

function track_post_views ($post_id) {
    if ( !is_single() ) return;
    if ( empty ( $post_id) ) {
        global $post;
        $post_id = $post->ID;    
    }
    set_post_views($post_id);
}
add_action( 'wp_head', 'track_post_views');


function get_post_views($postID){
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0 View";
    }
    return $count.' Views';
}

function load_posts_by_category() {
    // Retrieve and sanitize parameters
    $category_id = isset($_POST['category_id']) && $_POST['category_id'] !== 'most-popular' ? intval($_POST['category_id']) : '';
    $search_query = isset($_POST['search']) ? sanitize_text_field($_POST['search']) : '';
    $offset = 0; // Handle offset

    $args = array(
        'post_type'      => 'post',
        'posts_per_page' => 21, 
        'post_status'    => 'publish',
        'offset'         => $offset // Use offset for pagination
    );

    if (!empty($category_id)) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'category',
                'field'    => 'term_id',
                'terms'    => $category_id,
            ),
        );
    }
    
    if (!empty($search_query)) {
        add_filter('posts_where', 'filter_where_post_title_only', 10, 2);
        $args['s'] = $search_query;
        $args['meta_key'] = 'post_views_count';
        $args['orderby'] = 'meta_value_num';
        $args['order'] = 'DESC';
    } else {
        $args['orderby'] = 'date';
        $args['order'] = 'DESC';
    }
 
    $post_query = new WP_Query($args);

    ob_start();

    if ($post_query->have_posts()) {
        $posts_in_row = 0;
        $rows_counter = 0;

        echo '<div class="row hm-mn-rw">';

        while ($post_query->have_posts()) : $post_query->the_post();
            global $post;
            ?>
            <div class="col-md-4 category-posts-cl">
                <input type="hidden" data-posts-per-page="<?php echo esc_attr($args['posts_per_page']); ?>">
                <div class="category-grid-card-cl">
                    <?php $thumbnail_url = get_the_post_thumbnail_url($post->ID, 'medium'); ?>
                    <?php $noImage = get_stylesheet_directory_uri() . "/images/no-post-img.jpg"; ?>
                    <a class="ctgdc_img" href="<?php echo esc_url(get_permalink()); ?>">
                        <div class="category-post-image-cl" style="background-image: url('<?php echo esc_url($thumbnail_url ? $thumbnail_url : $noImage); ?>'); background-size: cover; background-position: center;"></div>
                    </a>
                    <?php
                        $post_excerpt = get_the_excerpt($post->ID);
                        $post_excerpt = preg_replace('/https?:\/\/www\.youtube\.com\/watch\?v=[^ \t\n\r]+/', '', $post_excerpt);
                        $post_excerpt = preg_replace('/\[embed[^\]]*\]https?:\/\/www\.youtube\.com\/watch\?v=[^\]]*\[\/embed\]/s', '', $post_excerpt);
                    ?>
                    <a class="title_category" href="<?php echo esc_url(get_permalink()); ?>">
                        <h5 class="category-title-cl">
                            <?php echo wp_trim_words(get_the_title(), 6, '...'); ?>
                        </h5>
                        <div class="list_dec">
                            <p>
                                <?php echo $post_excerpt; ?>
                            </p>
                        </div>
                    </a>
                    
                    <div class="recipe-stars-ratings" style="padding-left: 5px;">
                        <?php $rating_average = get_post_meta($post->ID, 'wprm_rating_average', true); ?>
                        <?php echo get_star_rating_html($rating_average); ?>
                    </div>
                    <hr>
                    <?php
                    echo '<p class="category-desc-cl">' . $post_excerpt . '</p>';
                    ?>
                    <a href="<?php echo esc_url(get_permalink($post->ID)); ?>" class="btn banner-cat-grid-btn">Read Recipe</a>
                </div>
            </div>
            <?php
            $posts_in_row++; // Increment the post count within the current row

            // If the row has 3 posts, close the row and possibly insert an ad
            if ($posts_in_row % 3 == 0) {
                echo '</div>'; 
                $rows_counter++;

                // Every 2 rows, insert the Google ad
                if ($rows_counter % 2 == 0) {
                    ?>
                    <div class="row hm-mn-rw">
                        <div class="col-md-12">
                            <div id="google_ad_full_width" class="hm-google-ad-full-width"> 
                                <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7375354652362298"
                                         crossorigin="anonymous"></script>
                                <!-- Horizontal responsive ad -->
                                <ins class="adsbygoogle"
                                     style="display:block" 
                                     data-ad-client="ca-pub-7375354652362298" 
                                     data-ad-slot="5805387952" 
                                     data-ad-format="auto" 
                                     data-full-width-responsive="true"></ins> 
                                <script>
                                    (adsbygoogle = window.adsbygoogle || []).push({});
                                </script> 
                            </div> 
                        <div class="mb-google-mb-ads">
                        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7375354652362298"
                            crossorigin="anonymous"></script>
                        <ins class="adsbygoogle"
                            style="display:block"
                            data-ad-format="fluid"
                            data-ad-layout-key="-6t+ed+2i-1n-4w"
                            data-ad-client="ca-pub-7375354652362298"
                            data-ad-slot="2222775671"></ins>
                        <script>
                            (adsbygoogle = window.adsbygoogle || []).push({});
                        </script>
                        </div> 
                        </div>
                    </div> 
                    <?php 
                }

                // Start a new row for the next set of posts
                echo '<div class="row hm-mn-rw">'; 
                $posts_in_row = 0; // Reset the counter for the new row
            }

        endwhile;
        echo '</div>'; // Close the final row

        wp_reset_postdata();
    } else {
        echo '<p>No posts found</p>';
    }

    $output = ob_get_clean();
    echo $output;
    wp_die();
}







// Custom filter function to search by post title only
// 
function filter_where_post_title_only($where, $wp_query) {
    global $wpdb;
    $search = $wp_query->get('s');
    if ($search) {
        $where .= ' AND ' . $wpdb->posts . '.post_title LIKE \'%' . esc_sql($wpdb->esc_like($search)) . '%\'';
    }
    return $where;
}

function get_ratings_by_comment_id($comment_id) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'wp_wprm_ratings';

    $ratings = $wpdb->get_results($wpdb->prepare(
        "SELECT rating FROM $table_name WHERE comment_id = %d AND approved = 1",
        $comment_id
    ));

    return $ratings;
}


add_action('wp_ajax_load_posts_by_category', 'load_posts_by_category');
add_action('wp_ajax_nopriv_load_posts_by_category', 'load_posts_by_category');



function load_more_home_posts_by_category() {
    $category_id = isset($_POST['category_id']) && $_POST['category_id'] !== 'most-popular' ? intval($_POST['category_id']) : '';
    $search_query = isset($_POST['search']) ? sanitize_text_field($_POST['search']) : '';
    $sort_by = isset($_POST['sortby']) ? sanitize_text_field($_POST['sortby']) : 'date';
    $offset = isset($_POST['offset']) ? intval($_POST['offset']) : 0;



    $args = array(
        'post_type'      => 'post',
        'orderby'        => $sort_by,
        'order'          => 'DESC',
        'posts_per_page' => 3, // Load 3 posts per "View More" click
        'offset'         => $offset,
        'post_status'    => 'publish'
    );

    if (!empty($category_id)) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'category',
                'field'    => 'term_id',
                'terms'    => $category_id,
            ),
        );
    }

    if (!empty($search_query)) {
        add_filter('posts_where', 'filter_where_post_title_only', 10, 2);
        $args['s'] = $search_query;
    }

    $post_query = new WP_Query($args);

    if (!empty($search_query)) {
        remove_filter('posts_where', 'filter_where_post_title_only', 10, 2);
    }

    ob_start();

    if ($post_query->have_posts()) {
        while ($post_query->have_posts()) : $post_query->the_post();
            global $post;
            ?>
            <div class="col-md-4 category-posts-cl">
            <input type="hidden" data-posts-load-page="<?php echo esc_attr($args['posts_per_page']); ?>">
           
                <div class="category-grid-card-cl">
                    <?php $thumbnail_url = get_the_post_thumbnail_url($post->ID, 'medium'); ?>
                    <?php $noImage = get_stylesheet_directory_uri() . "/images/no-post-img.jpg"; ?>

                    <a class="ctgdc_img" href="<?php echo esc_url(get_permalink()); ?>">
                        <div class="category-post-image-cl" style="background-image: url('<?php echo esc_url($thumbnail_url ? $thumbnail_url : $noImage); ?>'); background-size: cover; background-position: center;"></div>
                    </a>
					 <?php
						$post_excerpt = get_the_excerpt($post->ID);
						$post_excerpt = preg_replace('/https?:\/\/www\.youtube\.com\/watch\?v=[^ \t\n\r]+/', '', $post_excerpt);
						$post_excerpt = preg_replace('/\[embed[^\]]*\]https?:\/\/www\.youtube\.com\/watch\?v=[^\]]*\[\/embed\]/s', '', $post_excerpt);
					?>
                    <a class="title_category"  href="<?php echo esc_url(get_permalink()); ?>">
                        <h5 class="category-title-cl">
                            <?php echo wp_trim_words(get_the_title(), 6, '...'); ?>
                        </h5>
						<div class="list_dec">
							<p>
								<?php echo $post_excerpt; ?>
							</p>
						</div>
                    </a>
                    <div class="recipe-stars-ratings" style="padding-left: 5px;">
                        <?php $rating_average = get_post_meta($post->ID, 'wprm_rating_average', true); ?>
                        <?php echo get_star_rating_html($rating_average); ?>
                    </div>
                    <hr>
                   <?php
                    echo '<p class="category-desc-cl">' . $post_excerpt . '</p>';
                    ?>
                    <a href="<?php echo esc_url(get_permalink($post->ID)); ?>" class="btn banner-cat-grid-btn">Read Recipe</a>
                </div>
            </div>
            <?php
        endwhile;
    } else {
        echo '<p>No more posts found</p>';
    }

    $response['data'] = ob_get_clean();
    $response['has_more'] = $post_query->found_posts > ($offset + 3);

    wp_send_json($response);
    wp_reset_postdata();
    wp_die();
}
add_action('wp_ajax_load_more_home_posts_by_category', 'load_more_home_posts_by_category');
add_action('wp_ajax_nopriv_load_more_home_posts_by_category', 'load_more_home_posts_by_category');








if (function_exists('acf_add_options_page')) {

	acf_add_options_page(array(
		'page_title'    => 'Social Media Settings',
		'menu_title'    => 'Social Media Setting',
		'menu_slug'     => 'social-media-settings',
		'capability'    => 'edit_posts',
		'redirect'      => false
	));
}

// This function adds specific classes to the content of certain pages
function add_terms_privacy_classes_to_content($content)
{
	if (is_page('terms-and-conditions') || is_page('privacy-policy')) {
		// Determine the class prefix based on the page
		$prefix = is_page('terms-and-conditions') ? 'terms' : 'privacy';

		// Define the tags and their corresponding classes
		$tags = array(
			'h1' => $prefix . '-heading-main',
			'h2' => $prefix . '-heading-section',
			'h3' => $prefix . '-heading-subsection',
			'p'  => $prefix . '-paragraph'
		);

		// Loop over the tags and their corresponding classes
		foreach ($tags as $tag => $class) {
			// Use regex to add the class to the tag
			$content = preg_replace_callback("/<$tag([^>]*)>(.*?)<\/$tag>/", function ($matches) use ($class, $tag) {
				// If the tag already has a class, append the new class
				// Otherwise, add the class attribute with the new class
				return "<$tag" . (strpos($matches[1], 'class=') !== false ? preg_replace('/class="([^"]*)"/', 'class="$1 ' . $class . '"', $matches[1]) : $matches[1] . ' class="' . $class . '"') . '>' . $matches[2] . "</$tag>";
			}, $content);
		}
	}
	// Return the modified content
	return $content;
}
// Add the function to the 'the_content' filter
add_filter('the_content', 'add_terms_privacy_classes_to_content');






// Ajax For Recipe Archive Page
// 
// 
function load_posts_by_subcategory() {
    $subcategory_id = isset($_POST['subcategory_id']) ? intval($_POST['subcategory_id']) : 0;
    if (!$subcategory_id) {
        wp_send_json_error('Invalid subcategory ID');
        wp_die();
    }

    $args = array(
        'post_type' => 'post',
        'posts_per_page' => 12,
        'orderby' => 'date',
        'order' => 'DESC',
        'post_status' => 'publish',
        'tax_query' => array(
            array(
                'taxonomy' => 'category',
                'field' => 'term_id',
                'terms' => $subcategory_id,
                'include_children' => true,
            ),
        ),
    );

    $query = new WP_Query($args);
    ob_start();

    if ($query->have_posts()) {
        $posts_in_row = 0;
        $rows_counter = 0;

        echo '<div class="row">'; // Start the first row

        while ($query->have_posts()) : $query->the_post();
            $posts_in_row++;
            $post_id = get_the_ID();
            $thumbnail_url = get_the_post_thumbnail_url($post_id, 'medium');
            $noImage = get_stylesheet_directory_uri() . "/images/no-post-img.jpg";
            ?>
            <div class="col-md-3 recipes-category-posts-cl">
                <div class="recipes-category-grid-card-cl">
                    <a class="post-link-cl" href="<?php echo get_permalink(); ?>">
                        <div class="recipes-category-post-image-cl">
                            <?php if ($thumbnail_url) : ?>
                                <img src="<?php echo esc_url($thumbnail_url); ?>" alt="<?php the_title_attribute(); ?>">
                            <?php else : ?>
                                <img src="<?php echo esc_url($noImage); ?>" alt="Placeholder">
                            <?php endif; ?>
                        </div>
                        <h4 class="recipes-category-title-cl"><?php echo wp_trim_words(get_the_title(), 3, '...'); ?></h4>
                    </a>
                    <a href="<?php the_permalink(); ?>" class="btn recipe-read-more-btn">Read Recipe</a>
                </div>
            </div>
            <?php

            if ($posts_in_row % 4 == 0) {
                echo '</div>'; 
                $rows_counter++;

        
               if ($rows_counter % 2 == 0) {
                     ?>
                     <div class="row">
                      <div class="col-md-12 google_ad_full_width">
                           <div id="google_ad_full_width"  class="hm-google-ad-full-width"> 
                            <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7375354652362298"
                                     crossorigin="anonymous"></script>
                               <!-- Horizontal responsive ad -->
                              <ins class="adsbygoogle"
                                     style="display:block" 
                                    data-ad-client="ca-pub-7375354652362298" 
                                     data-ad-slot="5805387952" 
                                   data-ad-format="auto" 
                                      data-full-width-responsive="true"></ins> 
                              <script>
                                    (adsbygoogle = window.adsbygoogle || []).push({});
                          </script> 
						  </div>
                             <div class="mb-google-mb-ads">
                        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7375354652362298"
                            crossorigin="anonymous"></script>
                        <ins class="adsbygoogle"
                            style="display:block"
                            data-ad-format="fluid"
                            data-ad-layout-key="-6t+ed+2i-1n-4w"
                            data-ad-client="ca-pub-7375354652362298"
                            data-ad-slot="2222775671"></ins>
                        <script>
                            (adsbygoogle = window.adsbygoogle || []).push({});
                        </script>
                           </div>
                         </div> 
                   </div> 
                  <?php 
        }

                echo '<div class="row">'; // Start a new row for the next set of posts
                $posts_in_row = 0; // Reset the counter for the new row
            }

        endwhile;

        echo '</div>'; // Close the last row

    } else {
        echo '<p>No posts found</p>';
    }

    $response['data'] = ob_get_clean();
    $response['has_more'] = $query->found_posts > 8; // Check if there are more than 8 posts

    wp_send_json($response);
    wp_reset_postdata();
    wp_die();
}
add_action('wp_ajax_load_posts_by_subcategory', 'load_posts_by_subcategory');
add_action('wp_ajax_nopriv_load_posts_by_subcategory', 'load_posts_by_subcategory');

function load_more_posts_by_subcategory() {
    $subcategory_id = isset($_POST['subcategory_id']) ? intval($_POST['subcategory_id']) : 0;
    $offset = isset($_POST['offset']) ? intval($_POST['offset']) : 0;
    if (!$subcategory_id) {
        wp_send_json_error('Invalid subcategory ID');
        wp_die();
    }

    $args = array(
        'post_type' => 'post',
        'posts_per_page' => 4, // Load 4 posts at a time
        'offset' => $offset,
        'orderby' => 'date',
        'order' => 'DESC',
        'post_status' => 'publish',
        'tax_query' => array(
            array(
                'taxonomy' => 'category',
                'field' => 'term_id',
                'terms' => $subcategory_id,
                'include_children' => false,
            ),
        ),
    );

    $query = new WP_Query($args);
    ob_start();

    if ($query->have_posts()) {
        echo '<div class="row lm-ps-sb-rw-cl">'; // Start the row

        $posts_in_row = 0;

        while ($query->have_posts()) : $query->the_post();
            $posts_in_row++;
            $post_id = get_the_ID();
            $thumbnail_url = get_the_post_thumbnail_url($post_id, 'medium');
            $noImage = get_stylesheet_directory_uri() . "/images/no-post-img.jpg";
            ?>
            <div class="col-md-3 recipes-category-posts-cl"> 
                <div class="recipes-category-grid-card-cl">
                    <a class="post-link-cl" href="<?php echo get_permalink(); ?>">
                        <div class="recipes-category-post-image-cl">
                            <?php if ($thumbnail_url) : ?>
                                <img src="<?php echo esc_url($thumbnail_url); ?>" alt="<?php the_title_attribute(); ?>">
                            <?php else : ?>
                                <img src="<?php echo esc_url($noImage); ?>" alt="Placeholder">
                            <?php endif; ?>
                        </div>
                        <h4 class="recipes-category-title-cl"><?php echo wp_trim_words(get_the_title(), 3, '...'); ?></h4>
                    </a>
                    <a href="<?php the_permalink(); ?>" class="btn recipe-read-more-btn">Read Recipe</a>
                </div>
            </div>
            <?php

            if ($posts_in_row % 4 == 0) {
                echo '</div>'; // Close the current row
                echo '<div class="row lm-ps-sb-rw-cl">'; // Start a new row for the next set of posts
                $posts_in_row = 0; // Reset the counter for the new row
            }

        endwhile;

        echo '</div>'; // Close the last row

    } else {
        echo '<p>No more posts found</p>';
    }

    $response['data'] = ob_get_clean();
    $response['has_more'] = $query->found_posts > ($offset + 4); // Check if there are more posts to load

    wp_send_json($response);
    wp_reset_postdata();
    wp_die();
}
add_action('wp_ajax_load_more_posts_by_subcategory', 'load_more_posts_by_subcategory');
add_action('wp_ajax_nopriv_load_more_posts_by_subcategory', 'load_more_posts_by_subcategory');





function the_login_custom_login_css() {
    echo '<style type="text/css">
	
.login form .input, .login input[type=password], .login input[type=text] {
	
    border: 1px solid #ADAEAF!important;
    background: transparent!important;
    border-radius: 12px!important;
    height: 50px;
    margin-bottom: 24px!important;
    padding: 0 22px!important;
	
}
    #login {
       width: 500px;
    }
	
	.login form {
	background: transparent;
    border: none;
    box-shadow: none;
	}
	
	
	.login .message, .login .notice, .login .success {
	
	background-color: transparent;
    box-shadow: 0;
    word-wrap: break-word;

	}
	
	.wp-core-ui .button-group.button-large .button, .wp-core-ui .button.button-large {

    padding: 10px 10px;
}

.login .button-primary {
    width: 100%;
    margin-top: 2rem;
	border: 0px;
    background: #FF8947;

}

.dashicons-visibility:before {

color: #474d5d;
}



.wp-login-log-in{
 text-align:center!important;
     color: #73B000!important;
    font-family: Source Serif Pro;
    font-size: 20.73px;
    font-weight: 700;
    line-height: 26.02px;
    text-align: left;
}

.wp-login-register{
    text-align:center!important;
    color: #73B000!important;
    font-family: Source Serif Pro;
    font-size: 20.73px;
    font-weight: 700;
    line-height: 26.02px;
    text-align: left;

}
.login .button.wp-hide-pw {
height:50px;
}
.wp-login-lost-password{
    text-align:center!important;
    color: #DF7314!important;
    font-family: Source Serif Pro;
    font-size: 20.73px;
    font-weight: 700;
    line-height: 26.02px;
    text-align: left;
	}
	
	.login #nav {
	text-align:center;
	}
	
	
	
 .login #backtoblog{
 
 text-align: center!important;
 margin-top:2rem!important;
}
	
	#backtoblog a{
   
  
    font-family: Source Serif Pro;
    font-size: 20.73px;
    font-weight: 700;
    line-height: 26.02px;

}

.privacy-policy-link{
    text-decoration:none;
    text-align: center !important;
    font-family: Source Serif Pro;
    font-size: 20.73px;
    font-weight: 700;
    line-height: 26.02px;

}


.login label {
    font-family: Source Serif Pro;
    font-size: 20.73px;
    font-weight: 700;
    line-height: 26.02px;

}

.login .button-primary {
border-radius: 15px;
    font-family: Source Serif Pro;
    font-size: 20.73px;
    font-weight: 700;

}

#reg_passmail{
font-family: Source Serif Pro;
    font-size: 17.73px;
}
	
	
	</style>';
	
	
	
	
	
}
add_action('login_head', 'the_login_custom_login_css');



// Function to include header.php in the login page
function include_custom_login_header() {
    ?>
    <style type="text/css">
   
    </style>
    <?php
    get_template_part('header');
}

// Function to include footer.php in the login page
function include_custom_login_footer() {
    ?>
    <style type="text/css">
		
       .site-footer .widget {
		background: transparent;
		color: #fff;
		float: left;
		margin-right: 281px;
		width: max-content;
		}
		
		.open-close-quick-links-mobile {
			display:none;
		}
		
		.site-footer .widget-area {
			justify-content: center;
                display: flex;
			    max-width: 100%;
		}
		.site-footer .widget {
         margin-right: 221px;
		}
			.ftbt_last {
			width: 44% !important;
		}
		   	
@media screen and (max-width: 768px) {
	#login{
		width:320px!important;
	}
	.site-footer .textwidget {
		width:320px!important;
	}
		

		
		}
		
		
		@media (min-width: 768px) and (max-width: 990px) {
			
			.site-footer{
				
			padding:3rem;
				
			}
			
			.footer_bottom  .ftbt_flx .ftbt_item.ftbt_big{
				padding:0px!important;

			}
			
		
			.site-footer .widget-area {
				display:grid;
				padding:1rem!important;
			  justify-content: left;
				
			}
			
			.site-footer .widget {
				margin-right: 0px;
			}
			
			.site-footer .sidebar-container {
				padding-top:0px;
			}
			
			.footer_bottom {
				padding: 0px 0px !important;
			}
			
		}
		
	
    </style>
    <?php
    get_template_part('footer');
}

// Hook the custom header function to the login page
add_action('login_header', 'include_custom_login_header');

// Hook the custom footer function to the login page
add_action('login_footer', 'include_custom_login_footer');



// Ajax For Trending Recipes 
// 


// Function to load posts by trending subcategory
// 
// 
function load_posts_by_trending_subcategory() {
    $subcategory_id = isset($_POST['subcategory_id']) ? sanitize_text_field($_POST['subcategory_id']) : 'all';
    $offset = isset($_POST['offset']) ? intval($_POST['offset']) : 0;
//     $posts_per_page = isset($_POST['posts_per_page']) ? intval($_POST['posts_per_page']) : 6;

    $args = array(
        'post_type' => 'post',
        'posts_per_page' => 12,
        'offset' => $offset,
        'orderby' => 'date',
        'order' => 'DESC',
        'post_status' => 'publish'
    );

    if ($subcategory_id !== 'all') {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'category',
                'field' => 'term_id',
                'terms' => intval($subcategory_id),
                'include_children' => false,
            ),
        );
    }

    $query = new WP_Query($args);
    ob_start();

    if ($query->have_posts()) {
		 $posts_in_row = 0;
        $rows_counter = 0;

        echo '<div class="row ">'; // Start the first row

        while ($query->have_posts()) : $query->the_post();
            $posts_in_row++;
            $post_id = get_the_ID();
            $thumbnail_url = get_the_post_thumbnail_url($post_id, 'medium');
            $noImage = get_stylesheet_directory_uri() . "/images/no-post-img.jpg";
            ?>
            <div class="col-md-3 recipes-trending-posts-cl">
                <div class="recipes-trending-grid-card-cl">
                    <a class="post-link-cl" href="<?php echo get_permalink($post_id); ?>">
                        <div class="recipes-trending-post-image-cl">
                            <?php if ($thumbnail_url) : ?>
                                <img src="<?php echo esc_url($thumbnail_url); ?>" alt="<?php the_title_attribute(); ?>">
                            <?php else : ?>
                                <img src="<?php echo esc_url($noImage); ?>" alt="Placeholder">
                            <?php endif; ?>
                        </div>
                        <h4 class="recipes-trending-title-cl"><?php echo wp_trim_words(get_the_title(), 3, '...'); ?></h4>
                    </a>
                    <a href="<?php the_permalink(); ?>" class="btn recipe-trending-read-more-btn">Read Recipe</a>
                </div>
            </div>
            <?php
		 if ($posts_in_row % 4 == 0) {
                echo '</div>'; 
                $rows_counter++;

        
               if ($rows_counter % 2 == 0) {
                     ?>
                     <div class="row">
                      <div class="col-md-12 google_ad_full_width">
                           <div id="google_ad_full_width"  class="hm-google-ad-full-width"> 
                            <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7375354652362298"
                                     crossorigin="anonymous"></script>
                               <!-- Horizontal responsive ad -->
                              <ins class="adsbygoogle"
                                     style="display:block" 
                                    data-ad-client="ca-pub-7375354652362298" 
                                     data-ad-slot="5805387952" 
                                   data-ad-format="auto" 
                                      data-full-width-responsive="true"></ins> 
                              <script>
                                    (adsbygoogle = window.adsbygoogle || []).push({});
                          </script> 
						  </div>
                            
                             <div class="mb-google-mb-ads">
                        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7375354652362298"
                            crossorigin="anonymous"></script>
                        <ins class="adsbygoogle"
                            style="display:block"
                            data-ad-format="fluid"
                            data-ad-layout-key="-6t+ed+2i-1n-4w"
                            data-ad-client="ca-pub-7375354652362298"
                            data-ad-slot="2222775671"></ins>
                        <script>
                            (adsbygoogle = window.adsbygoogle || []).push({});
                        </script>
                        </div>
                           </div>
                   </div> 
                  <?php 
        }
                echo '<div class="row">'; 
                $posts_in_row = 0;
            }
        endwhile;
        echo '</div>';

    } else {
        echo '<p>No posts found</p>';
    }

    $response['data'] = ob_get_clean();
    $response['has_more'] = $query->found_posts > $offset + 12;

    wp_send_json($response);
    wp_reset_postdata();
    wp_die();
}

add_action('wp_ajax_load_posts_by_trending_subcategory', 'load_posts_by_trending_subcategory');
add_action('wp_ajax_nopriv_load_posts_by_trending_subcategory', 'load_posts_by_trending_subcategory');


function load_more_posts_by_trending_subcategory() {
    $subcategory_id = isset($_POST['subcategory_id']) ? sanitize_text_field($_POST['subcategory_id']) : 'all';
    $offset = isset($_POST['offset']) ? intval($_POST['offset']) : 0;

    $args = array(
        'post_type' => 'post',
        'posts_per_page' => 4,
        'offset' => $offset,
        'orderby' => 'date',
        'order' => 'DESC',
        'post_status' => 'publish'
    );

    if ($subcategory_id !== 'all') {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'category',
                'field' => 'term_id',
                'terms' => intval($subcategory_id),
                'include_children' => false,
            ),
        );
    }

    $query = new WP_Query($args);

    ob_start();

    if ($query->have_posts()) {
        echo '<div class="row trd-rw-cl">'; // Start the row

        while ($query->have_posts()) {
            $query->the_post();
            $post_id = get_the_ID();
            $thumbnail_url = get_the_post_thumbnail_url($post_id, 'medium');
            $noImage = get_stylesheet_directory_uri() . "/images/no-post-img.jpg";
            ?>
            <div class="col-md-3 recipes-trending-posts-cl">
                <div class="recipes-trending-grid-card-cl">
                    <a class="post-link-cl" href="<?php echo get_permalink($post_id); ?>">
                        <div class="recipes-trending-post-image-cl">
                            <?php if ($thumbnail_url) : ?>
                                <img src="<?php echo esc_url($thumbnail_url); ?>" alt="<?php the_title_attribute(); ?>">
                            <?php else : ?>
                                <img src="<?php echo esc_url($noImage); ?>" alt="Placeholder">
                            <?php endif; ?>
                        </div>
                        <h4 class="recipes-trending-title-cl"><?php echo wp_trim_words(get_the_title(), 3, '...'); ?></h4>
                    </a>
                    <a href="<?php the_permalink(); ?>" class="btn recipe-trending-read-more-btn">Read Recipe</a>
                </div>
            </div>
            <?php
        }

        echo '</div>'; // Close the row
    } else {
        echo '<p>No more posts found</p>';
    }

    $response['data'] = ob_get_clean();
    $response['has_more'] = $query->found_posts > ($offset + 4); // Check if there are more posts to load

    wp_send_json($response);
    wp_reset_postdata();
    wp_die();
}
add_action('wp_ajax_load_more_posts_by_trending_subcategory', 'load_more_posts_by_trending_subcategory');
add_action('wp_ajax_nopriv_load_more_posts_by_trending_subcategory', 'load_more_posts_by_trending_subcategory');


function my_login_redirect($redirect_to, $request, $user) {
    // Is there a user to check?
    if (isset($user->roles) && is_array($user->roles)) {
        // Check if the user is an administrator
        if (in_array('administrator', $user->roles)) {
            // Redirect them to the default place
            return admin_url();
        } else {
            // Redirect them to the homepage
            return home_url();
        }
    } else {
        return $redirect_to;
    }
}

 add_filter('login_redirect', 'my_login_redirect', 10, 3);


function redirect_404_to_homepage() {
    if (is_404()) {
        wp_redirect(home_url());
        exit();
    }
}
add_action('template_redirect', 'redirect_404_to_homepage');




function mytheme_customize_register( $wp_customize ) {
    // Add setting for logo
    $wp_customize->add_setting( 'site_logo' , array(
        'default'     => '',
        'sanitize_callback' => 'esc_url_raw', // Sanitization function for URLs
        'capability'  => 'edit_theme_options',
    ) );

    // Add control to upload the logo
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'site_logo', array(
        'label'       => __( 'Site Logo', 'mytheme' ),
        'section'     => 'title_tagline', // Adding it to the "Site Identity" section
        'settings'    => 'site_logo',
        'description' => 'Upload a logo for your site.',
    ) ) );
}
add_action( 'customize_register', 'mytheme_customize_register' );
