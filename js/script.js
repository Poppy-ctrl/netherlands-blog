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

    // Date formatting function for display
    function formatDate(dateString) {
        const options = { day: '2-digit', month: 'short', year: '2-digit' };
        const date = new Date(dateString);
        return date.toLocaleDateString('en-GB', options);
    }

    // Handle saving drafts
    $('#draftPost').on('submit', function(e) {
        e.preventDefault();

        // Get the input information
        let title = $('#post-title').val();
        let content = $('#post-content').val();
        let date = new Date().toISOString(); // Full ISO date with timestamp

        // Create an object for the draft
        let draft = {
            id: Date.now(), // Unique id based on timestamp
            title: title,
            content: content,
            date: date // Store the full ISO date
        };

        // Save draft to localStorage
        let drafts = JSON.parse(localStorage.getItem('drafts')) || [];
        drafts.push(draft);

        // Sort drafts by date (most recent first)
        drafts.sort((a, b) => new Date(b.date) - new Date(a.date));

        // Update localStorage
        localStorage.setItem('drafts', JSON.stringify(drafts));

        // Redirect to the manage posts page
        window.location.href = 'manage-posts.html'; // Redirect to your manage posts page
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
                    <td>${formatDate(draft.date)}</td> <!-- Format date for display -->
                    <td>${draft.title}</td>
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

            // Reload the page to update the table
            location.reload();
        }
    });

    // Load published posts into all posts page
    function loadPublishedPosts() {
        if ($('body').hasClass('all-posts-page')) {
            let publishedPosts = JSON.parse(localStorage.getItem('publishedPosts')) || [];
            const postsList = $('#posts-list'); // Ensure this ID matches HTML

            // Clear any existing content
            postsList.empty();

            // Sort posts by date (most recent first)
            publishedPosts.sort((a, b) => new Date(b.date) - new Date(a.date));

            // Loop through published posts and append them to the list
            publishedPosts.forEach(post => {
                postsList.append(`
                    <div class="post">
                        <div class="post-preview">
                            <h2><a href="single.html?id=${post.id}">${post.title}</a></h2>
                            <i class="far fa-calendar">${formatDate(post.date)}</i>
                            <p class="preview-text">
                                ${post.content.substring(0, 150)}... <!-- Show a preview of the content -->
                            </p>
                        </div>
                    </div>
                `);
            });
        }
    }

    // Call the function when the page is loaded
    loadPublishedPosts();
});




