<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Connect to the database
$conn = mysqli_connect("localhost", "poppy", "123Elvis!", "CrocsAndClogsDatabase");

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Saving draft posts into SQL Table
if (isset($_POST["submit"])) {
    // Get the title and post content
    $title = $_POST["title"];
    $post = $_POST["post"];

    // Sanitize post content
    $post = mysqli_real_escape_string($conn, $post);
    $post = strip_tags($post, '<p><b><i><u><strong><em><ul><ol><li><a>');


    // Handle the image and URL inputs
    $image = $_FILES["image"]["name"];
    $url = isset($_POST["url"]) ? $_POST["url"] : null;

    // Get selected categories directly from $_POST['categories']
    $categories = isset($_POST['categories']) ? $_POST['categories'] : [];

    // If categories are selected, join them into a string
    if (!empty($categories)) {
        $categoriesString = implode(', ', $categories);
    } else {
        $categoriesString = ''; // If no categories are selected, leave empty
    }

    // Prepare and execute the SQL query
    $sql = "INSERT INTO draftposts (title, post, image, url, categories) VALUES ('$title', '$post', '$image', '$url', '$categoriesString')";
    
    if (mysqli_query($conn, $sql)) {
        echo "Draft saved successfully!";
    } else {
        echo "Error saving draft: " . mysqli_error($conn);
    }
}




//Fetching draft posts from MySQL and posting in manage-posts.php table
function fetchDraftPosts($conn) {
    $draftsQuery = "SELECT * FROM draftposts ORDER BY created_at DESC";
    $draftsResult = mysqli_query($conn, $draftsQuery);

    // Check for errors
    if (!$draftsResult) {
        return "Error fetching drafts: " . mysqli_error($conn);
    }

    $rows = '';
    while ($row = mysqli_fetch_assoc($draftsResult)) {
        $formattedDate = date("d-m-Y", strtotime($row['created_at']));
        $rows .= "<tr>
                    <td>{$formattedDate}</td>
                    <td>{$row['title']}</td>
                    <td>{$row['categories']}</td>
                    <td>{$row['image']}</td>
                    <td>";

        // Check if URL is present and not empty
        if (!empty($row['url'])) {
            $rows .= "<a href='" . htmlspecialchars($row['url']) . "'>View</a>";
        } else {
            $rows .= "";
        }

        $rows .= "</td>
                    <td><a href='edit.php?id={$row['id']}'>Edit</a></td>
                    <td><a href='manage-posts.php?id={$row['id']}&action=delete draft'>Delete</a></td>
                    <td><a href='manage-posts.php?id={$row['id']}&action=publish'>Publish</a></td>
                  </tr>";
    }
    return $rows;
}

// opening draft post for editing
function fetchDraftById($conn, $id) {
    $query = "SELECT * FROM draftposts WHERE id = $id";
    $result = mysqli_query($conn, $query);
    
    return mysqli_fetch_assoc($result);
}

//updating database with edited draft
if (isset($_POST["update-draft"])) {
    $id = $_POST["id"];
    $title = $_POST["title"];
    $post = mysqli_real_escape_string($conn, $_POST["post"]);  // Escape special characters in the post content
    $url = empty($_POST["url"]) ? null : $_POST["url"];
    
    // Collect selected categories into an array
    $categories = [];
    if (isset($_POST['my-life'])) { $categories[] = 'My Life'; }
    if (isset($_POST['dutch-culture'])) { $categories[] = 'Dutch Culture'; }
    if (isset($_POST['language'])) { $categories[] = 'Language'; }
    if (isset($_POST['dutch-attractions'])) { $categories[] = 'Dutch Attractions'; }
    if (isset($_POST['visa'])) { $categories[] = 'VISA'; }
    if (isset($_POST['healthcare'])) { $categories[] = 'Healthcare'; }
    if (isset($_POST['housing'])) { $categories[] = 'Housing'; }
    if (isset($_POST['dutch-holidays'])) { $categories[] = 'Dutch Holidays'; }
    if (isset($_POST['job-hunting'])) { $categories[] = 'Job Hunting'; }
    
    $categoriesString = implode(', ', $categories);

    $imageFileName = null;
    // Check if a new image is uploaded
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
        $targetDir = "../../../Styling/Post_photos/";
        $imageFileName = basename($_FILES["image"]["name"]);
        $targetFile = $targetDir . $imageFileName; 
    } else {
        // If no new image is uploaded, retain the old image name
        $currentDraft = fetchDraftById($conn, $id); 
        $imageFileName = $currentDraft['image'];
    }

    // Update query
    $sql = "UPDATE draftposts 
            SET title = '$title', post = '$post', image = '$imageFileName', url = '$url', categories = '$categoriesString' 
            WHERE id = $id";

    if (mysqli_query($conn, $sql)) {
        header("Location: manage-posts.php");
        exit();
    } else {
        echo "Error updating draft: " . mysqli_error($conn);
    }
}


