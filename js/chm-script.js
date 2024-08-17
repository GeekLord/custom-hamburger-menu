jQuery(document).ready(function($) {
    function toggleMenu() {
        $('.chm-hamburger-content').toggleClass('chm-active');
        $('.chm-hamburger-icon').toggleClass('active'); // Toggle the active class for rotation
    }

    // Toggle menu when clicking the hamburger icon or close icon
    $('.chm-hamburger-icon').on('click', toggleMenu);
    $('.chm-close-icon').on('click', toggleMenu);

    // Optional: Close the menu if clicking outside of it
    $(document).on('click', function(event) {
        if (!$(event.target).closest('.chm-hamburger-content, .chm-hamburger-icon').length) {
            if ($('.chm-hamburger-content').hasClass('chm-active')) {
                $('.chm-hamburger-content').removeClass('chm-active');
                $('.chm-hamburger-icon').removeClass('active'); // Reset rotation
            }
        }
    });
});
