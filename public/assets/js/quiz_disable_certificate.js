$(document).ready(function ()
{
    $('#send_trigger').click(function ()
    {   
        $.post( "/quiz/send", { 'quiz_id': quiz_id } )
        .done(function(result)
        {
            alert( result.msg );
        });

        window.location.href = "/";
        return false;
    }); 
});
