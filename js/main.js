!(function ($) {

    $(function () {

        $('#interoSubscribe1').each(function () {

            var $this = $(this),
                $form = $this.find('form:eq(0)'),
                $name = $form.find('input[name="subscribe_name"]'),
                $email = $form.find('input[name="subscribe_email"]'),
                $submit = $form.find('button[type="submit"]');

            $this.interoLeadPopup('init', {
                timeout: 1000,
                closeSelector: '.interochimp-form-close'
            });

            $this.on('interosite_lead_popup_close', function (e) {
                $(this).interoLeadPopup('schedule', 5);
            });

            $form.submit(function () {
                return false;
            });

            var data = {
                'action': 'interochimp_action',
                security: InteroChimpAjax.security
            };





        });

    });

})(jQuery);