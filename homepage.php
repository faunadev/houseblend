<?php
session_start(); // Start the session to access session variables


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
$icedCoffeeSrc = "icedkopi.png";
$menuImages = [
    "bestsellers/Menu1.jpg",
    "bestsellers/Menu2.jpg",
    "bestsellers/Menu3.jpg",
    "bestsellers/Menu4.jpg",
    "bestsellers/Menu8.jpg",
    "bestsellers/Menu7.jpg",
    "bestsellers/Menu6.jpg",
    "bestsellers/Menu5.jpg"
];
?>


<!DOCTYPE html>
<html lang="en">
<head>


    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<!-- FontAwesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">


    <style>
        /* Body Styling */
        body {
            font-family: 'Poppins', sans-serif;
            background-image: url('bg.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            margin: 0;
            padding: 0;
            color: white;
        }


        /* ---------- Navbar ---------- */
        .navbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: rgba(0, 0, 0, 0.8);
            height: 80px;
            width: 100%;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            padding: 0 40px; /* Adjust padding for better spacing */
            box-sizing: border-box;
        }


        /* Align left and right sections properly */
        .menu-left, .menu-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }


        /* Navbar Links */
        .navbar a {
            color: white;
            text-decoration: none;
            font-size: 16px;
            padding: 8px 12px;
            line-height: 80px; /* Ensure vertical alignment */
        }

        .navbar button {
            font-weight: bold;
        }

        /* Button Hover Effect */
        .navbar a:hover {
            color: #cb6701;
        }

        /* Center Logo */
        .navbar img[alt="Logo"] {
            width: 120px; /* Adjust width */
            height: auto;
            display: block;
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            top: 50%;
            transform: translate(-50%, -50%);
        }


        /* Container for Search Logo and Search Bar */
        .search-container {
            display: flex;
            align-items: center;
        }


        /* Search Logo */
        .search-logo {
            width: 30px;
            height: 30px;
            margin-right: 10px;
        }


        /* Search Bar */
        .search-bar {
            border: 2px solid white;
            border-radius: 20px;
            padding: 5px 10px;
            width: 200px;
            background-color: transparent;
            color: white;
        }


        /* Profile Icon */
        .profile-logo {
            width: 30px;
            height: 30px;
        }


        /* Fix Navbar Pushing Content Down */
        body {
            margin: 0;
            padding: 0;
        }


        /* Ensure Content Starts Below Navbar */
        .content {
            padding-top: 80px; /* Matches navbar height */
        }




        /* Username display */
        .username-display {
            color: #cb6701;
            font-size: 16px;
            margin-right: 25px;
            font-weight: bold;
            text-transform: capitalize;
        }


        /* Styling for Login and Register buttons */
        .auth-btn {
            color: white;
            text-decoration: none;
            font-size: 16px;
            margin: 0 -5px;
            transition: color 0.3s;
        }


        /* Hover effect for Login/Register buttons */
        .auth-btn:hover {
            color: #cb6701;
        }

        /* Bold specific navbar items */
            .navbar a[href="homepage.php"],
            .navbar a[href="menupage.php"],
            .navbar a[href="about.php"],
            .navbar a[href="contacts.php"] {
                font-weight: bold;
            }


        /* ----------End of Navbar---------- */


        .content {
            margin-top: 100px;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px;
        }


        .content img {
            width: 45%;
            margin-right: 5px;
            object-fit: cover;
        }


        .content .text {
            width: 50%;
            padding-left: 40px;
            color: white;
        }


        h1 {
            color: #cb6701;
            font-size: 36px;
            font-style: italic;
            font-weight: bold;
            margin: 5px 0;
            line-height: 1.2;
        }


        p {
            margin: 5px 0;
            line-height: 1.5;
        }


        .shop-now {
            background-color: #cb6701;
            color: black;
            padding: 12px 25px;
            text-align: center;
            display: inline-block;
            border-radius: 5px;
            font-size: 16px;
            text-decoration: none;
            cursor: pointer;
            margin-top: 20px;
        }


        .shop-now:hover {
            background-color: #ff7f00;
        }


        .best-sellers {
            text-align: center;
            margin: 50px 0;
        }


        .best-sellers h2 {
            color: #cb6701;
            font-size: 32px;
            margin-bottom: 20px;
        }


        .menu-items {
            display: flex;
            justify-content: center;
            position: relative;
            flex-wrap: wrap;
            gap: 20px; /* Space between items */
        }


        .menu-item {
            position: relative;
            width: 300px;
            margin: 10px;
            border-radius: 15px;
            overflow: hidden;
            cursor: pointer;
            transition: transform 0.3s ease;
        }


        .menu-item:hover {
            transform: scale(1.05);
        }


        /* Image Styling */
        .menu-item img {
            max-width: 100%;
            height: auto;
            border-radius: 15px;
            object-fit: cover;
        }


        /* Description Styling */
        .menu-text {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent black */
            color: white;
            text-align: center;
            padding: 10px;
            display: none; /* Initially hidden */
            font-size: 14px;
            border-radius: 0 0 15px 15px;
        }


        /* Show the description when the image is hovered */
        .menu-item:hover .menu-text {
            display: block;
        }


        .menu-item {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }


        .menu-item:hover {
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.4); /* Slightly bigger shadow on hover */
        }


