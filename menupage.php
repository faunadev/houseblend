<?php
ob_start(); // Start output buffering

// Define variables for dynamic content
$title = "Homepage - Houseblend N's Tea & Coffee Shop";
$logoSrc = "logo.png";
$menuItems = [
    "HOME" => "homepage.php",
    "MENU" => "menupage.php",
    "ABOUT US" => "about.php",
    "CONTACTS" => "contacts.php",
];
$searchPlaceholder = "Search...";
$searchLogoSrc = "slogo.png";
$profileLogoSrc = "profile.png";
$cartLogoSrc = "cart.png";

$menus = [
    "Hot Coffee" => "#", // You can replace "#" with the actual link to the Hot Coffee page
    "Iced Coffee" => "#", // Same here for the Iced Coffee link
    "Non-Coffee" => "#", // Link to Non-Coffee section
    "Oat Series" => "#" // Link to Oat Series section
];

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Houseblend N's Tea & Coffee Shop</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            background-image: url('bg.jpg');
            background-size: cover;
            background-attachment: fixed;
            color: #333;
        }

        /* ----------Sidebar---------- */
        .sidebar {
            box-sizing: border-box;
            width: 220px;
            padding: 20px;
            height: calc(100vh - 80px);
            position: fixed;
            top: 80px; /* sits below the fixed navbar */
            left: 0;
            background-color: rgba(0, 0, 0, 0.9);
            border-right: 1px solid #2a2a2a;
            z-index: 999;
            overflow-y: auto;
            scrollbar-width: none;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: stretch;
        }

        .sidebar::-webkit-scrollbar {
            display: none;
        }

        .sidebar h3 {
            font-size: 14px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #cb6701;
            text-align: center;
            margin: 0 0 15px;
        }

        .sidebar ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .sidebar ul li {
            margin: 8px 0;
        }

        .sidebar ul li a {
            text-decoration: none;
            color: #fff;
            font-size: 16px;
            padding: 12px 14px;
            display: block;
            text-align: center;
            border-radius: 8px;
            border: 1px solid transparent;
            transition: background-color 0.3s, color 0.3s, border-color 0.3s;
        }

        .sidebar ul li a:hover {
            color: #ff8500;
            border-color: #cb6701;
        }

        .sidebar ul li a.active {
            background-color: #cb6701;
            color: #fff;
            border-color: #cb6701;
        }

        /* ----------Menu sections---------- */
        .menu-section {
            margin-left: 220px;
            padding: 20px 30px;
            margin-bottom: 20px;
            scroll-margin-top: 90px; /* keeps heading visible below the navbar */
        }

        .menu-section h3 {
            font-size: 26px;
            color: #ff8500;
            text-align: center;
            margin-bottom: 25px;
            text-shadow: 0 2px 6px rgba(0, 0, 0, 0.6);
        }

        .menu-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            justify-content: center;
        }

        .menu-item {
            text-align: center;
            width: 180px;
            padding: 15px 10px;
            background-color: rgba(0, 0, 0, 0.55);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 12px;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .menu-item:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 18px rgba(0, 0, 0, 0.4);
        }

        .menu-item img {
            width: 140px;
            height: 190px;
            border-radius: 0%;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s;
            background-color: transparent;
            padding: 0px;
        }

        .menu-item img:hover {
            transform: scale(1.05);
        }

        .menu-item h4 {
            font-size: 16px;
            margin: 12px 0 5px;
            color: white;
        }

        .quantity-control {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            margin-top: 10px;
        }

        .quantity-control button {
            background-color: #cb6701;
            color: #fff;
            border: none;
            width: 32px;
            height: 32px;
            cursor: pointer;
            font-size: 18px;
            line-height: 1;
            border-radius: 6px;
            transition: background-color 0.3s;
        }

        .quantity-control button:hover {
            background-color: #ff8500;
        }

        .quantity-control input {
            width: 36px;
            height: 30px;
            text-align: center;
            border: 1px solid #ddd;
            font-size: 16px;
            border-radius: 6px;
            box-sizing: border-box;
        }

        /* ----------Footer---------- */
        footer {
            margin-left: 220px;
            padding: 20px;
            text-align: center;
            border-top: 1px solid #333;
            background-color: black;
            color: #fff;
        }

        footer p {
            margin: 0;
            color: #fff;
        }

        footer a {
            color: #fff;
            text-decoration: none;
            transition: color 0.3s;
        }

        footer a:hover {
            color: #ff8500;
        }

        /* ----------Navbar---------- */
        .navbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: rgba(0, 0, 0, 0.85);
            padding: 20px 60px;
            height: 80px;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            box-sizing: border-box;
        }

        .menu-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            margin: 0 10px;
            font-size: 16px;
            font-weight: bold;
            transition: color 0.3s;
        }

        .navbar a:hover {
            color: #cb6701;
        }

        .navbar img[alt="Logo"] {
            width: 150px;
            height: auto;
        }

        .menu-right {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .menu-right a {
            margin: 0;
            display: flex;
        }

        .search-container {
            display: flex;
            align-items: center;
        }

        .search-logo {
            width: 30px;
            height: 30px;
            margin-right: 10px;
        }

        .search-bar {
            border: 2px solid white;
            border-radius: 20px;
            padding: 5px 10px;
            width: 200px;
            background-color: transparent;
            color: white;
            outline: none;
        }

        .search-bar:focus {
            border-color: #cb6701;
        }

        .profile-logo, .cart-logo {
            width: 30px;
            height: 30px;
            cursor: pointer;
        }

        /* ----------Cart icon, bubble and dropdown---------- */
        .cart-container {
            position: relative;
            cursor: pointer;
            display: flex;
            align-items: center;
            padding: 10px 0; /* bigger hover area around the icon */
        }

        .cart-bubble {
            position: absolute;
            top: 0;
            right: -8px;
            min-width: 18px;
            height: 18px;
            box-sizing: border-box;
            background-color: #ff8500;
            color: white;
            font-size: 11px;
            font-weight: bold;
            padding: 0 5px;
            border-radius: 9px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .cart-bubble:empty {
            display: none;
        }

        .cart-dropdown {
            position: absolute;
            top: 100%;
            right: 0;
            width: 320px;
            background-color: white;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
            border-radius: 10px;
            display: none; /* Initially hidden */
            flex-direction: column;
            padding: 15px;
            z-index: 1001;
            max-height: 400px;
            overflow-y: auto;
            cursor: default;
            box-sizing: border-box;
        }

        /* Invisible bridge so the dropdown doesn't close while the mouse
           travels from the cart icon down to the dropdown */
        .cart-dropdown::before {
            content: "";
            position: absolute;
            top: -20px;
            left: 0;
            right: 0;
            height: 20px;
        }

        .cart-dropdown.active,
        .cart-container:hover .cart-dropdown {
            display: flex;
        }

        .cart-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }

        .cart-item img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 6px;
            flex-shrink: 0;
        }

        .cart-item h4 {
            margin: 0;
            font-size: 14px;
            color: #333;
            flex: 1;
        }

        .cart-item span {
            font-size: 13px;
            font-weight: bold;
            color: #cb6701;
            white-space: nowrap;
        }

        .cart-item button {
            background-color: #cb6701;
            color: #fff;
            border: none;
            width: 24px;
            height: 24px;
            border-radius: 5px;
            cursor: pointer;
            flex-shrink: 0;
        }

        .cart-item button:hover {
            background-color: #ff8500;
        }

        .cart-empty {
            text-align: center;
            color: #666;
            font-style: italic;
            padding: 10px 0;
        }

        .cart-dropdown-footer {
            margin-top: 15px;
            text-align: center;
        }

        .cart-dropdown-footer button {
            width: 100%;
            background-color: #cb6701;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .cart-dropdown-footer button:hover {
            background-color: #ff8500;
        }

        /* ----------Small screens---------- */
        @media (max-width: 800px) {
            .navbar {
                padding: 20px 15px;
            }

            .navbar a {
                margin: 0 4px;
                font-size: 13px;
            }

            .navbar img[alt="Logo"],
            .search-bar,
            .search-container {
                display: none;
            }

            .sidebar {
                width: 100%;
                height: auto;
                top: 80px;
                padding: 8px;
                border-right: none;
            }

            .sidebar ul {
                display: flex;
                justify-content: center;
                flex-wrap: wrap;
                gap: 6px;
            }

            .sidebar ul li {
                margin: 0;
            }

            .sidebar ul li a {
                padding: 8px 10px;
                font-size: 14px;
            }

            .menu-section {
                margin-left: 0;
                padding: 20px 15px;
                scroll-margin-top: 140px;
            }

            .menu-section:first-of-type {
                margin-top: 60px;
            }

            footer {
                margin-left: 0;
            }
        }
    </style>


