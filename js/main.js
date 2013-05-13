
$(document).ready(function() {

    var autoComplete = false;
    $("#go").click(function() {
        var authorName = $('#searchInput').val();
        searchDBPedia(authorName, autoComplete);
    });

    $('#searchInput').keypress(function(event) {
        if (event.keyCode === 13) {
            var authorName = $('#searchInput').val();
            searchDBPedia(authorName, autoComplete);
        } else {
            if ($(this).val().length === 0) {
                if (event.keyCode !== 8) {
                    event = event || window.event;
                    var charCode = event.keyCode || event.which;
                    var charStr = String.fromCharCode(charCode);
                    $(function() {
                        var result;
                        
                        $.ajax({
                            url: 'autocomplete.php',
                            data: {char: charStr},
                            type: "GET",
                            success: function(data) {
                                result = jQuery.parseJSON(data);
                                
                                $("#searchInput").autocomplete({
                                    source: result,
                                    autofocus: true,
                                    select: function(){
                                        autoComplete = true;
                                    }
                                });
                                $("#searchInput").autocomplete("enable");
                            }

                        });
                    });

                } else {
                    $("#searchInput").autocomplete("disable");
                }
            }
        }
    });

    $("td.authorName").click(function() {
        searchDBPedia($(this).text());
    });
    $("#update_link").click(function() {
        updateData();
    });
});

