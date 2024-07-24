<?php
$options = get_option('ca_options');
$input_field_label = isset($options['ca_input_field_label']) ? $options['ca_input_field_label'] : 'Enter your code';
$button_text = isset($options['ca_button_text']) ? $options['ca_button_text'] : 'Submit';
$popup_content = isset($options['ca_popup_content']) ? $options['ca_popup_content'] : 'Authentication result will be displayed here.';
$form_bg_color = isset($options['ca_form_background_color']) ? $options['ca_form_background_color'] : '#ffffff';
$button_color = isset($options['ca_button_color']) ? $options['ca_button_color'] : '#007bff';
$popup_bg_color = isset($options['ca_popup_background_color']) ? $options['ca_popup_background_color'] : '#ffffff';
?>

<div class="container mt-5" style="background-color: <?php echo esc_attr($form_bg_color); ?>;">
    <h2 class="heading2">Authenticate your code</h2>
    <form id="submitForm">
        <div class="form-group">
            <input type="text" class="form-control" id="codeId" name="codeId" placeholder="<?php echo esc_attr($input_field_label); ?>" required>
        </div>
        <button type="submit" class="btn btn-primary" id="submitButton" style="background-color: <?php echo esc_attr($button_color); ?>;"><?php echo esc_html($button_text); ?></button>
    </form>
</div>

<!-- Modal to display API response -->
<div id="responseModal" class="modal" style="display: none; background-color: <?php echo esc_attr($popup_bg_color); ?>;">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-body">
                <pre id="modalContent"><?php echo esc_html($popup_content); ?></pre>
            </div>
            <div class="modal-footer">
                <button id="newButton" class="btn btn-secondary">Close</button>
            </div>
        </div>
    </div>
</div>
