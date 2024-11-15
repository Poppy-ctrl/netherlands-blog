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
    <title>About</title>
</head>

<body class=about-page"> 
    <header>
        <div class="logo">
            <h1 class="logo-text">Crocs & Clogs</h1> <!--name wrapped in span so the words can be formatted later-->
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

    <!-- About post -->
    <div class="content clearfix">
        <div class="main-content single-post">
            <h1 class="about-title">About Me</h1>
            <div class="post-content">
                <div class="about-me-image">
                    <img src="../Styling/About-page-photo.png" alt="about-me-image">
                </div>
                <div class="first-about-post-preview">
                    <p class="first-line">
                        Moving abroad is a fantasy many of us have entertained, even if only briefly after a great holiday.
                    </p>
                    <p class="preview-text">
                        Returning to the grind of your 9-5 back home 
                        (for me, that’s the UK) just seems dull in comparison to where you’ve been. Then there's that one acquaintance with the jealousy-inducing story of how they lived abroad and “found themselves”. But <strong>how</strong> do you actually move abroad? While many Brits consider Australia, what about our neighbor across the 
                        North Sea <i>the Netherlands</i> which feels just out of reach after Brexit? That’s where I come in.
                    </p>
                </div>
            </div>

            <div class="post-content-2">
                <div class="second-about-post-preview">
                    <p class="first-line">
                    Hi, I’m Poppy, a Brit who moved to the Netherlands in July 2024. I want to share everything I’ve learned as an expat here, to save you the research I had to do myself — and maybe help others affected by 
                    Brexit achieve their dream of moving abroad. 
                    </p>
                    <p class="preview-text">
                    My story starts during the Covid-19 lockdown with Discord (yes, slightly embarrassing). I had just graduated from university, ended a long-term relationship,
                    and felt isolated like so many of us did. I joined Discord to connect with people online, and a few months in, I met Jeroen (or "Jack," as he’s often called by non-Dutch speakers). We hit it off 
                    immediately. Talking to him felt natural and comfortable, and soon enough, I liked him. At the time, I told my best friend Lucy about Jack, but I wasn’t ready for a relationship. Besides, long-distance 
                    relationships—especially between countries—don’t work, right? But we had such a great time just chatting over video calls and texting all day (sorry to my first corporate job—I was texting my e-boyfriend 
                    in the lab instead of analysing samples). 
                    </p>
                </div>
                <div class="about-me-image-2">
                    <img src="../Styling/about-page-photo-2.png" alt="about-me-image">
                </div>
            </div>
            <div class="third-about-post-preview">
                <p class="preview-text">
                    After six months, Jeroen flew to the UK to meet me in person, and it felt like we had known each other for years. Since then, we’ve been dating long-distance, 
                    shuttling between the UK and the Netherlands, learning each other’s cultures, and growing together as a couple. After nearly three years, in 2024, I decided it was time to move to the Netherlands. The 
                    visa process was intense, and I found very little guidance available, so I had to navigate it on my own, which took a lot of time and money. But trust me—it was worth every bit of effort.
                </p>
                <p class="preview-text">
                        I’ve come to love the Netherlands and its people, and this blog is my way of sharing: 
                    </p>
                <div class="bullet-point-1">
                    <div class="bullet-stars">
                        <img src="../Styling/Poppy-Star.jpeg" alt="poppy-star-image">
                    </div>
                    <p class="preview-text">
                        My personal experiences and reflections
                    </p>
                </div>
                <div class="bullet-point-2">
                    <div class="bullet-stars">
                        <img src="../Styling/Jake-Star.jpeg" alt="poppy-star-image">
                    </div>
                    <p class="preview-text">
                        Practical advice to help others achieve the dream of moving abroad, especially post-Brexit
                    </p>
                </div>
                <p class="preview-text">
                    So, whether you're just curious about the Netherlands, interested in expat life, or wondering how you can make the move too, sign up for my newsletter and explore 
                    the different pages of my blog to find exactly what you’re looking for. And if you have any questions or topics you'd like me to cover, feel free to reach out via the contact information 
                    in the footer of every page.
                </p>
            </div>
            <div class="thanks">
                <div class="thanks-stars">
                        <img src="../Styling/Thanks-stars_01.png" alt="poppy-star-image">
                </div>
                <h2 class="thanks-for-visiting">Thanks for visiting!</h2>
                <div class="thanks-stars">
                        <img src="../Styling/Thanks-stars_02.png" alt="poppy-star-image">
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
                    <button name="submit-email" type="submit-email" class="btn-email-submit"><i class="fas fa-arrow-right"></i></button>
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

    <div class="footer-bottom">
        &copy; 2024 Crocs & Clogs. All rights reserved. Designed by Poppy and Jake Bennett
    </div>

    <!-- JQuery source code -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Custom script -->
    <script src="js/script.js"></script>

</body>
</html>