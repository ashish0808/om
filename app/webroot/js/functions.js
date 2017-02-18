jQuery(function($) {
    /*jQuery('.date-picker').datepicker({
        autoclose: true,
        todayHighlight: true
    })
    //show datepicker when clicking on the icon
    .next().on(ace.click_event, function(){
            jQuery(this).prev().focus();
    });*/


    $('body').delegate(".date-picker", 'focus', function(){
        $(this).datepicker({
            autoclose: true,
            todayHighlight: true
        }).next().on(ace.click_event, function(){
            jQuery(this).prev().focus();
        });
    });

    jQuery('#timepicker1').timepicker({
        minuteStep: 1,
        showSeconds: true,
        showMeridian: false
    }).next().on(ace.click_event, function(){
        jQuery(this).prev().focus();
    });
});

function showLoading() {
    $('.loading-image, .load-lightbox').fadeIn();
}

function hideLoading() {
    $('.loading-image, .load-lightbox').fadeOut();
}