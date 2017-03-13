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

    $("body").on('click', '.saveCasePayments', function() {

        paymentUpdated();

        var btnClicked = $(this).val();
        $("#casePaymentsHiddenSubmit").val(btnClicked);

        $.ajax({
            url: $('#casePayments').attr('action'),
            type: "POST",
            data: $('#casePayments').serialize(),
            dataType:'json',
            success: function(data) {

                var nextPage = 'remarks';
                processAfterSaveResponse(data, btnClicked, nextPage);
            }
        });

        return false;
    });

    $("body").on('click', '.deletePayment', function() {

        if (confirm('Are you sure you want to delete this payment?')) {
            var deleteAction = $(this).attr('id');
            $.ajax({
                url: deleteAction,
                type: "POST",
                data: { 'action' : 'delete'},
                dataType:'json',
                success: function(data) {

                    if(data.status == 'success') {

                        var nextPage = 'feesInformation';
                        showEditPage(nextPage);
                    }
                }
            });
        }

        return false;
    });

    $("body").on('click', '.editCasePayment, .editCaseFiling', function() {

        var pageTitle = $(this).attr('pageTitle');
        var pageName = $(this).attr('pageName');
        $.ajax({
            type: "POST",
            url: pageName,
            data: false,
            beforeSend: function( xhr ) {
                showLoading();
            },
            success: function(data) {

                hideLoading();
                $('#projectModal .modal-title').html(pageTitle);
                $('#projectModal .modal-body').html(data);
                $('#projectModal').modal('show');
            }
        });
    });

    $("body").on('click', '.updateCasePayment', function() {

        paymentUpdated();

        $.ajax({
            url: $('#editCasePayments').attr('action'),
            type: "POST",
            data: $('#editCasePayments').serialize(),
            dataType:'json',
            success: function(data) {

                $('.editBasicDetailsError').hide();
                if(data.status=='error') {

                    $.each(data.message, function (i, v) {

                        if($('#edit_error_'+i).length > 0) {

                            $('#edit_error_'+i).html(v);
                            $('#edit_error_'+i).show();
                        }
                    });
                } else if(data.status == 'success') {

                    $('#projectModal').modal('hide');
                    var nextPage = 'feesInformation';
                    showEditPage(nextPage);
                }
            }
        });

        return false;
    });

    $("body").on('click', '.saveRemarks', function() {

        var btnClicked = $(this).val();
        $("#remarksHiddenSubmit").val(btnClicked);

        $.ajax({
            url: $('#editRemarks').attr('action'),
            type: "POST",
            data: $('#editRemarks').serialize(),
            dataType:'json',
            success: function(data) {

                var nextPage = $('#fifthStep').html();
                processAfterSaveResponse(data, btnClicked, nextPage);
            }
        });

        return false;
    });

    $("body").on('click', '.saveCaseFiling', function() {

        ajaxFileUpload();

        return false;
    });

    $("body").on('click', '.updateCaseFiling', function() {

        var file_data = $("#EditClientCaseMainFile").prop("files")[0];
        var form_data = new FormData();

        form_data.append("data[CaseFiling][id]", $("#EditCaseFilingId").val());
        form_data.append("data[CaseFiling][filing_date]", $("#EditCaseFilingFilingDate").val());
        form_data.append("data[CaseFiling][filing_type]", $("#EditCaseFilingFilingType").val());
        form_data.append("data[CaseFiling][filing_no]", $("#EditCaseFilingFilingNo").val());
        form_data.append("file", file_data);

        $.ajax({
            url: $('#editCaseFilingForm').attr('action'),
            dataType:'json',
            cache:false,
            contentType: false,
            processData: false,
            data: form_data,
            type: "POST",
            success: function(data) {

                $('.editBasicDetailsError').hide();
                if(data.status=='error') {

                    $.each(data.message, function (i, v) {

                        if($('#edit_error_'+i).length > 0) {

                            $('#edit_error_'+i).html(v);
                            $('#edit_error_'+i).show();
                        }
                    });
                } else if(data.status == 'success') {

                    $('#projectModal').modal('hide');
                    var nextPage = $('#fifthStep').html();
                    showEditPage(nextPage);
                }
            }
        });

        return false;
    });

    $("body").on('click', '.saveCaseRegistration', function() {

        $.ajax({
            url: $('#caseRegistrationForm').attr('action'),
            type: "POST",
            data: $('#caseRegistrationForm').serialize(),
            dataType:'json',
            success: function(data) {

                $('.editBasicDetailsError').hide();
                if(data.status=='error') {

                    $.each(data.message, function (i, v) {

                        if($('#register_error_'+i).length > 0) {

                            $('#register_error_'+i).html(v);
                            $('#register_error_'+i).show();
                        }
                    });
                } else if(data.status == 'success') {

                    var nextPage = $('#fifthStep').html();
                    showEditPage(nextPage);
                }
            }
        });

        return false;
    });

    $("body").on('click', '.updateCaseEssentials', function() {

        showLoading();
        $.ajax({
            url: $('#formEssentialWorks').attr('action'),
            type: "POST",
            data: $('#formEssentialWorks').serialize(),
            dataType:'json',
            success: function(data) {

                hideLoading();
            }
        });

        return false;
    });

    $("body").on('click', '.addDecision', function() {

        showLoading();
        $.ajax({
            url: $('#addDecision').attr('action'),
            type: "POST",
            data: $('#addDecision').serialize(),
            dataType:'json',
            success: function(data) {

                $('.editBasicDetailsError').hide();
                if(data.status=='error') {

                    $.each(data.message, function (i, v) {

                        if($('#error_'+i).length > 0) {

                            $('#error_'+i).html(v);
                            $('#error_'+i).show();
                        }
                    });
                } else if(data.status == 'success') {

                    var nextPage = 'caseDecision';
                    showEditPage(nextPage);
                }

                hideLoading();
            }
        });

        return false;
    });
});

function ajaxFileUpload() {

    var file_data = $("#ClientCaseMainFile").prop("files")[0];
    var form_data = new FormData();

    form_data.append("data[CaseFiling][filing_date]", $("#CaseFilingFilingDate").val());
    form_data.append("data[CaseFiling][filing_type]", $("#CaseFilingFilingType").val());
    form_data.append("data[CaseFiling][filing_no]", $("#CaseFilingFilingNo").val());
    form_data.append("file", file_data);

    $.ajax({
        url: $('#caseFilingForm').attr('action'),
        dataType:'json',
        cache:false,
        contentType: false,
        processData: false,
        data: form_data,
        type: "POST",
        success: function(data) {

            $('.editBasicDetailsError').hide();
            if(data.status=='error') {

                $.each(data.message, function (i, v) {

                    if($('#error_'+i).length > 0) {

                        $('#error_'+i).html(v);
                        $('#error_'+i).show();
                    }
                });
            } else if(data.status == 'success') {

                var nextPage = $('#fifthStep').html();
                showEditPage(nextPage);
            }
        }
    });

    return false;
}

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