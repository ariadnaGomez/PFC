function updateData() {
   alert("yay");
        $('#updating_gif').show();
        $.ajax({
            url: 'http://localhost:8082/downloader2/services/authors/',
            type: 'GET',
            success: function() {
                $('#updating_gif').hide();
                
            },
            error: function(data) {
                alert('woops!'); //or whatever
            }
        });
    
}