/* Fullscreen Splash Screen */


#splash-screen {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100vh;
    background: #BF7C2C; /* Coffee color */
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
    opacity: 1; /* Ensure full opacity */
    transition: opacity 2s ease-out; /* Fade-out transition */
}




/* Coffee Loader Animation */
@keyframes wave {
    0% { opacity: 0; transform: translateY(15px); }
    50% { opacity: 1; transform: translateY(0); }
    100% { opacity: 0; transform: translateY(-15px); }
}


.loader ul {
    margin: 0 0 10px 0;
    padding: 0;
    list-style: none;
    width: 60px;
    text-align: center;
    animation: wave 2.5s infinite linear;
}


.loader li {
    display: inline-block;
    background: #FAF1D9;
    height: 30px;
    width: 9px;
    border-radius: 0 100%;
    transform: rotate(12deg);
}


.cup {
    background: #F2E3B4;
    width: 60px;
    height: 54px;
    border-radius: 0 0 50% 50%;
    position: relative;
}


.cup:before {
    content: "";
    position: absolute;
    width: 66px;
    height: 20px;
    border-radius: 50%;
    background: inherit;
    left: -3px;
    top: -10px;
}


.cup:after {
    content: "";
    position: absolute;
    width: 56px;
    height: 12px;
    border-radius: 50%;
    background: #3A2F28;
    left: 2px;
    top: -6px;
}


.loader span {
    background: #F2E3B4;
    width: 13px;
    height: 20px;
    position: absolute;
    right: -13px;
    top: 10px;
    border-radius: 0 50% 50% 0;
}


.loader span:before {
    content: "";
    position: absolute;
    top: 4px;
    left: 0;
    background: #BF7C2C;
    width: 10px;
    height: 12px;
    border-radius: 0 50% 50% 0;
}


.loader span:after {
    content: "";
    position: absolute;
    top: 40px;
    left: -50px;
    background: #F2E3B4;
    width: 40px;
    height: 8px;
    border-radius: 50%;
}

/* ---------- Footer Styling ---------- */
.footer-section {
  background: #151414;
  padding: 60px 0;
  color: white;
  font-family: 'Poppins', sans-serif;
}


.footer-cta {
  display: flex;
  justify-content: space-between;
  text-align: left;
  border-bottom: 1px solid #373636;
  padding-bottom: 20px;
}


.single-cta {
  display: flex;
  align-items: center;
  gap: 15px;
}


.single-cta i {
  font-size: 30px;
  color: #ff5e14;
}


.footer-content {
  display: flex;
  justify-content: space-between;
  flex-wrap: wrap;
  padding-top: 30px;
}


.footer-widget {
  width: 23%;
  text-align: left;
}


.footer-logo img {
  max-width: 150px;
}


.footer-widget h3 {
  color: white;
  font-weight: bold;
  margin-bottom: 15px;
  border-bottom: 2px solid #ff5e14;
  display: inline-block;
  padding-bottom: 5px;
}


.footer-widget ul {
  list-style: none;
  padding: 0;
}


