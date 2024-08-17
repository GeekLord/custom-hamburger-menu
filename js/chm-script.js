jQuery(document).ready(function($) {
    $('.my-color-field').wpColorPicker();

    var file_frame;

    $(document).on('click', '.upload_image_button', function(event) {
        event.preventDefault();

        var button = $(this);

        // If the media frame already exists, reopen it.
        if (file_frame) {
            file_frame.open();
            return;
        }

        // Create the media frame.
        file_frame = wp.media.frames.file_frame = wp.media({
            title: 'Select or Upload an Image',
            button: {
                text: 'Use this image'
            },
            multiple: false
        });

        // When an image is selected, run a callback.
        file_frame.on('select', function() {
            var attachment = file_frame.state().get('selection').first().toJSON();
            button.prev('input').val(attachment.url); // Set the image URL in the input field
        });

        // Finally, open the modal
        file_frame.open();
    });

    // Restore Defaults Button Click
    $('#chm-restore-defaults').on('click', function() {
        // Default values
        var defaults = {
            chm_menu_item_color: '#000000',
            chm_menu_item_hover_color: '#000000',
            chm_menu_item_font_weight: '400',
            chm_menu_item_font_size: '16',
            chm_hamburger_text_color: '#ffffff',
            chm_hamburger_hover_color: '#cccccc',
            chm_hamburger_font_weight: '400',
            chm_hamburger_font_size: '16',
            chm_background_color: 'rgba(51, 51, 51, 0.9)',
            chm_mainmenu_submenu_background_color: '#ffffff',
            chm_hamburger_submenu_background_color: 'rgba(0, 0, 0, 0.5)',
            chm_mainmenu_submenu_text_color: '#000000',
            chm_hamburger_submenu_text_color: '#ffffff',
            chm_background_image: ''
        };

        // Reset each field to its default value
        for (var key in defaults) {
            $('[name="' + key + '"]').val(defaults[key]).change();
        }

        // Alert user that defaults have been restored
        alert('Default settings have been restored.');
    });
});

jQuery(document).ready(function($) {
    // Toggle hamburger menu on icon click
    $('.chm-hamburger-icon').on('click', function() {
        $('.chm-hamburger-content').toggleClass('chm-active');
        $('.chm-hamburger-icon').toggleClass('active'); // Optional: Toggle a class for the icon animation
    });

    // Close the menu when clicking the close button or outside the menu
    $('.chm-close-icon').on('click', function() {
        $('.chm-hamburger-content').removeClass('chm-active');
        $('.chm-hamburger-icon').removeClass('active');
    });
});
