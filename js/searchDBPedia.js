function searchDBPedia(authorName, autocomplete) {
    if (authorName === "") {
        $("#searchTitle").html('Input must not be empty');

    } else {

        $('#loading_gif').show();
        $.ajax({
            url: 'searchDBPedia.php',
            type: 'GET',
            data: {authorName: authorName},
            success: function(data) {
                $('#loading_gif').hide();
                var result = jQuery.parseJSON(data);
                if (result['data']) {
                    createAuthorInfo(result['data']);
                    if (result['books'].length > 0) {
                        createBookInfo(result['books']);
                    }
                    if (result['influences'].length > 0) {
                        createInfluencesInfo(result['influences']);
                    }
                } else {
                    alert('No matches found.');
                }
            },
            error: function(data) {
                alert('woops!'); //or whatever
            }
        });
    }
}

function createAuthorInfo(data) {

    var birthDate = (data['?birthDate']['label']) ?
            data['?birthDate']['label'] : data['?birthDate2']['label'];

    var birthPlace = (data['?birthPlace']['label']) ?
            data['?birthPlace']['label'] : data['?birthPlace2']['label'];
    birthPlace = (birthPlace) ?
            birthPlace : data['?birthPlace3']['label'];

    var deathDate = (data['?deathDate']['label']) ?
            data['?deathDate']['label'] : data['?deathDate2']['label'];

    var deathPlace = (data['?deathPlace']['label']) ?
            data['?deathPlace']['label'] : data['?deathPlace2']['label'];
    deathPlace = (deathPlace) ?
            deathPlace : data['?deathPlace3']['label'];

    $("#content").html('<h1>' + data['?name']['label'] + '</h1>');
    $("#content").append('<p>' + data['?abstract']['label']);
    if (data['?photo']['label']) {
        $('#content').append('<img class="imgl" src="' + data['?photo']['label'] + '" alt="" />');
    }
    $('#content').append('<div id=column><div class="subnav"><h2>Biography Data</h2><ul><li><div>Birth Date</div><ul><li>'
            + birthDate + '</li></ul></li><li><div>Birth Place</div><ul><li>'
            + birthPlace + '</li></ul></li><li><div>Death Date</div><ul><li>'
            + deathDate + '</li></ul></li><li><div>Death Place</div><ul><li>'
            + deathPlace + '</li></ul></li></ul></div></div>');

}

function createBookInfo(data) {
    $('#content').append('<table cellpadding="0" cellspacing="0"><thead><tr><th></th><th>Title</th></tr></thead><tbody id="tbody">');
    var indice = 0;
    for (indice in data) {
        var showIndex = parseInt(indice) + parseInt(1);
        var format = (indice % 2 === 0) ? 'dark' : 'light';
        $('#tbody').append('<tr class="' + format + '"><td>' + showIndex +
                '</td><td>' + data[indice]['?title']['label'] + '</td></tr>');
    }
}

function createInfluencesInfo(data) {
    $("#content").append('<h2> Influences </h2>');
    $('#content').append('<table cellpadding="0" cellspacing="0"><thead><tr><th></th><th>Title</th><th>Author</th></tr></thead><tbody id="tbody2">');
    var indice = 0;
    for (indice in data) {
        var showIndex = parseInt(indice) + parseInt(1);
        var format = (indice % 2 === 0) ? 'dark' : 'light';
        $('#tbody2').append('<tr class="' + format + '"><td>' + showIndex +
                '</td><td>' + data[indice]['?title']['label'] + '</td>' +
                '<td>' + data[indice]['?name']['label'] + '</td></tr>');
    }
}