<!-- Cart Items Section -->
<script>
// Highlight the sidebar link of the section currently in view
function highlightSidebar() {
    const sections = document.querySelectorAll('.menu-section');
    const links = document.querySelectorAll('.sidebar a');

    let currentSection = '';

    sections.forEach((section) => {
        const rect = section.getBoundingClientRect();
        if (rect.top <= window.innerHeight / 2 && rect.bottom >= window.innerHeight / 2) {
            currentSection = section.id;
        }
    });

    links.forEach((link) => {
        if (link.getAttribute('href').substring(1) === currentSection) {
            link.classList.add('active');
        } else {
            link.classList.remove('active');
        }
    });
}

// Add event listener to detect scrolling and update the sidebar
window.addEventListener('scroll', highlightSidebar);

// Initialize once the page has loaded
document.addEventListener('DOMContentLoaded', highlightSidebar);

let cartItems = [];

function updateCartSession(cartItems) {
    // Send cart items to server via AJAX
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'update_cart.php', true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Success
        }
    };
    xhr.send(JSON.stringify({ cartItems: cartItems }));
}

// Save cart items to localStorage
function saveCartToLocalStorage() {
    localStorage.setItem('cartItems', JSON.stringify(cartItems));
}

// Update the cart bubble to reflect the total quantity
function updateCartBubble() {
    const cartBubble = document.getElementById('cart-bubble');
    const totalQuantity = cartItems.reduce((total, item) => total + item.quantity, 0);

    cartBubble.textContent = totalQuantity > 0 ? totalQuantity : '';
    cartBubble.style.display = totalQuantity > 0 ? 'flex' : 'none';

    // Save cart to localStorage after every update
    saveCartToLocalStorage();
}

