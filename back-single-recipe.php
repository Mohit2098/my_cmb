<?php get_header(); ?>
<!-- Recipe Single Page Template -->

<section class="recipe-singe-page-section">
	<div class="container main-container">
		<div class="row recipe-banner">
			<div class="col-md-4 recipe-banner-left-col">
				<div class="recipe-banner-left-col-container">

					<!-- Recipe Title -->
					<h1 class="heading">
						<?php
						$recipe_name = do_shortcode('[wprm-recipe-name]');
						if (!empty($recipe_name)) {
							$position = strpos($recipe_name, ',');
							if ($position !== false) {
								$recipe_name = substr($recipe_name, 0, $position);
							}
							echo $recipe_name;
						} else {
							the_title();
						}
						?>
					</h1>

					<!-- Author and Date -->
					<?php if ( !empty( get_the_author() ) ) : ?>
					<p class="author-title">
						By: <?php echo get_the_author(); ?>
					</p>
				<?php endif; ?>
					
				<?php
				$post_date = do_shortcode('[wprm-recipe-date]');
				if ( !empty( $post_date ) ) :
				?>
					<p class="post-date">
						<?php echo $post_date; ?>
					</p>
				<?php endif; ?>

					<!-- Servings and Total Time -->
				<div class="wrapper-cl-servings-units-time">
				<?php
					$servings = do_shortcode('[wprm-recipe-servings label_container="1" label="Serving" label_separator=" : "]');
					$total_time = do_shortcode('[wprm-recipe-time type="total" label_container="1" label="Total Time" shorthand="1" label_separator=" :"]');

						if (!empty($servings)) {
							?>
							<div class="servings-units">
								<img class="users-icons" src="<?php echo get_template_directory_uri(); ?>/images/users-icon.svg">
								<?php echo $servings; ?>
							</div>
							<?php
						}

						if (!empty($total_time)) {
							?>
							<div class="total-time">
								<img class="total-time-to-cook" src="<?php echo get_template_directory_uri(); ?>/images/time-icon.svg">
								<?php echo $total_time; ?>
							</div>
							<?php
						}
						?>
					</div>
					<div class="subcribe-yt-btn mt-5 mb-3 d-flex justify-content-center">
						<a href="https://www.youtube.com/channel/UCb75CvYbm5BXpbEkGqFKABw" target="_blank">
						<button class="single-page-subscribe-btn">
							Subscribe to our YouTube channel!
						</button>
							</a>

					</div>
					
					<!-- Subscribe Button -->

					<!-- Recipe Rating -->
					<div class="recipe-rating-and-review mb-4">
						<span class="ratings">
							
							<p>
								Rate this recipe:
							</p>
						
							<?php
							echo do_shortcode('[wprm-recipe-rating display="stars-details"  style="inline" voteable="1" icon="star-empty"]');
							?>
						</span>
					</div>
					
						<div class="sg-ad-g-ad" style="height:100px;justify-content: center; display: flex;">
					<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7375354652362298"
     crossorigin="anonymous"></script>
<!-- Recipe New Horizontal Fixed Head -->
<ins class="adsbygoogle"
     style="display:inline-block;width:100%;height:90px"
     data-ad-client="ca-pub-7375354652362298"
     data-ad-slot="7985140761"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
						
					</div>
					
					
<div class="hm-mbl-g-ad" >
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7375354652362298"
     crossorigin="anonymous"></script>
<!-- Mobile Responsive Recipes -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-7375354652362298"
     data-ad-slot="5310837972"
     data-ad-format="auto"
     data-full-width-responsive="true"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
	
</div>
				
				</div>
			
			</div>
			

			<!-- Recipe Image -->
	
			
	<div class="col-md-8 recipe-banner-right-col">
    <?php
    // Get the content of the post
    $content = get_the_content();

    // Regular expression to find YouTube URLs
    $youtube_regex = '/https?:\/\/(?:www\.)?(youtube\.com\/watch\?v=|youtu\.be\/)([\w-]+)/';

    // Check if the content contains a YouTube URL
    if (preg_match($youtube_regex, $content, $matches)) {
        // Extract the video ID from the matched YouTube URL
        $video_id = $matches[2];

        // Create the embed URL
        $embed_url = 'https://www.youtube.com/embed/' . esc_attr($video_id);

        // Embed the YouTube video with ads before and after
        ?>
<!--         <div class="row">
            <div class="col-md-12"> -->
                <!-- Embedded YouTube video -->
<!--                <div class="embed-responsive embed-responsive-16by9"> -->
<!--                     <iframe class="embed-responsive-item" src="<?php echo $embed_url; ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe> -->
		  <iframe class="recipe-iframe-vd-cl" src="<?php echo $embed_url; ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
<!--                 </div>
            </div>
        </div> -->

      
        <?php
    } else {
        // Get the post thumbnail URL
        if (has_post_thumbnail()) {
            $thumbnail_url = get_the_post_thumbnail_url();

            // Display the post thumbnail
            echo '<div class="post-thumbnail">';
            echo '<img src="' . esc_url($thumbnail_url) . '" alt="' . get_the_title() . '">';
            echo '</div>';
        }
    }
    ?>
