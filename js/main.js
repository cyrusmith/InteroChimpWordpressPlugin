!(function ($) {

    $(function () {

        var isProcessing = false;

        function startProcessing() {
            isProcessing = true;
            disableFrom(true);
            var height = $('#interoSubscribe1 button[type="submit"]').parent().get(0).clientHeight;
            $('#interoSubscribe1 button[type="submit"]').parent().hide();
            $('#interoSubscribe1 .emailloader').show();
            $('#interoSubscribe1 .emailloader').css('height', height + 'px');
        }

        function stopProcessing() {
            isProcessing = false;
            disableFrom(false);
            $('#interoSubscribe1 button[type="submit"]').parent().show();
            $('#interoSubscribe1 .emailloader').hide();
        }

        function disableFrom(isDisabled) {
            $('#interoSubscribe1 input[name="subscribe_name"]').prop('disabled', isDisabled);
            $('#interoSubscribe1 input[name="subscribe_email"]').prop('disabled', isDisabled);
            $('#interoSubscribe1 button[type="submit"]').prop('disabled', isDisabled);
        }

        var $subscribeContainer = $('#interoSubscribe1');

        $subscribeContainer.interoLeadPopup('init', {
            timeout: 1000,
            closeSelector: '.interochimp-form-close'
        });

        $subscribeContainer.on('interosite_lead_popup_close', function (e) {
            if (!isProcessing) {
                $(this).interoLeadPopup('schedule', 5);
            }

        });

        $(document).on('submit', '#interoSubscribe1 form', function () {
            return false;
        });

        $(document).on('focus', '#interoSubscribe1 input[name="subscribe_email"]', function () {
            $(this).parent().removeClass('has-error');
        });

        $(document).on('click', '#interoSubscribe1 button[type="submit"]', function () {

            if (isProcessing) return;

            var $name = $('#interoSubscribe1 input[name="subscribe_name"]'),
                $email = $('#interoSubscribe1 input[name="subscribe_email"]'),
                $listId = $('#interoSubscribe1 input[name="subscribe_list_id"]'),
                thankyou = $('#interoSubscribe1 input[name="subscribe_thankyou"]').val();

            var email = $email.val().trim();

            if (!email) {
                $email.parent().addClass('has-error');
                return;
            }

            var data = {
                'action': 'interochimp_action',
                security: InteroChimpAjax.security,
                name: $name.val(),
                email: $email.val(),
                listId: $listId.val()
            };

            startProcessing();
            $.ajax({
                type: "POST",
                url: InteroChimpAjax.ajaxurl,
                data: data,
                success: function (response) {
                    if (response.status == "OK") {
                        noty({text: thankyou});
                    }
                    else {
                        $(this).interoLeadPopup('schedule', 5);
                    }
                },
                error: function () {
                    $(this).interoLeadPopup('schedule', 5);
                },
                complete: function () {
                    isProcessing = false;
                    stopProcessing();
                    $subscribeContainer.interoLeadPopup('close');
                },
                dataType: 'json'
            });
        });


    });

})(jQuery);