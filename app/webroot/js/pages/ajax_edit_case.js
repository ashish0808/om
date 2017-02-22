$(document).ready(function(){
    var partyType = $('#ClientCasePartyType').val();
    showPartTypeFields(partyType)
    $("body").on('change', '#ClientCasePartyType', function() {

        var partyType = $(this).val();
        showPartTypeFields(partyType)
    });

    /*changePaymentType($('#ClientCasePaymentStatus').val())
    $("body").on('change', '#ClientCasePaymentStatus', function() {

        changePaymentType($(this).val())
    });*/

    $("body").on('click', '.addCasePayment', function() {

        var pageTitle = $(this).attr('pageTitle');
        var pageName = $(this).attr('pageName');
        $(".modal .modal-title").html(pageTitle);
        $(".modal .modal-body").html("Content loading please wait...");
        $(".modal").modal("show");
        $(".modal .modal-body").load(pageName);
    });
});

function showPartTypeFields(partyType) {

    $('.companyField').addClass('hide');
    $('.clientField').addClass('hide');

    if(partyType=='Company') {

        $('.companyField').removeClass('hide');
    } else if(partyType=='Private Client') {

        $('.clientField').removeClass('hide');
    }
}

/*
function changePaymentType(payment_type)
{
    if(payment_type == 'nil') {

        $('.paymentRequiredField').addClass('hide');
    } else {

        $('.paymentRequiredField').removeClass('hide');
    }
}*/
