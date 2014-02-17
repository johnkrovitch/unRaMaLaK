/**
 * Creates bootstrap alert
 *
 */
var AlertManager = {
    alerts: [],
    container: '',
    removeTime: 0,

    init: function (options) {
        var defaultOptions = {
            containerSelector: '.alert-container',
            removeTime: 5000
        };
        if (options) {
            options = $.merge(defaultOptions, options);
        }
        else {
            options = defaultOptions;
        }
        this.container = $(options.containerSelector);
        this.removeTime = options.removeTime;
        // find existing alerts
        this.bindAlerts();

        if (this.removeTime > 0) {
            // remove them on count
            if (this.alerts.length) {
                this.launchCounter();
            }
        }
        if (!this.container.length) {
            throw new Error('Alert container not found');
        }
    },

    addAlert: function (message, type) {
        var notificationTemplate = '<div class="alert alert-%type%">%message%&nbsp;<button type="button" class="close">×</button></div>';
        var notification = notificationTemplate.replace('%type%', type).replace('%message%', message);

        this.container.append($(notification));
        this.bindAlerts();
        this.launchCounter();
    },

    bindAlerts: function () {
        this.findAlerts();

        if (this.alerts.length) {
            this.alerts.find('button.close').on('click', function () {
                $(this).parents('div.alert').remove();
            });
        }
    },

    findAlerts: function () {
        this.alerts = $('div.alert');
    },

    launchCounter: function () {
        var alerts = this.alerts;
        var removeTime = this.removeTime;

        if (removeTime > 0) {
            setTimeout(function () {
                alerts.fadeOut('fast', function () {
                    $(this).remove();
                });
            }, removeTime);
        }
    }
};
