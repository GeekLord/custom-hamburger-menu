<?php
/**
 * Plugin Name: Custom Hamburger Menu
 * Description: A plugin that adds a menu with desktop and mobile behavior using a shortcode.
 * Version: 1.0
 * Author: Shobhit Kumar PRabhakar
 */

// Enqueue necessary styles and scripts
function chm_enqueue_scripts() {
    wp_enqueue_style('chm-style', plugin_dir_url(__FILE__) . 'css/chm-style.css');
    wp_enqueue_script('chm-script', plugin_dir_url(__FILE__) . 'js/chm-script.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'chm_enqueue_scripts');

// Shortcode to display the custom menu
function chm_menu_shortcode($atts) {
    $menu = wp_nav_menu(array(
        'theme_location' => 'chm-menu',
        'container' => 'nav',
        'container_class' => 'chm-main-menu',
        'echo' => false,
        'fallback_cb' => '__return_false',
    ));

    $hamburger_menu = wp_nav_menu(array(
        'theme_location' => 'chm-hamburger-menu',
        'container' => 'nav',
        'container_class' => 'chm-hamburger-menu',
        'echo' => false,
        'fallback_cb' => '__return_false',
    ));

    ob_start();
    ?>
    <div class="chm-menu-wrapper">
        <div class="chm-menu-desktop">
            <?php echo $menu; ?>
            <button class="chm-hamburger-icon" aria-label="Open Menu">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect y="4" width="24" height="2" fill="#000"/>
                    <rect y="11" width="24" height="2" fill="#000"/>
                    <rect y="18" width="24" height="2" fill="#000"/>
                </svg>
            </button>
        </div>
        <div class="chm-hamburger-content">
            <button class="chm-close-icon" aria-label="Close Menu">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <line x1="18" y1="6" x2="6" y2="18" stroke="white" stroke-width="2"/>
                    <line x1="6" y1="6" x2="18" y2="18" stroke="white" stroke-width="2"/>
                </svg>
            </button>
            <?php echo $hamburger_menu; ?>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('custom_hamburger_menu', 'chm_menu_shortcode');

// Register a custom menu location
function chm_register_menus() {
    register_nav_menus(array(
        'chm-menu' => __('CHM Main Menu'),
        'chm-hamburger-menu' => __('CHM Hamburger Menu'),
    ));
}
add_action('init', 'chm_register_menus');


// Add a settings menu item in the WordPress admin
function chm_add_admin_menu() {
    add_menu_page(
        'Custom Hamburger Menu',          // Page title
        'Hamburger Menu',                 // Menu title
        'manage_options',                 // Capability
        'chm-settings',                   // Menu slug
        'chm_settings_page',              // Function to display the page
        'dashicons-menu-alt',             // Icon
        80                                // Position
    );
}
add_action('admin_menu', 'chm_add_admin_menu');
function chm_settings_page() {
    ?>
    <div class="wrap">
        <h1>Custom Hamburger Menu Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('chm-settings-group');
            do_settings_sections('chm-settings');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}


function chm_settings_init() {
    // Register settings
    register_setting('chm-settings-group', 'chm_menu_item_color');
    register_setting('chm-settings-group', 'chm_menu_item_hover_color');
    register_setting('chm-settings-group', 'chm_menu_item_font_weight');
    register_setting('chm-settings-group', 'chm_menu_item_font_size');
    register_setting('chm-settings-group', 'chm_hamburger_text_color');
    register_setting('chm-settings-group', 'chm_hamburger_hover_color');
    register_setting('chm-settings-group', 'chm_hamburger_font_weight');
    register_setting('chm-settings-group', 'chm_hamburger_font_size');
    register_setting('chm-settings-group', 'chm_background_color');
    register_setting('chm-settings-group', 'chm_background_image');

    // Add settings section
    add_settings_section(
        'chm_settings_section', 
        'Customize Menu Appearance', 
        'chm_settings_section_callback', 
        'chm-settings'
    );

    // Add settings fields
    add_settings_field(
        'chm_menu_item_color', 
        'Menu Item Text Color', 
        'chm_menu_item_color_callback', 
        'chm-settings', 
        'chm_settings_section'
    );

    add_settings_field(
        'chm_menu_item_hover_color', 
        'Menu Item Hover Color', 
        'chm_menu_item_hover_color_callback', 
        'chm-settings', 
        'chm_settings_section'
    );

    add_settings_field(
        'chm_menu_item_font_weight', 
        'Menu Item Font Weight', 
        'chm_menu_item_font_weight_callback', 
        'chm-settings', 
        'chm_settings_section'
    );

    add_settings_field(
        'chm_menu_item_font_size', 
        'Menu Item Font Size', 
        'chm_menu_item_font_size_callback', 
        'chm-settings', 
        'chm_settings_section'
    );

    add_settings_field(
        'chm_hamburger_text_color', 
        'Hamburger Menu Text Color', 
        'chm_hamburger_text_color_callback', 
        'chm-settings', 
        'chm_settings_section'
    );

    add_settings_field(
        'chm_hamburger_hover_color', 
        'Hamburger Menu Hover Color', 
        'chm_hamburger_hover_color_callback', 
        'chm-settings', 
        'chm_settings_section'
    );

    add_settings_field(
        'chm_hamburger_font_weight', 
        'Hamburger Menu Font Weight', 
        'chm_hamburger_font_weight_callback', 
        'chm-settings', 
        'chm_settings_section'
    );

    add_settings_field(
        'chm_hamburger_font_size', 
        'Hamburger Menu Font Size', 
        'chm_hamburger_font_size_callback', 
        'chm-settings', 
        'chm_settings_section'
    );

    add_settings_field(
        'chm_background_color', 
        'Hamburger Menu Background Color', 
        'chm_background_color_callback', 
        'chm-settings', 
        'chm_settings_section'
    );

    add_settings_field(
        'chm_background_image', 
        'Hamburger Menu Background Image', 
        'chm_background_image_callback', 
        'chm-settings', 
        'chm_settings_section'
    );
}
add_action('admin_init', 'chm_settings_init');

// Callback functions for new fields
function chm_menu_item_font_weight_callback() {
    $font_weight = get_option('chm_menu_item_font_weight', '400');
    echo '<input type="number" name="chm_menu_item_font_weight" value="' . esc_attr($font_weight) . '" class="small-text" min="100" max="900" step="100" />';
}

function chm_menu_item_font_size_callback() {
    $font_size = get_option('chm_menu_item_font_size', '16');
    echo '<input type="number" name="chm_menu_item_font_size" value="' . esc_attr($font_size) . '" class="small-text" min="10" max="40" step="1" /> px';
}

function chm_hamburger_font_weight_callback() {
    $font_weight = get_option('chm_hamburger_font_weight', '400');
    echo '<input type="number" name="chm_hamburger_font_weight" value="' . esc_attr($font_weight) . '" class="small-text" min="100" max="900" step="100" />';
}

function chm_hamburger_font_size_callback() {
    $font_size = get_option('chm_hamburger_font_size', '16');
    echo '<input type="number" name="chm_hamburger_font_size" value="' . esc_attr($font_size) . '" class="small-text" min="10" max="40" step="1" /> px';
}

add_action('admin_init', 'chm_settings_init');

function chm_settings_section_callback() {
    echo 'Customize the appearance of your hamburger menu and main menu items here.';
}

// Callback functions for the new fields
function chm_menu_item_color_callback() {
    $color = get_option('chm_menu_item_color');
    echo '<input type="text" name="chm_menu_item_color" value="' . esc_attr($color) . '" class="my-color-field" data-default-color="#000000" />';
}

function chm_menu_item_hover_color_callback() {
    $color = get_option('chm_menu_item_hover_color');
    echo '<input type="text" name="chm_menu_item_hover_color" value="' . esc_attr($color) . '" class="my-color-field" data-default-color="#000000" />';
}

function chm_hamburger_text_color_callback() {
    $color = get_option('chm_hamburger_text_color');
    echo '<input type="text" name="chm_hamburger_text_color" value="' . esc_attr($color) . '" class="my-color-field" data-default-color="#ffffff" />';
}

function chm_hamburger_hover_color_callback() {
    $color = get_option('chm_hamburger_hover_color');
    echo '<input type="text" name="chm_hamburger_hover_color" value="' . esc_attr($color) . '" class="my-color-field" data-default-color="#cccccc" />';
}




add_action('admin_init', 'chm_settings_init');


function chm_text_color_callback() {
    $text_color = get_option('chm_text_color');
    echo '<input type="text" name="chm_text_color" value="' . esc_attr($text_color) . '" class="my-color-field" data-default-color="#000000" />';
}

function chm_background_color_callback() {
    $background_color = get_option('chm_background_color');
    echo '<input type="text" name="chm_background_color" value="' . esc_attr($background_color) . '" class="my-color-field" data-default-color="#333333" />';
}

function chm_background_image_callback() {
    $background_image = get_option('chm_background_image');
    echo '<input type="text" name="chm_background_image" value="' . esc_attr($background_image) . '" class="regular-text" />';
    echo '<button class="upload_image_button button">Upload Image</button>';
}
function chm_enqueue_admin_scripts($hook) {
    if ('toplevel_page_chm-settings' !== $hook) {
        return;
    }

    wp_enqueue_style('wp-color-picker');
    wp_enqueue_media();
    wp_enqueue_script('chm-admin-script', plugin_dir_url(__FILE__) . 'js/chm-admin.js', array('wp-color-picker', 'jquery'), null, true);
}
add_action('admin_enqueue_scripts', 'chm_enqueue_admin_scripts');



function chm_dynamic_styles() {
    $menu_item_color = get_option('chm_menu_item_color', '#000000');
    $menu_item_hover_color = get_option('chm_menu_item_hover_color', '#000000');
    $menu_item_font_weight = get_option('chm_menu_item_font_weight', '400');
    $menu_item_font_size = get_option('chm_menu_item_font_size', '16px');
    $hamburger_text_color = get_option('chm_hamburger_text_color', '#ffffff');
    $hamburger_hover_color = get_option('chm_hamburger_hover_color', '#cccccc');
    $hamburger_font_weight = get_option('chm_hamburger_font_weight', '400');
    $hamburger_font_size = get_option('chm_hamburger_font_size', '16px');
    $background_color = get_option('chm_background_color', '#333333');
    $background_image = get_option('chm_background_image', '');

    $custom_css = "
        .chm-main-menu a {
            color: {$menu_item_color};
            font-weight: {$menu_item_font_weight};
            font-size: {$menu_item_font_size};
        }
        .chm-main-menu a:hover {
            color: {$menu_item_hover_color};
        }
        .chm-hamburger-content a {
            color: {$hamburger_text_color};
            font-weight: {$hamburger_font_weight};
            font-size: {$hamburger_font_size};
        }
        .chm-hamburger-content a:hover {
            color: {$hamburger_hover_color};
        }
        .chm-hamburger-content {
            background-color: {$background_color};
            background-image: url('{$background_image}');
            background-size: cover;
            background-repeat: no-repeat;
        }
    ";
    wp_add_inline_style('chm-style', $custom_css);
}
add_action('wp_enqueue_scripts', 'chm_dynamic_styles');
