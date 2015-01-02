# Place all the behaviors and hooks related to the matching controller here.
# All this logic will automatically be available in application.js.
# You can use CoffeeScript in this file: http://coffeescript.org/

ready = ->
    $("ul li a").mouseenter ->
        $(this).animate({
            paddingLeft: "+=5"
        }, 250)
    
    $("ul li a").mouseleave ->
        $(this).animate({
            paddingLeft: "-=5"
        }, 250)
    
    
$(document).on('page:change', ready)