.footer-widget ul li a {
  color: #bbbbbb;
  text-decoration: none;
  transition: 0.3s;
}


.footer-widget ul li a:hover {
  color: #ff5e14;
}


.footer-social-icon {
  display: flex;
  gap: 10px;
  margin-top: 10px;
}


.footer-social-icon a {
  width: 40px;
  height: 40px;
  background: transparent;
  display: flex;
  justify-content: center;
  align-items: center;
  border-radius: 50%;
  border: 1px solid #ff5e14;
  color: white;
  transition: 0.3s;
}


.footer-social-icon a:hover {
  background: #ff5e14;
}


.subscribe-form {
  display: flex;
  margin-top: 10px;
}


.subscribe-form input {
  width: 70%;
  padding: 10px;
  background: #333;
  border: none;
  color: white;
  outline: none;
}


.subscribe-form button {
  background: #ff5e14;
  padding: 10px 15px;
  border: none;
  color: white;
  cursor: pointer;
}


.copyright-text {
  text-align: center;
  padding: 15px 0;
  color: #bbbbbb;
}




    </style>
</head>


<body>


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

        
<!-- Splash Screen Loader -->
<div id="splash-screen">
    <div class="loader">
        <ul>
            <li></li>
            <li></li>
            <li></li>
        </ul>
        <div class="cup"><span></span></div>
    </div>
</div>




<script>
document.addEventListener("DOMContentLoaded", function () {
    console.log("Splash screen loaded...");


    let splashScreen = document.getElementById("splash-screen");


    setTimeout(() => {
        splashScreen.style.transition = "opacity 2s ease-out"; // Smooth fade-out
        splashScreen.style.opacity = "0";


        setTimeout(() => {
            splashScreen.style.display = "none"; // Hide it completely after fade
        }, 2000);
       
    }, 4000); // Loader fully visible for 4 seconds
});


</script>

        <!-- Display the username beside the profile logo -->
        <?php if (isset($_SESSION['username'])): ?>
            <span class="username-display"><?php echo htmlspecialchars($_SESSION['username']); ?></span>
       
            <!-- Show Login and Register buttons if the user is not logged in -->
            <a href="logout.php" class="logout-btn">Logout</a>
        <?php else: ?>
            <a href="login.php" class="auth-btn">Login</a>
            <a href="register.php" class="auth-btn">Register</a>
        <?php endif; ?>
    </div>
</div>









<!----------First Page---------->
    <div class="content">
        <img src="<?php echo $icedCoffeeSrc; ?>" alt="Iced Coffee">
        <div class="text">
            <h1>HOUSEBLEND N's TEA</h1>
            <h1>& COFFEE SHOP</h1>
            <br></br>
            <p>Welcome to Houseblend N's Tea & Coffee Shop,</p>
            <p>where we serve the finest selection of handcrafted</p>
            <p>beverages to awaken your senses. From iced coffee to</p>
            <p>refreshing teas, experience the perfect blend of flavors</p>
            <p>that will leave you wanting more. Join us for a</p>
            <p>relaxing time and discover your new favorite drink!</p>
            <a href="menupage.php" class="shop-now">ORDER NOW</a>
        </div>
    </div>


