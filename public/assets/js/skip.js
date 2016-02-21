$(document).ready(function ()
{
    $('#modal_trigger').click(function () 
    {
        $('#modal').modal('show')
    });

    $('#modal_skip').click(function ()
    {
        if ( skip_article_id == null )
        {
            window.location.href = "/quiz/skip/" + quiz_id + "/" + article_id ;
        }
        else
        {
            window.location.href = "/quiz/skip/" + quiz_id + "/" + article_id + "/" + skip_article_id ;
        }
    });

});
