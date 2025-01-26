

    // Update cart when input value changes (with max quantity validation)
    $(document).on("change", ".quantity__input", function() {
        // var quantity = parseInt($(this).val(), 10);
        // var lineItemIndex = $(this).data("line-item");
        // var variantId = $(this).data("quantity-variant-id");
    
        // // Correctly select the .variant-checkbox element with the matching data-variant-id
        // var $variantElement = $(`.variant-checkbox[data-variant-id="${variantId}"]`);
        // var maxQuantity = parseInt($variantElement.data("variant-qt"), 10);
    
        // console.log("Variant ID:", variantId);
        // console.log("Max Quantity Element:", $variantElement);
        // console.log("Max Quantity:", maxQuantity);
    
        // if (lineItemIndex) {
        //     if (isNaN(quantity) || quantity <= 0) {
        //         quantity = 1; // Default to 1 if input is blank or invalid
        //         $(this).val(quantity);
        //     }
    
        //     // Check if the selected quantity exceeds the max available
        //     if (quantity > maxQuantity) {
        //         alert(`Only ${maxQuantity} units available.`);
        //         $(this).val(maxQuantity); // Set the input back to the max quantity
        //         quantity = maxQuantity;
        //     }
    
        //     debouncedUpdateCartItem(lineItemIndex, quantity);
        // } else {
        //     console.warn('Line item index is missing');
        // }
    
         var quantity = parseInt($(this).val(), 10);
        var lineItemIndex = $(this).data("line-item");
        var variantId = $(this).data("quantity-variant-id");
    
        var maxQuantity;
    
        // Check if .variant-checkbox exists for this variant
        var $variantElement = $(`.variant-checkbox[data-variant-id="${variantId}"]`);
        if ($variantElement.length) {
            // Use .variant-checkbox data attribute
            maxQuantity = parseInt($variantElement.data("variant-qt"), 10);
        } else {
            // Fallback to .cart-update-data if .variant-checkbox is not found
            var $cartUpdateDataElement = $(`.cart-update-data[data-variant-id="${variantId}"]`);
            maxQuantity = parseInt($cartUpdateDataElement.data("max-qt"), 10);
        }
    
        console.log("Variant ID:", variantId);
        console.log("Max Quantity:", maxQuantity);
    
        if (lineItemIndex) {
            if (isNaN(quantity) || quantity <= 0) {
                quantity = 1; // Default to 1 if input is blank or invalid
                $(this).val(quantity);
            }
    
            // Check if the selected quantity exceeds the max available
            if (quantity > maxQuantity) {
                alert(`Only ${maxQuantity} units available.`);
                $(this).val(maxQuantity); // Set the input back to the max quantity
                quantity = maxQuantity;
            }
    
            debouncedUpdateCartItem(lineItemIndex, quantity);
        } else {
            console.warn('Line item index is missing');
        }
      
    });