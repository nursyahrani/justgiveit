var CommonLibrary = function() {
    
};

CommonLibrary.isGuest = function() {
    $guest = $("#current-user-id").val() === null || $("#current-user-id").val() === "" ;
    if($guest) {
        $('#login-modal').modal("show").load($(this).attr("value"));
    }
    return $guest;
}

CommonLibrary.validateEmail = function(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);  
};


