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
});
