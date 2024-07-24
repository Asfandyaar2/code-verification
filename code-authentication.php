<?php
/*
Plugin Name: Code Authentication
Plugin URI: https://example.com/code-authentication
Description: A plugin to authenticate codes via a form and display the response in a modal.
Version: 1.0
Author: Asfand & Adnan
Author URI: https://example.com
License: GPL2
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

// Define plugin constants
define( 'CA_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'CA_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

// Include necessary files
require_once CA_PLUGIN_DIR . 'includes/enqueue-scripts.php';
require_once CA_PLUGIN_DIR . 'includes/admin-settings.php';




// Register shortcode
function ca_shortcode() {
    ob_start();
    include CA_PLUGIN_DIR . 'templates/form-template.php';
    return ob_get_clean();
}
add_shortcode( 'code_authentication', 'ca_shortcode' );

// Plugin activation hook
function ca_activate() {
    // Activation code here
}
register_activation_hook( __FILE__, 'ca_activate' );

// Plugin deactivation hook
function ca_deactivate() {
    // Deactivation code here
}
register_deactivation_hook( __FILE__, 'ca_deactivate' );

function ca_validate_code() {
    check_ajax_referer('ca_nonce', 'security'); // Check nonce

    $code_id = sanitize_text_field($_POST['codeId']);

    // Replace with the actual API URL and make the request
    $api_url = 'http://192.168.0.102:5000/api/v1/codes/external/validate';
    $response = wp_remote_post($api_url, array(
        'body' => array('codeId' => $code_id)
    ));

    if (is_wp_error($response)) {
        error_log('API request failed: ' . $response->get_error_message()); // Log error message
        wp_send_json_error(array('message' => 'API request failed.'));
    } else {
        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true);
        if ($data && isset($data['message'])) {
            wp_send_json_success(array('message' => $data['message']));
        } else {
            wp_send_json_error(array('message' => 'Invalid response from API.'));
        }
    }
}
add_action('wp_ajax_ca_validate_code', 'ca_validate_code'); // For logged-in users
add_action('wp_ajax_nopriv_ca_validate_code', 'ca_validate_code'); // For non-logged-in users


?>
