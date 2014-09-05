!(function ($) {

    $.fn.interoMailchimpSubscribe = function () {

        return this.each(function () {
            var $form = $(this);
            if ($form.hasClass('popup')) {
                setTimeout(function () {
                    $.fn.custombox(document.getElementsByTagName('body')[0], {
                        url: '#' + $form.attr('id'),
                        overlay: true,
                        effect: 'sign',
                        eClose: '.interochimp-form-close'
                    });
                }, 1000);
            }

        });
    };


    $(function () {

        var data = {
            'action': 'interochimp_action',
            security: InteroChimpAjax.security
        };

        $('.interochimp-form').interoMailchimpSubscribe();

    });

})(jQuery);