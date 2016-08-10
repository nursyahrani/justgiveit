$(document).ready(function(){
    $(document).on('click', '.home-post-list-bid', function(event ) {
        var post_id = $(this).data('id');
        $("#send-message-modal-" + post_id).modal("show")
            .find('#send-message-modal-' + post_id)
            .load($(this).attr("value"));
    });
    
    $(".give-stuff-modal-button").click(function(){
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