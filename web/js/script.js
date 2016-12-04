$(document).ready(function () {
	$("header").mouseenter(function () {
        if ($("#navBar").css('display') == "none") {
            $("#navBar").animate({height: "show"}, 500)
        }
    });
    $("header").mouseleave(function () {
        if ($("#navBar").css('display') == "block") {
            $("#navBar").animate({height: "hide"}, 500)
        }
    })
});