// Update cart item quantity when interacting in the cart
function updateCartItemQuantity(itemName, change) {
    const existingItem = cartItems.find(item => item.name === itemName);
    if (existingItem) {
        existingItem.quantity += change;
        if (existingItem.quantity <= 0) {
            cartItems = cartItems.filter(item => item.name !== itemName); // Remove if quantity is 0
        }

        // Reflect changes in the menu's input field
        const menuInput = document.getElementById(`qty${itemName}`);
        if (menuInput) {
            menuInput.value = existingItem.quantity > 0 ? existingItem.quantity : 0;
        }

        updateCartBubble();
        renderCartItems();
    }
}

// This function allows updating the menu's quantity controls
function updateMenuQuantity(itemName, quantity) {
    const inputField = document.getElementById(`qty${itemName}`);
    if (inputField) {
        inputField.value = quantity;
    }
}

// Render the cart items in the dropdown
function renderCartItems() {
    const cartItemsContainer = document.getElementById('cart-items');
    cartItemsContainer.innerHTML = ''; // Clear existing items

    if (cartItems.length === 0) {
        document.getElementById('cart-empty').style.display = 'block';
    } else {
        document.getElementById('cart-empty').style.display = 'none';
        cartItems.forEach(item => {
            const cartItemElement = document.createElement('div');
            cartItemElement.classList.add('cart-item');
            cartItemElement.innerHTML = `
                <img src="${item.image}" alt="${item.name}" style="width: 50px; height: 50px;">
                <h4>${item.name} (x${item.quantity})</h4>
                <span>P${item.price * item.quantity}</span>
                <button onclick="decreaseCartItemQuantity('${item.name}')">-</button>
                <button onclick="increaseCartItemQuantity('${item.name}')">+</button>
            `;
            cartItemsContainer.appendChild(cartItemElement);
        });
    }
}

// Add or update items in the cart
function addOrUpdateCartItem(itemName, itemPrice, quantity, itemImage) {
    // Check if the item already exists in the cart
    const existingItem = cartItems.find(item => item.name === itemName);

    if (existingItem) {
        // Update the existing item quantity
        existingItem.quantity = quantity;
        // If quantity is 0, remove the item
        if (existingItem.quantity === 0) {
            cartItems = cartItems.filter(item => item.name !== itemName);
        }
    } else if (quantity > 0) {
        // If item doesn't exist in the cart, add it
        cartItems.push({ name: itemName, price: itemPrice, quantity: quantity, image: itemImage });
    }

    updateCartBubble();
    renderCartItems();
}

