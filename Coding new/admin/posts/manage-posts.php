<?php

include "../../logic.php"; 

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Deleting drafts from the draftposts table
if (isset($_GET['id'], $_GET['action']) && $_GET['action'] === 'delete draft') {
    $id = intval($_GET['id']);
    $deleteQuery = "DELETE FROM draftposts WHERE id = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: manage-posts.php");
        exit();
    } else {
        echo "Error deleting draft: " . mysqli_error($conn);
    }
}

// Move drafts to published table on publish
if (isset($_GET['action'], $_GET['id']) && $_GET['action'] === 'publish') {
    $id = intval($_GET['id']);
    $draftQuery = "SELECT * FROM draftposts WHERE id = ?";
    $stmt = $conn->prepare($draftQuery);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $draftResult = $stmt->get_result();
    
    if ($draftResult) {
        $draft = $draftResult->fetch_assoc();

        $title = $draft['title'];
        $post = $draft['post'];
        $image = $draft['image'];
        $url = $draft['url'];
        $categories = $draft['categories'];

        $publishQuery = "INSERT INTO publishedposts (title, post, image, url, categories) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($publishQuery);
        $stmt->bind_param("sssss", $title, $post, $image, $url, $categories);

        if ($stmt->execute()) {
            $deleteQuery = "DELETE FROM draftposts WHERE id = ?";
            $stmt = $conn->prepare($deleteQuery);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            header("Location: manage-posts.php");
            exit();
        } else {
            echo "Error publishing draft: " . mysqli_error($conn);
        }
    }
}

// Deleting posts from the publishedposts table
if (isset($_GET['id'], $_GET['action']) && $_GET['action'] === 'delete post') {
    $id = intval($_GET['id']);
    $deleteQuery = "DELETE FROM publishedposts WHERE id = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        header("Location: manage-posts.php");
        exit();
    } else {
        echo "Error deleting post: " . mysqli_error($conn);
    }
}

// Fetch drafts and published posts
$draftsRows = fetchDraftPosts($conn);
$publishedRows = fetchPublishedPosts($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/848e24f63c.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../css/admin.css">
    <title>Admin</title>
</head>
<body class="admin-page">

    <header>
        <div class="logo">
            <h1 class="logo-text">Crocs & Clogs</h1>
        </div>
    </header>

    <div class="manage-page">
        <div class="post-options">
            <div class="options">
                <a href="create-post.php">Add Post</a>
            </div>
        </div>

        <div class="manage-posts">
            <h2 class="manage-posts-title">Manage Posts</h2>
            <h3 class="drafts-title">Manage Drafts</h3>
            <table>
                <thead>
                    <tr>
                        <th>Post</th>
                        <th>Title</th>
                        <th>Categories</th>
                        <th>Image</th>
                        <th>Link</th>
                        <th colspan="3">Actions</th>
                    </tr>
                </thead>
                <tbody id="drafts-list">
                    <?php echo $draftsRows; ?>
                </tbody>
            </table>

            <h3 class="published-posts-title">Manage Published Posts</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Post</th>
                            <th>Title</th>
                            <th>Categories</th>
                            <th>Image</th>
                            <th>Link</th>
                            <th colspan="1">Action</th>
                        </tr>
                    </thead>
                    <tbody id="published-posts-list">
                    <?php echo $publishedRows; ?>
                    </tbody>
                </table>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="../../js/script.js"></script>
</body>
</html>

