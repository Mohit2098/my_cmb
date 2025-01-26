<?php

/**
 * Template Name: home
 */

get_header();

?>


<?php
// For Banner
$banner_heading = get_field('banner_heading');
$banner_description = get_field('banner_description');
$banner_image = get_field('banner_image');
$ebook_heading = get_field('e-book_heading');
$ebook_image = get_field('e-book_image');
$ebook_cta = get_field('e-book_cta');
$select_user_comment_post = get_field('select_user_comment_post');
$user_comments_section = get_field('user_comments_section');


?>

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
<section class="home-page-banner-section-cl" style="display:flex">
	
  <div class="container" style=" width:100%; display: flex;">
    <div class="hmpb_box" style="width:80%;">
      <div class="row">
        <div class="col-md-6 hmpbox-left-col">
          <div class="home-page-banner">
            <h1 class="banner-heading"><?php echo $banner_heading; ?></h1>
            <hr style="border: 1px solid #ffff;">
            <span class="banner-desc"><?php echo wpautop($banner_description); ?></span>
          </div>

          <div class="banner-ebook-cl">

            <div class="ebook-image-cl">
              <img src="<?php echo $ebook_image['url']; ?>" alt="<?php echo $ebook_image['alt']; ?>">
            </div>
            <div class="ebook-detail-cl">
              <h2 class="banner-ebook-heading"><?php echo $ebook_heading; ?></h2>
              <div class="ebook-btn-link">
				  
                <img src="<?php echo get_template_directory_uri(); ?>/images/gumroad-seeklogo.png">
				 <script>
    document.addEventListener("DOMContentLoaded", function() {
        var script = document.createElement("script");
        script.src = "https://gumroad.com/js/gumroad.js";
        document.body.appendChild(script);
    });
</script>

                <a href="<?php echo $ebook_cta['url']; ?>"><?php echo $ebook_cta['title']; ?></a>
              </div>

            </div>
          </div>
        </div>
        <div class="col-md-6 home-banner-image">
          <div class="image">
<!--             <div class="row">
              <div class="col-md-8 author-image-cl"> -->

                <img class="at-main-img" src="<?php echo $banner_image['url']; ?>" alt="<?php echo $banner_image['alt']; ?>">
                <img src="<?php echo get_template_directory_uri(); ?>/images/blob.png">


              </div>
				
<!--             </div>

          </div> -->
        </div>
      </div>
    </div>
	  <div class="bn-hm-g-ad" style="width: 250px;
    height: 100%;
    display: flex;
    margin-left: 3rem;">
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7375354652362298"
     crossorigin="anonymous"></script>
<!-- New Home Final ad Fixed Vertical -->
<ins class="adsbygoogle"
     style="display:inline-block;width:240px;height:100%"
     data-ad-client="ca-pub-7375354652362298"
     data-ad-slot="7403209920"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
	  </div>
  </div>
</section>





