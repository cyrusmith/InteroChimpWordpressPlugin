!(function ($) {

    function LeadPopup(element, options) {

        this.element = $(element);
        this.cookieKey = null;
        var elId = this.element.attr('id');
        if (!elId) {
            this.__isMyId = true;
            this.element.attr('id', 'interosite-leadpopup-' + (LeadPopup.counter++));
        }
        else {
            this.cookieKey = LeadPopup.COOKIE_KEY + elId;
        }
        this.options = $.extend({}, LeadPopup.DEFAULTS);
        if ($.isPlainObject(options)) {
            this.options = $.extend(this.options, options);
        }
    }

    LeadPopup.counter = 1;

    LeadPopup.DEFAULTS = {
        timeout: 0,
        closeSelector: '.close'
    };

    LeadPopup.COOKIE_KEY = "interosite_lead_popup";
    LeadPopup.EVENT_CLOSE = "interosite_lead_popup_close";
    LeadPopup.FOREVER = 1000;

    LeadPopup.prototype = {

        init: function () {

            if (this.checkShown()) return;

            setTimeout($.proxy(function () {
                if (this.checkShown()) return;
                this.open();
            }, this), this.options.timeout);

        },

        checkShown: function () {
            if (this.cookieKey == null) return false;
            var isShown = $.cookie(this.cookieKey);
            return isShown === true;
        },

        open: function () {
            $.fn.custombox(document.getElementsByTagName('body')[0], {
                url: '#' + this.element.attr('id'),
                overlay: true,
                effect: 'sign',
                eClose: this.options.closeSelector,
                close: $.proxy(function() {
                    this.element.triggerHandler(LeadPopup.EVENT_CLOSE)
                }, this)
            });
            if (this.cookieKey != null) {
                $.cookie(this.cookieKey, true, {
                    expires: LeadPopup.FOREVER
                });
            }
        },

        close: function() {
            $.fn.custombox('close');
        },

        schedule: function (days) {
            days = parseInt(days);
            if (!days) return;
            $.cookie(LeadPopup.COOKIE_KEY, true, {
                expires: days
            });
        },

        destroy: function () {
            if (this.__isMyId) {
                this.element.attr('id', null);
            }
            this.element = null;
        }

    };

    /**
     * Expose jquery plugin
     * @param action String action, init by default
     */
    $.fn.interoLeadPopup = function (action, param1) {

        $.cookie.json = true;

        return this.each(function () {
            var $el = $(this);
            var popup = $el.data('interosite-leadpopup');
            if (typeof action === "undefined" || action == "init") {
                if (popup instanceof LeadPopup) {
                    popup.destroy();
                }
                popup = new LeadPopup(this, param1 || null);
                popup.init();
                $el.data('interosite-leadpopup', popup);
            }
            else {
                if (!popup) return;
                switch (action) {
                    case "open":
                        popup.open();
                        break;

                    case "close":
                        popup.close();
                        break;

                    case "schedule":
                        if (typeof param1 === "undefined") break;
                        popup.schedule(param1);
                        break;

                    case "destroy":
                        popup.destroy();
                        break;
                }

            }

        });
    }

})(jQuery);