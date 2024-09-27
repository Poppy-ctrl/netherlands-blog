$(document).ready(function() {
    // Handle menu toggle
    $('.menu-toggle').on('click', function() {
        $('.nav').toggleClass('showing');
    });

    $('#home-link').on('click', function(e) {
        e.preventDefault();
        window.location.href='home.html';
    });

    $('#about-link').on('click', function(e) {
        e.preventDefault();
        window.location.href='about.html';
    });

    $('#all-posts-link').on('click', function(e) {
        e.preventDefault();
        window.location.href='all-posts.html';
    });

    $('#manage-to-posts-link').on('click', function(e) {
        e.preventDefault();
        window.location.href='../../all-posts.html';
    });

    $('#manage-posts-link').on('click', function(e) {
        e.preventDefault();
        window.location.href='manage-posts.html';
    });


    // Function to get the ordinal suffix for a day
    function getOrdinalSuffix(day) {
        if (day > 3 && day < 21) return 'th'; // Special case for 11th to 13th
        switch (day % 10) {
            case 1: return 'st';
            case 2: return 'nd';
            case 3: return 'rd';
            default: return 'th';
        }
    }

    // Date formatting function for display
    function formatDate(dateString) {
        const date = new Date(dateString);
        const day = date.getDate();
        const month = date.toLocaleString('en-GB', { month: 'long' });
        const year = date.getFullYear();
        const suffix = getOrdinalSuffix(day);
    
        return `${day}${suffix} ${month} ${year}`;
    }

    // Load published posts into all posts page
    function loadPublishedPostsOnAllPostsPage() {
        if ($('body').hasClass('all-posts-page')) {
            let publishedPosts = JSON.parse(localStorage.getItem('publishedPosts')) || [];
            const postsList = $('#all-posts-list'); // Ensure this ID matches HTML

            // Clear any existing content
            postsList.empty();

            // Sort posts by date (most recent first)
            publishedPosts.sort((a, b) => new Date(b.date) - new Date(a.date));

            // Loop through published posts and append them to the list
            publishedPosts.forEach(post => {
                postsList.append(`
                    <div class="all-posts">
                        <div class="post-preview">
                            <h2><a href="full-post.html?id=${post.id}">${post.title}</a></h2>
                            <p class="post-date">${formatDate(post.date)}</p>
                            <p class="preview-text">
                                ${post.content.substring(0, 150)}... <!-- Show a preview of the content -->
                            </p>
                            <div class="post-categories">
                                ${post.categories.map(category => `<span class="category-bubble">${formatCategoryName(category)}</span>`).join('')}
                            </div>
                            <div class="all-posts-image">
                            ${post.image ? `<img src="${post.image}" alt="${post.title}">` : ''}
                            </div>
                        </div>
                    </div>
                `);
            });
        }
    }

    // Handle delete published post action
    $(document).on('click', '.delete-published-post', function(e) {
        e.preventDefault();
    
        // Get the ID of the published post to delete
        const idToDelete = $(this).data('id');
    
        // Get published posts from localStorage
        let posts = JSON.parse(localStorage.getItem('publishedPosts')) || [];
    
        // Filter out the deleted posts
        posts = posts.filter(post => post.id !== idToDelete);
    
        // Update localStorage
        localStorage.setItem('publishedPosts', JSON.stringify(posts));
    
        // Reload the page to update the table
        location.reload();
    });

    // Load newest post into homepage
    function loadLatestPost() {
        if ($('body').hasClass('homepage')) {
            let publishedPosts = JSON.parse(localStorage.getItem('publishedPosts')) || [];
            const latestPost = $('#latest-post'); // Ensure this ID matches HTML

            // Clear any existing content
            latestPost.empty();

            // Sort posts by date (most recent first)
            publishedPosts.sort((a, b) => new Date(b.date) - new Date(a.date));

            // Limit to newest post
            const newestPost = publishedPosts.slice(0, 1);

            // Loop through 3 most recent posts and append them to the homepage
            newestPost.forEach(post => {
                latestPost.append(`
                    <div class="post">
                        <div class="post-preview">
                            <div class="post-details">
                                <h2><a href="full-post.html?id=${post.id}">${post.title}</a></h2>
                                <p class="preview-text">
                                ${post.content.substring(0, 150)}... <!-- Show a preview of the content -->
                                </p>
                                <p class="post-date">${formatDate(post.date)}</p>
                            </div>
                            <div class="post-image">
                            ${post.image ? `<img src="${post.image}" alt="${post.title}">` : ''}
                            </div>
                        </div>
                    </div>
                `);
            });
        }
    }

    // Load three most recent posts into the homepage
    function loadRecentPosts() {
        if ($('body').hasClass('homepage')) {
            let publishedPosts = JSON.parse(localStorage.getItem('publishedPosts')) || [];
            const recentPostsList = $('#recent-posts-list'); // Ensure this ID matches HTML

            // Clear any existing content
            recentPostsList.empty();

            // Sort posts by date (most recent first)
            publishedPosts.sort((a, b) => new Date(b.date) - new Date(a.date));

            // Limit to three most recent posts
            const recentPosts = publishedPosts.slice(1, 4);

            // Loop through 3 most recent posts and append them to the homepage
            recentPosts.forEach(post => {
                recentPostsList.append(`
                <div class="post">
                <div class="post-preview">
                    <div class="recent-post-image">
                        ${post.image ? `<img src="${post.image}" alt="${post.title}">` : ''}
                    </div>
                    <div class="recent-post-details">
                        <p class="post-date">${formatDate(post.date)}</p>
                        <h2><a href="full-post.html?id=${post.id}">${post.title}</a></h2>
                    </div>
                </div>
            </div>
                `);
            });
        }
    }

    // Function to load full post details
    function loadFullPost() {
        const postId = getQueryParam('id');
        let publishedPosts = JSON.parse(localStorage.getItem('publishedPosts')) || [];
    
        // Find the post with the matching ID
        const post = publishedPosts.find(p => p.id == postId);

        if (post) {
            document.title = post.title;

            $('#full-post-container').html(`
                <div class="full-post">
                    <div class="full-post-image">
                        ${post.image ? `<img src="${post.image}" alt="${post.title}">` : ''}
                    </div>
                    <div class="post-info">
                        <h1>${post.title}</h1>
                        <p class="post-date">${formatDate(post.date)}</p>
                        <div class="post-categories">
                            ${post.categories.map(category => `<span class="category-bubble">${formatCategoryName(category)}</span>`).join('')}
                        </div>
                        <div class="link">
                        <p class="url">${post.link}</p>
                        </div>
                    </div>
                </div>
                <div class="full-post-content">${post.content}</div>
            `);
        }
    }

    function loadCategories() {
        // Get the selected category from the body data attribute
        const selectedCategory = document.body.getAttribute('data-category');
    
        if (document.body.classList.contains('categories-posts-page')) {
            let publishedPosts = JSON.parse(localStorage.getItem('publishedPosts')) || [];
            const categoryPostsList = document.getElementById('category-posts');
    
            // Clear any existing content
            categoryPostsList.innerHTML = '';
    
            // Filter posts based on the selected category
            const categoryFinder = publishedPosts.filter(post => {
                // Ensure categories exist and is an array before using .includes()
                return post.categories && Array.isArray(post.categories) && post.categories.includes(selectedCategory);
            });
    
            // Display the filtered posts
            if (categoryFinder.length > 0) {
                categoryFinder.forEach(post => {
                    categoryPostsList.innerHTML += `
                        <div class="all-posts">
                            <div class="post-preview">
                                <h2><a href="full-post.html?id=${post.id}">${post.title}</a></h2>
                                <p class="post-date">${formatDate(post.date)}</p>
                                <p class="preview-text">${post.content.substring(0, 150)}...</p>
                                <div class="post-categories">
                                    ${post.categories.map(category => `<span class="category-bubble">${formatCategoryName(category)}</span>`).join('')}
                                </div>
                                <div class="all-posts-image">
                                    ${post.image ? `<img src="${post.image}" alt="${post.title}">` : ''}
                                </div>
                            </div>
                        </div>
                    `;
                });
            } else {
                categoryPostsList.innerHTML = '<p>No posts found for this category.</p>';
            }
        }
    }
    document.addEventListener('DOMContentLoaded', loadCategories);

    // Detect category based on the page or a data attribute
    $(document).ready(function() {
        const body = $('body');

        if (body.hasClass('categories-posts-page')) {
            const category = body.data('my-life');
            loadCategories(category);
        }
    });
    $(document).ready(function() {
        const body = $('body');

        if (body.hasClass('categories-posts-page')) {
            const category = body.data('job-hunting');
            loadCategories(category);
        }
    });
    $(document).ready(function() {
        const body = $('body');

        if (body.hasClass('categories-posts-page')) {
            const category = body.data('dutch-culture');
            loadCategories(category);
        }
    });
    $(document).ready(function() {
        const body = $('body');

        if (body.hasClass('categories-posts-page')) {
            const category = body.data('visa');
            loadCategories(category);
        }
    });
    $(document).ready(function() {
        const body = $('body');

        if (body.hasClass('categories-posts-page')) {
            const category = body.data('career-building');
            loadCategories(category);
        }
    });
    $(document).ready(function() {
        const body = $('body');

        if (body.hasClass('categories-posts-page')) {
            const category = body.data('housing');
            loadCategories(category);
        }
    });
    $(document).ready(function() {
        const body = $('body');

        if (body.hasClass('categories-posts-page')) {
            const category = body.data('healthcare');
            loadCategories(category);
        }
    });
    $(document).ready(function() {
        const body = $('body');

        if (body.hasClass('categories-posts-page')) {
            const category = body.data('dutch-attractions');
            loadCategories(category);
        }
    });
    $(document).ready(function() {
        const body = $('body');

        if (body.hasClass('categories-posts-page')) {
            const category = body.data('language');
            loadCategories(category);
        }
    });
    $(document).ready(function() {
        const body = $('body');

        if (body.hasClass('categories-posts-page')) {
            const category = body.data('dutch-holidays');
            loadCategories(category);
        }
    });

    
    // Call all load functions
    loadPublishedPosts();
    loadPublishedPostsOnAllPostsPage();
    loadLatestPost();
    loadRecentPosts();
    loadFullPost();
    loadCategories();
});





