<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

// Define plugin URL if not already defined
if ( ! defined( 'CA_PLUGIN_URL' ) ) {
    define( 'CA_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}

function ca_enqueue_scripts() {
    // Enqueue Bootstrap CSS
    wp_enqueue_style( 'bootstrap-css', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css' );
    
    // Enqueue jQuery Modal CSS
    wp_enqueue_style( 'jquery-modal-css', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.2/jquery.modal.min.css' );

    // Enqueue Custom CSS
    wp_enqueue_style( 'ca-custom-css', CA_PLUGIN_URL . 'assets/css/style.css' );

    // Enqueue jQuery
    wp_enqueue_script( 'jquery' );

    // Enqueue Bootstrap JS
    wp_enqueue_script( 'bootstrap-js', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js', array( 'jquery' ), null, true );
    
    // Enqueue jQuery Modal JS
    wp_enqueue_script( 'jquery-modal-js', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.2/jquery.modal.min.js', array( 'jquery' ), null, true );

    // Enqueue Custom JS
    wp_enqueue_script( 'ca-custom-js', CA_PLUGIN_URL . 'assets/js/script.js', array( 'jquery' ), null, true );

    // Localize the script with new data
    // wp_localize_script( 'ca-custom-js', 'ca_ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );

     // Localize the script with new data
     wp_localize_script( 'ca-custom-js', 'ca_ajax_object', array(
        'ajax_url' => admin_url( 'admin-ajax.php' ),
        'nonce' => wp_create_nonce('ca_nonce'),
        'plugin_url' => CA_PLUGIN_URL
    ));
}
add_action( 'wp_enqueue_scripts', 'ca_enqueue_scripts' );
function my_enqueue_scripts() {
    wp_enqueue_script('my-script', get_template_directory_uri() . '/js/my-script.js', array('jquery'), null, true);
    wp_localize_script('my-script', 'ca_ajax_object', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('ca_nonce'),
        'plugin_url' => get_template_directory_uri() . '/assets/img/' // Adjust path as needed
    ));
}
add_action('wp_enqueue_scripts', 'my_enqueue_scripts');

?>
