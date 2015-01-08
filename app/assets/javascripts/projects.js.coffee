# Place all the behaviors and hooks related to the matching controller here.
# All this logic will automatically be available in application.js.
# You can use CoffeeScript in this file: http://coffeescript.org/

# This line is apparently needed to execute the code AFTER the document is ready. Otherwise this won't work :( 
ready = ->
    project_title_max_length = 35
    project_title_min_length = 6 
    
    $('#project_name_field').keyup ->
        text_length = $('#project_name_field').val().length
        text_remaining = project_title_max_length - text_length
        
        if text_length < 6
            text_needed = project_title_min_length - text_length
            $('#project_name_field_feedback').html "#{text_needed} characters needed"
        
        else
            $('#project_name_field_feedback').html "#{text_remaining} characters remaining"
        
    $('#project_name_field').keydown ->
        text_length = $('#project_name_field').val().length
        text_remaining = project_title_max_length - text_length
        
        if text_length < 6
            text_needed = project_title_min_length - text_length
            $('#project_name_field_feedback').html "#{text_needed} characters needed"
        
        else
            $('#project_name_field_feedback').html "#{text_remaining} characters remaining"
            
    $('#new_project_form').submit ->
        project_title_regex = /[A-z0-9\.\\\/\(\)\?\$\&\s]{6,35}/
        
        if project_title_regex.test($('#project_name_field').val())
            return true 
        else 
            $('#project_name_field_feedback').html "Something was wrong here!"
            return false 
            
    $("ul li a").mouseenter ->
        $(this).stop(true).animate({
            paddingLeft: "+=5"
        }, 250)
    
    $("ul li a").mouseleave ->
        $(this).stop(true).animate({
            paddingLeft: "-=5"
        }, 250)
        
$(document).on('page:change', ready)