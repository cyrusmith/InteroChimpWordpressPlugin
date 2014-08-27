!(function ($) {

    $(function () {

        var data = {
            'action': 'interochimp_action',
            security : InteroChimpAjax.security,
            'whatever': 1234
        };

        alert(InteroChimpAjax.ajaxurl);

        $.post(InteroChimpAjax.ajaxurl, data, function (response) {
            alert('Got this from the server: ' + response);
        });

    });

})(jQuery);