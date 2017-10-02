$(document).ready(function(){

    var client_type = $("#ClientCaseClientType").val();
    changeClientType(client_type)

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

    $("body").delegate(".isCaseRegistered", "change", function() {

        caseRegistrationFields();
    });

    $("body").delegate(".certifiedCopyRequired", "change", function() {

        certifiedCopyRequiredFields();
    });

    if($('#ClientCaseCaseNumber').val()=='') {

        $('.caseNumberRelatedFields').addClass('hide');
    } else {

        $('.caseNumberRelatedFields').removeClass('hide');
    }

    paymentUpdated();
    caseRegistrationFields();
    certifiedCopyRequiredFields();

    var isExistingCase = $("input[name='data[ClientCase][is_existing]']:checked").val();
	
	if(isExistingCase === undefined) {
		
		var isExistingCase = $(".hiddenCaseType").val();
	}
	
    getFileNumberField(isExistingCase);
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

function caseRegistrationFields()
{
    var isCaseRegistered = $("input[name='data[ClientCase][is_registered]']:checked").val();

    if(isCaseRegistered==1) {

        $('.registerCaseNumberField').removeClass('hide');
        $('.objectionCaseNumberField').addClass('hide');
    } else {

        $('.objectionCaseNumberField').removeClass('hide');
        $('.registerCaseNumberField').addClass('hide');
    }
}

function certifiedCopyRequiredFields()
{
    var isCertifiedCopyRequired = $(".certifiedCopyRequired").val();

    if(isCertifiedCopyRequired==1) {

        $('.requiredCertifiedCopy').removeClass('hide');
    } else {

        $('.requiredCertifiedCopy').addClass('hide');
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
