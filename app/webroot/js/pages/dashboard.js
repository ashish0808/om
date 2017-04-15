$(document).ready(function() {
    $.get("getCasesForDashboard", function(data) {
        $('#pending_for_filing_div').html($(data).html(data).find("#pending_for_filing").html());
        $('#pending_for_filing_count_div').html($(data).html(data).find("#pending_for_filing_count").html());
        $('#pending_for_refiling_div').html($(data).html(data).find("#pending_for_refiling").html());
        $('#pending_for_refiling_count_div').html($(data).html(data).find("#pending_for_refiling_count").html());
        $('#pending_for_registration_div').html($(data).html(data).find("#pending_for_registration").html());
        $('#pending_for_registration_count_div').html($(data).html(data).find("#pending_for_registration_count").html());
    });

    $.get("getCasesWithPendingActions", function(data) {
        $('#cases_with_pending_actions_div').html($(data).html(data).find("#cases_with_pending_actions").html());
        $('#cases_with_pending_actions_count_div').html($(data).html(data).find("#cases_with_pending_actions_count").html());
    });

    $.get("getCasesWithNoNextDate", function(data) {
        $('#cases_with_no_next_date_div').html($(data).html(data).find("#cases_with_no_next_date").html());
        $('#cases_with_no_next_date_count_div').html($(data).html(data).find("#cases_with_no_next_date_count").html());
    });
});