$().ready(function() {

    $("#searchUserAdminButton").on('click',function() {
        var username = $("#usernameInput").val()
        var id = $("#idInput").val()
        var url = baseUrl + "/api/admin/searchUser/"
        
        if (username != "" && username != undefined) {
            url += username + "/"
        }
        else {
            url += 0 + "/"
        }

        if (id != "" && id != undefined) {
            url += id 
        }

        $.getJSON(url,function(users) {
            var container = $("#resultQuery")
            container.empty()
            var html = ""
            users.forEach(user => {
                html += "<li class='mg-b-10 d-space-between'>"
                    html += "<div>"
                        html += "<img src='" + baseUrl + "/" + user.profil_image +"' style='width:50px;border-radius:50px;margin-right:10px;'/>"+ user.name + " [uid#" + user.id + "]"  
                    html += "</div>"
                    html += "<a href='"+ baseUrl + "/admin/launchRemoteConnection/"+ user.id +"' class='btn-sm btn-primary' style='height:25px;'>Se connecter</a>"
                html += "</li>"
            });
            html += "<span class='italic-text'>"+ users.length +" utilisateur(s) retourné(s).</span>"
            container.append(html)
        })
    })

})