$(document).ready(function(){
    // Handle menu toggle
    $('.menu-toggle').on('click', function(){
        $('.nav').toggleClass('showing');
    });

    // Date formatting function for display
    function formatDate(dateString) {
        const options = { day: '2-digit', month: 'short', year: '2-digit' };
        const date = new Date(dateString);
        return date.toLocaleDateString('en-GB', options);
    }

    // Handle saving drafts
    $('#draftPost').on('submit', function(e){ // Ensure the ID is correct for the form
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
        window.location.href = 'index.html'; // Redirect to your manage posts page
    });

    // Load drafts into the manage posts table if on admin page
    if ($('body').hasClass('admin-page')) {
        let drafts = JSON.parse(localStorage.getItem('drafts')) || [];
        const draftsTableBody = $('#drafts-list'); // Ensure this ID matches your HTML

        // Clear any existing content (remove this line if you want to keep old drafts)
        draftsTableBody.empty();

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
});


