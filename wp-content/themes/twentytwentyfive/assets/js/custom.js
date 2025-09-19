
jQuery(document).on('click', '.ics-calendar-month-grid tbody td', function(e) {
    // Check if this <td> has class "has_events"
    if (jQuery(this).hasClass('has_events')) {
        // Prevent click
        e.stopPropagation();
        return false;
    }

    // Otherwise, run your custom action
    let date = jQuery(this).data('date'); // if your plugin sets data-date
    alert("Clicked date: " + date);
})



jQuery(function() {
    var today = new Date();

    jQuery("#date_start").datetimepicker({
        minDate: today, // Disable past dates
        dateFormat: "yy-mm-dd",
        timeFormat: "HH:mm:ss",
        onSelect: function(selectedDate) {
            var start = jQuery(this).datetimepicker('getDate');
            jQuery("#date_end").datetimepicker("option", "minDate", start); // End date >= start date
        }
    });

    jQuery("#date_end").datetimepicker({
        minDate: today, // Disable past dates
        dateFormat: "yy-mm-dd",
        timeFormat: "HH:mm:ss"
    });
});
