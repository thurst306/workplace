// This is a manifest file that'll be compiled into application.js, which will include all the files
// listed below.
//
// Any JavaScript/Coffee file within this directory, lib/assets/javascripts, vendor/assets/javascripts,
// or vendor/assets/javascripts of plugins, if any, can be referenced here using a relative path.
//
// It's not advisable to add code directly here, but if you do, it'll appear at the bottom of the
// compiled file.
//
// Read Sprockets README (https://github.com/sstephenson/sprockets#sprockets-directives) for details
// about supported directives.
//
//= require jquery
//= require jquery.datetimepicker
//= require jquery_ujs
//= require turbolinks
//= require_tree .

$(document).on('page:change', function(){
    if ($(".flash").is(":empty")) {
        null;
    } else {
        $(".flash").animate({
            opacity: 0
        }, 2500);
    }
    
    if ($(".alert").is(":empty")) {
        null;
    } else {
        $(".alert").animate({
            opacity: 0
        }, 2500);
    }
    
    $("ul li a").mouseenter(function() {
        $(this).stop(true).animate({
            paddingLeft: "+=5"
        }, 250);
    });
    
    $("ul li a").mouseleave(function() {
        $(this).stop(true).animate({
            paddingLeft: "-=5"
        }, 250);
    });
    
    var menu_open = false;
    
    var menu_open_tween_speed = 0.5;
    
    $("#menu_button").click(function() {
        if(menu_open){
            if(document.body.scrollWidth > document.body.scrollHeight) {
                TweenLite.to("nav", menu_open_tween_speed, { left:-200 });
            } else {
                TweenLite.to("nav", menu_open_tween_speed, { top:-329 });
            }
        } else {
            if(document.body.scrollWidth > document.body.scrollHeight) {
                TweenLite.to("nav", menu_open_tween_speed, { left:0 });
            } else {
                TweenLite.to("nav", menu_open_tween_speed, { top:0 });
            }
        }
        menu_open = !menu_open;
    });
});