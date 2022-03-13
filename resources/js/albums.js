$(window).on('load',function() {
    const colorThief = new ColorThief()
    const img = $("#cover")
    var rgbColors = colorThief.getColor(img[0])
    $("#header-container").css("background-color","rgb(" + rgbColors[0] +"," + rgbColors[1] + "," + rgbColors[2])
    $("#buttonSendComment").css("background-color","rgb(" + rgbColors[0] +"," + rgbColors[1] + "," + rgbColors[2])
    $("#buttonVote").css("background-color","rgb(" + rgbColors[0] +"," + rgbColors[1] + "," + rgbColors[2])
    $(".radial-progress circle").css("stroke","rgb(" + rgbColors[0] +"," + rgbColors[1] + "," + rgbColors[2]) 
})


$('a[data-toggle="tooltip"]').tooltip();

$('svg.radial-progress').each(function( index, value ) { 
    $(this).find($('circle.complete')).removeAttr( 'style' );
});

$(window).on('load',(function(){
    $('svg.radial-progress').each(function( index, value ) { 
      // If svg.radial-progress is approximately 25% vertically into the window when scrolling from the top or the bottom
      if ( 
          $(window).scrollTop() > $(this).offset().top - ($(window).height() * 0.75) &&
          $(window).scrollTop() < $(this).offset().top + $(this).height() - ($(window).height() * 0.25)
      ) {
          // Get percentage of progress
          percent = $(value).data('percentage');
          // Get radius of the svg's circle.complete
          radius = $(this).find($('circle.complete')).attr('r');
          // Get circumference (2πr)
          circumference = 2 * Math.PI * radius;
          // Get stroke-dashoffset value based on the percentage of the circumference
          strokeDashOffset = circumference - ((percent * circumference) / 10);
          // Transition progress for 1.25 seconds
          $(this).find($('circle.complete')).animate({'stroke-dashoffset': strokeDashOffset}, 1250);
      }
    });
}))