</div>
		



		</div>
	</div>

	<!-- Recipe Details -->
	<section class="recipe-details-content-section">
		<div class="container main-container">
			<div class="row">
				<!-- Quick Links -->
				<div class="col-md-2 quick-links-col">
					<div class="quick-links-heading">
						<h4 class="heading">Quick Links</h4>
					</div>
					<div class="quick-links">
						<?php
						wp_nav_menu(array(
							'theme_location' => 'quick-links-menu',
							'container_class' => 'quick-links-menu-class'
						));
						?>
					</div>
					<div class="single-rc-g-ad">
					
						
					</div>
					
				</div>

				<!-- Recipe Content -->
				<div class="col-md-8 recipe-content-col">
					<!-- About the Recipe -->
					<div class="about-the-recipe">
						<h3 class="about-the-recipe-main-heading">
							<?php
							$recipe_name = do_shortcode('[wprm-recipe-name]');
							if (!empty($recipe_name)) {
								echo $recipe_name;
							} else {
								the_title();
							}
							?>
						</h3>
					</div>

					
							<p class="about-the-recipe-content">
								<?php
								$recipe_summary = do_shortcode('[wprm-recipe-summary]');
								if (!empty($recipe_summary)) {
									echo $recipe_summary;
								} else {
									the_excerpt();
								}
								?>
							</p>
						
						<div class="single-page-ct-cl">
							<?php echo the_post_thumbnail(get_the_ID(), 'large'); ?>
						</div>
				
					
					<!-- Ingredients -->
					<?php
					$ingredients = do_shortcode('[wprm-recipe-ingredients]');
					if ( !empty( $ingredients ) ) :
					?>
						<div class="ingredients-cl">
							<h3 class="about-the-recipe-heading">Ingredients</h3>
							<?php echo $ingredients; ?>
						</div>
					<?php endif; ?>
					
					<div class="hm-mbl-g-ad" >
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7375354652362298"
     crossorigin="anonymous"></script>
<!-- Mobile Responsive Recipes -->
<ins class="adsbygoogle"
     style="display:block;"
     data-ad-client="ca-pub-7375354652362298"
     data-ad-slot="5310837972"
     data-ad-format="auto"
     data-full-width-responsive="true"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
	
</div>

					<!-- Instructions -->
					<?php
					$instructions = do_shortcode('[wprm-recipe-instructions]');
					if ( !empty( $instructions ) ) :
					?>
						<div class="instructions-cl">
							<h3 class="about-the-recipe-heading">Instructions</h3>
							<?php echo $instructions; ?>
						</div>
					<?php endif; ?>

				
					<div class="google_ad">
						<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7375354652362298"
						 crossorigin="anonymous"></script>
					<!-- responsive main -->
					<ins class="adsbygoogle"
						 style="display:block"
						 data-ad-client="ca-pub-7375354652362298"
						 data-ad-slot="8629168559"
						 data-ad-format="auto"
						 data-full-width-responsive="true"></ins>
					<script>
						 (adsbygoogle = window.adsbygoogle || []).push({});
					</script>
					</div>
					
			
					
					
					
                   <!-- Notes -->

					<?php
					$notes = do_shortcode('[wprm-recipe-notes]');
					if ( !empty( $notes ) ) :
					?>
					
						
					
						<div class="notes-cl">
							<h3 class="about-the-recipe-heading">Notes</h3>
							<?php echo $notes; ?>
						</div>
					<?php endif; ?>
					
				<div class="row">
				<div class="col-md-12 justify-content-center d-flex">
					<script src="https://gumroad.com/js/gumroad.js"></script>
                  <a href="https://gum.co/VveUf" class="e-book-download-btn">
                   <button class="e-book-download-btn-cl">Buy ebook for $5</button>
                   </a>
				</div>
			</div>

				

<div class="single-post-cont">
    <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>
            <div <?php post_class(); ?>>
              <?php
				// Get the content of the post
				$post_content = get_the_content();

				// Remove YouTube links in various formats
				$patterns = [
					'/\[embed\]https?:\/\/www\.youtube\.com\/watch\?v=[^ \t\n\r\[\]]+\[\/embed\]/', // [embed] shortcode format
					'/<a[^>]+href="https?:\/\/www\.youtube\.com\/watch\?v=[^"]+"[^>]*>.*?<\/a>/', // Anchor tag format
					'/https?:\/\/www\.youtube\.com\/watch\?v=[^ \t\n\r]+/' // Plain URL format
				];

				$post_content = preg_replace($patterns, '', $post_content);

				// Output the cleaned content
				echo '<div class="single-page-filtered-content">' . $post_content;?>

            </div>
        <?php endwhile; ?>
   
    <?php endif; ?>
