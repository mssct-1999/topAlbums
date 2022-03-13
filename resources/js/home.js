$().ready(function() {

    var classementContainer = $("#classement")
    var num = 1;
    $.getJSON(baseUrl + "/api/home/classement",function(albums) {
        var html = ""
        albums.forEach(album => {
            html += "<div class='d-align-center'>"
                html += "<span class='bolder-text mg-r-10'>"+ num +"</span>"
                html += "<div class='mg-b-10 d-align-center shadow' style='padding:10px;border-radius:50px;width:100%;justify-content:space-between'>"
                    html += "<a href='"+ baseUrl + "/albums/show/" + album.artiste.nom+ "/ " + album.nom + "'>"
                        html += "<li class='album-name'>"
                            html += "<img class='disk-image-50 mg-r-10' src='"+ album.small_cover +"'/>" + album.nom + " / " + album.artiste.nom
                        html += "</li>"
                    html += "</a>"
                    if(album.average_vote >= 7) {
                        html += "<span class='bolder-text' style='color:#4DC274;'>" + album.average_vote + "</span>"
                    }
                    else if(album.average_vote < 7 && album.average_vote >= 5) {
                        html += "<span class='bolder-text' style='color:#F56702;'>" + album.average_vote + "</span>"                       
                    }
                    else {
                        html += "<span class='bolder-text' style='color:#E62737;'>" + album.average_vote + "</span>"
                    }                     
                html += "</div>"
            html += "</div>"
            num++
        });
        classementContainer.html(html)
    })
    
})