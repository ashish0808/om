function toggleIcon(e) {

    $(e.target)
        .prev('.widget-header')
        .find(".more-less")
        .toggleClass('icon-plus icon-minus');

    $('.collapse').not(e.target).removeClass('in')
        .prev('.widget-header').find(".more-less").removeClass('icon-minus').addClass('icon-plus');
}

function showEditPage(nextPage)
{
    var editUrl = $('#ajaxEdit').html();

    if(nextPage !== undefined && nextPage !== null) {

        editUrl = editUrl+'?defaultCollapseIn='+nextPage;
    }

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
}

$(document).ready(function(){

    showLoading();

    $("body").on('hidden.bs.collapse', '.panel-group', toggleIcon);
    $("body").on('shown.bs.collapse', '.panel-group', toggleIcon);

    showEditPage();

    $("body").on('click', '.saveBasicDetails', function() {

        var btnClicked = $(this).val();
        $("#basicDetailsHiddenSubmit").val(btnClicked);

        $.ajax({
            url: $('#editBasicDetails').attr('action'),
            type: "POST",
            data: $('#editBasicDetails').serialize(),
            dataType:'json',
            success: function(data) {

                var nextPage = 'clientInformation';
                processAfterSaveResponse(data, btnClicked, nextPage);
            }
        });

        return false;
    });

    $("body").on('click', '.saveClientInfo', function() {

        var partyType = $('#ClientCasePartyType').val();

        if(partyType=='Company') {

            $('.clientField').find('input:text').val('');
        } else if(partyType=='Private Client') {

            $('#ClientCaseUserCompaniesId').val('');
            $('.companyField').find('input:text').val('');
        }

        var btnClicked = $(this).val();
        $("#clientInfoHiddenSubmit").val(btnClicked);

        $.ajax({
            url: $('#editClientInfo').attr('action'),
            type: "POST",
            data: $('#editClientInfo').serialize(),
            dataType:'json',
            success: function(data) {

                var nextPage = 'feesInformation';
                processAfterSaveResponse(data, btnClicked, nextPage);
            }
        });

        return false;
    });
});

function processAfterSaveResponse(data, btnClicked, nextPage)
{
    $('.editBasicDetailsError').hide();
    if(data.status=='error') {

        $.each(data.message, function (i, v) {

            if($('#error_'+i).length > 0) {

                $('#error_'+i).html(v);
                $('#error_'+i).show();
            }
        });
    } else if(data.status=='success') {

        if(btnClicked=='next') {

            showEditPage(nextPage);
        } else {

            window.location.replace($('#redirectIncompleteForm').html());
        }
    }
}