// Increase quantity in menu and update cart
function increaseQuantity(inputId, itemName, itemPrice, itemImage) {
    const quantityInput = document.getElementById(inputId);
    let currentQuantity = parseInt(quantityInput.value) || 0;
    currentQuantity++;
    quantityInput.value = currentQuantity;

    addOrUpdateCartItem(itemName, itemPrice, currentQuantity, itemImage); // Sync with cart
}

// Decrease quantity in menu and update cart
function decreaseQuantity(inputId, itemName, itemPrice, itemImage) {
    const quantityInput = document.getElementById(inputId);
    let currentQuantity = parseInt(quantityInput.value) || 0;
    if (currentQuantity > 0) {
        currentQuantity--;
        quantityInput.value = currentQuantity;

        addOrUpdateCartItem(itemName, itemPrice, currentQuantity, itemImage); // Sync with cart
    }
}

// Cart dropdown open/close (hover is also handled in CSS)
function toggleCartDropdown() {
    document.getElementById('cart-dropdown').classList.add('active');
}

function closeCartDropdown() {
    document.getElementById('cart-dropdown').classList.remove('active');
}
</script>

</head>
<body>


<!-- Sidebar Section -->
<aside class="sidebar">
    <ul>
        <li><a href="#hot-coffee" id="link-hot-coffee">Hot Coffee</a></li>
        <li><a href="#iced-coffee" id="link-iced-coffee">Iced Coffee</a></li>
        <li><a href="#non-coffee" id="link-non-coffee">Non-Coffee</a></li>
        <li><a href="#oat-series" id="link-oat-series">Oat Series</a></li>
    </ul>
</aside>


<!-- Navbar Section -->
<div class="navbar">
    <div class="menu-left">
        <?php foreach ($menuItems as $item => $link): ?>
            <a href="<?php echo $link; ?>"><?php echo $item; ?></a>
        <?php endforeach; ?>
    </div>
    <img src="<?php echo $logoSrc; ?>" alt="Logo">
    <div class="menu-right">
        <div class="search-container">
            <img src="<?php echo $searchLogoSrc; ?>" alt="Search" class="search-logo">
            <input type="text" placeholder="<?php echo $searchPlaceholder; ?>" class="search-bar">
        </div>

        <!-- Profile logo as a button that links to profile.php -->
        <a href="profile.php">
            <img src="<?php echo $profileLogoSrc; ?>" alt="Profile" class="profile-logo">
        </a>

        <div class="cart-container" onmouseover="toggleCartDropdown()" onmouseleave="closeCartDropdown()">
            <img src="<?php echo $cartLogoSrc; ?>" class="cart-logo" alt="Cart Logo">
            <div id="cart-bubble" class="cart-bubble"></div>
            <div id="cart-dropdown" class="cart-dropdown">
                <div id="cart-items"></div>
                <div id="cart-empty" class="cart-empty">Your cart is empty.</div>
                <div class="cart-dropdown-footer">
                    <button onclick="window.location.href='orderpage.php'">View Cart</button>
                </div>
            </div>
        </div>
    </div>
</div>
<br>
<br>
<br>
<br>

