var func = func || {};

func.show_modal = function(quiz_id)
{
    $('#modal').modal('show');

    $('#modal_delete').click(function ()
    {
        window.location.href = "/admin/quiz/delete/" + quiz_id ;
    });
};
