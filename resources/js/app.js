/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.toastr = require('toastr')
global.tarteaucitron = require('tarteaucitronjs/tarteaucitron');

function setCookie(name, value) {
    var d = new Date()
    d.setTime(d.getTime() + (365*24*60*60*1000));
    var expires = "expires=" + d.toUTCString()
    document.cookie = name + "=" + value + ";" + expires +";path=/";
}

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
    
    $("[data-toggle='tooltip']").tooltip()
    var theme = getCookie('theme')
    theme == 'light' ? $("input").removeClass('dark-theme') : $("input").addClass('dark-theme') 
    theme == 'light' ? $("html").removeClass('dark-theme') : $("html").addClass('dark-theme')

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
    })
})

