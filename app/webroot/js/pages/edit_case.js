
function toggleIcon(e) {


    $(e.target)
        .prev('.widget-header')
        .find(".more-less")
        .toggleClass('icon-plus icon-minus');

    $('.collapse').not(e.target).removeClass('in')
        .prev('.widget-header').find(".more-less").removeClass('icon-minus').addClass('icon-plus');
}

$(document).ready(function(){

    $('#'+$('#getDefaultOpenTab').html()).collapse({
        toggle: true
    });

    $('.panel-group').on('hidden.bs.collapse', toggleIcon);
    $('.panel-group').on('shown.bs.collapse', toggleIcon);
});