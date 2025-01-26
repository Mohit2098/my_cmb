function debounce(func, delay) {
    let debounceTimer;
    return function() {
        const context = this;
        const args = arguments;
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => func.apply(context, args), delay);
    };
}

// Update cart count
function updateCartCount() {
    $.ajax({
        url: '/cart.js',
        dataType: 'json',
        success: function(cart) {
            if (cart && cart.item_count !== undefined) {
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

$('body').on('click', '.addtocart_id', function(e){
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
          success: function () {
              
              updateCartData();
               $('.cart-item-modal').addClass('open');
          },
          error: function (xhr) {
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

// Update cart modal with fetched items
function updateCartModal(cart) {
    var cartHtml = '';

   
    if (cart.items && Array.isArray(cart.items)) {
        cart.items.forEach(function(item, index) {
            var itemId = item.variant_id;
            var itemTitle = item.title || 'No Title';
            var itemQuantity = item.quantity || 0;
            var itemPrice = item.price ? (item.price / 100).toFixed(2) : '0.00';

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
                               <div class="item-price">$${formatNumberWithCommas(itemPrice)}</div>
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
    var totalPriceC = formatNumberWithCommas(totalPrice);
    var totalPriceFormatted = formatMoneyWithCurrency(totalPrice);
    // $(".sb-tt-price").text(`Total: ${totalPriceFormatted}`);
    $(".sb-tt-price").text(`${totalPriceFormatted}`);
    $(".cart-count-bubble span").text(`CART (${cart.item_count || 0})`);

    // Update the cart page quantities and prices
    updateCartPage(cart);

  
}

// Update cart page
function updateCartPage(cart) {
    if (cart.items && Array.isArray(cart.items)) {
        cart.items.forEach(function(item) {
            if (item.variant_id) {
                // Update quantity input
                var quantityInput = $(`input[data-quantity-variant-id="${item.variant_id}"]`);
                if (quantityInput.length > 0) {
                    quantityInput.val(item.quantity);
                }

                // Update item price
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

    // Update total price
    var totalPrice = (cart.total_price / 100).toFixed(2);
    var totalPriceC = formatNumberWithCommas(totalPrice);
    var totalPriceFormatted = formatMoneyWithCurrency(totalPrice);
    $(".price--end").text(`$${totalPriceC}`);
    $(".totals__total-value").text(totalPriceFormatted);
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
                    location.reload(); // Reload the page if quantity is 0
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

// Update subcart total
function updateSubcartTotal(cart) {
    var subcartTotal = cart.items.reduce(function(total, item) {
        return total + (item.quantity * item.price / 100);
    }, 0);
    $(".subcart-total-price").text(`Subtotal: ${formatMoneyWithCurrency(subcartTotal)}`);
}

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
        if (lineItemIndex && quantity >= 0) {
            debouncedUpdateCartItem(lineItemIndex, quantity);
        } else {
            console.warn('Line item index or quantity is missing or invalid');
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

