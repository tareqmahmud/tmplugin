;(function ($) {
    // After form submit
    $("#tmplugin-enquiry-form").on('submit', function (e) {
        // Prevent default submit
        e.preventDefault();

        // Fetch all the form data
        const data = $(this).serialize();

        console.log(data);

        // Get ajax url from the php
        const ajaxUrl = tmplugin.ajaxUrl;

        // Fire a ajax request to the php
        $.post(ajaxUrl, data, function (response) {
            console.log(response);
        })
            .fail(function () {
                console.log("Something went wrong")
            });
    });
})(jQuery);
