<?php

/**
 * The template for displaying Category pages
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */

get_header();

$social_media_icon = get_field('social_media_icon', 'option');

$social_media_link = get_field('social_media_link', 'option');

?>

<div id="primary" class="content-area">
    <div id="content" class="site-content" role="main">
     <section class="recipes-main-section">
    <div class="container">
      <h1 class="main-heading text-center">
    <?php 
        $current_category = get_queried_object();
        if ($current_category && !is_wp_error($current_category)) {
            echo esc_html($current_category->name); 
        } else {
            echo 'Category not found';
        }
    ?>
</h1>

    </div>
		 
		 
		 
<!-- Featured Post Section 		  -->
		 
    <div class="container recipes-banner-container">
        <div class="row recipes-banner-row">
            <!-- Latest Recipes -->
           <div class="col-12 col-md-3">
    <div class="recipe-list list-group">
        <p class="section-heading">Latest Recipes</p>
        <?php
        function get_parent_category_name($post_id) {
            $categories = get_the_category($post_id);
            if ($categories) {
                $category = $categories[0];
                while ($category->category_parent) {
                    $category = get_category($category->category_parent);
                }
                return $category->name;
            }
            return 'Recipes';
        }

        // Get current subcategory ID
        $current_category = get_queried_object();
        $category_id = $current_category->term_id;

        // Query parameters
        $args = array(
            'posts_per_page' => 8,
            'orderby' => 'date',
            'order' => 'DESC',
            'tax_query' => array(
                array(
                    'taxonomy' => 'category',
                    'field' => 'term_id',
                    'terms' => $category_id,
                    'include_children' => false,
                ),
            ),
        );

        // Custom query
        $latest_posts_query = new WP_Query($args);

        if ($latest_posts_query->have_posts()) :
            $index = 0;
            while ($latest_posts_query->have_posts()) : $latest_posts_query->the_post();
                $thumbnail = get_the_post_thumbnail(get_the_ID(), 'thumbnail');

                // Display posts from 2 to 6 in the "Latest Recipes" section
                if ($index >= 1 && $index < 6) :
        ?>
                <div class="list-group-item d-flex align-items-center">
                    <div class="flex-grow-1 me-3">
                        <div class="recipe-category"><?php echo get_parent_category_name(get_the_ID()); ?></div>
                        <a class="post-link-cl" href="<?php echo get_permalink($post->ID); ?>">
                            <div class="recipe-title"><?php the_title(); ?></div>
                        </a>
                        <div class="recipe-stars-ratings">
                            <?php $rating_average = get_post_meta($post->ID, 'wprm_rating_average', true); ?>
                            <?php echo get_star_rating_html($rating_average); ?>
                        </div>
                    </div>
                    <div class="flex-shrink-0" style="width: 50px;">
                        <?php if ($thumbnail) : ?>
                            <a class="post-link-cl" href="<?php echo get_permalink($post->ID); ?>">
                                <img src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'thumbnail'); ?>" alt="<?php the_title(); ?>" class="img-fluid">
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
        <?php
                endif;
                $index++;
            endwhile;
        else :
            echo '<p>No latest recipes found.</p>';
        endif;
        ?>
    </div>
</div>