<section class="filter-post-content">
  <div class="container">
    <div class="row filter-post-container-row">

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
      
		  <div class="g-ad-mn-dv">
			  
		 
 <div class="hm-left-google_ad" id="desktop-ad" style="background-color: #f0f0f0; border: 1px solid #ccc;">
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7375354652362298"
    crossorigin="anonymous"></script>
    <!-- Fixed Vertical Ads -->
    <ins class="adsbygoogle"
         style="display:inline-block;width:100%;height:700px"
         data-ad-client="ca-pub-7375354652362298"
         data-ad-slot="5237889620"></ins>
    <script>
         (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
</div>
			   </div>
 
     </div> 







      <div class="col-md-8 main-category-cl">
		
		  <div class="google_ad" id="g-desktop-ad" style="height:130px;!important;">
				  <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7375354652362298"
     crossorigin="anonymous"></script>
<!-- Horizontal Fixed Head -->
<ins class="adsbygoogle"
     style="display:inline-block;width:900px;height:130px"
     data-ad-client="ca-pub-7375354652362298"
     data-ad-slot="8540730452"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
				  	
		  </div>
		  <div id="loader" class="loader" style="display: none;">
  <!-- You can use CSS or an image for your loader -->
  <div class="spinner"></div>
</div>
        <div class="search-filter">
          <h3>Latest Recipes</h3>
          <div class="search-container">
            <button class="home-page-search-btn">
              <img src="<?php echo get_template_directory_uri(); ?>/images/home-page-search-icon.png" alt="Search Icon">
            </button>
            <input type="text" placeholder="Search Recipes..."  id="search-input">
          </div>

    


          <div class="category-grid-post-container mt-5 sss">
			  
			  <div class="veiw_list"> 
				  <div class="vwls_flx">
					  <div class="wls_item wls_grid">
						  <div class="wls_inner wls_btn" data-type="gird">
							  <img src="<?php echo get_template_directory_uri(); ?>/images/grid.png" alt="gird"/>
						  </div>
					  </div>
					   <div class="wls_item wls_grid">
						  <div class="wls_inner wls_btn" data-type="list">
							  <img src="<?php echo get_template_directory_uri(); ?>/images/list.png" alt="list"/>
						  </div>
					  </div>
					  
				  </div>
			  </div>
			  
            <div class="category-filter">
              <?php
              $terms = get_terms(array(
                'taxonomy' => 'category',
                'hide_empty' => true, // Set to true to hide empty categories
              ));
              $category_count = !empty($terms) && !is_wp_error($terms) ? count($terms) : 0;
              $initial_limit = 5;
              $counter = 0;
              ?>

              <div class="category-listing" data-initial-limit="<?php echo $initial_limit; ?>">
                <a href="javascript:void(0)" class="category-filter-btn active" data-category-id="most-popular">Latest</a>
                <?php if ($category_count > 0) {
                  foreach ($terms as $term) {
                    $class = $counter >= $initial_limit ? 'hidden' : '';
                    echo '<a href="javascript:void(0)" class="category-filter-btn ' . $class . '" data-category-id="' . $term->term_id . '">' . $term->name . '</a>';
                    $counter++;
                  }
                } ?>
                <a href="javascript:void(0)" id="show-more" class="category-filter-btn">Show More</a>
                <a href="javascript:void(0)" id="show-less" class="category-filter-btn hidden">Show Less</a>
              </div>
            </div>


            <div class="category-filter-post-container">

              <div class="row" id="main-rw-id">
                <!-- AJAX loaded posts will be displayed here -->
              </div>
			
            </div>
			  
          </div>
			
        </div> 
		 <div class="row" style="
    height: 50px;
">
                        <div class="col-md-12 justify-content-center d-flex">
                            <button id="home-view-more-btn"><span class="home-view-more-grid-btn">View More</span></button>
			  </div>
		  </div>

		  <div class="g-ads">
			  	  <div class="google_ad" id="g-desktop-ad" style="height:130px;!important;">
				  <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7375354652362298"
     crossorigin="anonymous"></script>
<!-- Horizontal Fixed Head -->
<ins class="adsbygoogle"
     style="display:inline-block;width:900px;height:130px"
     data-ad-client="ca-pub-7375354652362298"
     data-ad-slot="8540730452"></ins>
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
		
		  
<?php
// Function to display category section
function display_category_section($related_posts, $taxonomy_name)
{
    if ($related_posts && $taxonomy_name) :
        ?>
        <div class="taxonomy-title">
            <h4><?php echo esc_html($taxonomy_name); ?></h4>
        </div>
        <div class="category-grid-post-container">
            <div class="row">
                <?php
                global $post;
             
                foreach ($related_posts as $post) :
                    setup_postdata($post);
                
                    ?>
                    <div class="col-md-4 category-posts-cl">
                        <div class="category-grid-card-cl">
                            <?php $thumbnail_url = get_the_post_thumbnail_url($post_id, 'medium'); ?>
                            <?php $noImage = get_stylesheet_directory_uri() . "/images/no-post-img.jpg"; ?>

                            <a href="<?php echo esc_url(get_permalink()); ?>">
                                <div class="category-post-image-cl"
                                     style="background-image: url('<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'large')); ?>'); background-size: cover; background-position: center;"></div>
                            </a>
                            <a class="title_category" href="<?php echo esc_url(get_permalink()); ?>">
                                <h5 class="category-title-cl">
                                    <?php echo wp_trim_words(get_the_title(), 6, '...'); ?>
                                </h5>
                            </a>
                            <div class="recipe-stars-ratings" style="padding-left:5px;">
                                <?php $rating_average = get_post_meta($post->ID, 'wprm_rating_average', true); ?>
                                <?php echo get_star_rating_html($rating_average); ?>
                            </div>
                            <hr>
                            <p class="category-desc-cl"><?php echo wp_trim_words(get_the_excerpt($post->ID), 20); ?></p>
                            <a href="<?php echo get_permalink($post->ID); ?>" class="btn banner-cat-grid-btn">Read
                                Recipe</a>
                        </div>
                    </div>

                <?php endforeach;
                wp_reset_postdata(); // Reset post data after the loop
                ?>
            </div>
        </div>
    <?php
    elseif ($related_posts && !$taxonomy_name) :
        ?>
        <div class="category-grid-post-container">
            <div class="row">
                <?php
                global $post;
                foreach ($related_posts as $post) :
                    setup_postdata($post);
                    ?>
                    <div class="col-md-4 category-posts-cl">
                        <div class="category-grid-card-cl">
                            <?php $thumbnail_url = get_the_post_thumbnail_url($post_id, 'medium'); ?>
                            <?php $noImage = get_stylesheet_directory_uri() . "/images/no-post-img.jpg"; ?>

                            <a href="<?php echo esc_url(get_permalink()); ?>">
                                <div class="category-post-image-cl"
                                     style="background-image: url('<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'large')); ?>'); background-size: cover; background-position: center;"></div>
                            </a>
                            <a href="<?php echo esc_url(get_permalink()); ?>">
                                <h5 class="category-title-cl">
                                    <?php echo wp_trim_words(get_the_title(), 6, '...'); ?>
                                </h5>
                            </a>
                            <div class="recipe-stars-ratings" style="padding-left:5px;">
                                <?php $rating_average = get_post_meta($post->ID, 'wprm_rating_average', true); ?>
                                <?php echo get_star_rating_html($rating_average); ?>
                            </div>
                            <hr>
                            <p class="category-desc-cl"><?php echo wp_trim_words(get_the_excerpt($post->ID), 20); ?></p>
                            <a href="<?php echo get_permalink($post->ID); ?>" class="btn banner-cat-grid-btn">Read
                                Recipe</a>
                        </div>
                    </div>
                <?php endforeach;
                wp_reset_postdata(); // Reset post data after the loop
                ?>
            </div>
        </div>
    <?php
    else :
        ?>
        <p>No related posts found.</p>
    <?php
    endif;
}

// Fetch the selected categories from the multi-select field
$selected_categories = get_field('select_category');

if (!empty($selected_categories) && is_array($selected_categories)) {
    // Loop through each selected category
    foreach ($selected_categories as $selected_category) {
        if ($selected_category) {
            $query_args = [
                'post_type' => 'post',
                'posts_per_page' => 3,
                'orderby' => 'date', // Order by post date
                'order' => 'ASC',
                'tax_query' => [
                    [
                        'taxonomy' => 'category',
                        'field' => 'term_id',
                        'terms' => $selected_category,
                    ],
                ],
            ];

            $query = new WP_Query($query_args);

            if ($query->have_posts()) {
                $related_posts = $query->posts;
                $taxonomy_name = get_term($selected_category)->name;

                display_category_section($related_posts, $taxonomy_name);
            } else {
                display_category_section([], '');
            }
            wp_reset_postdata(); // Reset post data after the query
        }
    }
}
?>


        <div class="taxonomy-title">
          <h4>User Comments</h4>
        </div>

        <div class="category-grid-post-container">
          <div class="row">
            <?php
            if ($select_user_comment_post) :
              foreach ($select_user_comment_post as $index => $post_id) :
                $post = get_post($post_id);
                if ($post) :
                  setup_postdata($post);
            ?>
                  <div class="col-md-4 category-posts-cl">
                    <div class="category-grid-card-cl">
                      <?php $thumbnail_url = get_the_post_thumbnail_url($post_id, 'medium'); ?>
                      <?php $noImage = get_stylesheet_directory_uri() . "/images/no-post-img.jpg"; ?>
                      <a href="<?php echo esc_url(get_permalink()); ?>">
                        <div class="category-post-image-cl" style="background-image: url('<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'large')); ?>'); background-size: cover; background-position: center;"></div>
                      </a>
                      <a href="<?php echo esc_url(get_permalink()); ?>">
                        <h5 class="category-title-cl">
                          <?php echo wp_trim_words(get_the_title(), 6, '...'); ?>
                        </h5>
                      </a>

                      <div class="recipe-stars-ratings">
                        <?php $rating_average = get_post_meta($post->ID, 'wprm_rating_average', true); ?>
                        <?php echo get_star_rating_html($rating_average); ?>
                      </div>
                      <hr>
                      <div class="category-desc-cl users-comments">
                        <?php
                        // Ensure the index is within bounds of the comments section array
                        if (isset($user_comments_section[$index])) {
                          $comment = $user_comments_section[$index];
                        ?>
                          <div class="latest-comment">
                            <p class="home-page-comment-author"><strong><?php echo esc_html($comment['add_user_name']); ?>:</strong></p>
                            <p class="comment-content"><?php echo wp_kses_post($comment['add_user_comment']); ?></p>
                          </div>
                        <?php
                        }
                        ?>
                      </div>
                      <a href="<?php echo esc_url(get_permalink()); ?>" class="btn banner-cat-grid-btn">Read Recipe</a>
                    </div>
                  </div>
            <?php
                  wp_reset_postdata(); // Reset post data after each post
                endif;
              endforeach;
            else :
              echo '<p>No selected posts.</p>';
            endif;
            ?>
          </div>
        </div>
      </div>
      <div class="col-md-2 hm-google_addon">
         <div class="google_ad" id="hm-right-ad">
		<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7375354652362298"
     crossorigin="anonymous"></script>
<!-- Fixed Vertical Ads -->
<ins class="adsbygoogle"
     style="display:inline-block;width:100%;height:700px"
     data-ad-client="ca-pub-7375354652362298"
     data-ad-slot="5237889620"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
        </div>
    </div>
		
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
  </div>
	
	
	
	
</section>
<?php get_footer(); ?>