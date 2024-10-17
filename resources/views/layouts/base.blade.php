<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/frontend/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Shippori+Mincho&family=Work+Sans:wght@400;800&display=swap"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat+Alternates:wght@500&family=Roboto:wght@400;800&display=swap"
        rel="stylesheet">
</head>

<body>
    <nav>
        <div class="logo">
            <img src="assets/images/samaa-logo.png" alt="Logo">
        </div>
        <div class="menu-toggle" id="menuToggle">
            <div></div>
            <div></div>
            <div></div>
        </div>
        <div class="menu" id="menu">
            <button class="close-menu" id="closeMenu">×</button>
            <h2 class="menu-title">Menu</h2>
            <a href="/">Home</a>
            <a href="/about-us">About Us</a>
            <!--<a href="#">Library</a>
            <a href="#">Listen to Music</a>
            <a href="#">Patient List</a>
            <a href="#">Feedback</a>
            <a href="#">Schedule</a>
            <a href="#">Therapy</a>-->
            <a href="/contact-us">Contact Us</a>
            <!--<a href="#">Login</a>-->

            <div class="profile">
                <span>Doctor Youssef</span>
                <img src="assets/images/user.jfif" alt="Profile">
            </div>
        </div>
    </nav>

    @yield('content')

    <footer class="footer">
        <div class="footer-container">
            <div class="footer-logo">
                <img src="assets/images/samaa-logo.png" alt="Logo">
            </div>
            <div class="footer-links">
                <div class="column">
                    <a href="/">Home</a>
                    <a href="#">Therapy</a>
                    <a href="#">Register</a>
                </div>
                <div class="column">
                    <a href="/about-us">About Us</a>
                    <a href="/contact-us">Contact Us</a>
                </div>
                <div class="column">
                    <a href="#">Library</a>
                </div>
            </div>
            <div class="footer-help">
                <a href="#" class="help-btn">Help Center</a>
                <div class="social-icons">
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p><i class="fas fa-envelope"></i> Samaa@Gmail.Com</p>
        </div>
    </footer>

    <script src="{{ asset('assets/js/frontend/scripts.js') }}"></script>

</body>

</html>
