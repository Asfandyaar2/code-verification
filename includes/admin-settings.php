<?php
// Hook into the admin menu
function ca_add_admin_menu() {
    add_menu_page(
        'Code Authentication Settings', // Page title
        'Code Authentication',          // Menu title
        'manage_options',               // Capability
        'code_authentication',          // Menu slug
        'ca_settings_page',             // Callback function
        'dashicons-admin-generic'       // Icon
    );
}
add_action('admin_menu', 'ca_add_admin_menu');

// Register plugin settings
function ca_register_settings() {
    register_setting('ca_settings_group', 'ca_options');

    add_settings_section(
        'ca_settings_section', 
        'Customize Form Settings', 
        null, 
        'code_authentication'
    );

    add_settings_field(
        'ca_input_field_label',
        'Input Field Label',
        'ca_input_field_label_callback',
        'code_authentication',
        'ca_settings_section'
    );

    add_settings_field(
        'ca_button_text',
        'Button Text',
        'ca_button_text_callback',
        'code_authentication',
        'ca_settings_section'
    );

    add_settings_field(
        'ca_popup_content',
        'Popup Content',
        'ca_popup_content_callback',
        'code_authentication',
        'ca_settings_section'
    );

    add_settings_field(
        'ca_form_background_color',
        'Form Background Color',
        'ca_form_background_color_callback',
        'code_authentication',
        'ca_settings_section'
    );

    add_settings_field(
        'ca_button_color',
        'Button Color',
        'ca_button_color_callback',
        'code_authentication',
        'ca_settings_section'
    );

    add_settings_field(
        'ca_popup_background_color',
        'Popup Background Color',
        'ca_popup_background_color_callback',
        'code_authentication',
        'ca_settings_section'
    );
}
add_action('admin_init', 'ca_register_settings');

function ca_settings_page() {
    ?>
    <div class="wrap">
        <h1>Code Authentication Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('ca_settings_group');
            do_settings_sections('code_authentication');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

function ca_input_field_label_callback() {
    $options = get_option('ca_options');
    ?>
    <input type="text" name="ca_options[ca_input_field_label]" value="<?php echo esc_attr($options['ca_input_field_label']); ?>" />
    <?php
}

function ca_button_text_callback() {
    $options = get_option('ca_options');
    ?>
    <input type="text" name="ca_options[ca_button_text]" value="<?php echo esc_attr($options['ca_button_text']); ?>" />
    <?php
}

function ca_popup_content_callback() {
    $options = get_option('ca_options');
    ?>
    <textarea name="ca_options[ca_popup_content]" rows="5" cols="50"><?php echo esc_textarea($options['ca_popup_content']); ?></textarea>
    <?php
}

function ca_form_background_color_callback() {
    $options = get_option('ca_options');
    ?>
    <input type="text" name="ca_options[ca_form_background_color]" value="<?php echo esc_attr($options['ca_form_background_color']); ?>" class="my-color-field" />
    <?php
}

function ca_button_color_callback() {
    $options = get_option('ca_options');
    ?>
    <input type="text" name="ca_options[ca_button_color]" value="<?php echo esc_attr($options['ca_button_color']); ?>" class="my-color-field" />
    <?php
}

function ca_popup_background_color_callback() {
    $options = get_option('ca_options');
    ?>
    <input type="text" name="ca_options[ca_popup_background_color]" value="<?php echo esc_attr($options['ca_popup_background_color']); ?>" class="my-color-field" />
    <?php
}

// Enqueue color picker script and styles
function ca_admin_enqueue_scripts($hook) {
    if ($hook != 'toplevel_page_code_authentication') {
        return;
    }
    wp_enqueue_style('wp-color-picker');
    wp_enqueue_script('ca-admin-script', CA_PLUGIN_URL . 'assets/js/admin-script.js', array('wp-color-picker'), false, true);
}
add_action('admin_enqueue_scripts', 'ca_admin_enqueue_scripts');
?>
