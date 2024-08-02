$(document).ready(function() {
    let showWeather = 'no';
    if (showWeather == "no" || showWeather == null) {
        $(".cloudbar i").removeClass("la-cloud-meatball");
        $(".cloudbar i").addClass("la-cloud");
        $("#wrapper .site-main").css("cssText", "margin-top: 0px !important;");
        $(".site-header").css("top", "0");
        $(".html-marquee").css('top', '-48px');
    } else {
        $(this).addClass("la-cloud-meatball");
        $(".cloudbar i").removeClass("la-cloud");
        $("#wrapper .site-main").css("cssText", "margin-top: 40px !important;");
        $(".html-marquee").css('top', '0px');
        $(".site-header").css("top", "47px");
    }
});
