/**
 * calendar.js
 * custom scripts for calendar widget (Ajax)
 */

var t3calendar = {};

t3calendar.ajax = function (url, parentObject) {
    jQuery('#loader').addClass('loading');
    jQuery.ajax({
        url: url,
        context: parentObject
    })
        .done(function (data) {
            this.html(data);
            jQuery('#loader').removeClass('loading');
        })
};
jQuery('.tx-t3calendar-widget ').on('click', '.navigation.ajax a', function (e) {
    e.preventDefault();
    var element = jQuery(this),
        calendarId = element.data('calendarid'),
        parentObject = jQuery('#' + calendarId);
    t3calendar.ajax(element.attr('href'), parentObject);
});

