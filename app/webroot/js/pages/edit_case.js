function toggleIcon(e) {

    $(e.target)
        .prev('.widget-header')
        .find(".more-less")
        .toggleClass('icon-plus icon-minus');

    $('.collapse').not(e.target).removeClass('in')
        .prev('.widget-header').find(".more-less").removeClass('icon-minus').addClass('icon-plus');
}

$(document).ready(function(){

    showLoading();

    $("body").on('hidden.bs.collapse', '.panel-group', toggleIcon);
    $("body").on('shown.bs.collapse', '.panel-group', toggleIcon);

    var editUrl = $('#ajaxEdit').html();

    $.ajax({
        type: "GET",
        url: editUrl,
        success: function(html) {

            hideLoading();

            $('#editPage-cnt').html(html)

            $('#'+$('#getDefaultOpenTab').html()).collapse({
                toggle: true
            });
        }
    });
});