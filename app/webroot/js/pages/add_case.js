function changeClientType(client_type)
{
    if(client_type == 'petitioner') {

        $('.customRequired').each(function() {
            $(this).removeClass('hide');
        });
    } else {

        $('.customRequired').each(function() {
            $(this).addClass('hide');
        });
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
    getFileNumberField(isExistingCase)

    /*$('#saveQuickClient').on('click', function(){
        $.ajax({
            url: $('#addQuickClient').attr('action'),
            type:"POST",
            data: $('#addQuickClient').serialize(),
            dataType:'json',
            success: function(data) {
                $('.addQuickClientError').hide();
                if(data.status=='error') {

                    $.each(data.message, function (i, v) {

                        if($('#error_'+i).length > 0) {

                            $('#error_'+i).html(v);
                            $('#error_'+i).show();
                        }
                    });
                } else if(data.status=='success') {

                    var $el = $("#ClientCaseClientId");
                    $el.empty(); // remove old options
                    $.each(data.clients, function(key,value) {
                        $el.append($("<option></option>")
                            .attr("value", key).text(value));
                    });

                    $('#myModal').modal('hide');
                }
            }
        });
    });*/
});