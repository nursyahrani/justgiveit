$(document).ready(function(){
    $(".interested_button").click(function(){
        var stuff_id = $(this).data('services');
        console.log('Stuff id: ' + stuff_id);

        krajeeDialog.confirm("Are you sure you are interested in this stuff?", function (result) {
            if (result) {
                $("#interested_button_form_" + stuff_id).submit();
            } else {
            }
        });
    });
})