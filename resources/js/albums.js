$(window).on('load',function() {
    const colorThief = new ColorThief()
    const img = $("#cover")
    var rgbColors = colorThief.getColor(img[0])
        $("#header-container").css("background-color","rgb(" + rgbColors[0] +"," + rgbColors[1] + "," + rgbColors[2])
})

$('a[data-toggle="tooltip"]').tooltip();