//Fetching published posts from MySQL and posting in manage-posts.php table
function fetchPublishedPosts($conn) {
    $publishedQuery = "SELECT * FROM publishedposts ORDER BY created_at DESC";
    $publishedResult = mysqli_query($conn, $publishedQuery);

    // Check for errors
    if (!$publishedResult) {
        return "Error fetching published posts: " . mysqli_error($conn);
    }

    $rows = '';
    while ($row = mysqli_fetch_assoc($publishedResult)) {
        $formattedDate = date("d-m-Y", strtotime($row['created_at']));
        $rows .= "<tr>
                    <td>{$formattedDate}</td>
                    <td>{$row['title']}</td>
                    <td>{$row['categories']}</td>
                    <td>{$row['image']}</td>
                    <td>";

        // Check if URL is present and not empty
        if (!empty($row['url'])) {
            $rows .= "<a href='" . htmlspecialchars($row['url']) . "'>View</a>";
        } else {
            $rows .= "";
        }

        $rows .= "</td>
                    <td><a href='manage-posts.php?id={$row['id']}&action=delete post'>Delete</a></td>
                  </tr>";
    }
    return $rows;
}

function formatDate($dateString) {
    $date = new DateTime($dateString);
    $day = $date->format('j'); // Day of the month without leading zeros
    $month = $date->format('F'); // Full month name
    $year = $date->format('Y'); // Full year

    $suffix = getOrdinalSuffix($day);
    return "{$day}{$suffix} {$month} {$year}";
}

function getOrdinalSuffix($day) {
    if ($day >= 11 && $day <= 13) {
        return 'th'; // Special cases for 11th, 12th, 13th
    }
    switch ($day % 10) {
        case 1: return 'st';
        case 2: return 'nd';
        case 3: return 'rd';
        default: return 'th';
    }
}

function formatCategories($categoriesString) {
    $categoriesArray = explode(',', $categoriesString);
    $categoriesArray = array_slice($categoriesArray, 0, 3);
    $categoryBubbles = array_map(function($category) {
        return '<span class="category-bubble">' . htmlspecialchars(trim($category)) . '</span>';
    }, $categoriesArray);
    return implode(' ', $categoryBubbles);
}

// All published posts from table onto all posts page
function postingAllPosts($conn) {
    $allpostsQuery = "SELECT * FROM publishedposts ORDER BY created_at DESC";
    $allpostsResult = mysqli_query($conn, $allpostsQuery);

    // Check for errors
    if (!$allpostsResult) {
        return "Error fetching all published posts: " . mysqli_error($conn);
    }

    $rows = '';
    while ($row = mysqli_fetch_assoc($allpostsResult)) {
        $formattedDate = formatDate($row['created_at']);

        // Strip HTML tags from post content and truncate it
        $plainTextPreview = htmlspecialchars(substr(strip_tags($row['post']), 0, 150)) . "...";

        // Create a new post entry
        $rows .= "<div class='all-posts'>
                    <div class='post-preview'>
                        <div class='all-posts-info'>
                            <h2><a href='full-post.php?id={$row['id']}'>{$row['title']}</a></h2>
                            <p class='post-date'>{$formattedDate}</p>
                            <div class='post-categories'>" . formatCategories($row['categories']) . "</div>
                        </div>
                        <div class='all-posts-image'>
                            <img src='../Styling/Post_photos/" . htmlspecialchars($row['image']) . "' alt='" . htmlspecialchars($row['title']) . "'>
                        </div>
                    </div>";

        $rows .= "</div></div>";
    }
    return $rows;
}

// Load newest post into homepage
function postingNewestPost($conn) {
    $newestpostQuery = "SELECT id, title, post, categories, image, created_at FROM publishedposts ORDER BY ID DESC LIMIT 1";
    $newestpostResult = mysqli_query($conn, $newestpostQuery);

    // Check for errors
    if (!$newestpostResult) {
        return "Error fetching newest published posts: " . mysqli_error($conn);
    }

    $rows = '';
    while ($row = mysqli_fetch_assoc($newestpostResult)) {
        // Debug: Check if date is formatted correctly
        if (!function_exists('formatDate')) {
            return "Error: formatDate function is undefined.";
        }

        $formattedDate = formatDate($row['created_at']);

        // Strip HTML tags from post content and truncate it
        $plainTextPreview = htmlspecialchars(substr(strip_tags($row['post']), 0, 150)) . "...";

        // Create a new post entry with the same structure and class names as in your JS
        $rows .= "<div class='post'>
                    <div class='post-preview'>
                        <div class='post-details'>
                            <h2><a href='full-post.php?id={$row['id']}'>{$row['title']}</a></h2>
                            <p class='preview-text'>{$plainTextPreview}</p>
                            <p class='post-date'>{$formattedDate}</p>
                        </div>
                        <div class='post-image'>
                            <img src='../Styling/Post_photos/" . htmlspecialchars($row['image']) . "' alt='" . htmlspecialchars($row['title']) . "'>
                        </div>
                    </div>
                </div>";
    }
    return $rows;
}



