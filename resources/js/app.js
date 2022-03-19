/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.toastr = require('toastr')

function setCookie(name, value) {
    var d = new Date()
    d.setTime(d.getTime() + (365*24*60*60*1000));
    var expires = "expires=" + d.toUTCString()
    document.cookie = name + "=" + value + ";" + expires +";path=/";
}

$().ready(function() {
    $("[data-toggle='tooltip']").tooltip()

    $("#toggleThemeIcon").attr('data-theme') == 'light' ? $("input").addClass('dark-theme') : $("input").removeClass('dark-theme') 

    var sun_icon = 'fa-solid fa-sun'
    var moon_icon = 'fa-solid fa-moon'
    $("#toggleThemeIcon").on('click',function() {
        $(this).attr('data-theme') == 'dark' ? $(this).attr('data-theme','light') : $(this).attr('data-theme','dark')
        var currentTheme = $(this).attr('data-theme')
        
        if (currentTheme == 'dark') {    
            $(this).removeClass(moon_icon)
            $(this).addClass(sun_icon)

            $("body").addClass('dark-theme')
            $("nav").addClass('dark-theme')
            $("input").addClass('dark-theme')
            $(".album-name").addClass('dark-theme')

            setCookie('theme','dark')
        }
        else if (currentTheme == 'light') {
            $(this).removeClass(sun_icon)
            $(this).addClass(moon_icon)

            $("body").removeClass('dark-theme')
            $("nav").removeClass('dark-theme')
            $("input").removeClass('dark-theme')
            $(".album-name").removeClass('dark-theme')

            setCookie('theme','light')
        }

        console.log(getCookie('theme'))
    })
})