<div class="col-12 col-md-6 recipe-center-col">
    <div class="featured-recipe">
        <?php
        // Reset query to get the latest post for the "Featured Recipe" section
        if ($latest_posts_query->have_posts()) :
            $latest_posts_query->rewind_posts();
            $post = $latest_posts_query->posts[0];
            setup_postdata($post);
            $thumbnail = get_the_post_thumbnail($post->ID, 'full');
        ?>
            <a class="post-link-cl" href="<?php echo get_permalink($post->ID); ?>">
                <img src="<?php echo get_template_directory_uri(); ?>/images/featuredRecipeBadge.png" alt="featuredRecipeBadge" class="featuredRecipeBadge-img-cl">
                <?php if ($thumbnail) : ?>
                    <img src="<?php echo get_the_post_thumbnail_url($post->ID, 'full'); ?>" alt="<?php the_title(); ?>" class="img-fluid">
                <?php endif; ?>
            </a>
            <div class="recipe-center-content">
                <div class="recipe-category"><?php echo get_parent_category_name($post->ID); ?></div>
                <a class="post-link-cl" href="<?php echo get_permalink($post->ID); ?>">
                    <h3 class="recipe-center-title"><?php the_title(); ?></h3>
                </a>
                <hr>
                <span class="recipe-center-desc"><?php the_excerpt(); ?></span>
                <div class="recipe-stars-ratings">
                    <?php $rating_average = get_post_meta($post->ID, 'wprm_rating_average', true); ?>
                    <?php echo get_star_rating_html($rating_average); ?>
                </div>
					<div class="row">
				<div class="col-md-4">
					<script src="https://gumroad.com/js/gumroad.js"></script>
                  <a href="https://gum.co/VveUf" class="e-book-download-btn">
                   <button class="e-book-download-btn-cl">Buy ebook for $5</button>
                   </a>
				</div>
			</div>
            </div>
        <?php
            wp_reset_postdata();
        else :
            echo '<p>No featured recipe found.</p>';
        endif;
        ?>
    </div>
</div>

<div class="col-12 col-md-3 text-center">
	
	
	
	
<!--     <?php
    //if ($latest_posts_query->have_posts()) :
       // for ($index = 6; $index < 8; $index++) {
        //    if (isset($latest_posts_query->posts[$index])) {
          //      $post = $latest_posts_query->posts[$index];
            //    setup_postdata($post);
            //    $thumbnail = get_the_post_thumbnail($post->ID, 'medium');
   // ?> -->
                <div class="right-recipes">
					
					<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7375354652362298"
     crossorigin="anonymous"></script>
<!-- Category Fixed Vertical Head -->
<ins class="adsbygoogle"
     style="display:inline-block;width:300px;height:610px"
     data-ad-client="ca-pub-7375354652362298"
     data-ad-slot="8207667899"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
<!--                     <a class="post-link-cl" href="<?php //echo get_permalink($post->ID); ?>"> -->
                       <?php //if ($thumbnail) : ?>
                            <?php //echo $thumbnail; ?>
                        <?php //endif; ?>
<!--                         <div class="recipe-category"><?php //echo get_parent_category_name($post->ID); ?></div> -->
<!--                         <p class="recipe-right-post-title mt-1"><?php //the_title(); ?></p> -->
<!--                     </a> -->
                </div>
    <?php
//             }
//         }
//         wp_reset_postdata();
//     else :
//         echo 'No recent posts found.';
//     endif;
    ?>
</div>

        </div>
    </div>

		

		 
<section class="recipe-category-filter-sec" >
    <div class="container">
        <div class="row">
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
				
				   	<div class="google_ad" id="recipe-left-g-ad" style="margin-top:70px;">
						<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7375354652362298"
     crossorigin="anonymous"></script>
<!-- Category Siderbar fixed horizontal -->
<ins class="adsbygoogle"
     style="display:block;width:100%;height:height:650px"
     data-ad-client="ca-pub-7375354652362298"
     data-ad-slot="9847180481"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
					
				</div>
            </div>
			
			
			
            <div class="col-md-10 recipes recipes-grid-post-col">
				
				<div class="recipe-center-g-ad">
					<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7375354652362298"
     crossorigin="anonymous"></script>
<!-- Category Ficed Head Ad -->
<ins class="adsbygoogle"
     style="display:block;width:100%;height:130px"
     data-ad-client="ca-pub-7375354652362298"
     data-ad-slot="4476306446"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
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
				
				
				
				<?php 
