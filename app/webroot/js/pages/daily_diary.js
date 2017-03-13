$(document).ready(function() {

    $("body").on('click', '.updateCaseProceeding', function() {
        $.ajax({
            url: $('#editCaseProceedingForm').attr('action'),
            cache: false,
            processData: false,
            data: $('#editCaseProceedingForm').serialize(),
            type: "POST",
            success: function(data) {
                $('.editBasicDetailsError').hide();
                if (data.status == 'error') {
                    $.each(data.message, function(i, v) {
                        if ($('#edit_error_' + i).length > 0) {

                            $('#edit_error_' + i).html(v);
                            $('#edit_error_' + i).show();
                        }
                    });
                } else {
                    $('#projectModal').modal('hide');
                    var formData = new FormData();
                    formData.append('data[CaseProceeding][date_of_hearing]', data);
                    $.ajax({
                        type: "POST",
                        cache: false,
                        processData: false,
                        contentType: false,
                        url: '/om/CaseProceedings/',
                        data: formData,
                        success: function(html) {
                            hideLoading();
                            $('#content').html(html);
                        }
                    });
                }
            }
        });
        return false;
    });

    $("body").on('click', '.editCaseProceeding', function() {

        var pageTitle = $(this).attr('pageTitle');
        var pageName = $(this).attr('pageName');
        $.ajax({
            type: "GET",
            url: pageName,
            beforeSend: function(xhr) {
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

});
