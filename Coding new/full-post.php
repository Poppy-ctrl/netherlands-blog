<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Font awesome link -->
    <script src="https://kit.fontawesome.com/848e24f63c.js" crossorigin="anonymous"></script>

    <!-- Google fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

    <!-- Custom styling -->
    <link rel="stylesheet" href="css/style.css">
    <title>Full Post</title>
</head>

<body class="full-post-page">
    <header>
        <div class="logo">
            <h1 class="logo-text">Crocs & Clogs</h1>
        </div>
        <!-- Page Tabs -->
        <i class="fa fa-bars menu-toggle"></i>
        <ul class="nav">
            <li><a href="#" id="home-link">Home</a></li>
            <li><a href="#" id="about-link">About</a></li>
            <li><a href="#" id="all-posts-link">All Posts</a></li>
            <li><a href="#" id="resources-link">Resources</a></li>
        </ul>
    </header>

    <div class="content clearfix">
    <div class="main-content" id="full-post-container">
        
        <?php
        include "logic.php";

        // Display Full Post
        $postId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $post = getFullPost($conn, $postId);
        if ($post) {
            $formattedDate = formatDate($post['created_at']); // Ensure this function exists
            echo "<div class='full-post'>
                    <div class='full-post-image'>
                        <img src='../Styling/" . htmlspecialchars($post['image']) . "' alt='" . htmlspecialchars($post['title']) . "'>
                    </div>
                    <div class='post-info'>
                        <h1>" . htmlspecialchars($post['title']) . "</h1>
                        <p class='post-date'>{$formattedDate}</p>
                        <div class='post-categories'>"
                            . formatCategories($post['categories']) .
                        "</div>
                        <div class='post-url'>";
                        if (!empty($post['url'])) {
                            echo "<a href='" . htmlspecialchars($post['url']) . "' target='_blank'>" . htmlspecialchars($post['url']) . "</a>";
                        } else {
                            echo ""; 
                        }
                        echo "</div>
                    </div> <!-- End of post-info -->
                </div>";
            echo "<div class='full-post-content'>
                    <p>" . htmlspecialchars($post['post']) . "</p>
                </div>";
            } else {
                echo "<p>Post not found.</p>";
            }
        ?>
    </div>
</div>




    <!-- Footer -->
    <div class="footer">
        <div class="footer-content">
            <div class="footer-section-contact">
                <h2>Let's Chat!</h2>
                <h3>
                <p>
                    This blog is my personal journey as a British native embracing life in the Netherlands. 
                    I had the pleasure of coding this website from scratch, while my talented brother, Jake, crafted its design.
                </p>
                <p>
                    Got any questions or business enquiries for us? Reach out by email, or get connected on socials.
                </p>
                </h3>
                <br>
            </div>
            <div class="footer-section-illustration">
                <img src="../Styling/IMG_8314.JPG" alt="swirl illustration">
            </div>
            <div class="contact-info">
                <div class="footer-section-contact-choices">
                    <div class="email">
                    <h2>Poppy</h2>
                    </div>
                    <div class="socials">
                        <div class="instagram">
                            <i class="fa-brands fa-instagram"></i>
                        </div>
                        <div class="linkedin">
                            <i class="fa-brands fa-linkedin"></i>
                        </div>
                        <div class="github">
                            <i class="fa-brands fa-square-github"></i>
                        </div>
                        <h2>crocsandclogsblog@gmail.com</h2>
                    </div>
                </div>
                <div class="footer-section-contact-choices">
                    <div class="email">
                        <h2>Jake</h2>
                    </div>
                    <div class="socials">
                        <div class="instagram">
                            <i class="fa-brands fa-instagram"></i>
                        </div>
                        <div class="linkedin">
                            <i class="fa-brands fa-linkedin"></i>
                        </div>
                        <h2>bennett_jl@yahoo.com</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="newsletter">
        <h2>Crocs & Clogs</h2>
        <h3>Did you know I also have a newsletter? Sign up here to get notified about my latest posts straight to your email inbox as soon as they're uploaded!</h3>
        <div class="newsletter-sign-up">
            <form id="email-input" class="email-input">
                <input type="text" id="email-address" name="email-address" class="text-input" placeholder="Your email">
                <button type="submit" class="btn-email-submit"><i class="fas fa-arrow-right"></i></button>
            </form>
        </div>
    </div>

    <div class="footer-bottom">
        &copy; 2024 Crocs & Clogs. All rights reserved. Designed by Poppy and Jake Bennett
    </div>

    <!-- JQuery source code -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Custom script -->
    <script src="js/script.js"></script>

</body>
</html>
