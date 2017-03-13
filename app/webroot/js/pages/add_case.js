function changeClientType(client_type)
{
    $('.customRequiredAppellant').each(function() {
        $(this).addClass('hide');
    });

    $('.customRequired').each(function() {
        $(this).addClass('hide');
    });

    if(client_type == 'respondent') {

        $('.customRequired').each(function() {
            $(this).removeClass('hide');
        });
        $('.fieldForAppellant').addClass('hide');
    } else if(client_type == 'petitioner') {

        $('.customRequiredAppellant').each(function() {
            $(this).removeClass('hide');
        });
        $('.fieldForAppellant').removeClass('hide');
    }
}

function getFileNumberField(isExistingCase)
{
    if(isExistingCase==1) {

        $('.fileNumber').removeClass('hide');
    } else {

        $('.fileNumber').addClass('hide');
    }
}

$(document).ready(function(){

    $('.select2').css('width','100%').select2();

    $("body").delegate("#ClientCaseClientType", "change", function(event) {

        var client_type = $(this).val();
        changeClientType(client_type)
    });

    $("body").delegate(".isExistingCase", "change", function(event) {

        var isExistingCase = $("input[name='data[ClientCase][is_existing]']:checked").val();
        getFileNumberField(isExistingCase)
    });

    var client_type = $("#ClientCaseClientType").val();
    changeClientType(client_type)

    var isExistingCase = $("input[name='data[ClientCase][is_existing]']:checked").val();
    getFileNumberField(isExistingCase);
});