<!------ Coffee Series Section ------>
<div class="menu-section" id="hot-coffee">
    <h3>Hot Coffee Series</h3>
    <div class="menu-grid">

        <div class="menu-item">
            <img src="americano.png" alt="Americano">
            <h4>Americano P80</h4>
            <div class="quantity-control">
                <button onclick="decreaseQuantity('qty1', 'Americano', 80, 'https://via.placeholder.com/100')">-</button>
                <input type="text" id="qty1" value="0" readonly>
                <button onclick="increaseQuantity('qty1', 'Americano', 80, 'https://via.placeholder.com/100')">+</button>
            </div>
        </div>
        <div class="menu-item">
            <img src="cafe latte.png" alt="Cafe Latte">
            <h4>Cafe Latte P90</h4>
            <div class="quantity-control">
                <button onclick="decreaseQuantity('qty2', 'Cafe Latte', 90, 'https://via.placeholder.com/100')">-</button>
                <input type="text" id="qty2" value="0" readonly>
                <button onclick="increaseQuantity('qty2', 'Cafe Latte', 90, 'https://via.placeholder.com/100')">+</button>
            </div>
        </div>
        <div class="menu-item">
            <img src="v-black.png" alt="V-Black">
            <h4>V-Black P110</h4>
            <div class="quantity-control">
                <button onclick="decreaseQuantity('qty3', 'V-Black', 110, 'https://via.placeholder.com/100')">-</button>
                <input type="text" id="qty3" value="0" readonly>
                <button onclick="increaseQuantity('qty3', 'V-Black', 110, 'https://via.placeholder.com/100')">+</button>
            </div>
        </div>

        <div class="menu-item">
            <img src="sea salt.png" alt="Sea Salt Latte">
            <h4>Sea Salt Latte P140</h4>
            <div class="quantity-control">
                <button onclick="decreaseQuantity('qty4', 'Sea Salt Latte', 140, 'https://via.placeholder.com/100')">-</button>
                <input type="text" id="qty4" value="0" readonly>
                <button onclick="increaseQuantity('qty4', 'Sea Salt Latte', 140, 'https://via.placeholder.com/100')">+</button>
            </div>
        </div>

        <div class="menu-item">
            <img src="caramel macchiato.png" alt="Caramel Macchiato">
            <h4>Caramel Macchiato P140</h4>
            <div class="quantity-control">
                <button onclick="decreaseQuantity('qty5', 'Caramel Macchiato', 140, 'https://via.placeholder.com/100')">-</button>
                <input type="text" id="qty5" value="0" readonly>
                <button onclick="increaseQuantity('qty5', 'Caramel Macchiato', 140, 'https://via.placeholder.com/100')">+</button>
            </div>
        </div>

        <div class="menu-item">
            <img src="spanish latte.png" alt="Spanish Latte">
            <h4>Spanish Latte P120</h4>
            <div class="quantity-control">
                <button onclick="decreaseQuantity('qty6', 'Spanish Latte', 120, 'https://via.placeholder.com/100')">-</button>
                <input type="text" id="qty6" value="0" readonly>
                <button onclick="increaseQuantity('qty6', 'Spanish Latte', 120, 'https://via.placeholder.com/100')">+</button>
            </div>
        </div>

        <div class="menu-item">
            <img src="white chocolate mocha.png" alt="White Chocolate Mocha">
            <h4>White Chocolate Mocha P140</h4>
            <div class="quantity-control">
                <button onclick="decreaseQuantity('qty7', 'White Chocolate Mocha', 140, 'https://via.placeholder.com/100')">-</button>
                <input type="text" id="qty7" value="0" readonly>
                <button onclick="increaseQuantity('qty7', 'White Chocolate Mocha', 140, 'https://via.placeholder.com/100')">+</button>
            </div>
        </div>

        <div class="menu-item">
            <img src="dark chocolate mocha.png" alt="Dark Chocolate Mocha">
            <h4>Dark Chocolate Mocha P140</h4>
            <div class="quantity-control">
                <button onclick="decreaseQuantity('qty8', 'Dark Chocolate Mocha', 140, 'https://via.placeholder.com/100')">-</button>
                <input type="text" id="qty8" value="0" readonly>
                <button onclick="increaseQuantity('qty8', 'Dark Chocolate Mocha', 140, 'https://via.placeholder.com/100')">+</button>
            </div>
        </div>

    </div>
</div>

