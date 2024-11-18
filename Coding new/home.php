<?php
include "logic.php";

$newestpostRows = postingNewestPost($conn);
$recentpostsRows = postingRecentPosts($conn);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Font awesome link -->
    <script src="https://kit.fontawesome.com/848e24f63c.js" crossorigin="anonymous"></script>
    
    <!-- Google fonts roboto-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

    <!-- Google fonts eczar -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Eczar:wght@400..800&display=swap" rel="stylesheet">
    
    <!-- Custom styling -->
    <link rel="stylesheet" href="css/style.css">
    <title>Blog</title>
</head>

<body class="homepage"> 
    <header>
        <div class="logo">
            <h1 class="logo-text">Crocs & Clogs</h1> 
        </div>
        <!-- Page Tabs -->
        <i class="fa fa-bars menu-toggle"></i>
        <ul class="nav">
            <li><a href="#" id="home-link" >Home</a></li>
            <li><a href="#" id="about-link">About</a></li>
            <li><a href="#" id="all-posts-link">All Posts</a></li>
            <li><a href="#" id="resources-link">Resources</a></li>
        </ul>
    </header>

    <!-- Content Topics -->
    <div class="content clearfix">
        <div class="main-content">
            <div class="topics">
                <div class="topic-container">
                    <div class="topic-name">
                        <h2><a href="my-life.php">My Life</a></h2>
                    </div>
                    <div class="topic-name">
                        <h2><a href="job-hunting.php">Job hunting</a></h2>
                    </div>
                    <div class="topic-name">
                        <h2><a href="dutch-culture.php">Dutch Culture</a></h2>
                    </div>
                    <div class="topic-name">
                        <h2><a href="visa.php">VISA</a></h2>
                    </div>
                    <div class="topic-name">
                        <h2><a href="career-building.php">Career Building</a></h2>
                    </div>
                    <div class="topic-name">
                        <h2><a href="housing.php">Housing</a></h2>
                    </div>
                    <div class="topic-name">
                        <h2><a href="healthcare.php">Healthcare</a></h2>
                    </div>
                    <div class="topic-name">
                        <h2><a href="dutch-attractions.php">Dutch Attractions</a></h2>
                    </div>
                    <div class="topic-name">
                        <h2><a href="language.php">Language</a></h2>
                    </div>
                    <div class="topic-name">
                        <h2><a href="dutch-holidays.php">Dutch Holidays</a></h2>
                    </div>
                </div>
            </div>

            <div id="latest-post" class="latest-post">
                <div class="post">
                <?php echo $newestpostRows; ?>
                </div>
            </div>
            <!-- <button type="button" class="btn btn-latest">
                Latest Post!
                <i class='fa-solid fa-star'></i>
            </button> -->
            
            <h1 class="recent-posts-title">Recent Posts</h1>
            <div id="recent-posts-list" class="recent-posts-list">
            <?php echo $recentpostsRows; ?>
            </div>
            <div class="see-all-posts-button">
                <button type="button" class="btn" id="see-all-posts-button">
                    See all posts
                </button>
            </div>
    </div>

    <div class="newsletter">
        <div class="newsletter-content">
            <div class="newsletter-info">
                <h2>Get all my updates!</h2>
                <h3>Did you know I also have a newsletter? Sign up here to get notified about my latest posts straight to your email inbox as soon as they're uploaded!</h3>
            </div>
            <div class="newsletter-sign-up">
                <form id="email-input" class="email-input" method="POST">
                    <input type="text" id="email-address" name="email" class="text-input" placeholder="Your email">
                    <button name="submit-email" type="submit-email" class="btn-email-submit"><i class="fa-solid fa-heart"></i>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <div class="footer-content">
            <div class="footer-section-contact">
                <h2>Let's Chat!</h2>
                <h3>
                <p>
                    Got any questions or business enquiries for us? Reach out by email, or get connected on socials.
                </p>
                </h3>
            </div>
            <div class="contact-info">
                <div class="footer-section-contact-choices">
                    <div class="email">
                        <div class="name-star">
                            <img src="../Styling/Poppy-Star.jpeg" alt="poppy-star-image">
                        </div>
                        <h2>Poppy</h2>
                    </div>
                    <div class="socials-poppy">
                    <h2>crocsandclogsblog@gmail.com</h2>
                        <div class="instagram" data-url="https://www.instagram.com/poppaleeki?igsh=a2V1NTJla21rM3N6&utm_source=qr">
                            <i class="fa-brands fa-instagram"></i>
                        </div>
                        <div class="linkedin" data-url="https://www.linkedin.com/in/poppybennett?utm_source=share&utm_campaign=share_via&utm_content=profile&utm_medium=ios_app">
                            <i class="fa-brands fa-linkedin"></i>
                        </div>
                        <div class="github" data-url="https://github.com/Poppy-ctrl">
                            <i class="fa-brands fa-square-github"></i>
                        </div>
                    </div>
                    <h3>
                    <p>
                    This blog is my personal journey as a British native embracing life in the Netherlands. 
                    I had the pleasure of coding this website from scratch, while my talented brother, Jake, crafted its design.
                    </p>
                    </h3>
                    <br>
                </div>
                <div class="footer-section-contact-choices">
                    <div class="email">
                        <div class="name-star">
                            <img src="../Styling/Jake-Star.jpeg" alt="jake-star-image">
                        </div>
                        <h2>Jake</h2>
                    </div>
                    <div class="socials-jake">
                        <h2>bennett_jl@yahoo.com</h2>
                        <div class="website" data-url="https://www.jakebennett.co">
                            <i class="fa-regular fa-file-code"></i>
                        </div>
                        <div class="linkedin" data-url="https://www.linkedin.com/in/bennettjakr/">
                            <i class="fa-brands fa-linkedin"></i>
                        </div>
                    </div>
                    <h3>
                    <p>
                    I’m a graphic and motion designer and I love telling stories through visuals. 
                    This project was the perfect collaboration - combining my skills and Poppy’s brains - 
                    to craft a blog that captures her personality and Dutch adventures.
                    </p>
                    </h3>
                    <br>
                </div>
            </div>
        </div>
    </div>

    <div class="home-footer-bottom">
        &copy; 2024 Crocs & Clogs. All rights reserved. Designed by Poppy and Jake Bennett
    </div>

    <!-- JQuery source code -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Custom script -->
    <script src="js/script.js"></script>

</body>
</html>
