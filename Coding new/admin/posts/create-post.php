<?php
include "/../../logic.php"; 
?>

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
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900&display=swap" rel="stylesheet">
    
    <!-- Custom styling -->
    <link rel="stylesheet" href="../../css/admin.css">
    
    <!-- TinyMCE script -->
    <script src="https://cdn.tiny.cloud/1/knman3bnv0js3pvnf1pahlq19whs3qav1ak39ip6tesseovx/tinymce/5/tinymce.min.js"></script>
    <script>
    tinymce.init({
        selector: '#post',
        plugins: 'paste',
        valid_elements: '*[*]',
        extended_valid_elements: 'p[class],strong/b,em,i',
    });
    </script>

    
    <title>Create Post</title>
</head>

<body>
    <header>
        <div class="logo">
            <h1 class="logo-text">Crocs & Clogs</h1>
        </div>
        <!-- Page Tabs -->
        <ul class="nav">
            <li><a href="#" id="manage-posts-link">Manage Posts</a></li>
        </ul>
    </header>

    <!-- Creating Posts -->
    <div class="post-creation">
        <h2>New Post</h2>
        <div class="post-inputs">
            <form action="manage-posts.php" method="POST" enctype="multipart/form-data">
                <input type="text" id="post-title" name="title" class="text-input" placeholder="Title" required>
                
                <!-- TinyMCE editor -->
                <textarea id="post" name="post" class="text-input" placeholder="Your Post"></textarea>

                
                <label for="categories">Choose a category:</label>
                <div class="categories">
                    <input type="checkbox" id="my-life" name="categories[]" value="My Life">
                    <label for="my-life">My Life</label><br>
                    <input type="checkbox" id="dutch-culture" name="categories[]" value="Dutch Culture">
                    <label for="dutch-culture">Dutch Culture</label><br>
                    <input type="checkbox" id="language" name="categories[]" value="Language">
                    <label for="language">Language</label><br>
                    <input type="checkbox" id="dutch-attractions" name="categories[]" value="Dutch Attractions">
                    <label for="dutch-attractions">Dutch Attractions</label><br>
                    <input type="checkbox" id="visa" name="categories[]" value="VISA">
                    <label for="visa">VISA</label><br>
                    <input type="checkbox" id="healthcare" name="categories[]" value="Healthcare">
                    <label for="healthcare">Healthcare</label><br>
                    <input type="checkbox" id="housing" name="categories[]" value="Housing">
                    <label for="housing">Housing</label><br>
                    <input type="checkbox" id="dutch-holidays" name="categories[]" value="Dutch Holidays">
                    <label for="dutch-holidays">Dutch Holidays</label><br>
                    <input type="checkbox" id="job-hunting" name="categories[]" value="Job Hunting">
                    <label for="job-hunting">Job Hunting</label><br>
                </div>
                
                <label for="post-image">Upload Image:</label>
                <input type="file" id="post-image" name="image" accept="image/*">
                
                <label for="url">Enter a URL:</label>
                <input type="url" name="url" id="url" placeholder="Optional URL" pattern="https://.*" size="30">
                
                <button name="submit" type="submit" class="btn btn-big">Save to Drafts</button>
            </form>
        </div>
    </div>

    <!-- JQuery source code -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Custom script -->
    <script src="../../js/script.js"></script>
</body>
</html>

