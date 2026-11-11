<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart Functionality</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Cart Icon and Bubble */
        #cart-icon {
            position: relative;
            font-size: 24px;
            cursor: pointer;
        }

        #cart-count {
            position: absolute;
            top: -10px;
            right: -10px;
            background-color: red;
            color: white;
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 12px;
        }

        /* Cart Summary */
        #cart-summary {
            margin-top: 10px;
            font-size: 16px;
            display: none; /* Hidden initially, shown only when there are items */
        }

        #order-now {
            margin-top: 10px;
            padding: 5px 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        #order-now:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

    <!-- Cart Icon and Summary -->
    <div id="cart-icon">
        <i class="fa fa-shopping-cart"></i>
        <span id="cart-count">0</span>
    </div>
    <div id="cart-summary">
        <p>Total: <span id="cart-total">₱0.00</span></p>
        <button id="order-now" onclick="goToOrderPage()">Order Now</button>
    </div>

    <!-- Example Quantity Buttons for Adding Items -->
    <button class="increase-quantity-button" data-itemId="1" data-price="100">Add Quantity for Item 1</button>
    <button class="increase-quantity-button" data-itemId="2" data-price="150">Add Quantity for Item 2</button>

    <script>
        // Cart Object to Track Items and Total
        let cart = {
            items: 0,
            total: 0
        };

        // Function to Add Item to Cart
        function addToCart(price) {
            // Increase item count and total price
            cart.items += 1;
            cart.total += price;

            // Update cart count and total display
            document.getElementById('cart-count').textContent = cart.items;
            document.getElementById('cart-total').textContent = ₱${cart.total.toFixed(2)};

            // Show cart summary if there are items
            document.getElementById('cart-summary').style.display = cart.items > 0 ? 'block' : 'none';
        }

        // Function to Increase Quantity of a Specific Item
        function increaseQuantity(itemId, price) {
            // Simulate adding the item to the cart
            addToCart(price);
        }

        // Navigate to Order Page Function
        function goToOrderPage() {
            window.location.href = "order-page.html";
        }

        // Attach Event Listeners to Quantity Buttons
        document.querySelectorAll('.increase-quantity-button').forEach(button => {
            button.addEventListener('click', function() {
                const price = parseFloat(this.dataset.price); // Get price from data-price attribute
                increaseQuantity(this.dataset.itemId, price);
            });
        });
    </script>
</body>
</html>