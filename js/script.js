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

    // Check if user is an admin (this could be done by checking a flag or value set in the session)
    // For demo purposes, we'll assume an admin flag is set in localStorage
    if (localStorage.getItem('isAdmin') === 'true') {
        $('#admin-link').show();
    }

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

    // Handle saving drafts
    $('#draftPost').on('submit', function(e) {
        e.preventDefault();

        // Get the input information
        let title = $('#post-title').val();
        let content = $('#post-content').val();
        let categories = []; 
        $('input[type=checkbox]:checked').each(function() {
            categories.push($(this).val());
        });
        let date = new Date().toISOString(); // Full ISO date with timestamp

        // Create an object for the draft
        let draft = {
            id: Date.now(), // Unique id based on timestamp
            title: title,
            content: content,
            categories: categories,
            date: date // Store the full ISO date
        };

        // Handle image upload and conversion to Base64
        const fileInput = $('#post-image')[0];
        if (fileInput.files && fileInput.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                // Once the image is converted to Base64, save it in the draft object
                draft.image = e.target.result;
    
                // Save draft to localStorage
                let drafts = JSON.parse(localStorage.getItem('drafts')) || [];
                drafts.push(draft);

                // Sort drafts by date (most recent first)
                drafts.sort((a, b) => new Date(b.date) - new Date(a.date));

            // Update localStorage
            localStorage.setItem('drafts', JSON.stringify(drafts));

            // Redirect to the manage posts page
            window.location.href = 'manage-posts.html'; // Redirect to your manage posts page
        };
            reader.readAsDataURL(fileInput.files[0]); // Convert image to Base64
        } else {
            // No image uploaded, save draft without an image
            let drafts = JSON.parse(localStorage.getItem('drafts')) || [];
            drafts.push(draft);

            // Sort drafts by date (most recent first)
            drafts.sort((a, b) => new Date(b.date) - new Date(a.date));

            // Update localStorage
            localStorage.setItem('drafts', JSON.stringify(drafts));

            // Redirect to the manage posts page
            window.location.href = 'manage-posts.html'; // Redirect to your manage posts page
        }
    });

    // Load drafts into the manage posts table if on admin page
    if ($('body').hasClass('admin-page')) {
        let drafts = JSON.parse(localStorage.getItem('drafts')) || [];
        const draftsTableBody = $('#drafts-list'); // Ensure this ID matches your HTML
    
        // Sort drafts by date (most recent first)
        drafts.sort((a, b) => new Date(b.date) - new Date(a.date));
    
        // Loop through drafts and append them to the table
        drafts.forEach(draft => {
            draftsTableBody.append(`
                <tr>
                    <td>${formatDate(draft.date)}</td> 
                    <td>${draft.title}</td>
                    <td>${draft.categories}</td>
                    <td>${draft.image ? 'Image attached' : 'No image'}</td>
                    <td>
                        <a href="edit.html?id=${draft.id}">Edit</a>
                        <a href="#" class="delete-draft" data-id="${draft.id}">Delete</a>
                        <a href="#" class="publish-draft" data-id="${draft.id}">Publish</a>
                    </td>
                </tr>
            `);
        });
    
        console.log('Drafts:', drafts); // Log drafts to verify data
    }

    // Handle delete draft action
    $(document).on('click', '.delete-draft', function(e) {
        e.preventDefault();

        // Get the ID of the draft to delete
        const idToDelete = $(this).data('id');

        // Get drafts from localStorage
        let drafts = JSON.parse(localStorage.getItem('drafts')) || [];

        // Filter out the deleted draft
        drafts = drafts.filter(draft => draft.id !== idToDelete);

        // Update localStorage
        localStorage.setItem('drafts', JSON.stringify(drafts));

        // Reload the page to update the table
        location.reload();
    });

    function getQueryParam(param) { //getting details of ID of draft to edit
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(param);
    }

    // Load draft details to edit
    $(function() {
        const draftId = getQueryParam('id');
        if (draftId) {
            // Get drafts from localStorage
            let drafts = JSON.parse(localStorage.getItem('drafts')) || [];
            // Find the draft to edit
            let draftToEdit = drafts.find(draft => draft.id == draftId);

            if (draftToEdit) {
                // Populate form fields with draft data
                $('#post-title').val(draftToEdit.title);
                $('#post-content').val(draftToEdit.content);
                $('#categories').val(draftToEdit.categories);
                            // Show image preview if it exists
                if (draftToEdit.image) {
                    $('#image-preview').attr('src', draftToEdit.image).show();
                } else {
                    $('#image-preview').hide();
                }
            }
        }
    });

    $('#editDraftPost').on('submit', function(e) {
        e.preventDefault();
    
        // Get the draft ID from the URL
        const draftId = getQueryParam('id');
    
        // Get the input information
        let title = $('#post-title').val();
        let content = $('#post-content').val();
        let categories = []; 
        $('input[type=checkbox]:checked').each(function() {
            categories.push($(this).val());
        });
        let date = new Date().toISOString(); // Full ISO date with timestamp
    
        // Retrieve drafts from localStorage
        let drafts = JSON.parse(localStorage.getItem('drafts')) || [];
    
        // Find the draft to edit
        let draftToEdit = drafts.find(draft => draft.id == draftId);
    
        if (draftToEdit) {
            // Update draft fields
            draftToEdit.title = title;
            draftToEdit.content = content;
            draftToEdit.categories = categories;
            draftToEdit.date = date; // Update date
    
        // Handle image upload and conversion to Base64
        const fileInput = $('#post-image')[0];
        if (fileInput.files && fileInput.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                draftToEdit.image = e.target.result;

                // Save updated drafts to localStorage
                localStorage.setItem('drafts', JSON.stringify(drafts));

                // Redirect to the manage posts page
                window.location.href = 'manage-posts.html'; // Redirect to your manage posts page
            };
            reader.readAsDataURL(fileInput.files[0]); // Convert image to Base64
        } else {
            // If no new image is uploaded, keep the existing image
            // Save updated drafts to localStorage
            localStorage.setItem('drafts', JSON.stringify(drafts));

            // Redirect to the manage posts page
            window.location.href = 'manage-posts.html'; // Redirect to your manage posts page
            }
        }
    });

    $(document).on('click', '.publish-draft', function(e) {
        e.preventDefault();

        // Get the ID of the draft to publish
        const idToPublish = $(this).data('id');

        // Get drafts from localStorage
        let drafts = JSON.parse(localStorage.getItem('drafts')) || [];
        let publishedPosts = JSON.parse(localStorage.getItem('publishedPosts')) || [];

        // Find the draft to publish
        let draftToPublish = drafts.find(draft => draft.id === idToPublish);

        if (draftToPublish) {
            // Remove the draft from the drafts array
            drafts = drafts.filter(draft => draft.id !== idToPublish);

            // Add the draft to the published posts array
            publishedPosts.push(draftToPublish);

            // Update localStorage
            localStorage.setItem('drafts', JSON.stringify(drafts));
            localStorage.setItem('publishedPosts', JSON.stringify(publishedPosts));

            // Refresh the manage posts page to update the tables
            location.reload();
        }
    });

    // Function to load published posts into the published posts table
    function loadPublishedPosts() {
        if ($('body').hasClass('admin-page')) {
            let publishedPosts = JSON.parse(localStorage.getItem('publishedPosts')) || [];
            const publishedTableBody = $('#published-posts-list'); // Ensure this ID matches your HTML

            // Clear any existing content in the table
            publishedTableBody.empty();

            // Sort published posts by date (most recent first), assuming posts have a `date` field
            publishedPosts.sort((a, b) => new Date(b.date) - new Date(a.date));

            // Loop through published posts and append them to the table
            publishedPosts.forEach(post => {
                publishedTableBody.append(`
                <tr>
                    <td>${formatDate(post.date)}</td>
                    <td>${post.title}</td>
                    <td>${post.categories}</td>
                    <td>
                        <a href="#" class="delete-published-post" data-id="${post.id}">Delete</a>
                    </td>
                </tr>
            `);
            });

            console.log('Published Posts:', publishedPosts); // Log published posts to verify data
        }
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
                            ${post.categories.map(category => `<span class="category-bubble">${category}</span>`).join('')}
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
                        <h2><a href="full-post.html?id=${post.id}">${post.title}</a></h2>
                        <p class="post-date">${formatDate(post.date)}</p>
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
                            ${post.categories.map(category => `<span class="category-bubble">${category}</span>`).join('')}
                        </div>
                    </div>
                </div>
                <div class="full-post-content">${post.content}</div>
            `);
        }
    }

    // Load posts for the selected category
    function loadCategories() {
        console.log("loadCategories() is running");  // Debugging log
        const selectedCategory = getQueryParam('category');
        if ($('body').hasClass('categories-posts-page')) {
            let publishedPosts = JSON.parse(localStorage.getItem('publishedPosts')) || [];
            console.log("Selected Category:", selectedCategory); // Log the selected category
            const categoryPostsList = $('#category-posts');

            localStorage.setItem('publishedPosts', JSON.stringify([{id: 1, title: 'Sample Post', categories: ['Language', 'Culture'], content: 'This is a sample post.', date: new Date().toISOString()}]));



            // Clear any existing content
            categoryPostsList.empty();

            // Filter posts based on the selected category
            const categoryFinder = publishedPosts.filter(post => post.categories.includes(selectedCategory));
            console.log("Filtered Posts:", categoryFinder);

            // Loop through filtered posts and append them to the list
            if (categoryFinder.length > 0) {
                categoryFinder.forEach(post => {
                    categoryPostsList.append(`
                        <div class="all-posts">
                            <div class="post-preview">
                                <h2><a href="full-post.html?id=${post.id}">${post.title}</a></h2>
                                <p class="post-date">${formatDate(post.date)}</p>
                                <p class="preview-text">${post.content.substring(0, 150)}...</p>
                                <div class="post-categories">
                                    ${post.categories.map(category => `<span class="category-bubble">${category}</span>`).join('')}
                                </div>
                                <div class="all-posts-image">
                                    ${post.image ? `<img src="${post.image}" alt="${post.title}">` : ''}
                                </div>
                            </div>
                        </div>
                    `);
                });
            } else {
                categoryPostsList.append('<p>No posts found for this category.</p>'); // Message if no posts match
            }
        }
    }
    
    // Call all load functions
    loadPublishedPosts();
    loadPublishedPostsOnAllPostsPage();
    loadLatestPost();
    loadRecentPosts();
    loadFullPost();
    loadCategories();
});





