function searchBNE(searchBy, offset) {
    var input = $('#searchInput').val();
    if (input === "") {
        $("#searchTitle").html('Input must not be empty');

    } else {
        $('#loading_gif').show();
        $.ajax({
            url: 'searchBNE.php',
            type: 'GET',
            data: {searchBy: searchBy, input: input, offset: offset},
            success: function(data) {
                $('#loading_gif').hide();
                var result = jQuery.parseJSON(data);
                createTable(result["data"], offset);
                createNextButton(result["nextButton"], result["prevButton"], searchBy);
            },
            error: function(data) {
                alert('woops!'); //or whatever
            }
        });
    }
}
function createTable(result, offset) {
    $('#content').html('<table cellpadding="0" cellspacing="0"><thead><tr><th></th><th>Title</th></tr></thead><tbody id="tbody">');
    var indice = 0;
    for (indice in result) {
        var showIndex = parseInt(indice) + parseInt(1);
        var format = (indice % 2 === 0) ? 'dark' : 'light';
        $('#tbody').append('<tr class="' + format + '"><td>' + showIndex +
                '</td><td>' + result[indice]['?title']['label'] + '</td></tr>');
    }
    $("td.authorName").click(function() {
        searchDBPedia($(this).text());
    });
}

function createNextButton(hasNext, hasPrevious, searchBy){
    $('#content').append('<div class="pagination"><ul><li class="prev"><div id="prevlink">&laquo; Previous</a></li><li class="splitter">&hellip;</li><li class="next"><div id="nextlink">Next &raquo;</a></li></ul></div>');
    if (!hasNext){
        $('#nextlink').addClass("activelink");
    } else {
        $('#nextlink').addClass("link1");
    }
    
    if (!hasPrevious){
        $('#prevlink').addClass("activelink");
    } else {
        $('#prevlink').addClass("link1");
    }
    $("#prevlink").click(function() {
        searchBNE(searchBy, 'prev')
    });
    $("#nextlink").click(function() {
        searchBNE(searchBy, 'next')
    });
}

