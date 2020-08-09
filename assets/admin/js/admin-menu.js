;(function ($) {
    $(".wp-list-table.toplevel_page_tmplugin").on('click', '.delete .submitdelete', function (e) {
        e.preventDefault();

        // Fetch the post id
        const id = $(this).data('id');

        const self = $(this);

        const data = {
            action: tmplugin.action,
            id: id,
            _wpnonce: tmplugin.nonce
        };

        $.post(tmplugin.ajaxUrl, data, function (response) {
            console.log(response);
        })
            .fail(function (error) {
                console.log(error);
            })
            .done(function () {
                self.closest('tr')
                    .css('background-color', 'red')
                    .hide(400, function () {
                        $(this).remove();
                    });
            });

    });
})(jQuery);
