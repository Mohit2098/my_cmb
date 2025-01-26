$(document).ready(function() {
    $('.text-info-sb:first p:first').css({
           'padding-left': '3rem',  
           'padding-right': '3rem' 
       });
     
     var $infoWindow = $('#infoWindow');
     var infoWindowTop;
     
     // Function to adjust the position of the info window
     function adjustInfoWindow() {
       var scrollTop = $(window).scrollTop();
       var windowHeight = $(window).height();
       var infoWindowHeight = $infoWindow.outerHeight();
       var bottomOffset = windowHeight - infoWindowHeight;
   
       if (scrollTop > infoWindowTop - bottomOffset) {
         $infoWindow.addClass('info-fixed');
       } else {
         $infoWindow.removeClass('info-fixed');
       }
     }
   
     // Initial state reset on page load
     function resetInfoWindow() {
       $infoWindow.removeClass('fixed');
       // Recalculate the top offset after the DOM is fully loaded and a slight delay
       setTimeout(function() {
         infoWindowTop = $infoWindow.offset().top;
       }, 100);
     }
   
     // Reset the info window initially
     resetInfoWindow();
   
     // Attach scroll and resize event handlers
     $(window).on('scroll', function() {
      // adjustInfoWindow();
     });
   
     $(window).on('resize', function() {
       // Recalculate the top offset on resize
       infoWindowTop = $infoWindow.offset().top;
     //  adjustInfoWindow();
     });
   
     // Call adjustInfoWindow once to ensure initial correct state without causing jump
    // adjustInfoWindow();
   
   
   
   
     
       var $navbarToggler = $('.navbar-toggler');
       var $togglerIcon = $navbarToggler.find('.navbar-toggler-icon');
       var $navMobileMenu = $('.nav-mobile-menu-items');
   
       // Toggle navbar menu
       $navbarToggler.click(function() {
           var isExpanded = $(this).attr('aria-expanded') === 'true';
           $togglerIcon.toggleClass('bars-icon cross-icon');
           $navMobileMenu.toggleClass('hidden visible');
           $('body').toggleClass('no-scroll', !isExpanded);
           $(this).attr('aria-expanded', String(!isExpanded));
       });
   
       $('#navbarNav').on('shown.bs.collapse', function() {
           $('.header-cl').addClass('active');
           $togglerIcon.removeClass('bars-icon').addClass('cross-icon');
           $navbarToggler.attr('aria-expanded', 'true');
           $navMobileMenu.removeClass('hidden').addClass('visible');
           $('body').addClass('no-scroll');
       });
   
       $('#navbarNav').on('hidden.bs.collapse', function() {
           $('.header-cl').removeClass('active');
           $togglerIcon.removeClass('cross-icon').addClass('bars-icon');
           $navbarToggler.attr('aria-expanded', 'false');
           $navMobileMenu.removeClass('visible').addClass('hidden');
           $('body').removeClass('no-scroll');
       });
   
    
   
   function debounce(func, delay) {
       let debounceTimer;
       return function() {
           const context = this;
           const args = arguments;
           clearTimeout(debounceTimer);
           debounceTimer = setTimeout(() => func.apply(context, args), delay);
       };
   }
   // Format number with commas
   function formatNumberWithCommas(amount) {
       return amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
   }
   // Format amount with commas and currency symbol
   function formatMoneyWithCurrency(amount) {
       var formattedNumber = formatNumberWithCommas(parseFloat(amount).toFixed(2));
       return `$${formattedNumber} USD`;
   }
   $('body').on('click', '.quantity__button, cart-remove-button', function(){
       setTimeout(function() {
          $.getJSON("/cart.js", function (cart) {
             console.log(cart.total_price);
               var totalPrice = (cart.total_price / 100).toFixed(2);
               var totalPriceFormatted = formatMoneyWithCurrency(totalPrice);
               $('.cart__footer_isolate .totals__total-value').html(totalPriceFormatted); 
           });
       }, 1500);
   })
     
   // Update cart count
   function updateCartCount() {
       $.ajax({
           url: '/cart.js',
           dataType: 'json',
           success: function(cart) {
               if (cart && cart.item_count !== undefined) {
                    check_properties(cart);
                   var itemCount = cart.item_count;
                   $('#cart-icon-bubble .cart-count-bubble').html('<span>CART(' + itemCount + ')</span>');
               } else {
                   console.warn('Cart object is missing item_count property');
               }
           },
           error: function(xhr) {
               console.error('Error fetching cart count:', xhr.responseText);
           }
       });
   }
   updateCartCount();
   $(document).on('cart:updated', function() {
       updateCartCount();
   });
   $('body').on('click', '.addtocart_id', function(e) {
       e.preventDefault();
       var selectedVariantId = $(this).data('id');
       $.ajax({
           url: '/cart/add.js',
           type: 'POST',
           data: {
               id: selectedVariantId,
               quantity: 1
           },
           dataType: 'json',
           success: function() {
               updateCartData();
               $('.cart-item-modal').addClass('open');
           },
           error: function(xhr) {
               console.error("Error adding to cart:", xhr.responseText);
               alert("Failed to add product to cart. Please try again.");
           }
       });
   });
   // Fetch cart items
   function fetchCartItems() {
       $.ajax({
           type: 'GET',
           url: '/cart.js',
           dataType: 'json',
           success: function(cart) {
               if (cart && cart.items) { 
                   updateCartModal(cart);
               } else {
                   console.warn('Cart object is missing items property');
               }
           },
           error: function(xhr) {
               console.error('Error fetching cart items:', xhr.responseText);
           }
       });
   }
   
   //  app properties
   function check_properties(cart) {
     if(!$('body').hasClass('template-cart')){
      cart.items.forEach(function(item, index) { 
         if(!jQuery.isEmptyObject(item.properties)){ 
           var id = item.id;
           var lineIndex = index+1;
           console.log(id);
              $.ajax({
                   url: "/cart/change.js",
                   type: "POST",
                   dataType: 'json',
                   data: { line: lineIndex, quantity: 0 }
               });
           }
        });
     }
   } 
     
   // Update cart modal with fetched items
   function updateCartModal(cart) {
       var cartHtml = '';
       if (cart.items && Array.isArray(cart.items)) {
           cart.items.forEach(function(item, index) {
               var itemId = item.variant_id;
               var itemTitle = item.title || 'No Title';
               var itemQuantity = item.quantity || 0;
               var itemPrice = item.price ? (item.price / 100).toFixed(2) : '0.00';
               // Calculate individual item subtotal (item price * item quantity)
               var itemSubtotal = (item.price * item.quantity / 100).toFixed(2);
               cartHtml += `
                   <div class="cart-item d-flex justify-content-between align-items-center">
                       <div class="item-info w-100">
                           <div class="row w-100 yt-row-cl">
                               <div class="crt_itme crt_title">
                                   <h6>${itemTitle}</h6>
                                   <button class="btn btn-link p-0 remove-item-btn" data-line-item="${index + 1}">Remove</button>
                               </div>
                               <div class="crt_itme crt_qty justify-content-center d-flex">
                                   <quantity-input class="quantity cart-quantity qt-mn-cl">
                                       <button class="quantity__button md-qu-btn rm-btn" name="minus" type="button" data-line-item="${index + 1}">
                                           -
                                       </button>
                                       <input
                                           class="quantity__input modal-inpt-qt"
                                           data-quantity-variant-id="${itemId}"
                                           type="number"
                                           name="updates[]"
                                           value="${itemQuantity}"
                                           min="0"
                                           aria-label="Quantity"
                                           data-line-item="${index + 1}"
                                       >
                                       <button class="quantity__button ad-btn" name="plus" type="button" data-line-item="${index + 1}">
                                           +
                                       </button>
                                   </quantity-input>
                               </div>
                               <div class="crt_itme crt_price justify-content-end d-flex align-items-center">
                                   <div class="item-price">$${formatNumberWithCommas(itemSubtotal)}</div>
                               </div>
                           </div>
                       </div>
                   </div>`;
           });
       } else {
           console.warn('Cart items are missing or not an array');
       }
       $(".modal-body").html(cartHtml);
       var totalPrice = (cart.total_price / 100).toFixed(2);
       var totalPriceFormatted = formatMoneyWithCurrency(totalPrice);
       $(".sb-tt-price").text(totalPriceFormatted);
       $(".cart-count-bubble span").text(`CART (${cart.item_count || 0})`);
       updateCartPage(cart);
   }
   // Update cart page
   function updateCartPage(cart) {
       if (cart.items && Array.isArray(cart.items)) {
           cart.items.forEach(function(item) {
               if (item.variant_id) {
                   var quantityInput = $(`input[data-quantity-variant-id="${item.variant_id}"]`);
                   if (quantityInput.length > 0) {
                       quantityInput.val(item.quantity);
                   }
                   var itemPriceElement = $(`span[data-variant-id="${item.variant_id}"]`);
                   if (itemPriceElement.length > 0) {
                       var itemPrice = (item.price / 100).toFixed(2);
                       itemPriceElement.text(formatMoneyWithCurrency(itemPrice));
                   }
               } else {
                   console.warn('Item or item variant is missing ID');
               }
           });
       } else {
           console.warn('Cart items are missing or not an array');
       }
       var totalPrice = (cart.total_price / 100).toFixed(2);
       var totalPriceFormatted = formatMoneyWithCurrency(totalPrice);
       $(".totals__total-value").text(totalPriceFormatted);
   }
   // Update cart item quantity
   function updateCartItem(lineItemIndex, quantity) {
       $.ajax({
           type: 'POST',
           url: '/cart/change.js',
           data: { line: lineItemIndex, quantity: quantity },
           dataType: 'json',
           success: function(cart) {
               if (cart) {
                   updateCartModal(cart);
                   if (quantity === 0) {
                       //location.reload(); // Reload the page if quantity is 0
                   }
               } else {
                   console.warn('Cart object is missing after update');
               }
           },
           error: function(xhr) {
               console.error('Error updating cart item:', xhr.responseText);
           }
       });
   }
   // Debounced version of updateCartItem
   const debouncedUpdateCartItem = debounce(updateCartItem, 300);
   // Cart item modal functionality
   function CartItemModal() {
       var cartIconBubble = $("#cart-icon-bubble");
       var modal = $(".cart-item-modal");
       var closeButton = $(".cart-item-modal-close");
       cartIconBubble.on("click", function() {
           modal.toggleClass("open");
           fetchCartItems();
       });
       closeButton.on("click", function() {
           modal.removeClass("open");
       });
       $('.citmd_bg').on("click", function() {
           modal.removeClass("open");
       });
       // Update cart when input value changes
       $(document).on("change", ".quantity__input", function() {
           var quantity = parseInt($(this).val(), 10);
           var lineItemIndex = $(this).data("line-item");
           if (lineItemIndex) {
               if (isNaN(quantity) || quantity <= 0) {
                   quantity = 1; // Default to 1 if input is blank or invalid
                   $(this).val(quantity);
               }
               debouncedUpdateCartItem(lineItemIndex, quantity);
           } else {
               console.warn('Line item index is missing');
           }
       });
       $(document).on("click", ".remove-item-btn", function() {
           var lineItemIndex = $(this).data("line-item");
           if (lineItemIndex) {
               debouncedUpdateCartItem(lineItemIndex, 0);
           } else {
               console.warn('Line item index is missing');
           }
       });
   }
   CartItemModal();
   
   
   
   
   
   
     // modal popup.js 
     
       let basePrice = 0;
       let quantity = 1;
       let variantId = null;
   
       function updateCartData() {
           $.getJSON("/cart.js", function (cart) {
               let itemCount = cart.item_count || 0;
               $("#cart-icon-bubble .cart-count-bubble").html(`<span>CART(${itemCount})</span>`);
              updateCartModal(cart);
             
           });
       }
   
       function updatePrice(newQuantity) {
           $(".md-pr-ft-pr-cl").text(`$${(basePrice * newQuantity).toFixed(2)}`);
       }
   
       updateCartData();
   $(".btn-pdp-check").on("click", function () {
       const productId = $(this).data("product-id");
       const title = $(this).closest(".product-image").next(".coll-product-info").find(".coll-pr-title-head").data("product-title") || "No title found";
       const imageUrl = $(this).closest(".product-image").find(".prd-img img").attr("src") || "";
       const description = $(this).closest(".product-image").next(".coll-product-info").find(".coll-pr-title-head-desc").data("product-description") || "No description found";
       const status = $(this).data("product-status") === false ? "Sold Out" : "Available";
       basePrice = parseFloat($(this).data("product-price").replace("$", "")) || 0;
       const pickup = $(this).data('pickup');
       quantity = 1; // Reset quantity
       variantId = null; // Reset variantId
   
       let optionLabelsHtml = "";
       let optionCheckboxesHtml = "";
   
       $(this).closest(".coll-product-card").find(".vr").each(function () {
           const optionTitle = $(this).data("variant-title");
           const optionLabel = $(this).data("product-option");
           const variantId = $(this).val(); // Use variantId here
           const variantQuantity = $(this).data("variant-qt");
           const variantPrice = $(this).data("price");
           const variantImageSrc = $(this).data("image-src");
   
           if (optionLabelsHtml.indexOf(optionLabel) === -1) {
               optionLabelsHtml += `<p class="product-options-vr-lb">${optionLabel}</p>`;
           }
   
           optionCheckboxesHtml += 
               `<label class="product-options">
                   <input type="checkbox" class="variant-checkbox" data-variant-id="${variantId}" data-variant-qt="${variantQuantity}" data-price="${variantPrice}" data-image-src="${variantImageSrc}">
                   ${optionTitle}
               </label>`;
       });
   
       $(".product-modal-body").html(
           `<div class="product-modal-header">
               <div class="pmd_top_time">${pickup}</div>
               <div class="row pmd_flx">
                   <div class="col-md-6 md-prd-dt-info-cl">
                       <div class="pmd_item_inner">
                           <div class="product__title single-prod-title">
                               <h1>${title}</h1>
                           </div>
                           <div class="row st-prd-ds-rw-cl">
                               <div class="col-md-4 md-st-col-cl">
                                   <p class="product-status-cl">${status}</p>
                               </div>
                               <div class="col-md-8">
                                   <div class="md-prd-desc"><p>${description}</p></div>
                               </div>
                           </div>
                           <div class="row md-prd-vr-pr-rw-cl">
                               <div class="col-md-6 w-100 cmb-vr-prd-col">
                                   <div class="cmb-vr-prd d-flex">
                                       <div class="opt-vr-prd">
                                           ${optionLabelsHtml}
                                       </div>
                                       <div class="opt-vr-prd-tt d-flex">
                                           ${optionCheckboxesHtml}
                                       </div>
                                   </div>
                               </div>
                               <div class="col-md-6 md-pp-quantity-input-col">
                                   <label for="quantityInput" class="quantityInputLb">QTY</label>
                                   <quantity-input class="quantity md-ft-qt-btn">
                                       <button class="quantity__button no-js-hidden md-ft-qt-btn-mn" name="minus" type="button">-</button>
                                       <input class="quantity__input md-ft-qt-inp" type="number" min="1" value="${quantity}">
                                       <button class="quantity__button no-js-hidden md-ft-qt-btn-pl" name="plus" type="button">+</button>
                                   </quantity-input>
                               </div>
                           </div>
                           <div class="row align-items-end">
                               <div class="col-md-4">
                                   <p class="product-price md-pr-ft-pr-cl">$${(basePrice * quantity).toFixed(2)}</p>
                               </div>
                               <div class="col-md-8">
                                   <a href="javascript:void(0);" data-variant-id="${variantId}" class="add-to-cart-btn md-atc-btn">Add to Cart</a>
                               </div>
                           </div>
                       </div>
                   </div>
                   <div class="col-md-6">
                       <div class="product-modal-body-content">
                           <img src="${imageUrl}" alt="${title}" class="product-modal-image">
                       </div>
                   </div>
               </div>
           </div>`
       );
   
   
   
   
      $(".md-ft-qt-btn-pl").off("click").on("click", function () {
           // Fetch the current quantity from the input field
           let currentQuantity = parseInt($(".md-ft-qt-inp").val()) || 1;
   
           // Get the selected variant and its available quantity
           const selectedVariant = $(".opt-vr-prd-tt .product-options.active input");
           const availableQuantity = selectedVariant.data("variant-qt");
   
           // Calculate the new quantity
           let newQuantity = currentQuantity;
   
           // Check if the new quantity exceeds available quantity
           if (newQuantity > availableQuantity) {
               // Show an alert and set newQuantity to the available maximum
               alert(`You cannot add more than ${availableQuantity} units.`);
               newQuantity = availableQuantity; // Ensure quantity does not exceed available stock
           }
   
           // Update the input field and price
           $(".md-ft-qt-inp").val(newQuantity);
           updatePrice(newQuantity);
       });
     
   
       // Handle minus button click
       $(".md-ft-qt-btn-mn").off("click").on("click", function () {
           let currentQuantity = parseInt($(".md-ft-qt-inp").val()) || 1;
   
           currentQuantity = Math.max(1, currentQuantity); // Ensure minimum quantity is 1
           updatePrice(currentQuantity);
           $(".md-ft-qt-inp").val(currentQuantity);
       });
   
       // Handle quantity input field (manual input)
       $(document).on("input", ".md-ft-qt-inp", function () {
           let currentQuantity = $(this).val();
   
           // Temporarily allow empty input for user editing
           if (currentQuantity === "") {
               return; // Let the user input a number
           }
   
           currentQuantity = parseInt(currentQuantity) || 1;
   
           const selectedVariant = $(".opt-vr-prd-tt .product-options.active input");
           const availableQuantity = selectedVariant.data("variant-qt");
   
           // Ensure the input quantity doesn't exceed the available quantity
           if (currentQuantity > availableQuantity) {
               alert(`You cannot add more than ${availableQuantity} units.`);
               currentQuantity = availableQuantity; // Reset to max allowed
           }
   
           updatePrice(currentQuantity);
           $(this).val(currentQuantity); // Update the input field value
       });
   
       // Handle blur event to ensure minimum quantity is 1
       $(document).on("blur", ".md-ft-qt-inp", function () {
           let currentQuantity = $(this).val();
   
           // If input is empty or invalid, set it back to 1
           if (currentQuantity === "" || parseInt(currentQuantity) < 1) {
               currentQuantity = 1;
           }
   
           $(this).val(currentQuantity);
           updatePrice(currentQuantity);
       });
   
       $("#productModal").show();
       setFirstProductOptionActive();
   
       function setFirstProductOptionActive() {
           const firstProductOption = $(".opt-vr-prd-tt .product-options").first();
           if (firstProductOption.length > 0) {
               firstProductOption.addClass("active");
               $(".variant-checkbox", firstProductOption).prop('checked', true);
               basePrice = parseFloat($(".variant-checkbox", firstProductOption).data("price").replace("$", "")) || 0;
               quantity = 1; // Reset quantity to 1
               updatePrice(quantity);
           }
       }
   });
   
   // Update price function
   function updatePrice(quantity) {
       const totalPrice = (basePrice * quantity).toFixed(2);
       $(".product-price.md-pr-ft-pr-cl").text(`$${totalPrice}`);
   }
   
   // Handle variant checkbox change
   $(document).on("change", ".variant-checkbox", function () {
       $(".opt-vr-prd-tt .product-options").removeClass("active");
       $(this).closest(".product-options").addClass("active");
   
       const selectedVariantId = $(this).data("variant-id");
       const initialQuantity = $(this).data("variant-qt");
       const newPrice = $(this).data("price");
       const variantImageSrc = $(this).data("image-src");
   
       basePrice = parseFloat(newPrice.replace("$", "")) || 0;
       quantity = Math.min(parseInt($(".md-ft-qt-inp").val()) || 1, initialQuantity);
       updatePrice(quantity);
       $(".md-ft-qt-inp").val(quantity);
   
       if (variantImageSrc) {
           $(".product-modal-image").attr("src", variantImageSrc);
       }
   });
   
   // Handle Add to Cart button with AJAX
   $(document).on('click', '.add-to-cart-btn', function (event) {
       event.preventDefault();
       const selectedVariantId = $(".opt-vr-prd-tt .product-options.active input").data('variant-id');
       const quantity = parseInt($(".md-ft-qt-inp").val()) || 1;
   
       if (!selectedVariantId) {
           alert("Please select a product option.");
           return;
       }
   
       $.ajax({
           type: 'POST',
           url: '/cart/add.js',
           data: {
               id: selectedVariantId,
               quantity: quantity
           },
           dataType: 'json',
           success: function (response) {
                      $("#productModal").hide();
                       updateCartData();
                        $('.cart-item-modal').addClass('open');
           },
           error: function (error) {
               alert("An error occurred while adding to the cart.");
           }
       });
   });
   
       $(document).on('click', '.close-btn-md', function () {
           $("#productModal").hide();
       });
   });
   
   
   
   
   
   
   
   