<?php
/**
 * Plugin Name: Custom Hamburger Menu
 * Description: A plugin that adds a responsive hamburger menu with customizable options.
 * Version: 1.0.2
 * Author: Shobhit Kumar Prabhakar
 * Author URI: https://shobhit.net
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain: custom-hamburger-menu
 * Domain Path: /languages
 */

// Enqueue necessary styles and scripts
function chm_enqueue_scripts() {
    wp_enqueue_style('chm-style', plugin_dir_url(__FILE__) . 'css/chm-style.css');
    wp_enqueue_script('chm-script', plugin_dir_url(__FILE__) . 'js/chm-script.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'chm_enqueue_scripts');

// Shortcode to display the custom hamburger menu
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
                </svg>            </button>
        </div>
        <div class="chm-hamburger-content">
            <button class="chm-close-icon" aria-label="Close Menu">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <line x1="18" y1="6" x2="6" y2="18" stroke="white" stroke-width="2"/>
                    <line x1="6" y1="6" x2="18" y2="18" stroke="white" stroke-width="2"/>
                </svg>            </button>
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
    register_setting('chm-settings-group', 'chm_mainmenu_submenu_background_color');
    register_setting('chm-settings-group', 'chm_mainmenu_submenu_text_color');
    register_setting('chm-settings-group', 'chm_hamburger_submenu_background_color');
    register_setting('chm-settings-group', 'chm_hamburger_submenu_text_color');

    add_settings_section(
        'chm_settings_section', 
        'Customize Menu Appearance', 
        'chm_settings_section_callback', 
        'chm-settings'
    );

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

    add_settings_field(
        'chm_mainmenu_submenu_background_color', 
        'Main Menu Submenu Background Color', 
        'chm_mainmenu_submenu_background_color_callback', 
        'chm-settings', 
        'chm_settings_section'
    );

    add_settings_field(
        'chm_mainmenu_submenu_text_color', 
        'Main Menu Submenu Text Color', 
        'chm_mainmenu_submenu_text_color_callback', 
        'chm-settings', 
        'chm_settings_section'
    );

    add_settings_field(
        'chm_hamburger_submenu_background_color', 
        'Hamburger Menu Submenu Background Color', 
        'chm_hamburger_submenu_background_color_callback', 
        'chm-settings', 
        'chm_settings_section'
    );

    add_settings_field(
        'chm_hamburger_submenu_text_color', 
        'Hamburger Menu Submenu Text Color', 
        'chm_hamburger_submenu_text_color_callback', 
        'chm-settings', 
        'chm_settings_section'
    );

    // Restore Defaults Button
    add_settings_field(
        'chm_restore_defaults', 
        'Restore Defaults', 
        'chm_restore_defaults_callback', 
        'chm-settings', 
        'chm_settings_section'
    );
}
add_action('admin_init', 'chm_settings_init');

// Callback functions for the new fields
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

function chm_background_image_callback() {
    $image = get_option('chm_background_image');
    echo '<input type="text" name="chm_background_image" value="' . esc_attr($image) . '" class="regular-text" />';
    echo '<button class="upload_image_button button">Upload Image</button>';
}

function chm_restore_defaults_callback() {
    echo '<button type="button" class="button" id="chm-restore-defaults">Restore Defaults</button>';
}
add_action('admin_init', 'chm_settings_init');

// Callback functions for the new fields
function chm_mainmenu_submenu_background_color_callback() {
    $color = get_option('chm_mainmenu_submenu_background_color', 'rgba(255, 255, 255, 0.9)');
    echo '<input type="text" name="chm_mainmenu_submenu_background_color" value="' . esc_attr($color) . '" class="my-color-field" data-default-color="rgba(255, 255, 255, 0.9)" />';
}

function chm_mainmenu_submenu_text_color_callback() {
    $color = get_option('chm_mainmenu_submenu_text_color', '#000000');
    echo '<input type="text" name="chm_mainmenu_submenu_text_color" value="' . esc_attr($color) . '" class="my-color-field" data-default-color="#000000" />';
}

function chm_hamburger_submenu_background_color_callback() {
    $color = get_option('chm_hamburger_submenu_background_color', 'rgba(0, 0, 0, 0.5)');
    echo '<input type="text" name="chm_hamburger_submenu_background_color" value="' . esc_attr($color) . '" class="my-color-field" data-default-color="rgba(0, 0, 0, 0.5)" />';
}

function chm_hamburger_submenu_text_color_callback() {
    $color = get_option('chm_hamburger_submenu_text_color', '#ffffff');
    echo '<input type="text" name="chm_hamburger_submenu_text_color" value="' . esc_attr($color) . '" class="my-color-field" data-default-color="#ffffff" />';
}

add_action('admin_init', 'chm_settings_init');



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




function chm_text_color_callback() {
    $text_color = get_option('chm_text_color');
    echo '<input type="text" name="chm_text_color" value="' . esc_attr($text_color) . '" class="my-color-field" data-default-color="#000000" />';
}

function chm_background_color_callback() {
    $background_color = get_option('chm_background_color');
    echo '<input type="text" name="chm_background_color" value="' . esc_attr($background_color) . '" class="my-color-field" data-default-color="#333333" />';
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
    $menu_item_font_size = get_option('chm_menu_item_font_size', '16'); // Default size in px
    $hamburger_text_color = get_option('chm_hamburger_text_color', '#ffffff');
    $hamburger_hover_color = get_option('chm_hamburger_hover_color', '#cccccc');
    $hamburger_font_weight = get_option('chm_hamburger_font_weight', '400');
    $hamburger_font_size = get_option('chm_hamburger_font_size', '16'); // Default size in px
    $background_color = get_option('chm_background_color', 'rgba(51, 51, 51, 0.9)');
    $background_image = get_option('chm_background_image', '');
    $mainmenu_submenu_background_color = get_option('chm_mainmenu_submenu_background_color', '#ffffff');
    $mainmenu_submenu_text_color = get_option('chm_mainmenu_submenu_text_color', '#000000');
    $hamburger_submenu_background_color = get_option('chm_hamburger_submenu_background_color', 'rgba(0, 0, 0, 0.5)');
    $hamburger_submenu_text_color = get_option('chm_hamburger_submenu_text_color', '#ffffff');

    // Ensure px is added to the font size if not already included
    if (is_numeric($menu_item_font_size)) {
        $menu_item_font_size .= 'px';
    }

    if (is_numeric($hamburger_font_size)) {
        $hamburger_font_size .= 'px';
    }

    $custom_css = "
        .chm-main-menu a {
            color: {$menu_item_color};
            font-weight: {$menu_item_font_weight};
            font-size: {$menu_item_font_size};
        }
        .chm-main-menu a:hover {
            color: {$menu_item_hover_color};
        }
        .chm-main-menu li ul {
            background-color: {$mainmenu_submenu_background_color};
        }
        .chm-main-menu li ul a {
            color: {$mainmenu_submenu_text_color};
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
            overflow-y: auto;
        }
        .chm-hamburger-content ul ul {
            background-color: {$hamburger_submenu_background_color};
        }
        .chm-hamburger-content ul ul a {
            color: {$hamburger_submenu_text_color};
        }
    ";
    wp_add_inline_style('chm-style', $custom_css);
}
add_action('wp_enqueue_scripts', 'chm_dynamic_styles');

function chm_add_settings_link($links) {
    // Add a link to the settings page
    $settings_link = '<a href="admin.php?page=chm-settings">Settings</a>';
    array_unshift($links, $settings_link); // Add it to the beginning of the list
    return $links;
}

add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'chm_add_settings_link');