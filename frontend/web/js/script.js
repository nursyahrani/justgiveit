$(document).ready(function(){
    $(document).on('click', ".interested_button", function(){
        var stuff_id = $(this).data('services');
        console.log('Stuff id: ' + stuff_id);

        $("#interested_button_form_" + stuff_id).submit();
    });

    $(document).on('submit', '.interested_button_form', function(event){
        event.preventDefault();

        console.log($(this).data('pjax'));
        $.pjax.submit(event, $(this).data('pjax'), {push:false,timeout:false,skipOuterContainers:true} );
    });

    $(document).on('pjax:complete', '.interested_button_section_pjax', function(event){
        event.preventDefault();
        var stuff_id = $(this).data('service');
        console.log($('#send-message-modal-' + stuff_id).length);

        $("#send-message-modal-" + stuff_id).modal("show")
            .find('#send-message-modal-' + stuff_id)
            .load($(this).attr("value"));
    });

    $("#give-stuff-modal-button").click(function(){
        $("#give-stuff-modal").modal("show")
            .find('#give-stuff-modal')
            .load($(this).attr("value"));
    });


    $("#send-message-user-profile").click(function(){
        $("#send-message-user-profile-modal").modal("show")
            .find('#send-message-user-profile-modal')
            .load($(this).attr("value"));
    });
})