<!----------Best Seller Section---------->
    <div class="best-sellers">
        <h2>Best Sellers</h2>
        <div class="menu-items">
            <?php
            foreach ($menuImages as $index => $menuImage) {
                echo '<div class="menu-item">';
                echo '<img src="' . $menuImage . '" alt="Menu Item ' . ($index + 1) . '">';
                echo '<div class="menu-text">';
                $descriptions = [
                    "Lemon Iced Tea: A refreshing iced tea infused with a tangy lemon flavor, perfect for a cooling and revitalizing drink.",
                    "Sea Salt Latte: A creamy latte topped with a hint of sea salt, creating a balanced sweet and savory flavor profile.",
                    "Sea Salt Matcha Latte: A smooth matcha latte with a touch of sea salt, blending earthy matcha with a savory twist.",
                    "Spanish Latte: A rich, velvety latte made with espresso and sweetened condensed milk, offering a creamy and indulgent flavor.",
                    "Dark Chocolate Mocha: A decadent mocha made with rich dark chocolate and espresso, topped with steamed milk for a smooth and satisfying drink.",
                    "Cocoa Oat Latte: A comforting latte made with oat milk and cocoa, creating a creamy, dairy-free chocolate experience.",
                    "Muscovado Oat Latte: A sweet and robust oat milk latte sweetened with muscovado sugar, offering a rich, caramel-like flavor.",
                    "Spanish Oat Latte: A plant-based version of the classic Spanish latte, made with oat milk and sweetened with condensed milk for a creamy, delicious taste."
                ];
                echo $descriptions[$index];
                echo '</div>';
                echo '</div>';
            }
            ?>
        </div>
    </div>
    <br><br><br>
    <footer class="footer-section">
    <div class="container">
        <!-- Contact Info -->
        <div class="footer-cta">
            <div class="single-cta">
                <i class="fas fa-map-marker-alt"></i>
                <div>
                    <h4>Find us</h4>
                    <span>Daang Bakal Rd, Antipolo, 1870 Rizal</span>
                </div>
            </div>
            <div class="single-cta">
                <i class="fas fa-phone"></i>
                <div>
                    <h4>Call us</h4>
                    <span>9876543210</span>
                </div>
            </div>
            <div class="single-cta">
                <i class="far fa-envelope"></i>
                <div>
                    <h4>Mail us</h4>
                    <span>houseblend2020@gmail.com</span>
                </div>
            </div>
        </div>


        <!-- Footer Content -->
        <div class="footer-content">
            <div class="footer-widget">
                <div class="footer-logo">
                    <img src="https://i.ibb.co/QDy827D/ak-logo.png" alt="logo">
                </div>
                <p>Coffee and tea bring people together, creating moments of connection, laughter, and warmth.</p>


                <h3>Follow us</h3>
                <div class="footer-social-icon">
                    <a href="https://web.facebook.com/p/Houseblend-100067354791255/?_rdc=1&_rdr#" target="_blank">
                        <i class="fab fa-facebook-f"></i></a>
                    <a href="https://www.instagram.com/houseblendnstea/?hl=en" target="_blank">
                        <i class="fab fa-instagram"></i></a>
                    <a href="mailto:houseblend2020@gmail.com">
                        <i class="fab fa-google"></i></a>
                </div>
            </div>



<!-- Useful Links -->
<div class="footer-widget">
    <h3>Useful Links</h3>
    <ul>
        <li><a href="homepage.php">Home</a></li>
        <li><a href="about.php">About Us</a></li>
        <li><a href="contacts.php">Contacts</a></li>
        <li><a href="https://www.google.com/maps/place/Housblend+N's+Tea+%26+Coffee/@14.5972419,121.0836309,13z/data=!4m10!1m2!2m1!1shouse+blend+antipolo+!3m6!1s0x3397b932e5b78d0b:0xaf62d6c41a5a4353!8m2!3d14.5972419!4d121.1598486!15sChRob3VzZSBibGVuZCBhbnRpcG9sb1oWIhRob3VzZSBibGVuZCBhbnRpcG9sb5IBBGNhZmXgAQA!16s%2Fg%2F11vzs1zrm6?entry=ttu&g_ep=EgoyMDI1MDMxOS4yIKXMDSoASAFQAw%3D%3D" target="_blank">Our Location</a></li>
        <li><a href="contacts.php">Feedback</a></li>
    </ul>
</div>


            <div class="footer-widget">
                <ul>
                    <li><a href="#">About</a></li>
                    <li><a href="#">Portfolio</a></li>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Expert Team</a></li>
                    <li><a href="#">Latest News</a></li>
                </ul>
            </div>


            <!-- Subscribe Section -->
            <div class="footer-widget">
                <h3>Subscribe</h3>
                <p>Don’t miss to subscribe to our new feeds, kindly fill the form below.</p>
                <div class="subscribe-form">
                    <input type="text" placeholder="Email Address">
                    <button><i class="fab fa-telegram-plane"></i></button>
                </div>
            </div>
        </div>


        <!-- Copyright -->
        <div class="copyright-text">
            <p>Copyright &copy; 2025, All Rights Reserved.</p>
        </div>
    </div>
</footer>


</body>
</html>



