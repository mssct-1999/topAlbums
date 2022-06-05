// import getCookie from './helpers'

var getCookie = function(name) {
    // Split cookie string and get all individual name=value pairs in an array
    var cookieArr = document.cookie.split(";");
    // Loop through the array elements
    for(var i = 0; i < cookieArr.length; i++) {
        var cookiePair = cookieArr[i].split("=");
        /* Removing whitespace at the beginning of the cookie name
        and compare it with the given string */
        if(name == cookiePair[0].trim()) {
            // Decode the cookie value and return
            return decodeURIComponent(cookiePair[1]);
        }
    } 
    // Return null if not found
    return null;
}

$().ready(function() {
    var classementContainer = $("#classement")
    var num = 1;
    var theme = getCookie('theme') 
    $.getJSON(baseUrl + "/api/home/classement",function(albums) {
        var html = ""
        albums.forEach(album => {
            html += "<div class='d-align-center'>"
                html += "<span class='bolder-text mg-r-10'>"+ num +"</span>"
                html += "<div class='mg-b-10 d-align-center shadow' style='padding:10px;border-radius:50px;width:100%;justify-content:space-between'>"
                    html += "<a href='"+ baseUrl + "/albums/show/" + album.artiste.nom+ "/ " + album.nom + "'>"
                        if (theme == 'dark') {
                            html += "<li class='album-name dark-theme'>"
                        }
                        else {
                            html += "<li class='album-name'>"
                        } 
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