$current_category = get_queried_object();
if ($current_category && !is_wp_error($current_category)) {
    echo '<h4 class="text-center heading-cl mt-5">';
    echo esc_html(trim($current_category->name)); 
    echo '</h4>';
    echo '<hr class="marker">';

    $category_description = category_description($current_category->term_id);
    if ($category_description) {
        // Remove empty <p> tags and <p> tags with only &nbsp;
        $category_description = preg_replace('/<p>(?:\s|&nbsp;)*<\/p>/i', '', $category_description);

        // Split description into sentences
        $sentences = explode('.', $category_description);
        $sentences = array_filter(array_map('trim', $sentences)); // Remove empty sentences

        // Determine if "Read More" button is needed
        if (count($sentences) > 3) {
            // Short description with first three sentences
            $short_description = implode('. ', array_slice($sentences, 0, 3)) . '.';
            echo '<div class="category-description" id="short-description">' . wp_kses_post($short_description) . '...</div>';
            
            // "Read More" button outside the description
            echo '<button id="load-cat-content" class="load-more-cat-content-btn" data-term-id="' . esc_attr($current_category->term_id) . '">Read More</button>';
            
            // Full description with "Show Less" button
            $full_description = implode('.', $sentences) . '.';
            echo '<div id="full-description" class="category-description" style="display:none;">' . wp_kses_post($full_description) . '<button id="show-less-content" class="show-less-cat-content-btn">Show Less</button></div>';
        } else {
            // Description is short enough to show in full
            echo '<div class="category-description">' . wp_kses_post($category_description) . '</div>';
        }
    }
} else {
    echo '<h4 class="text-center heading-cl mt-5">Category not found</h4>';
}
?>















				
				
              
                <div class="recipes-grid-post-container mt-5">
                    <!-- Tag filtering section -->
                    <div class="recipes-category-filter">
                        <div class="recipes-category-listing tag-listing" data-initial-limit="5">
                            <a href="javascript:void(0)" class="recipes-category-filter-btn active" data-subcategory-id="<?php echo $category_id;?>">All</a>
                            <?php
                            $current_category = get_queried_object();
                            $category_id = $current_category->term_id;

                            // Query for posts in the current category
                            $args = array(
                                'category__in' => array($category_id),
                                'posts_per_page' => -1,
                            );
                            $posts = get_posts($args);

                            // Collect all subcategories related to these posts
                            $subcategories = array();
                            foreach ($posts as $post) {
                                $post_categories = get_the_category($post->ID);
                                foreach ($post_categories as $post_category) {
                                    if ($post_category->term_id != $category_id) {
                                        $subcategories[$post_category->term_id] = $post_category;
                                    }
                                }
                            }

                            $counter = 0; // Add a counter
                            foreach ($subcategories as $subcategory) {
                                $hiddenClass = $counter >= 5 ? 'hidden' : '';
                                echo '<a href="javascript:void(0)" class="recipes-category-filter-btn ' . $hiddenClass . '" data-subcategory-id="' . esc_attr($subcategory->term_id) . '">' . esc_html($subcategory->name) . '</a>';
                                $counter++; // Increment the counter
                            }
                            ?>
                            <?php if ($counter > 5) : ?>
                                <a href="javascript:void(0)" id="show-more-tags" class="recipes-category-filter-btn">Show More</a>
                                <a href="javascript:void(0)" id="show-less-tags" class="recipes-category-filter-btn" style="display: none;">Show Less</a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Recipe posts section -->
                    <div class="recipes-category-filter-post-container">
                        <div class="row"  id="recipe-posts-container-row">
                           <!-- ajax data will fetch -->
                        </div>
                    </div> 

                    <div class="row">
                        <div class="col-md-12 justify-content-center d-flex">
                            <button id="recipe-view-more-btn"><span class="recipe-view-more-grid-post-btn">View More</span></button>
                        </div>
                    </div>
					
						<div class="recipe-center-g-ad">
					<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7375354652362298"
     crossorigin="anonymous"></script>
<!-- Category Ficed Head Ad -->
<ins class="adsbygoogle"
     style="display:block;width:100%;height:130px"
     data-ad-client="ca-pub-7375354652362298"
     data-ad-slot="4476306446"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
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
                </div>
            </div>
        </div>
    </div>
