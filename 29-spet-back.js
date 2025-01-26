jQuery(document).ready(function($) {
	
    // 	let margin=0;
    // 	window.addEventListener('scroll', () => {
    //     console.log('Page is being scrolled');
        
    //     // Example: Detect how far down the page has been scrolled
        
        
    //     const scrollPosition = window.scrollY;  // or window.pageYOffset
    //     console.log(`Scroll position: ${scrollPosition}`);
    // 		const el = document.getElementById("google-sticky-ad");
            
            
    // 		if (scrollPosition >= 1400){
    // 			margin = scrollPosition;
    // 			el.style.top=`${margin}px`;
    // 		console.log("set postion fixed", margin);
    // 	}
    // 		else{
    // 			margin = 0;
    // 		el.style.marginTop=`${margin}px`;
                
    // 		}
    // });
        
        
        $('#load-cat-content').on('click', function() {
            $('#short-description').hide();
            $('#full-description').show();
            $(this).hide(); // Hide the "Read More" button
        });
    
        $('#show-less-content').on('click', function() {
            $('#full-description').hide();
            $('#short-description').show();
            $('#load-cat-content').show(); // Show the "Read More" button again
    
            // Scroll to the top of the element with additional offset
            const offsetTop = $('.recipes-grid-post-col').offset().top - 50; // Adjust -100 to your preference
            $('html, body').animate({
                scrollTop: offsetTop
            }, 800); // Adjust the duration (800ms) as needed
        });
    });
    
    
    
    jQuery(document).ready(function($) {
        var postsPerPage = 6; // Default number of posts per page
        var postsLoaded = postsPerPage; // Track loaded posts count
        var initialLimit = $(".recipes-category-listing.tag-listing").data("initial-limit"); // Get initial limit from data attribute
    
        // Function to load posts via AJAX
        function loadPosts(subcategoryId, offset, appendData) {
            console.log("Loading posts for subcategory ID: ", subcategoryId); // Debug: Check subcategory ID being sent
    
            $.ajax({
                url: '/wp-admin/admin-ajax.php',
                type: 'POST',
                data: {
                    action: 'load_posts_by_trending_subcategory',
                    subcategory_id: subcategoryId,
                    offset: offset,
                    posts_per_page: postsPerPage
                },
                beforeSend: function() {
                    // Add loading indicator if needed
                },
                success: function(response) {
                    if (appendData) {
                        $('#trending-posts-container').append(response.data);
                    } else {
                        $('#trending-posts-container').html(response.data);
                    }
    
                    // Update postsLoaded count
                    postsLoaded = offset + postsPerPage;
    
                    // Show the "View More" button only if there are more posts to load
                    if (response.has_more) {
                        $('.recipe-trending-view-more-btn').show();
                    } else {
                        $('.recipe-trending-view-more-btn').hide();
                    }
                },
                error: function(xhr, status, error) {
                    console.log("AJAX Error: ", error); // Debug: Log AJAX errors
                }
            });
        }
    
        // Load default posts on page load
        var initialSubcategoryId = $('.recipes-trending-filter-btn.active').data('subcategory-id') || 'all';
        loadPosts(initialSubcategoryId, 0, false);
    
        // Click handler for subcategory buttons
        $('.recipes-category-listing.tag-listing').on('click', '.recipes-trending-filter-btn', function(e) {
            e.preventDefault();
            if (!$(this).hasClass('active')) {
                $('.recipes-trending-filter-btn').removeClass('active');
                $(this).addClass('active');
                var subcategoryId = $(this).data('subcategory-id') || 'all';
                console.log("Clicked subcategory ID: ", subcategoryId); // Debug: Check subcategory ID on click
                loadPosts(subcategoryId, 0, false); // Load posts based on selected subcategory
            }
        });
        
        
       
        
    
        // Click handler for "View More" button
       $('.recipe-trending-view-more-btn').on('click', function(e) {
        e.preventDefault();
    
        var subcategoryId = $('.recipes-trending-filter-btn.active').data('subcategory-id') || 'all';
        var currentPostsCount = $('.recipes-trending-posts-cl').length; // Count currently loaded posts
    
        $.ajax({
            url: '/wp-admin/admin-ajax.php',
            type: 'POST',
            data: {
                action: 'load_more_posts_by_trending_subcategory',
                subcategory_id: subcategoryId,
                offset: currentPostsCount
            },
            beforeSend: function() {
                // Optional: Add a loading indicator here if needed
                // 
                $('#loader').show();
                $('.recipe-trending-view-more-btn').text('Loading...').prop('disabled', true);
            },
            success: function(response) {
                if (response.data) {
                    $('#loader').hide();
                    // Append the new posts row by row to maintain the structure
                    var tempContainer = $('<div>').html(response.data);
                    var rows = tempContainer.find('.row');
                      rows.addClass('active');
                      
                      setTimeout(function() {
                        rows.removeClass('active');
                    }, 1000); 
    
                    rows.each(function() {
                        $('#trending-posts-container').append($(this));
                    });
    
                    // Restore the "View More" button text and state
                    $('.recipe-trending-view-more-btn').text('View More').prop('disabled', false);
    
                    // Hide the "View More" button if no more posts
                    if (!response.has_more) {
                        $('.recipe-trending-view-more-btn').hide();
                    }
                }
            },
            error: function(xhr, status, error) {
                console.log("AJAX Error: ", error); // Debug: Log AJAX errors
    
                // Restore the "View More" button text and state in case of error
                $('.recipe-trending-view-more-btn').text('View More').prop('disabled', false);
            }
        });
    });
    
    });
    
    
    
    jQuery(document).ready(function ($) {
            // Initially hide all questions and answers
            $('.question, .answer').hide();
    
            // Function to toggle the display of answers
            function toggleAnswer(element) {
                var answer = $(element).next('.answer');
                var icon = $(element).find('.icon i');
    
                if (answer.is(':visible')) {
                    answer.hide();
                    icon.removeClass('fa-minus').addClass('fa-plus');
                } else {
                    answer.show();
                    icon.removeClass('fa-plus').addClass('fa-minus');
                }
            }
    
            // Function to toggle the display of categories
            function toggleCategory(element) {
                var questions = $(element).next('.questions');
                var icon = $(element).find('.icon i');
    
                if (questions.is(':visible')) {
                    questions.hide().find('.question').hide();
                    icon.removeClass('fa-chevron-down').addClass('fa-chevron-right');
                } else {
                    questions.show().find('.question').show();
                    icon.removeClass('fa-chevron-right').addClass('fa-chevron-down');
                }
            }
    
            // Function to handle search
            function handleSearch() {
                var input = $('#faq-search-input').val().toLowerCase();
                var categories = $('.category');
                var found = false;
    
                categories.each(function () {
                    var category = $(this);
                    var categoryMatches = false;
                    var questions = category.find('.question');
    
                    questions.each(function () {
                        var question = $(this);
                        var questionTitle = question.find('.question-title span').text().toLowerCase();
    
                        if (questionTitle.includes(input)) {
                            question.find('.answer').hide();
                            question.find('.icon i').removeClass('fa-minus').addClass('fa-plus');
                            question.show();
                            categoryMatches = true;
                            found = true;
                        } else {
                            question.hide();
                        }
                    });
    
                    if (categoryMatches) {
                        category.find('.questions').show();
                        category.find('.icon i').removeClass('fa-chevron-right').addClass('fa-chevron-down');
                    } else {
                        category.find('.questions').hide();
                        category.find('.icon i').removeClass('fa-chevron-down').addClass('fa-chevron-right');
                    }
                });
    
                if (!found) {
                    alert('No matching questions found.');
                }
    
                // If input is empty, hide all questions
                if (input === '') {
                    categories.each(function () {
                        var category = $(this);
                        category.find('.question').hide();
                        category.find('.questions').hide();
                        category.find('.icon i').removeClass('fa-chevron-down').addClass('fa-chevron-right');
                    });
                }
            }
    
            // Add event listeners for search button and keyup using jQuery
            $('#faq-search-button').on('click', handleSearch);
            $('#faq-search-input').on('keyup', handleSearch);
    
            // Add event listeners for toggling answers using jQuery
            $('.question-title').on('click', function () {
                toggleAnswer($(this));
            });
    
            // Add event listeners for toggling categories using jQuery
            $('.category-title').on('click', function () {
                toggleCategory($(this));
            });
        });
    
    jQuery(document).ready(function($) {
        const menuButton = $('.recipes-menu-cl');
        const navMainCol = $('.header-nav-main-col, .header-login-signup-col');
    
       
    
        // Toggle display on click
        menuButton.click(function() {
            if (navMainCol.css('display') === 'none') {
                navMainCol.css('display', 'block');
                //navMainCol.addClass('active');
            } else {
                navMainCol.css('display', 'none');
                //navMainCol.removeClass('active');
            }
        });
    });
    
    
    
    
    jQuery(document).ready(function($) {
        const menuButton = $('.recipes-menu-cl');
        const navMainCol = $('.header-nav-main-col, .header-login-signup-col');
        const hoverDiv = $('#hoverDiv');
        const closeModal = $('.closeRecipeHover');
        
    
    
        // Hover functionality for hoverDiv
        menuButton.on('mouseenter', function() {
            if($(window).width() > 767){
                 hoverDiv.show();
            }  
        });
    
        menuButton.on('mouseleave', function() {
           if($(window).width() > 767){
               hoverDiv.hide();
           }
        });
    
        hoverDiv.on('mouseenter', function() { 
               hoverDiv.show(); 
        });
    
        hoverDiv.on('mouseleave', function() {
            hoverDiv.hide();
        });
    
        closeModal.on('click', function() {
            hoverDiv.hide();
        });
    
        // Prevent event propagation on child elements
        navMainCol.children().on('click', function(event) {
            event.stopPropagation();
        });
    });
    
    
    
    
    
    jQuery(document).ready(function($) {
    
      // 
      // Quick Link Menu Mobile Modal
      // 
      
      function QuickLinksVisibility() {
      var toggleButton = $(".open-close-quick-links-mobile");
      var modal = $(".quick-links-mobile-modal");
      
      toggleButton.on("click", function() {
          modal.toggleClass("open");
          toggleButton.toggleClass("cross");
      });
      }
      
      QuickLinksVisibility();
    
    
    });
    
    
    
    
    jQuery(document).ready(function($) {
        // Add placeholder text to the specified input fields
        $('.login input[type=email]').attr('placeholder', 'Email');
        $('.login input[type=password]').attr('placeholder', 'Password');
         $('#loginform input[name="log"]').attr('placeholder', 'Username or Email');
            $('#registerform label:contains("Username") + input[type="text"]').attr('placeholder', 'Username');
    
    
        
    });
    jQuery(document).ready(function($) {
        $('#backtoblog a').text('← Go Back');
    });
    
    
    jQuery(document).ready(function($) {
        var postsPerPage = 6; // Default number of posts per page
        var initialTagLimit = 5; // Define the initial tag limit
        var tagsLoaded = initialTagLimit;
    
        // Function to load posts via AJAX
        function loadPosts(subcategoryId) {
            console.log("Loading posts for subcategory ID: ", subcategoryId); // Debug: Check subcategory ID being sent
    
            $.ajax({
                url: '/wp-admin/admin-ajax.php',
                type: 'POST',
                data: {
                    action: 'load_posts_by_subcategory',
                    subcategory_id: subcategoryId
                },
                beforeSend: function() {
                    // Add loading indicator if needed
                },
                success: function(response) {
                    $('.recipes-category-filter-post-container .row').html(response.data);
                    // Reset the loaded count to initial posts per page
                    postsLoaded = postsPerPage; 
                    
                    // Show the "View More" button only if there are more posts to load
                    if (response.has_more) {
                        $('#recipe-view-more-btn').show();
                    } else {
                        $('#recipe-view-more-btn').hide();
                    }
                },
                error: function(xhr, status, error) {
                    console.log("AJAX Error: ", error); // Debug: Log AJAX errors
                }
            });
        }
    
        // Load default posts on page load
        var initialSubcategoryId = $('.recipes-category-filter-btn.active').data('subcategory-id') || 'all';
        loadPosts(initialSubcategoryId);
    
        // Click handler for subcategory buttons
        $('.recipes-category-listing.tag-listing .recipes-category-filter-btn').not('#show-more-tags, #show-less-tags').on('click', function(e) {
            e.preventDefault();
            if (!$(this).hasClass('active')) {
                $('.recipes-category-listing.tag-listing .recipes-category-filter-btn').not('#show-more-tags, #show-less-tags').removeClass('active');
                $(this).addClass('active');
                var subcategoryId = $(this).data('subcategory-id') || 'all';
                console.log("Clicked subcategory ID: ", subcategoryId); // Debug: Check subcategory ID on click
                loadPosts(subcategoryId); // Load posts based on selected subcategory
            }
        });
    
        // Click handler for "View More" button
        $('#recipe-view-more-btn').on('click', function(e) {
            e.preventDefault();
            
            var subcategoryId = $('.recipes-category-filter-btn.active').data('subcategory-id') || 'all';
            var currentPostsCount = $('.recipes-category-posts-cl').length; // Count currently loaded posts
    
            $.ajax({
                url: '/wp-admin/admin-ajax.php',
                type: 'POST',
                data: {
                    action: 'load_more_posts_by_subcategory',
                    subcategory_id: subcategoryId,
                    offset: currentPostsCount
                },
                beforeSend: function() {
                    $('#loader').show();
                    // Optional: Add a loading indicator here if needed
                    $('#recipe-view-more-btn').text('Loading...').prop('disabled', true);
                },
                success: function(response) {
                    if (response.data) {
                        $('#loader').hide();
                        // Append the new posts row by row to maintain the structure
                        var tempContainer = $('<div>').html(response.data);
                        var rows = tempContainer.find('.row');
                          rows.addClass('active');
                          setTimeout(function() {
                              rows.removeClass('active');
                            }, 1000); 
    
                        rows.each(function() {
                            $('#recipe-posts-container-row').append($(this));
                        });
    
                        // Restore the "View More" button text and state
                        $('#recipe-view-more-btn').text('View More').prop('disabled', false);
    
                        // Hide the "View More" button if no more posts
                        if (!response.has_more) {
                            $('#recipe-view-more-btn').hide();
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.log("AJAX Error: ", error); // Debug: Log AJAX errors
    
                    // Restore the "View More" button text and state in case of error
                    $('#recipe-view-more-btn').text('View More').prop('disabled', false);
                }
            });
       
        });
    
        // Function to update the visibility of "Show More" and "Show Less" buttons
        function updateShowButtons() {
            var hiddenTags = $('.recipes-category-listing.tag-listing .recipes-category-filter-btn.hidden').length;
            var totalTags = $('.recipes-category-listing.tag-listing .recipes-category-filter-btn').not('#show-more-tags, #show-less-tags').length;
    
            if (hiddenTags === 0) {
                $('#show-more-tags').hide();
                if (totalTags > initialTagLimit) {
                    $('#show-less-tags').show();
                }
            } else {
                $('#show-more-tags').show();
                $('#show-less-tags').hide();
            }
        }
    
        // Click handlers for "Show More" and "Show Less" tags buttons
        $('#show-more-tags').on('click', function(e) {
            e.preventDefault();
            var hiddenTags = $('.recipes-category-listing.tag-listing .recipes-category-filter-btn.hidden');
            hiddenTags.slice(0, initialTagLimit).removeClass('hidden');
            tagsLoaded += initialTagLimit;
            updateShowButtons();
        });
    
        $('#show-less-tags').on('click', function(e) {
            e.preventDefault();
            var visibleTags = $('.recipes-category-listing.tag-listing .recipes-category-filter-btn').not('.hidden');
            visibleTags.slice(initialTagLimit).addClass('hidden');
            tagsLoaded = initialTagLimit;
            updateShowButtons();
        });
    
        // Initial call to update button visibility
        updateShowButtons();
    });
    
    
    
    
    jQuery(document).ready(function($) {
    
    
    // Mobile Header Navigation
    
      $('#pull').on('click', function(e) {
        e.preventDefault();
        var navContainer = document.querySelector('.site-header-container .header-nav-main-col');
        var loginSignupContainer = document.querySelector('.site-header-container .header-login-signup-col');
        
        if ($(navContainer).css('display') === 'none') {
            navContainer.style.setProperty('display', 'block', 'important');
            loginSignupContainer.style.setProperty('display', 'block', 'important');
            $('#pull .bars').hide();
            $('#pull .close').show();
        } else {
            navContainer.style.setProperty('display', 'none', 'important');
            loginSignupContainer.style.setProperty('display', 'none', 'important');
            $('#pull .bars').show();
            $('#pull .close').hide();
        }
    });
    
    
    
    
    
    
    
    
    
    
    
      
      //
      //
      // Ajax Function For Home page category filter
      //
     
    $('#sort-modal-select').val('date');
    
    var initialLimit = $(".category-listing").data("initial-limit");
    var showMoreButton = $("#show-more");
    var showLessButton = $("#show-less");
    var viewMoreButton = $('#home-view-more-btn'); // Define the View More button
    
    function updateShowButtons() {
      if ($(".category-filter-btn.hidden").not("#show-more, #show-less").length === 0) {
        showMoreButton.hide();
        showLessButton.show().appendTo(".category-listing");
      } else {
        showMoreButton.show().appendTo(".category-listing");
        showLessButton.hide();
      }
    }
    
    function updateViewMoreButton(response) {
      if (response.trim() === "" || response.includes("No posts found")) { // Check if the response is empty or contains "No more posts found"
        viewMoreButton.addClass('hide').removeClass('show'); // Hide the button
      } else {
        viewMoreButton.addClass('show').removeClass('hide'); // Show the button
      }
    }
    
    // Show more categories
    showMoreButton.click(function (e) {
      e.preventDefault();
      $(".category-filter-btn.hidden").slice(0, initialLimit).removeClass("hidden");
      updateShowButtons();
    });
    
    // Show less categories
    showLessButton.click(function (e) {
      e.preventDefault();
      $(".category-filter-btn").not("#show-more, #show-less").slice(initialLimit).addClass("hidden");
      updateShowButtons();
    });
    
    // Load posts based on category
    $(".category-filter-btn").click(function (e) {
      e.preventDefault();
      var categoryId = $(this).data("category-id");
      if (!categoryId) return;
      $(".category-filter-btn").removeClass("active");
      $(this).addClass("active");
      totalPostsDisplayed = initialPostsDisplayed; // Reset totalPostsDisplayed for new category
      $('#main-rw-id').empty(); // Clear existing posts
      loadPosts(categoryId);
    });
    
    // Search functionality
    $("#search-input").on("change keyup", function () {
      var searchQuery = $(this).val();
      totalPostsDisplayed = initialPostsDisplayed; // Reset totalPostsDisplayed for new search
      $('#main-rw-id').empty(); // Clear existing posts
      if (searchQuery === "") {
        var categoryId = $(".category-filter-btn.active").data("category-id") || "most-popular";
        loadPosts(categoryId);
      } else {
        var categoryId = $(".category-filter-btn.active").data("category-id") || "";
        loadPosts(categoryId);
      }
    });
    
    // Sort functionality
    $('#sort-icon').on('click', function() {
      $('#sort-modal').show();
    });
    
    $('#sort-apply-button').on('click', function() {
      $('#sort-modal').hide();
      loadPosts();
    });
    
    // On browser back button press
    $(window).on("popstate", function () {
      var searchInput = $("#search-input").val();
      var categoryId = $(".category-filter-btn.active").data("category-id") || "most-popular";
    
      if (searchInput === "") {
        loadPosts(categoryId);
      }
    });
    
    function loadPosts(categoryId) {
      var search = $("#search-input").val();
      var sortby = $("#sort-modal-select").val() || 'date'; // Ensure default sort is 'date'
    
      var data = {
        action: "load_posts_by_category",
        search: search,
        sortby: sortby,
      };
    
      if (categoryId !== "most-popular") {
        data.category_id = categoryId;
      }
    
      console.log("Sending AJAX request with data:", data); // For debugging
    
      $.ajax({
        url: "/wp-admin/admin-ajax.php",
        type: "POST",
        data: data,
        success: function (response) {
          $(".category-filter-post-container .row").html(response);
          updateViewMoreButton(response); // Update View More button based on response
        },
        error: function (xhr, status, error) {
          console.error("AJAX request failed:", status, error); // For debugging
          viewMoreButton.addClass('hide').removeClass('show'); // Hide the button on error
        }
      });
    }
    
    // var postsPerPage = 3; 
    // var initialPostsDisplayed = 21;
    // var totalPostsDisplayed = initialPostsDisplayed;
    
    // Function to load more posts
    function loadMorePosts() {
        
    var postsPerPage = parseInt($('.load-mr').data('posts-load-page'));
    var initialPostsDisplayed =  parseInt($('.data-pst-pr-pg').data('posts-per-page'));
    var totalPostsDisplayed = initialPostsDisplayed;
        
        
      var categoryId = $('.category-filter-btn.active').data('category-id') || 'most-popular';
      var searchQuery = $('#search-input').val();
      var sortBy = $('#sort-modal-select').val() || 'date';
    
      $.ajax({
        url: '/wp-admin/admin-ajax.php',
        type: 'POST',
        data: {
          action: 'load_more_home_posts_by_category',
          category_id: categoryId,
          search: searchQuery,
          sortby: sortBy,
          offset: totalPostsDisplayed
        },
        beforeSend: function () {
                $('#loader').show();
          viewMoreButton.addClass('hide').removeClass('show'); // Hide the button while loading more posts
        },
        success: function (response) {
                $('#loader').hide();
            
          if (response.data) {
            var newRow = $('<div class="row hm-mn-rw active"></div>').html(response.data);
            $('#main-rw-id').append(newRow);
              
               // Add 'active' class only to the last loaded row
            newRow.addClass('active');
              
                setTimeout(function() {
              newRow.removeClass('active');
            }, 1000); 
             
    
            totalPostsDisplayed += postsPerPage;
    
            if (!response.has_more) {
              viewMoreButton.addClass('hide').removeClass('show'); // Hide the button if no more posts
            } else {
              viewMoreButton.addClass('show').removeClass('hide'); // Show the button if there are more posts
            }
          } 
        },
        error: function (xhr, status, error) {
          console.log("AJAX Error: ", error);
          viewMoreButton.addClass('hide').removeClass('show'); // Hide the button on error
        }
      });
    }
    
    // Event listener for the "View More" button
    $('#home-view-more-btn').on('click', function (e) {
      e.preventDefault();
        $('.google_ad').addClass('hide');
      loadMorePosts();
    });
    
    // Event listener for category filter buttons
    $('.category-filter-btn').on('click', function (e) {
      e.preventDefault();
    
      var $this = $(this);
    
      if ($this.hasClass('active')) {
        // Reset the totalPostsDisplayed for the new category
        totalPostsDisplayed = 18;
        $('#main-rw-id').html('');
           $('.google_ad').remove();
        loadMorePosts();
      }
    });
    
    // Event listener for search input
    $('#search-input').on('input', function () {
      totalPostsDisplayed = 9;
      $('#main-rw-id').html(); 
         $('.google_ad').remove();
      loadPosts(); // Corrected function call to loadPosts instead of loadMorePosts
    });
    
    // Load all posts by default (most popular)
    loadPosts("most-popular");
    
    
        
        
      //
      //
      // Timeline function for about us page
      //
    
        
        
    function adjustTimeline() {
      var $timelineItems = $(".timeline-item");
      var $dots = $(".timeline-img");
    
      if ($dots.length > 0) {
        $timelineItems.each(function (index, element) {
          var $content = $(element).find(".timeline-content");
          var $dot = $(element).find(".timeline-img");
    
          // Get the margin-top value of the content
          var marginTop = parseFloat($content.css("margin-top")) || 0;
          var contentHeight = $content.outerHeight();
          var contentTop = $content.position().top;
    
          // Adjust contentTop with marginTop
          var adjustedContentTop = contentTop + marginTop;
          var dotCenter = adjustedContentTop + contentHeight / 2 - $dot.outerHeight() / 2;
    
          $dot.css("top", dotCenter + "px");
        });
    
        var $firstDot = $dots.first();
        var $lastDot = $dots.last();
    
        var firstDotCenter = $firstDot.position().top + $firstDot.outerHeight() / 2;
        var lastDotCenter = $lastDot.position().top + $lastDot.outerHeight() / 2;
    
        var timelineHeight = lastDotCenter - firstDotCenter;
    
        // Remove any previously added dynamic styles to avoid conflicts
        $("style.timeline-dynamic").remove();
    
        // Create a dynamic style tag and append to head
        $(
          "<style class='timeline-dynamic'>.timeline-container::before { height: " +
            timelineHeight +
            "px; top: " +
            firstDotCenter +
            "px; }</style>"
        ).appendTo("head");
      }
    }
    
    // Call the adjustTimeline function when needed
    adjustTimeline();
        
    
    
    
      //
      // FAQ search functionality
      //
      //
      //
    
    function performFAQSearch(searchQuery) {
      $.ajax({
        url: "/wp-admin/admin-ajax.php",
        type: "POST",
        data: {
          action: "faq_search",
          query: searchQuery,
        },
        success: function (response) {
          $(".faq-cl").html(response);
        },
      });
    }
    
    // Event handler for clicking the search button
    $("#faq-search-button").on("click", function () {
      var searchQuery = $("#faq-search-input").val();
      performFAQSearch(searchQuery);
    });
    
    // Event handler for input change in the search input field
    $("#faq-search-input").on("input", function () {
      if ($(this).val() === "") {
        performFAQSearch("");
      }
    });
    
    // Event handler for keyup in the search input field
    $("#faq-search-input").on("keyup", function () {
      var searchQuery = $(this).val();
      performFAQSearch(searchQuery);
    });
    
    
    
      //
      //
      // Ajax Function for blog page save post button
      //
      //
      // Function to update the read status of blog posts
    
      function updateReadStatus() {
        $(".blog-card, .latest-post-banner").each(function () {
          let postId = $(this).data("post-id");
          let lastRead = localStorage.getItem("post-" + postId);
          if (lastRead) {
            let readTime = new Date(parseInt(lastRead));
            let now = new Date();
            let diff = Math.floor((now - readTime) / (1000 * 60)); // difference in minutes
    
            if (diff >= 60) {
              let hours = Math.floor(diff / 60);
              let minutes = diff % 60;
              $(this)
                .find(".read-time")
                .text("· " + hours + " hours " + "read")
                .show();
            } else {
              $(this)
                .find(".read-time")
                .text("· " + diff + " min read")
                .show();
            }
          } else {
            $(this).find(".read-time").text(""); // Default read time if not read before
          }
        });
      }
    
      // Function to attach click event for tracking post read time
      function attachClickEvent() {
        $(".blog-card a, .latest-post-banner a")
          .off("click")
          .on("click", function () {
            let postId = $(this)
              .closest(".blog-card, .latest-post-banner")
              .data("post-id");
            localStorage.setItem("post-" + postId, new Date().getTime());
          });
      }
    
      // Load more posts on clicking the "Read More" button
    
      var page = 2; // Initialize page number
    
        // Get the banner post ID dynamically from the data attribute
        var bannerPostId = $('.latest-post-banner').data('post-id');
    
        $('#read-more-btn').on('click', function(e) {
            e.preventDefault();
    
            $.ajax({
                url: "/wp-admin/admin-ajax.php",
                type: 'post',
                data: {
                    action: 'load_more_posts',
                    paged: page,
                    banner_post_id: bannerPostId
                },
                success: function(response) {
                    if (response.trim() !== "") {
                        $('#blog-grid').append(response); // Append new posts to the grid
                        page++; // Increment page number
    
                        // Re-apply event handlers and read status checks to new posts
                        attachClickEvent();
                        updateReadStatus();
                        applySavedPostFilters(); // Apply filters to newly loaded posts
                    } else {
                        $('#read-more-btn').hide(); // Hide the button if no more posts
                    }
                },
                error: function() {
                    console.log('An error occurred while loading more posts.');
                }
            });
        });
        
        
        
        
    
    
    
      // Function to handle saving and unsaving posts
      function handleSavePost() {
        var button = $(this);
        var postId = button.data("post-id");
        var svg = button.siblings(".save-post-icon"); // Select the SVG image
        var action = button.hasClass("saved") ? "unsave_post" : "save_post";
    
        // Perform AJAX request to save/unsave the post
        $.ajax({
          url: "/wp-admin/admin-ajax.php",
          type: "post",
          data: {
            action: action,
            post_id: postId,
          },
          success: function (response) {
            if (response == "saved") {
              button.addClass("saved");
              button.find(".icon-cl").text("-");
              // Apply CSS filter to fill the SVG background with red
              svg.css(
                "filter",
                "brightness(0) saturate(100%) invert(0%) sepia(0%) saturate(7500%) hue-rotate(350deg) brightness(100%) contrast(100%)"
              );
              alert("Post saved.");
            } else if (response == "unsaved") {
              button.removeClass("saved");
              button.find(".icon-cl").text("+");
              // Remove CSS filter to revert the SVG background to transparent
              svg.css("filter", "");
              alert("Post removed from saved.");
            }
          },
        });
      }
    
      // Function to apply CSS filters to saved posts on page load or after loading more posts
      function applySavedPostFilters() {
        $(".save-post-btn.saved").each(function () {
          var button = $(this);
          var svg = button.siblings(".save-post-icon");
          svg.css(
            "filter",
            "brightness(0) saturate(100%) invert(0%) sepia(0%) saturate(7500%) hue-rotate(350deg) brightness(100%) contrast(100%)"
          );
        });
      }
    
      // Initial read status check and event attachment
      updateReadStatus();
      attachClickEvent();
      applySavedPostFilters(); // Apply filters on initial load
    
      // Attach click event listener to the save post button
      $(document).on("click", ".save-post-btn", handleSavePost);
    
      // Handle delete button click on saved posts
      $(".saved-posts-grid").on("click", ".delete-post-btn", function () {
        var button = $(this);
        var postId = button.data("post-id");
    
        // Perform AJAX request to unsave the post
        $.ajax({
          url: "/wp-admin/admin-ajax.php",
          type: "post",
          data: {
            action: "unsave_post",
            post_id: postId,
          },
          success: function (response) {
            if (response == "unsaved") {
              button.closest(".blog-card").remove();
              alert("Your post has been removed from saved.");
    
              // Check if there are no more saved posts
              if ($(".saved-posts-grid .blog-card").length == 0) {
                $(".saved-posts-grid").html("<p>No saved posts found.</p>");
              }
            } else {
              alert("There was an error removing the post.");
            }
          },
        });
      });
    
      // Handle cancel button click for terms acceptance
      $(".button-terms-cancel").on("click", function () {
        // Retrieve the home URL from the data attribute
        var homeUrl = $(this).data("home-url");
    
        // Redirect to home page
        window.location.href = homeUrl;
      });
    
      // Handle accept button click for terms acceptance
      $(".button-terms-accept").on("click", function () {
        // Show confirmation message
        alert("You have agreed to the terms and conditions.");
      });
    
    
    
    //
    //		
    // 	Function for scrollbar
    // 	
    // 	
    // 	
    var $contentWrapper = $('.terms-and-conditions-wrapper');
      var $scrollbar = $('.scrollbar');
    
      $contentWrapper.on('scroll', function() {
          var scrollPercentage = $contentWrapper.scrollTop() / ($contentWrapper[0].scrollHeight - $contentWrapper.height());
          var scrollbarHeight = $scrollbar.parent().height() - $scrollbar.height();
          $scrollbar.css('top', (scrollPercentage * scrollbarHeight) + 'px');
      });
    
    
    
    
    });
    