</div>


					
			

					   <div class="row">
                    <div class="col-md-12">
					
							
                        <div class="container comment-section-contianer">
								<div class="mb-gads">
								<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7375354652362298"
									 crossorigin="anonymous"></script>
								<!-- Mobile header responsive -->
								<ins class="adsbygoogle"
									 style="display:block"
									 data-ad-client="ca-pub-7375354652362298"
									 data-ad-slot="6781227544"
									 data-ad-format="auto"
									 data-full-width-responsive="true"></ins>
								<script>
									 (adsbygoogle = window.adsbygoogle || []).push({});
								</script>
							</div>
								<div class="hm-mbl-g-ad">
						<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7375354652362298"
     crossorigin="anonymous"></script>
<!-- Multiplex responsive ad mobile -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-7375354652362298"
     data-ad-slot="8609314536"
     data-ad-format="auto"
     data-full-width-responsive="true"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
</div>

                            <?php
                            // If comments are open or we have at least one comment, load up the comment template.
                            if (comments_open() || get_comments_number()) :
                                comments_template();
                            endif;
                            ?>
                        </div>

                    </div>
                </div>

			</div>
					
		</div>
			<!-- Advertisement -->
				<div class="col-md-2 recipe-page-right-side-google-ad" style="width:200px;height:700px;">
					<div class="rg-g-ad">
										<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7375354652362298"
     crossorigin="anonymous"></script>
<!-- Recipes Siderbar fixed vertical -->
<ins class="adsbygoogle"
     style="display:inline-block;width:200px;height:700px"
     data-ad-client="ca-pub-7375354652362298"
     data-ad-slot="5269641224"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
					</div>
		
					
				</div>
		</div>
	</section>

	<!-- Social Media Links -->
	<section>
		<div class="social-media-container">
			<div class="container">
				<?php if (!empty($social_media_icon) & !empty($social_media_link)) : ?>
					<div class="social-media-item">
						<a href="<?php echo esc_url($social_media_link['url']); ?>" target="_blank">
							<img src="<?php echo esc_url($social_media_icon['url']); ?>" alt="<?php echo esc_attr($social_media_icon['alt']); ?>">
							<span class="social-heading"><?php echo esc_html($social_media_link['title']); ?></span>
						</a>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</section>

	<!-- Google Ads -->
	<section class="google-ads-section">
		<div class="container-fluid">
		</div>
	</section>
<?php
// Ensure you have access to the current global post object
global $post;

// Get the current post ID
$current_post_id = get_the_ID();

// Define the query arguments for related posts
$query_args = array(
    'post__not_in'    => array($current_post_id),
    'posts_per_page'  => 4,
    'orderby'         => 'rand',
    'ignore_sticky_posts' => 1,
);

// Execute the query
$related_posts = new WP_Query($query_args);
?>

<div class="row">
   

    <div class="col-md-12 related-post-grid-cl">
        <?php if ($related_posts->have_posts()) : ?>
            <div class="container">
                <h3>Check other Recipes</h3>
                <div class="post-page-grid-container mt-5">
                    <div class="related-post-container-grid">
                        <div class="row">
                            <?php while ($related_posts->have_posts()) : $related_posts->the_post(); ?>
                                <div class="col-md-3">
                                    <div class="related-post-grid-content">
                                        <a class="post-link-cl" href="<?php echo get_permalink(); ?>">
                                            <?php if (has_post_thumbnail()) : ?>
                                                <img src="<?php the_post_thumbnail_url('medium'); ?>" class="card-img-top" alt="<?php the_title(); ?>">
                                            <?php endif; ?>

                                            <div class="related-post-title">
                                                <a href="<?php the_permalink(); ?>">
                                                    <h5 class="title-cl"><?php the_title(); ?></h5>
                                                </a>
                                            </div>
                                        </a>
                                        <div class="user-group">
                                            <span class="single-page-ratings">
                                                <?php $rating_average = get_post_meta($post->ID, 'wprm_rating_average', true); ?>
                                                <?php echo get_star_rating_html($rating_average); ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php else : ?>
            <p>No related posts found.</p>
        <?php endif; ?>
    </div>
</div>


	<?php wp_reset_postdata(); ?>
	
		<div class="container">
			<div class="mb-gads">
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7375354652362298"
     crossorigin="anonymous"></script>
<!-- Mobile header responsive -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-7375354652362298"
     data-ad-slot="6781227544"
     data-ad-format="auto"
     data-full-width-responsive="true"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
</div>
	</div>
	
	
<div class="hm-mbl-g-ad" >
	<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7375354652362298"
     crossorigin="anonymous"></script>
<!-- Mobile header responsive -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-7375354652362298"
     data-ad-slot="6781227544"
     data-ad-format="auto"
     data-full-width-responsive="true"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
	
</div>
	
</section>



<?php get_footer(); ?>