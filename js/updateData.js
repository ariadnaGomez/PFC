function updateData() {
    $('#updating_gif').show();

    $.ajax({
        url: '../html/updateData.php',
        type: 'GET',
        success: function(data) {
            $('#updating_gif').hide();
            if (data) {
                $('#updated').show();
                $('#updated_not').hide();
            } else {
                $('#updated_not').show();
                $('#updated').hide();
            }

        },
        error: function() {
            $('#updating_gif').hide();
            $('#updated_not').show();
            $('#updated').hide();
        }
    });


}