</section>


    <!-- Dessert Section -->

    <section class="dessert-section-cl">
        <div class="container">


            <div class="row">
                <div class="col-md-2 recipe-left-google-ad-sec" style="margin-top: 4rem; height:670px;">
                    	<div class="google_ad">
							<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7375354652362298"
     crossorigin="anonymous"></script>
<!-- Category 2nd Fixed Vertical -->
<ins class="adsbygoogle"
     style="display:block;width:100%;height:670px"
     data-ad-client="ca-pub-7375354652362298"
     data-ad-slot="1090723063"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
						</div>
                </div>
                <div class="col-md-10 dessert-right-col">
                    <div class="main-title"><?php _e('Classic Dessert Recipes by Manjula', 'Food Blog'); ?>
                        <hr class="marker">
                    </div>
                    <div class="row">
                        <!-- Column for the latest dessert post -->

                        <div class="col-md-6 dessert-left-sub-col">

                            <div class="section-title"><?php _e('51 Favorite Sweets From "Manjula"', 'Food Blog'); ?></div>
                            <?php
                            // Get the ID of the "dessert" category
                            $dessert_category = get_category_by_slug('desserts');
                            $dessert_category_id = $dessert_category->term_id;

                            // Query to fetch the latest post from the "Dessert" category
                            $latest_args = array(
                                'cat' => $dessert_category_id, // Category ID of the 'Dessert' category
                                'posts_per_page' => 1, // Display only one post
                                'order' => 'DESC', // Order by descending
                                'orderby' => 'date' // Order by date
                            );

                            $latest_query = new WP_Query($latest_args);

                            if ($latest_query->have_posts()) {
                                while ($latest_query->have_posts()) {
                                    $latest_query->the_post();
                            ?>
                                    <a class="post-link-cl" href="<?php echo the_permalink(); ?>">
                                        <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>" class="img-fluid rounded">
                                    </a>
                            <?php
                                }
                            } else {
                                echo '<p>No dessert recipes found.</p>';
                            }
                            wp_reset_postdata();
                            ?>
                        </div>

                        <!-- Column for the three most recent dessert posts excluding the first one -->
                        <div class="col-md-6 dessert-right-sub-col">
                            <div class="section-subtitle"><?php _e('These classic recipes have stood the test of time.', 'Food Blog'); ?></div>
                            <ul class="list-unstyled recipe-list dessert-recipe-list">
                                <?php
                                // Query to fetch the three most recent posts from the "Dessert" category excluding the first one
                                $recent_args = array(
                                    'cat' => $dessert_category_id, // Category ID of the 'Dessert' category
                                    'posts_per_page' => 3, // Display three posts
                                    'offset' => 1, // Skip the first post
                                    'order' => 'DESC', // Order by descending
                                    'orderby' => 'date' // Order by date
                                );

                                $recent_query = new WP_Query($recent_args);

                                if ($recent_query->have_posts()) {
                                    while ($recent_query->have_posts()) {
                                        $recent_query->the_post();
                                ?>
                                        <li class="media mb-4">
                                            <a class="post-link-cl" href="<?php echo the_permalink(); ?>">
                                                <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>" class="mr-3 img-fluid rounded">
                                                <div class="media-body">
                                                    <p class="text-uppercase text-danger">Recipes & Menus</p>
                                                    <h5 class="recent-post-title mt-0 mb-1"><?php the_title(); ?></h5>
                                                    <div class="stars" style="--rating: 5;"></div>
                                                </div>
                                            </a>
                                        </li>
                                <?php
                                    }
                                } else {
                                    echo '<li class="media mb-4">No recipes found.</li>';
                                }
                                wp_reset_postdata();
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


<!--  Trending Reciepies -->

		 
    <section class="recipes-tag-post-content-sec"  data-subcategory-id="<?php echo esc_attr($category_id); ?>" >
        <div class="container">
            <div class="row recipes-container-row">
                <div class="col-md-2 recipe-left-google-ad-sec" style="margin-top:margin-top: 14rem;">
                   	<div class="google_ad">
							<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
							<!-- Responsize Header2 -->
							<ins class="adsbygoogle"
								 style="display:block; width:100%"
								 data-ad-client="ca-pub-7375354652362298"
								 data-ad-slot="6937317725"
								 data-ad-format="auto"></ins>
							<script>
							(adsbygoogle = window.adsbygoogle || []).push({});
							</script>
						</div>
                </div>
                <div class="col-md-10 recipes recipes-grid-post-col">
                    <h4 class="text-center heading-cl mt-5">Trending Recipes</h4>
                    <hr class="marker">
