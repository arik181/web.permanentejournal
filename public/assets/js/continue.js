$(document).ready(function ()
{
    if ($('#continue_trigger option:selected').val() != 0)
    {
        $('.disabled').removeClass('disabled')
    }

    $('#continue_trigger').change(function () 
    {
        $('.disabled').removeClass('disabled')
    });
});
