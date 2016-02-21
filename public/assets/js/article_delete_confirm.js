var func = func || {};

func.show_modal = function(quiz_id, article_id)
{
    $('#modal').modal('show');

    $('#modal_delete').click(function ()
    {
        window.location.href = "/admin/article/delete/" + quiz_id + "/" + article_id ;
    });
};
