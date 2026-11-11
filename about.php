<?php
// Define the background image and the slideshow images
$backgroundImage = "bg.jpg"; // Background for the whole page
$slideshowImages = [
    "aboutus/about1.jpg",
    "aboutus/about2.jpg",
    "aboutus/about3.jpg",
    "aboutus/about4.jpg"
];
$orangeColor = "#FFA500"; // Your orange color code
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <style>
        /* Full-page background */
        body {
            margin: 0;
            padding: 0;
            background: url('<?php echo $backgroundImage; ?>') no-repeat center center fixed;
            background-size: cover;
            font-family: Arial, sans-serif;
        }

        /* Title */
        .aboutus-title {
            color: <?php echo $orangeColor; ?>;
            font-size: 48px;
            text-align: center;
            padding: 20px;
            margin: 0;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); /* Adding a shadow for better readability */
        }

        /* Slideshow container */
        .slideshow-container {
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            margin-top: 20px;
            width: 80%; /* Set width of slideshow */
            max-width: 900px;
            overflow: hidden;
            margin-left: auto;
            margin-right: auto; /* Center the slideshow */
        }

        .slideshow {
            display: flex;
            transition: transform 0.5s ease; /* Smooth transition between images */
        }

        /* Slide Images */
        .slide {
            width: 100%;
            height: auto;
            object-fit: cover;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.5); /* Shadow for each image */
        }

        /* Navigation buttons */
        .nav-button {
            background-color: <?php echo $orangeColor; ?>;
            border: none;
            color: white;
            padding: 20px;
            cursor: pointer;
            font-size: 24px;
            border-radius: 50%;
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            z-index: 10;
            transition: background-color 0.3s ease;
            width: 50px; /* Set a fixed width */
            height: 50px; /* Set a fixed height */
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .nav-button:hover {
            background-color: darkorange;
        }

        .prev-button {
            left: 10px;
        }

        .next-button {
            right: 10px;
        }

        /* Dot navigation */
        .dots {
            text-align: center;
            margin-top: 10px;
        }

        .dot {
            height: 10px;
            width: 10px;
            margin: 0 5px;
            background-color: #bbb;
            border-radius: 50%;
            display: inline-block;
            transition: background-color 0.3s ease;
            cursor: pointer;
        }

        .active-dot {
            background-color: <?php echo $orangeColor; ?>;
        }

        /* ----------Navbar---------- */
        .navbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            opacity: 0.8;
            background-color: rgba(0, 0, 0, 0.8);
            padding: 20px 60px;
            height: 80px;
            position: fixed;
            top: 0;
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
        }

        .profile-logo {
            width: 30px;
            height: 30px;
            cursor: pointer;
        }

        /* Bold specific navbar items */
        .navbar a[href="homepage.php"],
        .navbar a[href="menupage.php"],
        .navbar a[href="about.php"],
        .navbar a[href="contacts.php"] {
            font-weight: bold;
        }
        /* ----------End of Navbar---------- */
        
    </style>
</head>
<body>
    <!-- "About Us" Title -->
     <br>
     <br>
     <br>
     <br>
    <h1 class="aboutus-title">About Us</h1>

    <!-- Slideshow Section -->
    <div class="slideshow-container">
        <button class="nav-button prev-button" onclick="changeSlide(-1)">&#10094;</button>
        <div class="slideshow">
            <?php foreach ($slideshowImages as $index => $image): ?>
                <img src="<?php echo $image; ?>" alt="About Us Image <?php echo $index + 1; ?>" class="slide">
            <?php endforeach; ?>
        </div>
        <button class="nav-button next-button" onclick="changeSlide(1)">&#10095;</button>
    </div>

    <!-- Dot Navigation -->
    <div class="dots">
        <?php foreach ($slideshowImages as $index => $image): ?>
            <span class="dot" onclick="currentSlide(<?php echo $index; ?>)"></span>
        <?php endforeach; ?>
    </div>

    <script>
        let currentSlideIndex = 0;
        const slides = document.querySelectorAll(".slide");
        const dots = document.querySelectorAll(".dot");

        function updateSlides() {
            // Move the slideshow container to the left to show the current image
            const offset = -currentSlideIndex * 100;
            document.querySelector(".slideshow").style.transform = `translateX(${offset}%)`;

            // Update dot navigation
            dots.forEach((dot, index) => {
                dot.classList.remove("active-dot");
                if (index === currentSlideIndex) {
                    dot.classList.add("active-dot");
                }
            });
        }

        function changeSlide(direction) {
            currentSlideIndex = (currentSlideIndex + direction + slides.length) % slides.length;
            updateSlides();
        }

        function currentSlide(index) {
            currentSlideIndex = index;
            updateSlides();
        }

        // Initial update to set up the slides
        updateSlides();
    </script>

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
        
    </div>
</div>




</body>
</html>