<div class="menu-section" id="iced-coffee">
    <h3>Iced Coffee Series</h3>
    <div class="menu-grid">

        <div class="menu-item">
            <img src="americano.png" alt="Americano">
            <h4>Americano P80</h4>
            <div class="quantity-control">
                <button onclick="decreaseQuantity('qty9', 'Americano', 80, 'https://via.placeholder.com/100')">-</button>
                <input type="text" id="qty9" value="0" readonly>
                <button onclick="increaseQuantity('qty9', 'Americano', 80, 'https://via.placeholder.com/100')">+</button>
            </div>
        </div>

        <div class="menu-item">
            <img src="cafe latte.png" alt="Cafe Latte">
            <h4>Cafe Latte P90</h4>
            <div class="quantity-control">
                <button onclick="decreaseQuantity('qty10', 'Cafe Latte', 90, 'https://via.placeholder.com/100')">-</button>
                <input type="text" id="qty10" value="0" readonly>
                <button onclick="increaseQuantity('qty10', 'Cafe Latte', 90, 'https://via.placeholder.com/100')">+</button>
            </div>
        </div>

        <div class="menu-item">
            <img src="v-black.png" alt="V-Black">
            <h4>V-Black P110</h4>
            <div class="quantity-control">
                <button onclick="decreaseQuantity('qty11', 'V-Black', 110, 'https://via.placeholder.com/100')">-</button>
                <input type="text" id="qty11" value="0" readonly>
                <button onclick="increaseQuantity('qty11', 'V-Black', 110, 'https://via.placeholder.com/100')">+</button>
            </div>
        </div>

        <div class="menu-item">
            <img src="sea salt.png" alt="Sea Salt Latte">
            <h4>Sea Salt Latte P140</h4>
            <div class="quantity-control">
                <button onclick="decreaseQuantity('qty12', 'Sea Salt Latte', 140, 'https://via.placeholder.com/100')">-</button>
                <input type="text" id="qty12" value="0" readonly>
                <button onclick="increaseQuantity('qty12', 'Sea Salt Latte', 140, 'https://via.placeholder.com/100')">+</button>
            </div>
        </div>

        <div class="menu-item">
            <img src="caramel macchiato.png" alt="Caramel Macchiato">
            <h4>Caramel Macchiato P140</h4>
            <div class="quantity-control">
                <button onclick="decreaseQuantity('qty13', 'Caramel Macchiato', 140, 'https://via.placeholder.com/100')">-</button>
                <input type="text" id="qty13" value="0" readonly>
                <button onclick="increaseQuantity('qty13', 'Caramel Macchiato', 140, 'https://via.placeholder.com/100')">+</button>
            </div>
        </div>

        <div class="menu-item">
            <img src="spanish latte.png" alt="Spanish Latte">
            <h4>Spanish Latte P120</h4>
            <div class="quantity-control">
                <button onclick="decreaseQuantity('qty14', 'Spanish Latte', 120, 'https://via.placeholder.com/100')">-</button>
                <input type="text" id="qty14" value="0" readonly>
                <button onclick="increaseQuantity('qty14', 'Spanish Latte', 120, 'https://via.placeholder.com/100')">+</button>
            </div>
        </div>

        <div class="menu-item">
            <img src="white chocolate mocha.png" alt="White Chocolate Mocha">
            <h4>White Chocolate Mocha P140</h4>
            <div class="quantity-control">
                <button onclick="decreaseQuantity('qty15', 'White Chocolate Mocha', 140, 'https://via.placeholder.com/100')">-</button>
                <input type="text" id="qty15" value="0" readonly>
                <button onclick="increaseQuantity('qty15', 'White Chocolate Mocha', 140, 'https://via.placeholder.com/100')">+</button>
            </div>
        </div>

        <div class="menu-item">
            <img src="dark chocolate mocha.png" alt="Dark Chocolate Mocha">
            <h4>Dark Chocolate Mocha P140</h4>
            <div class="quantity-control">
                <button onclick="decreaseQuantity('qty16', 'Dark Chocolate Mocha', 140, 'https://via.placeholder.com/100')">-</button>
                <input type="text" id="qty16" value="0" readonly>
                <button onclick="increaseQuantity('qty16', 'Dark Chocolate Mocha', 140, 'https://via.placeholder.com/100')">+</button>
            </div>
        </div>

    </div>
