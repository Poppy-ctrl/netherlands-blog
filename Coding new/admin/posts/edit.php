<?php
include "../../logic.php";

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $draft = fetchDraftById($conn, $id);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/848e24f63c.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../../css/admin.css">
    <title>Edit Draft</title>
</head>

<body>

    <header>
        <div class="logo">
            <h1 class="logo-text">Crocs & Clogs</h1>
        </div>
        <ul class="nav">
            <li><a href="#" id="manage-posts-link">Manage Posts</a></li>
        </ul>
    </header>

    <div class="post-creation">
        <h2>Edit Post</h2>
        <div class="post-inputs">
            <form action="edit.php?id=<?php echo $draft['id']; ?>" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($draft['id']); ?>">
                <input type="hidden" name="current_image" value="<?php echo htmlspecialchars($draft['image']); ?>">
                <input type="text" id="post-title" name="title" class="text-input" placeholder="Title" value="<?php echo htmlspecialchars($draft['title']); ?>">
                
                <!-- Textarea for post content -->
                <textarea id="post" name="post" class="text-input" placeholder="Your Post"><?php echo htmlspecialchars($draft['post']); ?></textarea>

                <label for="categories">Choose a category:</label>
                <div class="categories">
                    <?php
                    $categoriesArray = explode(', ', $draft['categories']);
                    $allCategories = [
                        'my-life' => 'My Life',
                        'dutch-culture' => 'Dutch Culture',
                        'language' => 'Language',
                        'dutch-attractions' => 'Dutch Attractions',
                        'visa' => 'VISA',
                        'healthcare' => 'Healthcare',
                        'housing' => 'Housing',
                        'dutch-holidays' => 'Dutch Holidays',
                        'job-hunting' => 'Job Hunting',
                    ];

                    foreach ($allCategories as $key => $value) {
                        $checked = in_array($value, $categoriesArray) ? 'checked' : '';
                        echo "<input type='checkbox' id='$key' name='$key' value='$key' $checked>
                              <label for='$key'>$value</label><br>";
                    }
                    ?>
                </div>

                <label for="post-image">Current Image:</label>
                <?php if ($draft['image']): ?>
                    <div>
                        <img src="../../../Styling/Post_photos/<?php echo htmlspecialchars($draft['image']); ?>" alt="image" style="width:100px;height:auto;">
                    </div>
                <?php else: ?>
                    <p>No image uploaded.</p>
                <?php endif; ?>

                <label for="new-image">Upload New Image:</label>
                <input type="file" id="post-image" name="image" accept="image/*">

                <label for="url">Post URL:</label>
                <input type="url" id="url" name="url" class="text-input" placeholder="Optional URL" value="<?php echo htmlspecialchars($draft['url'] ?? ''); ?>">

                <button type="submit" class="btn btn-big" name="update-draft" >Update Draft</button>
            </form>
        </div>
    </div>

    <!-- Initialize TinyMCE on the 'post' textarea -->
    <script src="https://cdn.tiny.cloud/1/knman3bnv0js3pvnf1pahlq19whs3qav1ak39ip6tesseovx/tinymce/5/tinymce.min.js"></script>
    <script>
        tinymce.init({
            selector: '#post',  // Use the ID of the textarea you want to apply TinyMCE to
            plugins: 'paste',
            paste_as_text: true, // Strip unwanted formatting
            valid_elements: '*[*]',  // Allow all elements
            extended_valid_elements: 'p[class],strong/b,em,i', // Allow specific HTML elements
        });
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="../../js/script.js"></script>

</body>
</html>


