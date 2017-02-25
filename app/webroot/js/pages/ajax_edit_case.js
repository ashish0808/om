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

    $("body").on('blur', '#casePayments :input', function() {

        paymentUpdated();
    });

    paymentUpdated();
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

function paymentUpdated()
{
    var amountPaid = $('#CasePaymentAmount').val();

    if($.isNumeric(amountPaid) && amountPaid > 0) {

        $('.paymentRequired').removeClass('hide');
    } else {

        $('.paymentRequired').addClass('hide');
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
