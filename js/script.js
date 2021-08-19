$('#toggleLogin').click(function(){
    $('#signup-form').addClass('hidden');
    $('#login-form').removeClass('hidden');
});

$('#toggleSignup').click(function(){
    $('#login-form').addClass('hidden');
    $('#signup-form').removeClass('hidden');
});
$('#diary').bind('input propertychange', function() {
    $.ajax({
        method: "POST",
        url: "updateDatabase.php",
        data: {content: $('#diary').val()}
      }) ;
});
$('#diary').val($('#diary').val().trim());