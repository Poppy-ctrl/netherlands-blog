$(document).ready(function() {
    // Handle menu toggle
    $('.menu-toggle').on('click', function() {
        $('.nav').toggleClass('showing');
    });

    $('#home-link').on('click', function(e) {
        e.preventDefault();
        window.location.href='home.php';
    });

    $('#about-link').on('click', function(e) {
        e.preventDefault();
        window.location.href='about.php';
    });

    $('#all-posts-link').on('click', function(e) {
        e.preventDefault();
        window.location.href='all-posts.php';
    });

    $('#resources-link').on('click', function(e) {
        e.preventDefault();
        window.location.href='resources.php';
    });

    $('#see-all-posts-button').on('click', function(e) {
        e.preventDefault();
        window.location.href='all-posts.php';
    });

    $('.socials-poppy div').on('click', function(e) {
        e.preventDefault();
        var url = $(this).data('url');
        window.location.href = url;
    });

    $('.socials-jake div').on('click', function(e) {
        e.preventDefault();
        var url = $(this).data('url');
        window.location.href = url;
    });

    document.getElementById("yourForm").addEventListener("submit", function(event) {
        // Get the raw HTML content from TinyMCE
        let content = tinymce.get("yourTextareaId").getContent();
        
        // Make sure that the content is updated in the form textarea field
        document.getElementById("yourTextareaId").value = content;
    });
    
    
});