<div class="recipes-grid-post-container mt-5">
    <div class="recipes-category-filter">
        <?php
        $terms = get_terms(array(
            'taxonomy' => 'category',
            'hide_empty' => true,
        ));
        $category_count = !empty($terms) && !is_wp_error($terms) ? count($terms) : 0;
        $initial_limit = 5; // Set initial limit here
        $counter = 0;
        ?>

        <div class="recipes-category-listing tag-listing" data-initial-limit="<?php echo $initial_limit; ?>">
            <a href="javascript:void(0)" class="recipes-trending-filter-btn active" data-subcategory-id="all">All</a>
            <?php if ($category_count > 0) {
                foreach ($terms as $term) {
                    $class = $counter >= $initial_limit ? 'hidden' : '';
                    echo '<a href="javascript:void(0)" class="recipes-trending-filter-btn ' . $class . '" data-subcategory-id="' . esc_attr($term->term_id) . '">' . esc_html($term->name) . '</a>';
                    $counter++;
                }
            } ?>
         
        </div>
    </div>

    <!-- Recipe posts section -->
    <div class="recipes-tag-filter-post-container">
        <div class="row" id="trending-posts-container">
            <?php
            $args = array(
                'posts_per_page' => 8,
                'orderby' => 'date',
                'order' => 'DESC',
                'tax_query' => array(
                    array(
                        'taxonomy' => 'category',
                        'field' => 'term_id',
                        'terms' => $category_id, // Ensure $category_id is properly set
                        'include_children' => false,
                    ),
                ),
            );
            $query = new WP_Query($args);
            if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();
                $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'medium');
                $strTransImage = get_stylesheet_directory_uri() . "/images/trans_lines.gif";
            ?>
                <div class="col-md-3 recipes-trending-posts-cl">
                    <div class="recipes-trending-grid-card-cl">
                        <div class="recipes-trending-post-image-cl">
                            <?php if ($thumbnail_url) : ?>
                                <img src="<?php echo esc_url($thumbnail_url); ?>" alt="<?php the_title_attribute(); ?>">
                            <?php else : ?>
                                <img src="<?php echo esc_url($strTransImage); ?>" style="height:150px;border:1px solid #F0F0F0;" alt="Placeholder">
                            <?php endif; ?>
                        </div>
                        <?php
                        $title = get_the_title();
                        $title = preg_replace('/\s*\([^)]*\)/', '', $title);
                        ?>
                        <h4 class="recipes-trending-title-cl"><?php echo esc_html($title); ?></h4>
                        <a href="<?php the_permalink(); ?>" class="btn recipe-trending-read-more-btn">Read Recipe</a>
                    </div>
                </div>
            <?php endwhile; endif; wp_reset_postdata(); ?>
        </div>
		
    </div>
</div>
					
                     <div class="row">
                            <div class="col-md-12 justify-content-center d-flex">
                                <button class="recipe-trending-view-more-btn"><span class="recipe-trending-view-more-grid-post-btn">View More</span></button>
                        </div>


                </div>
            </div>
        </div>
		</div>
    </section>

		 
		 

    

    </section>
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
			<div class="container">
			<div class="hm-ft-g-ds">
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
				<div class="hm-mb-ft-g-ad">
			<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7375354652362298"
     crossorigin="anonymous"></script>
<ins class="adsbygoogle"
     style="display:block"
     data-ad-format="autorelaxed"
     data-ad-client="ca-pub-7375354652362298"
     data-ad-slot="5819499669"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
		</div>
	</div>
    </section>
  




</div><!-- #content -->
</div><!-- #primary -->

<?php get_footer(); ?>