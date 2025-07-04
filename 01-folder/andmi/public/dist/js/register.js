    $('#jshshir').on('input', function() {
        if ($(this).val().length !== 14) {
            $('#jshshir-error').show();
        } else {
            $('#jshshir-error').hide();
        }
    });