// Load 3 most recent posts into homepage
function postingRecentPosts($conn) {
    $recentpostsQuery = "SELECT id, title, image, created_at FROM publishedposts ORDER BY ID DESC LIMIT 3 OFFSET 1";
    $recentpostsResult = mysqli_query($conn, $recentpostsQuery);

    // Check for errors
    if (!$recentpostsResult) {
        return "Error fetching newest published posts: " . mysqli_error($conn);
    }

    $rows = '';
    while ($row = mysqli_fetch_assoc($recentpostsResult)) {
        $formattedDate = formatDate($row['created_at']);
        $rows .= "<div class='post'>
                    <div class='post-preview'>
                        <div class='recent-post-image'>
                            <img src='../Styling/Post_photos/" . htmlspecialchars($row['image']) . "' alt='" . htmlspecialchars($row['title']) . "'>
                        </div>
                        <div class='recent-post-details'>
                            <p class='post-date'>{$formattedDate}</p>
                            <h2><a href='full-post.php?id={$row['id']}'>{$row['title']}</a></h2>
                        </div>
                    </div>
                </div>";
    }
    return $rows;
}

function getFullPost($conn, $id) {
    $query = "SELECT * FROM publishedposts WHERE id = {$id}";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        return "Error fetching post: " . mysqli_error($conn);
    }

    return mysqli_fetch_assoc($result); 
}

// Function to get posts by category
function getPostsByCategory($conn, $category) {
    $query = "SELECT * FROM publishedposts WHERE categories LIKE ? ORDER BY created_at DESC";
    
    $stmt = mysqli_prepare($conn, $query);
    $param = '%' . $category . '%';
    mysqli_stmt_bind_param($stmt, 's', $param);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Check for errors
    if (!$result) {
        return "Error fetching posts: " . mysqli_error($conn);
    }

    $rows = '';
    while ($row = mysqli_fetch_assoc($result)) {
        $formattedDate = formatDate($row['created_at']);
        $plainTextPreview = htmlspecialchars(substr(strip_tags($row['post']), 0, 150)) . "...";

        // Create a new post entry
        $rows .= "<div class='category-posts'>
                    <div class='post-preview'>
                        <div class='category-posts-info'>
                            <h2><a href='full-post.php?id={$row['id']}'>{$row['title']}</a></h2>
                            <p class='post-date'>{$formattedDate}</p>
                            <div class='post-categories'>" . formatCategories($row['categories']) . "</div>
                        </div>
                        <div class='category-posts-image'>
                            <img src='../Styling/Post_photos/" . htmlspecialchars($row['image']) . "' alt='" . htmlspecialchars($row['title']) . "'>
                        </div>
                    </div>
                  </div>";
    }

    mysqli_stmt_close($stmt);
    return $rows;
}


// Load resource links per category
function linksPerCategory($conn, $category) {
    $categorylinksQuery = "SELECT id, title, url, created_at FROM publishedposts WHERE categories LIKE ? ORDER BY created_at DESC";

    $stmt = mysqli_prepare($conn, $categorylinksQuery);
    if (!$stmt) {
        return "Error preparing statement: " . mysqli_error($conn);
    }


    $param = '%' . $category . '%';
    mysqli_stmt_bind_param($stmt, 's', $param);

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $rows = '';

    // Check for errors in the result set
    if (!$result) {
        return "Error fetching newest published posts: " . mysqli_error($conn);
    }

    while ($row = mysqli_fetch_assoc($result)) {   
        if (!empty($row['url'])) {
            $rows .= "<div class='categories-sections'>
                        <div class='categories-box'>
                            <h2>" . htmlspecialchars($row['title']) . " - <a href='" . htmlspecialchars($row['url']) . "'>" . htmlspecialchars($row['url']) . "</a></h2>
                        </div>
                      </div>";
        }
    }
    mysqli_stmt_close($stmt);
    return $rows;
}

//Saving emails into database for newsletter
if (isset($_POST["submit-email"])) {
    $email = $_POST["email"];

    $checkSql = "SELECT COUNT(*) FROM newsletterSignup WHERE email = '$email'";
    $result = mysqli_query($conn, $checkSql);
    $row = mysqli_fetch_array($result);

    if ($row[0] == 0) {
        $sql = "INSERT INTO newsletterSignup(email) VALUES ('$email')";
        if (mysqli_query($conn, $sql)) {
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}

//mysqli_close($conn);

?>


