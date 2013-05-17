function updateData() {
    $('#updating_gif').show();

    $.ajax({
        url: '../html/updateData.php',
        type: 'GET',
        success: function(data) {
            $('#updating_gif').hide();
            if (data) {
                $('#updated').show();
                $('#not_updated').hide();
            } else {
                $('#updated_not').show();
                $('#updated').hide();
            }

        },
        error: function() {
            $('#updating_gif').hide();
            $('#not_updated').show();
            $('#updated').hide();
        }
    });


}