</div>
<!------ Non-Coffee Section ------>
<div class="menu-section" id="non-coffee">
    <h3>Non-Coffee</h3>
    <div class="menu-grid">

        <div class="menu-item">
            <img src="iced tea.png" alt="Lemon Iced Tea">
            <h4>Lemon Iced Tea (P80)</h4>
            <div class="quantity-control">
                <button onclick="decreaseQuantity('qty17', 'Lemon Iced Tea', 80, 'https://via.placeholder.com/100')">-</button>
                <input type="text" id="qty17" value="0" readonly>
                <button onclick="increaseQuantity('qty17', 'Lemon Iced Tea', 80, 'https://via.placeholder.com/100')">+</button>
            </div>
        </div>

        <div class="menu-item">
            <img src="sea salt.png" alt="Sea Salt Cocoa">
            <h4>Sea Salt Cocoa P150</h4>
            <div class="quantity-control">
                <button onclick="decreaseQuantity('qty18', 'Sea Salt Cocoa', 150, 'https://via.placeholder.com/100')">-</button>
                <input type="text" id="qty18" value="0" readonly>
                <button onclick="increaseQuantity('qty18', 'Sea Salt Cocoa', 150, 'https://via.placeholder.com/100')">+</button>
            </div>
        </div>

        <div class="menu-item">
            <img src="sea salt matcha latte.png" alt="Sea Salt Matcha Latte">
            <h4>Sea Salt Matcha Latte P150</h4>
            <div class="quantity-control">
                <button onclick="decreaseQuantity('qty19', 'Sea Salt Matcha Latte', 150, 'https://via.placeholder.com/100')">-</button>
                <input type="text" id="qty19" value="0" readonly>
                <button onclick="increaseQuantity('qty19', 'Sea Salt Matcha Latte', 150, 'https://via.placeholder.com/100')">+</button>
            </div>
        </div>

        <div class="menu-item">
            <img src="strawberry cream yakult.png" alt="Strawberry Cream Yakult">
            <h4>Strawberry Cream Yakult P160</h4>
            <div class="quantity-control">
                <button onclick="decreaseQuantity('qty20', 'Strawberry Cream Yakult', 160, 'https://via.placeholder.com/100')">-</button>
                <input type="text" id="qty20" value="0" readonly>
                <button onclick="increaseQuantity('qty20', 'Strawberry Cream Yakult', 160, 'https://via.placeholder.com/100')">+</button>
            </div>
        </div>
    </div>
</div>



<!------ Oat Series Section ------>
<div class="menu-section" id="oat-series">
    <h3>Oat Series</h3>
    <div class="menu-grid">

        <div class="menu-item">
            <img src="oat latte.png" alt="Oat Latte">
            <h4>Oat Latte P120</h4>
            <div class="quantity-control">
                <button onclick="decreaseQuantity('qty21', 'Oat Latte', 120, 'https://via.placeholder.com/100')">-</button>
                <input type="text" id="qty21" value="0" readonly>
                <button onclick="increaseQuantity('qty21', 'Oat Latte', 120, 'https://via.placeholder.com/100')">+</button>
            </div>
        </div>

        <div class="menu-item">
            <img src="oat matcha latte.png" alt="Oat Matcha Latte">
            <h4>Oat Matcha Latte P150</h4>
            <div class="quantity-control">
                <button onclick="decreaseQuantity('qty22', 'Oat Matcha Latte', 150, 'https://via.placeholder.com/100')">-</button>
                <input type="text" id="qty22" value="0" readonly>
                <button onclick="increaseQuantity('qty22', 'Oat Matcha Latte', 150, 'https://via.placeholder.com/100')">+</button>
            </div>
        </div>

        <div class="menu-item">
            <img src="oat taro latte.png" alt="Oat Taro Latte">
            <h4>Oat Taro Latte P150</h4>
            <div class="quantity-control">
                <button onclick="decreaseQuantity('qty23', 'Oat Taro Latte', 150, 'https://via.placeholder.com/100')">-</button>
                <input type="text" id="qty23" value="0" readonly>
                <button onclick="increaseQuantity('qty23', 'Oat Taro Latte', 150, 'https://via.placeholder.com/100')">+</button>
            </div>
        </div>

        <div class="menu-item">
            <img src="muscovado oat latte.png" alt="Muscovado Oat Latte">
            <h4>Muscovado Oat Latte P150</h4>
            <div class="quantity-control">
                <button onclick="decreaseQuantity('qty24', 'Muscovado Oat Latte', 150, 'https://via.placeholder.com/100')">-</button>
                <input type="text" id="qty24" value="0" readonly>
                <button onclick="increaseQuantity('qty24', 'Muscovado Oat Latte', 150, 'https://via.placeholder.com/100')">+</button>
            </div>
        </div>

        <div class="menu-item">
            <img src="spanish latte.png" alt="Spanish Oat Latte">
            <h4>Spanish Oat Latte P150</h4>
            <div class="quantity-control">
                <button onclick="decreaseQuantity('qty25', 'Spanish Oat Latte', 150, 'https://via.placeholder.com/100')">-</button>
                <input type="text" id="qty25" value="0" readonly>
                <button onclick="increaseQuantity('qty25', 'Spanish Oat Latte', 150, 'https://via.placeholder.com/100')">+</button>
            </div>
        </div>


    </div>
</div>




<footer>
    <p>&copy; 2024 Houseblend N's Tea & Coffee Shop. All rights reserved.</p>
</footer>

</body>
</html>