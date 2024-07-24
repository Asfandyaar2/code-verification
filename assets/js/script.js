var svgPath = './close.svg';

jQuery(document).ready(function ($) {
    // Function to extract URL parameter by name
    console.log("ca_ajax_object", ca_ajax_object.plugin_url)
    function getParameterByName(name, url) {
        if (!url) url = window.location.href;
        name = name.replace(/[\[\]]/g, '\\$&');
        var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
            results = regex.exec(url);
        if (!results) return null;
        if (!results[2]) return '';
        return decodeURIComponent(results[2].replace(/\+/g, ' '));
    }

    // Check if codeId parameter is in the URL
    var codeIdParam = getParameterByName('codeId');
    if (codeIdParam) {
        // Populate the form field with the codeId parameter value
        $('#codeId').val(codeIdParam);

        // Call API directly on page load
        submitForm();
    }

    // Function to handle form submission
    function submitForm() {
        // Show loader
        $('#modalContent').html('<div class="loader"></div>');
        $('#responseModal').modal({
            showClose: false // Disable the close button
        });

        // Get form data
        var formData = {
            action: 'ca_validate_code', // Specify the action
            codeId: $('#codeId').val(),
            security: ca_ajax_object.nonce
        };

        // AJAX POST request
        $.ajax({
            type: 'POST',
            url: ca_ajax_object.ajax_url,
            data: formData,
            success: function (response) {
                if (response.success) {
                    // Format the result string
                    var resultString = response.data.message;

                    // Display result in modal
                    $('#modalContent').html('<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="122.879px" height="122.879px" viewBox="0 0 122.879 122.879" enable-background="new 0 0 122.879 122.879" xml:space="preserve"><g><path fill-rule="evenodd" clip-rule="evenodd" fill="#FF4141" d="M61.44,0c33.933,0,61.439,27.507,61.439,61.439 s-27.506,61.439-61.439,61.439C27.507,122.879,0,95.372,0,61.439S27.507,0,61.44,0L61.44,0z M73.451,39.151 c2.75-2.793,7.221-2.805,9.986-0.027c2.764,2.776,2.775,7.292,0.027,10.083L71.4,61.445l12.076,12.249 c2.729,2.77,2.689,7.257-0.08,10.022c-2.773,2.765-7.23,2.758-9.955-0.013L61.446,71.54L49.428,83.728 c-2.75,2.793-7.22,2.805-9.986,0.027c-2.763-2.776-2.776-7.293-0.027-10.084L51.48,61.434L39.403,49.185 c-2.728-2.769-2.689-7.256,0.082-10.022c2.772-2.765,7.229-2.758,9.953,0.013l11.997,12.165L73.451,39.151L73.451,39.151z"/></g></svg>' + resultString);

                    // Pass the codeId to the new button
                    $('#newButton').data('codeId', formData.codeId);
                } else {
                    // Handle error response
                    $('#modalContent').html('<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="122.879px" height="122.879px" viewBox="0 0 122.879 122.879" enable-background="new 0 0 122.879 122.879" xml:space="preserve"><g><path fill-rule="evenodd" clip-rule="evenodd" fill="#FF4141" d="M61.44,0c33.933,0,61.439,27.507,61.439,61.439 s-27.506,61.439-61.439,61.439C27.507,122.879,0,95.372,0,61.439S27.507,0,61.44,0L61.44,0z M73.451,39.151 c2.75-2.793,7.221-2.805,9.986-0.027c2.764,2.776,2.775,7.292,0.027,10.083L71.4,61.445l12.076,12.249 c2.729,2.77,2.689,7.257-0.08,10.022c-2.773,2.765-7.23,2.758-9.955-0.013L61.446,71.54L49.428,83.728 c-2.75,2.793-7.22,2.805-9.986,0.027c-2.763-2.776-2.776-7.293-0.027-10.084L51.48,61.434L39.403,49.185 c-2.728-2.769-2.689-7.256,0.082-10.022c2.772-2.765,7.229-2.758,9.953,0.013l11.997,12.165L73.451,39.151L73.451,39.151z"/></g></svg>' + response.data.message);
                }
            },
            error: function (xhr, status, error) {
                console.error('Error:', xhr.responseJSON.message); // Log error to console for debugging

                // Format error message
                var errorMessage = xhr.responseJSON.message;

                // Display error in modal
                $('#modalContent').html('<img src="' + svgPath + '" alt="Success" />' + errorMessage);
            },
            xhrFields: {
                withCredentials: true
            },
            crossDomain: true,
            rejectUnauthorized: false // Only for troubleshooting SSL issues
        });
    }

    // Handle form submission
    $('#submitForm').submit(function (event) {
        event.preventDefault(); // Prevent default form submission
        submitForm();
    });

    // Handle new button click
    $('#newButton').click(function () {
        var codeId = $(this).data('codeId');
        console.log('New button clicked with codeId:', codeId);
        // Perform desired action with codeId
        $.modal.close(); // Close the modal
    });

    // Link to open jQuery Modal popup
    $('a[rel="modal:open"]').click(function (event) {
        event.preventDefault();
        var modalTarget = $(this).attr('href');
        $(modalTarget).modal({
            showClose: false // Disable the close button
        });
    });
});
